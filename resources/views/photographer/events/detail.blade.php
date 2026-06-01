@extends('layouts.app')

@section('title', $event->name . ' - Fotomoderna')

@section('content')
<div class="mb-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('photographer.events.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $event->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $event->event_date->format('d/m/Y') }} - {{ $event->location }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Dettagli Evento -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Dettagli Evento</h2>
            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nome Evento</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Data Evento</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->event_date->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->location }}</dd>
                </div>
                @if($event->description)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Descrizione</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->description }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Stato</dt>
                    <dd class="mt-1">
                        @if($event->status === 'planned')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pianificato</span>
                        @elseif($event->status === 'ongoing')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">In corso</span>
                        @elseif($event->status === 'completed')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Completato</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Annullato</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Lead dell'evento -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Lead Acquisiti</h2>
                <a href="{{ route('photographer.leads.create', $event) }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition text-sm">
                    Nuovo Lead
                </a>
            </div>
            
            @if($event->leads->count() > 0)
                <div class="space-y-3">
                    @foreach($event->leads as $lead)
                        <a href="{{ route('photographer.leads.show', $lead) }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $lead->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $lead->email }}</p>
                                    <p class="text-sm text-gray-500">{{ $lead->phone }}</p>
                                    @if($lead->notes)
                                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($lead->notes, 100) }}</p>
                                    @endif
                                </div>
                                <div class="text-right ml-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $lead->photos_count ?? 0 }} foto
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $lead->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun lead</h3>
                    <p class="mt-1 text-sm text-gray-500">Inizia acquisendo il primo lead per questo evento.</p>
                    <div class="mt-6">
                        <a href="{{ route('photographer.leads.create', $event) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            Crea Lead
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar Statistiche -->
    <div class="space-y-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistiche</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Lead Totali</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $event->leads->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Foto Totali</span>
                    <span class="text-2xl font-bold text-purple-600">{{ $event->leads->sum(function($lead) { return $lead->photos->count(); }) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Azioni</h2>
            <div class="space-y-2">
                <a href="{{ route('photographer.leads.create', $event) }}" class="block w-full text-center bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                    Nuovo Lead
                </a>
                <a href="{{ route('photographer.leads.index') }}" class="block w-full text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    Tutti i Lead
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
