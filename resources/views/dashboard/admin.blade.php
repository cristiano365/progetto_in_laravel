@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white shadow p-6 rounded mt-8 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-2">Benvenuto Admin, {{ Auth::user()->name }}</h1>
    <p class="text-gray-700 mb-4">Qui puoi visualizzare e gestire TUTTI gli eventi ( e in futuro anche gli utenti).</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex space-x-4">
        <a href="{{ route('events.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Gestisci Eventi
        </a>

        <a href="{{ route('users.index') }}" class="bg-green-500 text-white px-4 py-2 rounded">
            Gestisci Utenti
        </a>
    </div>
</div>
@endsection
