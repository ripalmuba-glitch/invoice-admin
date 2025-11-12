@csrf
@if (isset($client))
    @method('PATCH')
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

<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Nama Klien (Wajib)')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $client->name ?? '')" required autofocus />
        @error('name')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $client->email ?? '')" />
            @error('email')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>
        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                          :value="old('phone', $client->phone ?? '')" />
            @error('phone')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>
    </div>

    <div>
        <x-input-label for="address" :value="__('Alamat')" />
        <textarea id="address" name="address" rows="4"
                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        >{{ old('address', $client->address ?? '') }}</textarea>
        @error('address')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>

    <div class="flex items-center justify-end space-x-4 pt-6">
        <a href="{{ route('clients.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
            Batal
        </a>
        <x-primary-button>
            {{ isset($client) ? 'Simpan Perubahan' : 'Simpan Klien' }}
        </x-primary-button>
    </div>
</div>
