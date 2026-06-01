<div>
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-4">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1" for="search">Cerca</label>
            <input id="search" type="text" placeholder="Nome, email o telefono..."
                class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                wire:model.debounce.300ms="search" />
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1" for="event">Evento</label>
            <select id="event"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                wire:model="eventId">
                <option value="">Tutti gli eventi</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">
                        {{ $event->name }} @if($event->event_date) ({{ $event->event_date->format('d/m/Y') }}) @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1" for="photographer">Fotografo</label>
            <select id="photographer"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                wire:model="photographerId">
                <option value="">Tutti i fotografi</option>
                @foreach($photographers as $photographer)
                    <option value="{{ $photographer->id }}">{{ $photographer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1" for="orderStatus">Stato ordine</label>
            <select id="orderStatus"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                wire:model="orderStatus">
                <option value="">Tutti</option>
                <option value="none">Senza ordine</option>
                <option value="pending">Ordine creato (in attesa)</option>
                <option value="paid">Ordine pagato</option>
                <option value="cancelled">Ordine cancellato</option>
            </select>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if ($leads->isEmpty())
                <p class="text-gray-500 text-center py-4">Nessun lead trovato.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telefono</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Evento</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fotografo</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stato
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ordine</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($leads as $lead)
                            <tr wire:key="lead-{{ $lead->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $lead->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $lead->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $lead->event->name ?? 'N/A' }}</div>
                                    @if($lead->event && $lead->event->event_date)
                                        <div class="text-xs text-gray-500">{{ $lead->event->event_date->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $lead->photographer->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $order = $lead->order;
                                    @endphp
                                    @if(!$order)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            Nessun ordine
                                        </span>
                                    @else
                                                            @php
                                                                $orderStatusColors = [
                                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                                    'paid' => 'bg-green-100 text-green-800',
                                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                                ];
                                                                $pStatus = $order->payment_status;
                                                            @endphp
                                         <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $orderStatusColors[$pStatus] ?? 'bg-gray-100 text-gray-800' }}">
                                                                @if($pStatus === 'pending')
                                                                    Ordine creato
                                                                @elseif($pStatus === 'paid')
                                                                    Ordine pagato
                                                                @else
                                                                    {{ strtoupper($pStatus) }}
                                                                @endif
                                                            </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.leads.show', $lead) }}"
                                        class="text-primary-600 hover:text-primary-900">Dettagli</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $leads->links() }}
                </div>
            @endif
        </div>
    </div>
</div>