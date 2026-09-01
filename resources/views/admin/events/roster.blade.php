@extends('layouts.app')

@section('title', 'Matricole - ' . $event->name . ' - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Matricole attese - {{ $event->name }}</h1>
                <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Torna all'evento
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Importa elenco</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Incolla una matricola per riga. Se conosci anche il nome, separalo con una virgola o un
                        punto e virgola (es. <code>123456,Mario Rossi</code>). Il fotografo potrà richiamare la
                        matricola il giorno dell'evento per ritrovare i dati.
                    </p>
                    <form action="{{ route('admin.events.roster.store', $event) }}" method="POST">
                        @csrf
                        <textarea name="list" rows="8" placeholder="123456,Mario Rossi&#10;123457&#10;123458,Anna Bianchi"
                            class="block w-full font-mono text-sm shadow-sm focus:ring-primary-500 focus:border-primary-500 border-gray-300 rounded-md"
                            required>{{ old('list') }}</textarea>
                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Importa
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        Elenco ({{ $students->count() }}) &middot;
                        Presenti {{ $students->whereNotNull('matched_lead_id')->count() }}
                    </h2>

                    @if($students->isEmpty())
                        <p class="text-gray-500 text-sm">Nessuna matricola importata per questo evento</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Matricola</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stato</th>
                                        <th class="px-3 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="px-3 py-2 text-sm text-gray-900 font-mono">{{ $student->matricola }}</td>
                                            <td class="px-3 py-2 text-sm text-gray-900">{{ $student->name ?? '-' }}</td>
                                            <td class="px-3 py-2 text-sm">
                                                @if($student->matched_lead_id)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Presente
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        In attesa
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                <form action="{{ route('admin.events.roster.destroy', [$event, $student]) }}" method="POST"
                                                    onsubmit="return confirm('Rimuovere questa matricola dall\'elenco?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Rimuovi</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
