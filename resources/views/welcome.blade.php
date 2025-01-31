@extends('layouts.app')

@section('title', 'Benvenuto nel Gestionale')

@section('content')
<div class="mt-8 bg-white shadow p-6 rounded centered max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Benvenuto!</h1>

    @auth
        <p class="text-gray-700">
            Ti sei autenticato come {{ Auth::user()->name }}. 
            Puoi accedere alla tua <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>.
        </p>
    @else
        <p class="text-gray-700 mb-4">Effettua il login o registrati.</p>
        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Login</a>
        <a href="{{ route('register.form') }}" class="bg-green-500 text-white px-4 py-2 rounded">Register</a>
    @endauth
</div>
@endsection
