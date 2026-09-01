@extends('layouts.app')

@section('title', 'Dettaglio Lead - Fotomoderna')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Dettaglio Lead: {{ $lead->name }}</h1>
                <div class="space-x-4">
                    <a href="{{ route('photographer.leads.edit', $lead) }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded">
                        Modifica
                    </a>
                    <a href="{{ route('photographer.leads.index') }}" class="text-gray-600 hover:text-gray-900">
                        &larr; Torna alla lista
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    @if (session('paymentUrl'))
                        <p class="mt-2 text-sm break-all">
                            Link di pagamento: <a href="{{ session('paymentUrl') }}" target="_blank" class="underline">{{ session('paymentUrl') }}</a>
                        </p>
                    @endif
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Pagamento -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pagamento</h3>

                    @if($lead->order)
                        <p class="text-sm text-gray-700">
                            <strong>Importo:</strong> {{ number_format($lead->order->amount, 2, ',', '.') }} &euro;
                        </p>
                        <p class="text-sm text-gray-700">
                            <strong>Stato:</strong>
                            @if($lead->order->payment_status === 'paid')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">PAGATO</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">IN ATTESA</span>
                            @endif
                        </p>
                    @else
                        <p class="text-gray-500 text-sm mb-4">Nessun ordine ancora registrato per questo lead.</p>
                        <a href="{{ route('photographer.orders.create', $lead) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Registra incasso
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Nome Completo
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $lead->name }}
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Email
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $lead->email }}"
                                    class="text-primary-600 hover:text-primary-900">{{ $lead->email }}</a>
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Telefono
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="tel:{{ $lead->phone }}"
                                    class="text-primary-600 hover:text-primary-900">{{ $lead->phone }}</a>
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Evento
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <strong>{{ $lead->event->name }}</strong> - {{ $lead->event->event_date->format('d/m/Y') }}
                            </dd>
                        </div>

                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">
                                Note
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">
                                {{ $lead->notes ?: 'Nessuna nota presente.' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Linked Photos Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Foto Associate</h3>

                        <a href="{{ route('photographer.photos.upload', $lead) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Upload Foto
                        </a>
                    </div>

                    @if($lead->photos->isEmpty())
                        <p class="text-gray-500 text-sm">Nessuna foto caricata per questo lead.</p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($lead->photos as $photo)
                                <div
                                    class="relative group aspect-w-1 aspect-h-1 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-primary-500">
                                    <img src="{{ $photo->url }}" alt=""
                                        class="object-cover pointer-events-none group-hover:opacity-75">
                                    <button type="button" class="absolute inset-0 focus:outline-none">
                                        <span class="sr-only">View details for {{ $photo->filename }}</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection