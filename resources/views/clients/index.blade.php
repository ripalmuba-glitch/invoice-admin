<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-primary-600 to-indigo-800 rounded-xl p-8 shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight">
                        Manajemen Klien
                    </h2>
                    <p class="text-lg text-indigo-100 mt-2">
                        Kelola semua daftar klien Anda di satu tempat.
                    </p>
                </div>
                <a href="{{ route('clients.create') }}"
                   class="flex-shrink-0 inline-flex items-center justify-center px-6 py-3 bg-white text-primary-700 text-base font-bold rounded-lg shadow-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Buat Klien Baru
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

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
                     x-transition class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-500">
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
                                    Nama Klien
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Kontak (Email)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Telepon
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            @forelse ($clients as $client)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $client->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $client->email ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $client->phone ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            Edit
                                        </a>

                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klien ini?');">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-1.343-3-3-3h-4c-1.657 0-3 1.343-3 3v2m6-6A3 3 0 1010 7a3 3 0 004 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p class="mt-4 text-lg">Belum ada klien terdaftar.</p>
                                        <p class="text-sm">Klik tombol "Buat Klien Baru" untuk memulai.</p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if ($clients->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $clients->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
