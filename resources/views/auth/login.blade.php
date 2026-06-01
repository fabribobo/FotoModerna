@extends('layouts.guest')

@section('title', 'Login - Fotomoderna')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-[#E02B24] rounded-lg shadow-2xl p-8">
            <div class="flex justify-center mb-8">
                <img src="{{ asset('images/logo-foto-moderna.png') }}" alt="Fotomoderna Logo" class="h-20 w-auto">
            </div>
            <h2 class="text-3xl font-bold text-center text-white mb-8">
                Fotomoderna
            </h2>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-white mb-2">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-white/30 bg-white/10 text-white placeholder-white/60 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                    @error('email')
                        <p class="mt-2 text-sm text-yellow-200">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="password" class="block text-sm font-medium text-white mb-2">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-white/30 bg-white/10 text-white placeholder-white/60 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
                    @error('password')
                        <p class="mt-2 text-sm text-yellow-200">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-white text-[#E02B24] py-3 px-4 rounded-md font-semibold text-lg hover:bg-gray-100 transition-colors duration-200 shadow-lg">
                    Accedi
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-white/90 mb-3">
                    Account di test:
                </p>
                <div class="space-y-1 text-xs text-white/80">
                    <p><strong class="text-white">Admin:</strong> admin@fotomoderna.com / password123</p>
                    <p><strong class="text-white">Fotografo:</strong> andrea@fotomoderna.com / password123</p>
                </div>
            </div>
        </div>
    </div>
@endsection