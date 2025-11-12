<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-primary-600 to-indigo-800 rounded-xl p-8 shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight">
                        Daftar Invoice
                    </h2>
                    <p class="text-lg text-indigo-100 mt-2">
                        Kelola semua invoice yang telah Anda buat.
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

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-500">
                        &times;
                    </button>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-xl border border-gray-200">

                <div class="p-4 border-b border-gray-200">
                    <form action="{{ route('invoices.index') }}" method="GET">
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="text" name="search"
                                   class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Cari berdasarkan No. Invoice atau Nama Klien..."
                                   value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Klien</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Terbit</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($invoices as $invoice)
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
                                        @php
                                            $bgColor = 'bg-gray-100 text-gray-800'; // Default (Draf)
                                            if ($invoice->status == 'Lunas') {
                                                $bgColor = 'bg-green-100 text-green-800';
                                            } elseif ($invoice->status == 'Terkirim') {
                                                $bgColor = 'bg-yellow-100 text-yellow-800';
                                            } elseif ($invoice->status == 'Dibatalkan') {
                                                $bgColor = 'bg-red-100 text-red-800 line-through';
                                            }
                                        @endphp

                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" type="button"
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full items-center transition-colors duration-150 {{ $bgColor }} hover:opacity-80">
                                                <span>{{ $invoice->status }}</span>
                                                <svg class="ml-1 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <div x-show="open"
                                                 @click.away="open = false"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="origin-top-left absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                                 style="display: none;">
                                                <div class="py-1" role="menu" aria-orientation="vertical">
                                                    @foreach (['Draf', 'Terkirim', 'Lunas', 'Dibatalkan'] as $status)
                                                        @if ($status !== $invoice->status)
                                                            <form action="{{ route('invoices.updateStatus', $invoice) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="{{ $status }}">
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                                                    Tandai sebagai: <strong>{{ $status }}</strong>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-800">
                                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="p-2 rounded-full text-blue-600 bg-blue-100 hover:bg-blue-200 transition-all" title="Preview Invoice">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('invoices.download', $invoice) }}" class="p-2 rounded-full text-green-600 bg-green-100 hover:bg-green-200 transition-all" title="Download PDF">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('invoices.edit', $invoice) }}" class="p-2 rounded-full text-indigo-600 bg-indigo-100 hover:bg-indigo-200 transition-all" title="Edit Invoice">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-full text-red-600 bg-red-100 hover:bg-red-200 transition-all" title="Hapus Invoice">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a8 8 0 11-16 0 8 8 0 0116 0z" />
                                        </svg>
                                        <p class="mt-4 text-lg">Belum ada invoice.</p>
                                        <p class="text-sm">Klik tombol "Buat Invoice Baru" untuk memulai.</p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if ($invoices->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
