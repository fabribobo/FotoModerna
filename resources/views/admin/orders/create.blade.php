@extends('layouts.app')

@section('title', 'Crea Ordine - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Crea Ordine per {{ $lead->name }}</h1>
                <a href="{{ route('admin.leads.show', $lead) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Torna al lead
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                            <strong class="font-bold">Attenzione!</strong>
                            <span class="block sm:inline">Ci sono dei problemi con i dati inseriti.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200">
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Riepilogo Lead</h2>
                        <p class="text-sm text-gray-700"><strong>Nome:</strong> {{ $lead->name }}</p>
                        <p class="text-sm text-gray-700"><strong>Email:</strong> {{ $lead->email }}</p>
                        <p class="text-sm text-gray-700"><strong>Telefono:</strong> {{ $lead->phone }}</p>
                        @if($lead->event)
                            <p class="text-sm text-gray-700"><strong>Evento:</strong> {{ $lead->event->name }}
                                @if($lead->event->event_date) ({{ $lead->event->event_date->format('d/m/Y') }}) @endif
                            </p>
                        @endif
                    </div>

                    <form action="{{ route('admin.orders.store', $lead) }}" method="POST">
                        @csrf

                        <!-- Tipo di servizio -->
                        <div class="mb-4">
                            <label for="service_type" class="block text-sm font-medium text-gray-700">Tipo di
                                servizio</label>
                            <select name="service_type" id="service_type"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                                required>
                                <option value="">Seleziona...</option>
                                @php
                                    $services = [
                                        'basic' => 'Pacchetto Basic',
                                        'premium' => 'Pacchetto Premium',
                                        'wedding' => 'Servizio Matrimonio',
                                        'event' => 'Evento Aziendale',
                                        'custom' => 'Personalizzato',
                                    ];
                                @endphp
                                @foreach($services as $value => $label)
                                    <option value="{{ $value }}" {{ old('service_type') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Importo -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Importo (€)</label>
                            <input type="number" step="0.01" min="0" name="amount" id="amount" value="{{ old('amount') }}"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>

                        <!-- Note -->
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Note (opzionali)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end pt-5">
                            <a href="{{ route('admin.leads.show', $lead) }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 mr-3">
                                Annulla
                            </a>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Crea Ordine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection