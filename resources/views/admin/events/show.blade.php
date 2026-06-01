@extends('layouts.app')

@section('title', 'Evento: ' . $event->name . ' - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="mb-6">
                <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Torna alla lista eventi
                </a>
            </div>

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $event->name }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.events.edit', $event) }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Modifica
                    </a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline"
                        onsubmit="return confirm('Sei sicuro di voler eliminare questo evento? Questa azione eliminerà anche tutti i lead, le foto e gli ordini associati.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Elimina
                        </button>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Dettagli Evento -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Dettagli Evento</h2>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Data Evento</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $event->event_date->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Luogo</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $event->location }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Stato</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @php
                                            $statusColors = [
                                                'planned' => 'bg-blue-100 text-blue-800',
                                                'ongoing' => 'bg-green-100 text-green-800',
                                                'completed' => 'bg-gray-100 text-gray-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabels = [
                                                'planned' => 'Pianificato',
                                                'ongoing' => 'In corso',
                                                'completed' => 'Completato',
                                                'cancelled' => 'Annullato',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$event->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$event->status] ?? $event->status }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fotografo Principale</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $event->photographer->name ?? 'Non assegnato' }}
                                    </dd>
                                </div>
                                @if($event->description)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Descrizione</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $event->description }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Lead -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Lead ({{ $event->leads->count() }})</h2>
                            @if($event->leads->isEmpty())
                                <p class="text-gray-500 text-sm">Nessun lead presente per questo evento</p>
                            @else
                                <ul class="divide-y divide-gray-200">
                                    @foreach($event->leads as $lead)
                                        <li class="py-3">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $lead->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $lead->email }} - {{ $lead->phone }}</p>
                                                </div>
                                                <a href="{{ route('admin.leads.show', $lead) }}"
                                                    class="text-primary-600 hover:text-primary-900 text-sm">
                                                    Dettagli &rarr;
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Fotografi Assegnati -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Fotografi Assegnati</h2>
                            @if($event->photographers->isEmpty())
                                <p class="text-gray-500 text-sm">Nessun fotografo assegnato</p>
                            @else
                                <ul class="space-y-2">
                                    @foreach($event->photographers as $photographer)
                                        <li class="flex items-center text-sm text-gray-900">
                                            <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $photographer->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Statistiche -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Statistiche</h2>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Lead</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $event->leads->count() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Foto</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $event->photos->count() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Fotografi</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $event->photographers->count() }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection