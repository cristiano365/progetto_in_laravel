@extends('layouts.app')

@section('title', 'Dashboard Gestore')

@section('content')
<div class="bg-white shadow p-6 rounded mt-8">
    <h1 class="text-2xl font-bold mb-2">Benvenuto Gestore, {{ Auth::user()->name }}</h1>
    <p class="text-gray-700 mb-4">
        Puoi modificare o cancellare solo gli eventi creati da te, ma li vedi comunque tutti.
    </p>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('events.index') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       Vai alla lista eventi
    </a>
</div>
@endsection
