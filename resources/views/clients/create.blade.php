<x-app-layout>
    <x-slot name="header">
        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                Buat Klien Baru
            </h2>
            <p class="text-md text-gray-600 mt-2">
                Isi formulir di bawah ini untuk mendaftarkan klien baru.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('clients.store') }}" method="POST">

                        @include('clients._form')

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
