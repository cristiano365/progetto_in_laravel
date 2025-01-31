@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@section('content')
<div class="bg-white shadow p-6 rounded mt-8">
    <h1 class="text-2xl font-bold mb-2">Benvenuto Cliente, {{ Auth::user()->name }}</h1>
    <p class="text-gray-700 mb-4">Puoi  visualizzare gli eventi disponibili</p>

    <a href="{{ route('events.index') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       Vedi Eventi
    </a>
</div>
@endsection
