<x-guest-layout>
    <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900">
        Admin Log In
    </h2>
    <p class="mt-2 text-center text-sm text-gray-600">
        Selamat datang kembali, silakan masuk.
    </p>

    @if ($errors->any())
        <div class="mt-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-md" role="alert">
            <div classs="font-bold">Oops! Terjadi kesalahan.</div>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="font-semibold"/>
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="font-semibold"/>
            <x-text-input id="password" class="block mt-2 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            </div>

        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <label for="remember_me" class="ms-2 block text-sm text-gray-900">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a class="font-medium text-primary-600 hover:text-primary-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full flex justify-center py-3 text-sm">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
