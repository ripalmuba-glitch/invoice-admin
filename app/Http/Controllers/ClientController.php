<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Menampilkan daftar semua klien.
     */
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Menampilkan form untuk membuat klien baru.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Menyimpan klien baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data (PENTING!)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Klien baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * (Kita tidak pakai halaman 'show' terpisah, jadi bisa dibiarkan)
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit klien.
     */
    public function edit(Client $client)
    {
        // Route model binding otomatis menemukan $client dari ID
        return view('clients.edit', compact('client'));
    }

    /**
     * Memperbarui data klien di database.
     */
    public function update(Request $request, Client $client)
    {
        // Validasi data (email unik tapi abaikan email klien ini sendiri)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Data klien berhasil diperbarui!');
    }

    /**
     * Menghapus klien dari database.
     */
    public function destroy(Client $client)
    {
        // LOGIKA PENTING: Jangan hapus klien jika dia punya invoice
        if ($client->invoices()->count() > 0) {
            return redirect()
                ->route('clients.index')
                ->with('error', 'Gagal! Klien ini tidak bisa dihapus karena memiliki data invoice terkait.');
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Klien berhasil dihapus.');
    }
}
