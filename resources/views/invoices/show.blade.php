<x-app-layout>
    <x-slot name="header">
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                        Preview Invoice: <span class="text-primary-600">{{ $invoice->invoice_number }}</span>
                    </h2>
                    <p class="text-md text-gray-600 mt-2">
                        Periksa detail invoice sebelum dikirim ke klien.
                    </p>
                </div>

                <div class="flex-shrink-0 flex items-center space-x-3">
                    <a href="{{ route('invoices.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow hover:bg-gray-300 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('invoices.download', $invoice) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Download PDF
                    </a>
                    <button onclick="window.print()"
                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg shadow hover:bg-primary-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v6a2 2 0 002 2h1v-4a1 1 0 011-1h8a1 1 0 011 1v4h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                        </svg>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div id="invoice-preview" class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                @include('invoices.templates.' . $invoice->template, ['invoice' => $invoice, 'company' => $company])
            </div>
        </div>
    </div>
    </x-app-layout>
