@extends('layouts.app')

@section('title', 'Tutti gli Utenti')

@section('content')
<div class="bg-white p-6 rounded shadow mt-8">
    <h1 class="text-2xl font-bold mb-4">Elenco Utenti</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(count($users) > 0)
        <ul class="space-y-2">
            @foreach($users as $user)
                <li class="border p-3 rounded flex justify-between items-center">
                    <div>
                        <strong>Nome utente: {{ $user-> name }}</strong>
                        <br/>
                        <span>
                            Contatto: {{ $user-> email }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>Nessun utente presente.</p>
    @endif
</div>
@endsection
