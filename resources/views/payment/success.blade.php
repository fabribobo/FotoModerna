@extends('layouts.guest')

@section('content')
    <div class="max-w-md mx-auto py-16 px-4 text-center">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4">Grazie!</h1>
        <p class="text-gray-600">
            Stiamo confermando il tuo pagamento per l'evento <strong>{{ $order->event->name }}</strong>.
            Riceverai a breve un'email con il link per scaricare le tue foto.
        </p>
    </div>
@endsection
