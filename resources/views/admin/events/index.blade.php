@extends('layouts.app')

@section('title', 'Eventi - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Gestione Eventi</h1>
                <a href="{{ route('admin.events.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Nuovo Evento
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                @if($events->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Nessun evento presente</p>
                        <a href="{{ route('admin.events.create') }}"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            Crea il primo evento
                        </a>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($events as $event)
                            <li>
                                <a href="{{ route('admin.events.show', $event) }}" class="block hover:bg-gray-50 transition">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-lg font-medium text-primary-600 truncate">
                                                        {{ $event->name }}
                                                    </p>
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
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-500 space-x-4">
                                                    <span class="flex items-center">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        {{ $event->event_date->format('d/m/Y') }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        {{ $event->location }}
                                                    </span>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-500 space-x-4">
                                                    <span>{{ $event->leads_count }} lead</span>
                                                    <span>{{ $event->photos_count }} foto</span>
                                                    <span>{{ $event->photographers->count() }}
                                                        {{ $event->photographers->count() === 1 ? 'fotografo assegnato' : 'fotografi assegnati' }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-5 flex-shrink-0">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="px-4 py-3 border-t border-gray-200">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection