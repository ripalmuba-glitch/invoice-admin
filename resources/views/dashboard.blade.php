<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-primary-600 to-indigo-800 rounded-xl p-8 shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight">
                        Selamat Datang, <span class="opacity-90">{{ $name }}</span>!
                    </h2>
                    <p class="text-lg text-indigo-100 mt-2">
                        Ini adalah ringkasan singkat dari aktivitas bisnis Anda.
                    </p>
                </div>

                <a href="{{ route('invoices.create') }}"
                   class="flex-shrink-0 inline-flex items-center justify-center px-6 py-3 bg-white text-primary-700 text-base font-bold rounded-lg shadow-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Buat Invoice Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-green-500">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pendapatan (Lunas)</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-yellow-500">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Menunggu Bayar</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                Rp {{ number_format($stats['pendingAmount'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-primary-500">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-primary-100 text-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Invoice</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ $stats['totalInvoices'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-indigo-500">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-1.343-3-3-3h-4c-1.657 0-3 1.343-3 3v2m6-6A3 3 0 1010 7a3 3 0 004 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Klien</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">
                                {{ $stats['totalClients'] }}
                            </p>
                        </div>
                    </div>
                </div>

            </div> <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">Invoice Terbaru</h3>
                    <p class="text-sm text-gray-600 mt-1">Daftar 5 invoice terakhir yang Anda buat.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    No. Invoice
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Klien
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Tanggal Terbit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($recentInvoices as $invoice)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary-600">
                                        {{ $invoice->invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $invoice->client?->name ?? 'Klien Dihapus' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($invoice->status == 'Lunas')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Lunas
                                            </span>
                                        @elseif ($invoice->status == 'Terkirim')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Terkirim
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Draf
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-800">
                                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900" title="Preview">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a8 8 0 11-16 0 8 8 0 0116 0z" />
                                        </svg>
                                        <p class="mt-4 text-lg">Belum ada invoice terbaru.</p>
                                        <p class="text-sm">Saat Anda membuat invoice, 5 yang terbaru akan muncul di sini.</p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
