@csrf
@if (isset($product))
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <x-input-label for="name" :value="__('Nama Produk/Layanan (Wajib)')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $product->name ?? '')" required autofocus />
            @error('name')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>
        <div>
            <x-input-label for="price" :value="__('Harga (Wajib)')" />
            <x-text-input id="price" name="price" type="number" step="any" min="0" class="mt-1 block w-full"
                          :value="old('price', $product->price ?? '')" required />
            @error('price')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>
    </div>

    <div>
        <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        >{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>

    <div class="flex items-center justify-end space-x-4 pt-6">
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
            Batal
        </a>
        <x-primary-button>
            {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
        </x-primary-button>
    </div>
</div>
