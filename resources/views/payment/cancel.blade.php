@extends('layouts.guest')

@section('content')
    <div class="max-w-md mx-auto py-16 px-4 text-center">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">Pagamento annullato</h1>
        <p class="text-gray-600">
            Il pagamento per l'evento <strong>{{ $order->event->name }}</strong> non è stato completato.
            Puoi riprovare in qualsiasi momento usando lo stesso link che ti abbiamo inviato via email.
        </p>
    </div>
@endsection
