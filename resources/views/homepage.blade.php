@extends('layouts.app')

@section('title', 'Fotomoderna - Gestionale Studio Fotografico')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-8">
                <h1 class="text-6xl font-bold text-gray-900 mb-4">
                    <span class="text-primary-600">Foto</span>Moderna
                </h1>
                <p class="text-xl text-gray-600">
                    Sistema gestionale completo per studi fotografici
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Per Fotografi</h3>
                    <p class="text-gray-600 text-sm">
                        Dashboard mobile-friendly per acquisizione lead e upload rapido foto durante gli eventi
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Per Amministratori</h3>
                    <p class="text-gray-600 text-sm">
                        Gestione completa di ordini, pagamenti e generazione automatica link temporanei
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Per Clienti</h3>
                    <p class="text-gray-600 text-sm">
                        Accesso sicuro alle gallery private con download automatico delle foto (30 giorni)
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Caratteristiche Principali</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Sistema di ruoli avanzato (Admin, Fotografo, Cliente)</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Upload multiplo e gestione avanzata delle foto</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Link temporanei sicuri con scadenza automatica</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Workflow completo di pagamento e consegna</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Interfaccia mobile-friendly per fotografi</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Email automatiche con link personalizzati</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-primary-600 text-white px-8 py-3 rounded-lg hover:bg-primary-700 transition-colors font-medium">
                        Vai alla Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-primary-600 text-white px-8 py-3 rounded-lg hover:bg-primary-700 transition-colors font-medium">
                        Accedi al Sistema
                    </a>
                @endauth
            </div>

            <div class="mt-8 text-sm text-gray-500">
                <p>Powered by Laravel 11 • Sviluppato per studi fotografici moderni</p>
            </div>
        </div>
    </div>
@endsection