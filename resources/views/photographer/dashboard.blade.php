@extends('layouts.app')

@section('title', 'Dashboard Fotografo - FotoModerna')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Fotografo</h1>
    <p class="text-gray-600 mt-2">Benvenuto, {{ auth()->user()->name }}</p>
</div>

<!-- Statistiche -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Eventi Attivi</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_events'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
                <svg class="w-6 h-6 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Lead Creati</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_leads'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100">
                <svg class="w-6 h-6 text-purple-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Foto Caricate</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_photos'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100">
                <svg class="w-6 h-6 text-yellow-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Eventi Pianificati</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['planned_events'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Eventi Correnti -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Eventi in Corso</h3>
        </div>
        <div class="px-6 py-4">
            @if($current_events->count() > 0)
                <div class="space-y-4">
                    @foreach($current_events as $event)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $event->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $event->location }}</p>
                                    <p class="text-xs text-gray-500">{{ $event->event_date->format('d/m/Y') }}</p>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Attivo
                                </span>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-sm text-gray-600">
                                    {{ $event->leads->count() }} lead registrati
                                </span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('photographer.events.show', $event) }}" 
                                       class="text-primary-600 hover:text-primary-800 text-sm">
                                        Dettagli
                                    </a>
                                    <a href="{{ route('photographer.leads.create', $event) }}" 
                                       class="bg-primary-600 text-white px-3 py-1 rounded text-sm hover:bg-primary-700">
                                        + Lead
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 mt-2">Nessun evento attivo</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Lead Recenti -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Lead Recenti</h3>
        </div>
        <div class="px-6 py-4">
            @if($recent_leads->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_leads as $lead)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $lead->name }}</p>
                                <p class="text-sm text-gray-600">{{ $lead->email }}</p>
                                <p class="text-xs text-gray-500">{{ $lead->event->name }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                    {{ $lead->photos->count() }} foto
                                </span>
                                <a href="{{ route('photographer.leads.show', $lead) }}" 
                                   class="text-primary-600 hover:text-primary-800 text-sm">
                                    Vedi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('photographer.leads.index') }}" 
                       class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                        Vedi tutti i lead →
                    </a>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Nessun lead creato</p>
            @endif
        </div>
    </div>
</div>

<!-- Menu di navigazione veloce -->
<div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Azioni Rapide</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('photographer.leads.create') }}" 
           class="block p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow hover:shadow-lg transition-all">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-lg">Nuovo Lead</h4>
                    <p class="text-blue-100 text-sm">Aggiungi un nuovo cliente</p>
                </div>
            </div>
        </a>

        <a href="{{ route('photographer.events.index') }}" 
           class="block p-6 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow hover:shadow-lg transition-all">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-lg">I Miei Eventi</h4>
                    <p class="text-green-100 text-sm">Gestisci i tuoi eventi</p>
                </div>
            </div>
        </a>

        <a href="{{ route('photographer.leads.index') }}" 
           class="block p-6 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg shadow hover:shadow-lg transition-all">
            <div class="flex items-center">
                <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-lg">Tutti i Lead</h4>
                    <p class="text-purple-100 text-sm">Visualizza tutti i clienti</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection