@extends('layouts.app')

@section('title', 'Nuovo Lead - Fotomoderna')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Registra Nuovo Lead</h1>
                <a href="{{ route('photographer.leads.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Torna alla lista
                </a>
            </div>

            @if($event)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Cerca matricola</h2>
                        <p class="text-sm text-gray-500 mb-3">
                            Richiama la matricola: se è nell'elenco caricato dall'amministratore i dati verranno
                            precompilati, altrimenti inseriscili qui sotto.
                        </p>
                        <form action="{{ route('photographer.leads.create', $event) }}" method="GET" class="flex gap-2">
                            <input type="text" name="matricola" value="{{ $matricola }}" placeholder="Numero di matricola"
                                class="flex-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Cerca
                            </button>
                        </form>

                        @if($matricola !== '')
                            @if($expectedStudent)
                                <p class="mt-3 text-sm text-green-700">Matricola trovata in elenco: dati precompilati.</p>
                            @else
                                <p class="mt-3 text-sm text-yellow-700">Matricola non presente in elenco: inserisci i dati mancanti.</p>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Attenzione!</strong>
                            <span class="block sm:inline">Ci sono dei problemi con i dati inseriti.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('photographer.leads.store') }}" method="POST">
                        @csrf

                        <!-- Event Selection -->
                        <div class="mb-4">
                            <label for="event_id" class="block text-sm font-medium text-gray-700">Evento</label>
                            <select name="event_id" id="event_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                                required>
                                <option value="">Seleziona un evento</option>
                                @foreach($events as $evt)
                                    <option value="{{ $evt->id }}" {{ (old('event_id') == $evt->id || (isset($event) && $event->id == $evt->id)) ? 'selected' : '' }}>
                                        {{ $evt->name }} ({{ $evt->event_date->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Matricola -->
                        <div class="mb-4">
                            <label for="matricola" class="block text-sm font-medium text-gray-700">Matricola</label>
                            <input type="text" name="matricola" id="matricola"
                                value="{{ old('matricola', $matricola) }}"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $expectedStudent->name ?? '') }}"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telefono</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Note</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end pt-5">
                            <button type="button" onclick="history.back()"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 mr-3">
                                Annulla
                            </button>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Salva Lead
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection