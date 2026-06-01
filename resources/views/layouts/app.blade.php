<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fotomoderna - Gestionale Studio Fotografico')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-[#e02b23] shadow-lg text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo-foto-moderna.png') }}" alt="Fotomoderna" class="h-10 w-auto">
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-white">
                                Ciao, <strong>{{ auth()->user()->name }}</strong>
                                @if(auth()->user()->hasRole('admin'))
                                    <span class="text-xs bg-white/20 text-white px-2 py-1 rounded-full">Admin</span>
                                @elseif(auth()->user()->hasRole('fotografo'))
                                    <span class="text-xs bg-white/20 text-white px-2 py-1 rounded-full">Fotografo</span>
                                @endif
                            </span>
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-100">
                                Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-gray-100">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center">
            <p>&copy; {{ date('Y') }} Fotomoderna - Gestionale Studio Fotografico</p>
        </div>
    </footer>
</body>

</html>