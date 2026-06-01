@extends('layouts.app')

@section('title', 'Modifica Evento - Amministrazione - Fotomoderna')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="mb-6">
            <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Torna al dettaglio evento
            </a>
        </div>

        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Modifica Evento: {{ $event->name }}</h1>

        <div class="bg-white shadow-sm sm:rounded-lg">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome Evento *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="event_date" class="block text-sm font-medium text-gray-700">Data Evento *</label>
                        <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('event_date') border-red-500 @enderror">
                        @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Luogo *</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrizione</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Stato *</label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('status') border-red-500 @enderror">
                        <option value="planned" {{ old('status', $event->status) === 'planned' ? 'selected' : '' }}>Pianificato</option>
                        <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>In corso</option>
                        <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Completato</option>
                        <option value="cancelled" {{ old('status', $event->status) === 'cancelled' ? 'selected' : '' }}>Annullato</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="photographer_id" class="block text-sm font-medium text-gray-700">Fotografo Principale</label>
                    <select name="photographer_id" id="photographer_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('photographer_id') border-red-500 @enderror">
                        <option value="">Nessuno</option>
                        @foreach($photographers as $photographer)
                            <option value="{{ $photographer->id }}" {{ old('photographer_id', $event->photographer_id) == $photographer->id ? 'selected' : '' }}>
                                {{ $photographer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('photographer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fotografi Assegnati</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
                        @foreach($photographers as $photographer)
                            <label class="flex items-center">
                                <input type="checkbox" name="photographers[]" value="{{ $photographer->id }}"
                                       {{ in_array($photographer->id, old('photographers', $assignedPhotographers)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $photographer->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Seleziona i fotografi che lavoreranno a questo evento</p>
                    @error('photographers')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.events.show', $event) }}"
                       class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Annulla
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Salva Modifiche
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
