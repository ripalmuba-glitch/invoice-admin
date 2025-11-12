<x-app-layout>
    <x-slot name="header">
        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                Buat Invoice Baru
            </h2>
            <p class="text-md text-gray-600 mt-2">
                Isi detail invoice, tambahkan item, dan total akan terhitung otomatis.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf

                <div x-data="invoiceForm({
                        products: {{ $products->mapWithKeys(fn($product) => [$product->id => ['name' => $product->name, 'price' => $product->price]])->toJson() }},
                        initialItems: {{ old('items') ? json_encode(old('items')) : 'null' }},
                        initialDiscount: {{ old('discount', 0) }},
                        initialTaxPercent: {{ old('tax_percent', 0) }}
                     })"
                     x-init="init()"
                     class="space-y-8">

                    <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                        <div class="p-8 space-y-6">
                            <h3 class="text-2xl font-semibold text-gray-900">Detail Invoice</h3>

                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg" role="alert">
                                    <div class="font-bold">Oops! Terjadi kesalahan.</div>
                                    <ul class="mt-1 list-disc list-inside text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="client_id" :value="__('Klien (Wajib)')" />
                                    <select id="client_id" name="client_id" required
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">-- Pilih Klien --</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="issue_date" :value="__('Tanggal Terbit (Wajib)')" />
                                    <x-text-input id="issue_date" name="issue_date" type="date" class="mt-1 block w-full"
                                                  :value="old('issue_date', now()->format('Y-m-d'))" required />
                                </div>
                                <div>
                                    <x-input-label for="due_date" :value="__('Jatuh Tempo (Wajib)')" />
                                    <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
                                                  :value="old('due_date', now()->addDays(14)->format('Y-m-d'))" required />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="invoice_number" :value="__('Nomor Invoice (Wajib)')" />
                                    <x-text-input id="invoice_number" name="invoice_number" type="text" class="mt-1 block w-full"
                                                  :value="old('invoice_number')" required placeholder="Contoh: INV-001 atau PROYEK-A" />
                                </div>

                                <div>
                                    <x-input-label for="template" :value="__('Pilih Template (Wajib)')" />
                                    <select id="template" name="template" required
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="template-yellow-modern" {{ old('template') == 'template-yellow-modern' ? 'selected' : '' }}>Modern (Kuning)</option>
                                        <option value="template-black-gold" {{ old('template') == 'template-black-gold' ? 'selected' : '' }}>Elegan (Hitam Emas)</option>
                                        <option value="template-blue-simple" {{ old('template') == 'template-blue-simple' ? 'selected' : '' }}>Simpel (Biru)</option>
                                        <option value="template-blue-geometric" {{ old('template') == 'template-blue-geometric' ? 'selected' : '' }}>Geometris (Biru)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                        <div class="p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-semibold text-gray-900">Item Tagihan</h3>
                                <button type="button" @click="addNewItem()" class="px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg shadow hover:bg-primary-700 transition-all">
                                    + Tambah Item
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pilih Produk</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Deskripsi Item</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase w-28">Qty</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase w-40">Harga</th>
                                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase w-40">Total</th>
                                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase w-20">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(item, index) in items" :key="index">
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <select x-model="item.product_id" @change="productSelected(index)"
                                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                        <option value="">-- Item Kustom --</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="hidden" :name="'items['+index+'][product_name]'" x-model="item.product_name">
                                                    <x-text-input type="text" x-model="item.product_name" class="w-full text-sm" required />
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="hidden" :name="'items['+index+'][quantity]'" x-model.number="item.quantity">
                                                    <x-text-input type="number" x-model.number="item.quantity" min="1" class="w-full text-sm" required />
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="hidden" :name="'items['+index+'][price]'" x-model.number="item.price">
                                                    <x-text-input type="number" x-model.number="item.price" min="0" step="any" class="w-full text-sm" required />
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    <span class="text-sm font-medium text-gray-900"
                                                          x-text="formatCurrency(item.quantity * item.price)">
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700" title="Hapus Item">
                                                        &times;
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                            <div class="p-8">
                                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Catatan</h3>
                                <textarea id="notes" name="notes" rows="6"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                          placeholder="Tulis syarat, ketentuan, atau info rekening bank di sini..."
                                >{{ old('notes', $default_notes) }}</textarea> </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                            <div class="p-8 space-y-4">
                                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                                <div class="flex justify-between items-center text-lg">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-bold text-gray-900" x-text="formatCurrency(subtotal)">Rp 0,00</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <label for="discount" class="text-gray-600">Diskon (Rp):</label>
                                    <x-text-input id="discount" name="discount" type="number" x-model.number="discount" min="0" step="any" class="w-48 text-right" />
                                </div>
                                <div class="flex justify-between items-center">
                                    <label for="tax_percent" class="text-gray-600">Pajak (%):</label>
                                    <x-text-input id="tax_percent" name="tax_percent" type="number" x-model.number="tax_percent" min="0" step="any" class="w-48 text-right" />
                                </div>
                                <hr class="my-2 border-t-2 border-dashed">
                                <div class="flex justify-between items-center text-3xl font-bold">
                                    <span class="text-gray-900">TOTAL:</span>
                                    <span class="text-primary-600" x-text="formatCurrency(grandTotal)">Rp 0,00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-primary-button class="text-lg px-8 py-3">
                            Simpan Invoice
                        </x-primary-button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function invoiceForm(data) {
            return {
                items: data.initialItems || [{ product_id: '', product_name: '', quantity: 1, price: 0 }],
                allProducts: data.products || {},
                discount: data.initialDiscount || 0,
                tax_percent: data.initialTaxPercent || 0,
                init() {
                    this.items.forEach(item => {
                        item.quantity = parseFloat(item.quantity) || 1;
                        item.price = parseFloat(item.price) || 0;
                    });
                },
                addNewItem() {
                    this.items.push({ product_id: '', product_name: '', quantity: 1, price: 0 });
                },
                removeItem(index) {
                    if (this.items.length > 1) { this.items.splice(index, 1); }
                },
                productSelected(index) {
                    let productId = this.items[index].product_id;
                    if (productId && this.allProducts[productId]) {
                        let product = this.allProducts[productId];
                        this.items[index].product_name = product.name;
                        this.items[index].price = parseFloat(product.price) || 0;
                    } else {
                        this.items[index].product_name = '';
                        this.items[index].price = 0;
                    }
                },
                get subtotal() {
                    return this.items.reduce((acc, item) => acc + (parseFloat(item.quantity) * parseFloat(item.price)), 0);
                },
                get taxAmount() { return (this.subtotal - this.discount) * (this.tax_percent / 100); },
                get grandTotal() { return this.subtotal - this.discount + this.taxAmount; },
                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0, }).format(amount);
                }
            }
        }
    </script>
</x-app-layout>
