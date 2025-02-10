@extends('layouts.app')

@section('title', 'Tutti gli Eventi')

@section('content')
<div class="bg-white p-6 rounded shadow mt-8">
    <h1 class="text-2xl font-bold mb-4">Elenco Eventi</h1>

    <form method="GET" action="{{ route('events.index') }}" class="mb-4">
        <label for="filter_category" class="mr-2">Filtra per Categoria:</label>
        <select name="category" id="filter_category" class="border p-1">
            <option value="">-- Tutte --</option>
            @php
                $catValues = ['cultura','turismo','sport','esperienza','convegni'];
                $selectedCat = request('category'); // Recupera ?category=...
            @endphp
            @foreach($catValues as $cv)
                <option value="{{ $cv }}" 
                    @if($selectedCat == $cv) selected @endif>
                    {{ ucfirst($cv) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">
            Filtra
        </button>
    </form>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(count($events) > 0)
        <ul class="space-y-2">
            @foreach($events as $event)
                <li class="border p-3 rounded flex justify-between items-center">
                    <div>
                        <strong>{{ $event->title }}</strong><br/>
                        
                        <span class="text-sm text-gray-500">
                            (Creato da: <strong>{{ $event->userName }}</strong>)
                        </span>
                        <br/>
                        
                        <span>Categoria: 
                            <strong>{{ $event->category ?? 'Nessuna' }}</strong>
                        </span>
                        <br/>
                        
                        <a href="{{ route('events.show', $event->id) }}" 
                           class="text-blue-500 hover:underline">
                            Dettagli
                        </a>
                    </div>

                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'gestore')
                        <div class="flex space-x-2">
                            <a href="{{ route('events.edit', $event->id) }}"
                               class="bg-yellow-500 text-white px-2 py-1 rounded">
                                Modifica
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-2 py-1 rounded"
                                        onclick="return confirm('Confermi l\'eliminazione?')">
                                    Elimina
                                </button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Nessun evento presente.</p>
    @endif

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'gestore')
        <a href="{{ route('events.create') }}"
           class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Crea nuovo evento
        </a>
    @endif
</div>
@endsection
