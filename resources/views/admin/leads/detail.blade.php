@extends('layouts.app')

@section('title', 'Dettaglio Lead - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Dettaglio Lead: {{ $lead->name }}</h1>
                <div class="space-x-4">
                    <a href="{{ route('admin.leads.edit', $lead) }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded">
                        Modifica
                    </a>
                    <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline"
                        onsubmit="return confirm('Sei sicuro di voler cancellare questo lead? Questa operazione eliminerà anche foto e ordini associati.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-800 font-bold py-2 px-4 rounded">
                            Elimina
                        </button>
                    </form>
                    <a href="{{ route('admin.leads.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        &larr; Torna alla lista
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Lead info -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Dati Lead</h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $lead->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $lead->email }}"
                                        class="text-primary-600 hover:text-primary-900">{{ $lead->email }}</a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Telefono</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $lead->phone }}"
                                        class="text-primary-600 hover:text-primary-900">{{ $lead->phone }}</a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Evento</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($lead->event)
                                        <div class="font-semibold">{{ $lead->event->name }}</div>
                                        @if($lead->event->event_date)
                                            <div class="text-xs text-gray-500">{{ $lead->event->event_date->format('d/m/Y') }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-500">Nessun evento associato</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fotografo</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($lead->photographer)
                                        {{ $lead->photographer->name }} ({{ $lead->photographer->email }})
                                    @else
                                        <span class="text-gray-500">Nessun fotografo associato</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stato</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $statusLabels = [
                                            'nuovo' => 'Nuovo',
                                            'contattato' => 'Contattato',
                                            'in_trattativa' => 'In trattativa',
                                            'convertito' => 'Convertito',
                                            'chiuso' => 'Chiuso',
                                        ];
                                        $statusColors = [
                                            'nuovo' => 'bg-blue-100 text-blue-800',
                                            'contattato' => 'bg-yellow-100 text-yellow-800',
                                            'in_trattativa' => 'bg-purple-100 text-purple-800',
                                            'convertito' => 'bg-green-100 text-green-800',
                                            'chiuso' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $status = $lead->status ?? 'nuovo';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Note</dt>
                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">
                                    {{ $lead->notes ?: 'Nessuna nota presente.' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Order info / actions -->
                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Ordine</h2>
                            @if($lead->order)
                                <p class="text-sm text-gray-700 mb-2">
                                    Servizio: <strong>{{ $lead->order->service_type }}</strong>
                                </p>
                                <p class="text-sm text-gray-700 mb-2">
                                    Importo: <strong>{{ number_format($lead->order->amount, 2, ',', '.') }} &euro;</strong>
                                </p>
                                <p class="text-sm text-gray-700 mb-2">
                                    Stato pagamento: <strong class="uppercase">{{ $lead->order->payment_status }}</strong>
                                </p>
                                @if($lead->order->paid_at)
                                    <p class="text-sm text-gray-700 mb-2">
                                        Pagato il: {{ $lead->order->paid_at->format('d/m/Y H:i') }}
                                    </p>
                                @endif
                                <a href="{{ route('admin.orders.show', $lead->order) }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Vai all'ordine
                                </a>
                            @else
                                <p class="text-sm text-gray-500 mb-4">Nessun ordine creato per questo lead.</p>
                                <a href="{{ route('admin.orders.create', $lead) }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Crea ordine
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Photos summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Foto Caricate</h2>
                            @if($lead->photos->isEmpty())
                                <p class="text-sm text-gray-500">Nessuna foto caricata per questo lead.</p>
                            @else
                                <p class="text-sm text-gray-700 mb-2">Totale foto: <strong>{{ $lead->photos->count() }}</strong>
                                </p>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @foreach($lead->photos->take(4) as $photo)
                                        <div class="relative group overflow-hidden rounded-md bg-gray-100">
                                            <img src="{{ $photo->url }}" alt="{{ $photo->original_name }}"
                                                class="object-cover w-full h-24 group-hover:opacity-75">
                                        </div>
                                    @endforeach
                                </div>
                                @if($lead->photos->count() > 4)
                                    <p class="text-xs text-gray-500 mt-2">E altre {{ $lead->photos->count() - 4 }} foto...</p>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('admin.photos.index') }}"
                                        class="text-primary-600 hover:text-primary-900 text-sm">Vai alla gallery completa</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection