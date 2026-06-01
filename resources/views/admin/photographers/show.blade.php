@extends('layouts.app')

@section('title', $photographer->name . ' - Fotomoderna')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <a href="{{ route('admin.photographers.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $photographer->name }}</h1>
                <p class="text-gray-600 mt-1">Dettagli fotografo</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.photographers.edit', $photographer) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Modifica
            </a>
            <form action="{{ route('admin.photographers.destroy', $photographer) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo fotografo? Questa azione non può essere annullata.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Elimina
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informazioni Principali -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Dati del fotografo -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informazioni Account</h2>
            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $photographer->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $photographer->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Ruolo</dt>
                    <dd class="mt-1">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            Fotografo
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Data Registrazione</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $photographer->created_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Eventi assegnati -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Eventi Assegnati</h2>
            @if ($photographer->events->count() > 0)
                <div class="space-y-3">
                    @foreach ($photographer->events as $event)
                        <a href="{{ route('admin.events.show', $event) }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $event->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $event->event_date->format('d/m/Y') }} - {{ $event->location }}
                                    </p>
                                </div>
                                @if ($event->status === 'planned')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pianificato</span>
                                @elseif ($event->status === 'ongoing')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">In corso</span>
                                @elseif ($event->status === 'completed')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Completato</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Annullato</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">Nessun evento assegnato</p>
            @endif
        </div>

        <!-- Lead creati -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Lead Creati</h2>
            @if ($photographer->leads->count() > 0)
                <div class="space-y-3">
                    @foreach ($photographer->leads->take(10) as $lead)
                        <a href="{{ route('admin.leads.show', $lead) }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $lead->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $lead->email }} - {{ $lead->phone }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $lead->created_at->format('d/m/Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                    @if ($photographer->leads->count() > 10)
                        <p class="text-sm text-gray-500 text-center pt-2">
                            e altri {{ $photographer->leads->count() - 10 }} lead...
                        </p>
                    @endif
                </div>
            @else
                <p class="text-gray-500 text-sm">Nessun lead creato</p>
            @endif
        </div>
    </div>

    <!-- Sidebar Statistiche -->
    <div class="space-y-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistiche</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Eventi Totali</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $photographer->events_count }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Lead Totali</span>
                    <span class="text-2xl font-bold text-green-600">{{ $photographer->leads_count }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Foto Caricate</span>
                    <span class="text-2xl font-bold text-purple-600">{{ $photographer->photos_count }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
