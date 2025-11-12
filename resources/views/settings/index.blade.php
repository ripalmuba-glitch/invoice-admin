<x-app-layout>
    <x-slot name="header">
        <div class_alias( class, alias, autoload )="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                Pengaturan Aplikasi
            </h2>
            <p class="text-md text-gray-600 mt-2">
                Kelola informasi perusahaan, logo, dan info bank Anda di sini.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg shadow-md" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-500">
                        &times;
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    <div class="font-bold">Oops! Terjadi kesalahan.</div>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8 space-y-6">

                        <h3 class="text-2xl font-semibold text-gray-900">Informasi Perusahaan</h3>

                        <div>
                            <x-input-label for="company_logo" :value="__('Logo Perusahaan')" />
                            @if ($settings->company_logo)
                                <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo Saat Ini" class="h-16 w-auto my-2">
                                <p class="text-sm text-gray-500">Logo saat ini. Unggah file baru untuk menggantinya.</p>
                            @else
                                <p class="text-sm text-gray-500">Belum ada logo.</p>
                            @endif
                            <input id="company_logo" name="company_logo" type="file" class="mt-2 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-primary-50 file:text-primary-700
                                hover:file:bg-primary-100" />
                            @error('company_logo')
                                <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="company_name" :value="__('Nama Perusahaan (Wajib)')" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full"
                                          :value="old('company_name', $settings->company_name)" required />
                        </div>

                        <div>
                            <x-input-label for="company_address" :value="__('Alamat Perusahaan')" />
                            <textarea id="company_address" name="company_address" rows="3"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            >{{ old('company_address', $settings->company_address) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="company_city_state_zip" :value="__('Kota, Provinsi, Kode Pos')" />
                                <x-text-input id="company_city_state_zip" name="company_city_state_zip" type="text" class="mt-1 block w-full"
                                              :value="old('company_city_state_zip', $settings->company_city_state_zip)" />
                            </div>
                            <div>
                                <x-input-label for="company_phone" :value="__('Telepon')" />
                                <x-text-input id="company_phone" name="company_phone" type="text" class="mt-1 block w-full"
                                              :value="old('company_phone', $settings->company_phone)" />
                            </div>
                            <div>
                                <x-input-label for="company_email" :value="__('Email')" />
                                <x-text-input id="company_email" name="company_email" type="email" class="mt-1 block w-full"
                                              :value="old('company_email', $settings->company_email)" />
                            </div>
                        </div>

                        <hr>

                        <h3 class="text-2xl font-semibold text-gray-900">Pengaturan Invoice</h3>
                        <div>
                            <x-input-label for="default_notes" :value="__('Catatan Default (Info Bank, dll)')" />
                            <textarea id="default_notes" name="default_notes" rows="5"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      placeholder="Contoh: Pembayaran dapat ditransfer ke Bank ABC No. Rek 123456 a.n Perusahaan Anda."
                            >{{ old('default_notes', $settings->default_notes) }}</textarea>
                        </div>

                    </div>

                    <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t">
                        <x-primary-button>
                            Simpan Pengaturan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
