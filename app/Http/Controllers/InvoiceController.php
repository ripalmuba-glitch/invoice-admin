<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;
use App\Models\InvoiceItem;
use App\Models\Setting;
use Illuminate\Http\Request; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Menampilkan daftar semua invoice (DENGAN FUNGSI SEARCH).
     */
    public function index(Request $request) // <-- TAMBAHKAN Request $request
    {
        $search = $request->get('search');

        // Mulai query
        $query = Invoice::with('client')->latest();

        // Jika ada pencarian, filter query
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari di nomor invoice
                $q->where('invoice_number', 'like', "%{$search}%")
                  // ATAU cari di relasi 'client' berdasarkan nama
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Eksekusi query dengan pagination
        $invoices = $query->paginate(10);

        // Penting: Tambahkan query pencarian ke link pagination
        $invoices->appends(['search' => $search]);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Menampilkan form untuk membuat invoice baru.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        // Ambil catatan default dari pengaturan
        $settings = Setting::find(1);
        $default_notes = $settings->default_notes ?? '';

        return view('invoices.create', compact('clients', 'products', 'default_notes'));
    }

    /**
     * Menyimpan invoice baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number', // Wajib unik
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'template' => 'required|string',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // 2. Mulai Database Transaction
            $invoiceData = DB::transaction(function () use ($validated, $request) {

                // 3. Hitung Total di Backend
                $subtotal = 0;
                foreach ($validated['items'] as $item) {
                    $subtotal += $item['quantity'] * $item['price'];
                }
                $discount = $validated['discount'] ?? 0;
                $taxPercent = $validated['tax_percent'] ?? 0;
                $taxAmount = ($subtotal - $discount) * ($taxPercent / 100);
                $total = ($subtotal - $discount) + $taxAmount;

                // 5. Simpan Invoice Utama
                $invoiceData = array_merge($validated, [
                    'status' => 'Draf',
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $taxAmount,
                    'total' => $total,
                ]);

                $invoice = Invoice::create($invoiceData);

                // 6. Simpan Semua Item Invoice
                foreach ($validated['items'] as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['quantity'] * $item['price'],
                    ]);
                }
                return $invoice;
            });

            // 7. Jika sukses, redirect
            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice baru (' . $invoiceData->invoice_number . ') berhasil dibuat!');

        } catch (\Exception $e) {
            // 8. Jika gagal, redirect kembali dengan error
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan invoice: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman preview invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'items');

        /** @var Setting $company */
        $company = Setting::firstOrCreate(['id' => 1]);

        // Buat path URL untuk logo (untuk preview web)
        if ($company->company_logo) {
            $company->company_logo_url = asset('storage/' . $company->company_logo);
        } else {
            $company->company_logo_url = null;
        }

        return view('invoices.show', compact('invoice', 'company'));
    }

    /**
     * Menampilkan form untuk mengedit invoice.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $invoice->load('items');
        $subtotalMinusDiscount = $invoice->subtotal - $invoice->discount;
        if ($subtotalMinusDiscount > 0) {
            $invoice->tax_percent = ($invoice->tax / $subtotalMinusDiscount) * 100;
        } else {
            $invoice->tax_percent = 0;
        }
        return view('invoices.edit', compact('invoice', 'clients', 'products'));
    }

    /**
     * Memperbarui invoice di database.
     */
    public function update(Request $request, Invoice $invoice)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number,' . $invoice->id,
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'template' => 'required|string',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // 2. Mulai Database Transaction
            DB::transaction(function () use ($validated, $request, $invoice) {
                // 3. Hitung Ulang Total di Backend
                $subtotal = 0;
                foreach ($validated['items'] as $item) {
                    $subtotal += $item['quantity'] * $item['price'];
                }
                $discount = $validated['discount'] ?? 0;
                $taxPercent = $validated['tax_percent'] ?? 0;
                $taxAmount = ($subtotal - $discount) * ($taxPercent / 100);
                $total = ($subtotal - $discount) + $taxAmount;

                // 4. Update Invoice Utama
                $invoiceData = array_merge($validated, [
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $taxAmount,
                    'total' => $total,
                ]);

                $invoice->update($invoiceData);

                // 5. Hapus Item Lama & Simpan Item Baru
                $invoice->items()->delete();
                foreach ($validated['items'] as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['quantity'] * $item['price'],
                    ]);
                }
            });

            // 7. Jika sukses, redirect
            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice (' . $invoice->invoice_number . ') berhasil diperbarui!');

        } catch (\Exception $e) {
            // 8. Jika gagal, redirect kembali dengan error
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui invoice: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus invoice dari database.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice berhasil dihapus!');
    }

    /**
     * Mengunduh invoice sebagai PDF.
     */
    public function downloadPDF(Invoice $invoice)
    {
        $invoice->load('client', 'items');

        /** @var Setting $company */
        $company = Setting::firstOrCreate(['id' => 1]);

        // Buat path SERVER untuk logo (untuk dompdf)
        if ($company->company_logo && file_exists(public_path('storage/' . $company->company_logo))) {
            $company->company_logo_url = public_path('storage/' . $company->company_logo);
        } else {
            $company->company_logo_url = null;
        }

        // Memuat template secara dinamis
        $templateName = $invoice->template ?? 'template-yellow-modern';
        $pdf = Pdf::loadView('invoices.templates.' . $templateName, compact('invoice', 'company'));

        // Ganti karakter '/' dan '\' dengan '-' agar menjadi nama file yang aman
        $safeInvoiceNumber = str_replace(['/', '\\'], '-', $invoice->invoice_number);
        $filename = 'invoice-' . $safeInvoiceNumber . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * FUNGSI UNTUK UPDATE STATUS INVOICE
     */
    public function updateStatus(Request $request, Invoice $invoice)
    {
        // 1. Validasi status yang masuk
        $validated = $request->validate([
            'status' => [
                'required',
                // Pastikan statusnya adalah salah satu dari 4 ini
                Rule::in(['Draf', 'Terkirim', 'Lunas', 'Dibatalkan']),
            ],
        ]);

        // 2. Update status invoice
        $invoice->update([
            'status' => $validated['status'],
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()
            ->route('invoices.index')
            ->with('success', 'Status invoice #' . $invoice->invoice_number . ' telah diperbarui menjadi ' . $validated['status']);
    }
}
