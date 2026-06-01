@extends('layouts.app')

@section('title', 'I Miei Eventi - Fotomoderna')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">I Miei Eventi</h1>
    <p class="text-gray-600 mt-2">Eventi fotografici assegnati</p>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($events as $event)
                <a href="{{ route('photographer.events.show', $event) }}" class="block bg-white border border-gray-200 rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $event->name }}</h3>
                            @if($event->status === 'planned')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pianificato</span>
                            @elseif($event->status === 'ongoing')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">In corso</span>
                            @elseif($event->status === 'completed')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Completato</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Annullato</span>
                            @endif
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $event->event_date->format('d/m/Y') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $event->location }}
                            </div>
                        </div>

                        @if($event->description)
                            <p class="mt-3 text-sm text-gray-500">{{ Str::limit($event->description, 80) }}</p>
                        @endif

                        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                {{ $event->leads_count ?? 0 }} lead
                            </span>
                            <span class="text-primary-600 text-sm font-medium">
                                Dettagli →
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $events->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun evento</h3>
            <p class="mt-1 text-sm text-gray-500">Non hai eventi assegnati al momento.</p>
        </div>
    @endif
</div>
@endsection
