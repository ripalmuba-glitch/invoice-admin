<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice; // <-- TAMBAHKAN INI
use App\Models\Client;  // <-- TAMBAHKAN INI

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     */
    public function index()
    {
        $name = Auth::user()->name;

        // --- PENGAMBILAN DATA REAL-TIME ---

        // 1. Ambil data untuk Stat Cards
        $totalRevenue = Invoice::where('status', 'Lunas')->sum('total');
        $pendingAmount = Invoice::whereIn('status', ['Draf', 'Terkirim'])->sum('total');
        $totalInvoices = Invoice::count();
        $totalClients = Client::count();

        // 2. Masukkan ke array $stats
        $stats = [
            'totalInvoices' => $totalInvoices,
            'totalClients' => $totalClients,
            'totalRevenue' => $totalRevenue,
            'pendingAmount' => $pendingAmount,
        ];

        // 3. Ambil 5 invoice terbaru untuk tabel
        $recentInvoices = Invoice::with('client') // 'with' untuk eager loading
                                 ->latest()      // Urutkan dari terbaru
                                 ->take(5)       // Ambil 5 saja
                                 ->get();

        // Kirim semua data ke view 'dashboard'
        return view('dashboard', [
            'name' => $name,
            'stats' => $stats,
            'recentInvoices' => $recentInvoices, // <-- Kirim data baru
        ]);
    }
}
