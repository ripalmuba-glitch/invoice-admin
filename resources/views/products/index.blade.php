@php
  // Kita perlu helper Str untuk memotong deskripsi
  use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-primary-600 to-indigo-800 rounded-xl p-8 shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight">
                        Produk & Layanan
                    </h2>
                    <p class="text-lg text-indigo-100 mt-2">
                        Kelola item yang sering Anda gunakan untuk invoice.
                    </p>
                </div>
                <a href="{{ route('products.create') }}"
                   class="flex-shrink-0 inline-flex items-center justify-center px-6 py-3 bg-white text-primary-700 text-base font-bold rounded-lg shadow-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Item Baru
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

            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Nama Produk/Layanan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-sm truncate">
                                        {{ Str::limit($product->description, 70, '...') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-800">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            Edit
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <p class="mt-4 text-lg">Belum ada produk atau layanan.</p>
                                        <p class="text-sm">Klik tombol "Buat Item Baru" untuk memulai.</p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
