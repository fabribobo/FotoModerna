@extends('layouts.app')

@section('title', 'Dettaglio Ordine - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Ordine #{{ $order->id }}</h1>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Torna alla lista ordini
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Info ordine -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Dettagli Ordine</h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Lead</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($order->lead)
                                        <a href="{{ route('admin.leads.show', $order->lead) }}"
                                            class="text-primary-600 hover:text-primary-900">
                                            {{ $order->lead->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Evento</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $order->event->name ?? 'N/A' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tipo di servizio</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($order->service_type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Importo</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ number_format($order->amount, 2, ',', '.') }}
                                    &euro;</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stato pagamento</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'paid' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $status = $order->payment_status;
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ strtoupper($status) }}
                                    </span>
                                </dd>
                            </div>
                            @if($order->paid_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Data pagamento</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->paid_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Note</dt>
                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">
                                    {{ $order->notes ?: 'Nessuna nota presente.' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Azioni download / pagamento -->
                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Azioni</h2>
                            @if($order->payment_status !== 'paid')
                                <form action="{{ route('admin.orders.mark-paid', $order) }}" method="POST"
                                    onsubmit="return confirm('Segnare questo ordine come pagato e inviare il link di download al cliente?');">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Segna come pagato e invia link
                                    </button>
                                </form>
                            @else
                                <p class="text-sm text-gray-700 mb-2">Ordine già segnato come pagato.</p>
                                @if($order->isDownloadValid())
                                    <p class="text-sm text-gray-700 mb-2">Link di download valido fino al
                                        {{ $order->download_expires_at->format('d/m/Y') }}.
                                    </p>
                                    <a href="{{ $order->getDownloadUrl() }}" target="_blank"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Apri link download
                                    </a>
                                @else
                                    <p class="text-sm text-red-600">Il link di download è scaduto.</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection