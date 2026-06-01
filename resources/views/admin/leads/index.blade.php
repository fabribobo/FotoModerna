@extends('layouts.app')

@section('title', 'Leads - Amministrazione - Fotomoderna')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Leads</h1>
            </div>

            <livewire:admin.lead-index />
        </div>
    </div>
@endsection