@extends('layouts.app')

@section('title', 'Dettaglio Evento')

@section('content')
<div class="bg-white shadow p-6 rounded mt-8">
    <h1 class="text-2xl font-bold mb-2">{{ $event->title }}</h1>
    <p class="text-gray-600 mb-2">
        Creato da: {{ $event->userName }}<br/>
        Data: {{ $event->date }}<br/>
        Location: {{ $event->location }}<br/>
        Categoria: {{ $event->category ?? 'Nessuna' }}
    </p>

    <p class="mb-4">
        {{ $event->description }}
    </p>

    <p class="mb-4">
        Contatti: {{ $event->userMail }}
    </p>

    <a href="{{ route('events.index') }}" class="text-blue-500 hover:underline">
        Torna all'elenco eventi
    </a>
</div>
@endsection
