@extends('layouts.app')

@section('title')
    @if($editMode)
        Modifica Evento
    @else
        Crea Nuovo Evento
    @endif
@endsection

@section('content')
<div class="bg-white shadow p-6 rounded mt-8 max-w-xl mx-auto">

    <h1 class="text-xl font-bold mb-4">
        @if($editMode)
            Modifica Evento
        @else
            Crea Nuovo Evento
        @endif

        @if(Auth::user()->role === 'admin')
            (Admin)
        @endif
    </h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($editMode && $event)
        <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-4">
            @method('PUT')
    @else
        <form action="{{ route('events.store') }}" method="POST" class="space-y-4">
    @endif
        @csrf

        <div>
            <label for="title" class="block font-semibold mb-1">Titolo</label>
            <input type="text"
                   name="title"
                   id="title"
                   required
                   class="w-full border border-gray-300 rounded px-3 py-2"
                   value="@if($editMode && $event){{ old('title', $event->title) }}@else{{ old('title') }}@endif"
            />
        </div>

        <div>
            <label for="description" class="block font-semibold mb-1">Descrizione</label>
            <textarea
                name="description"
                id="description"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >@if($editMode && $event){{ old('description', $event->description) }}@else{{ old('description') }}@endif</textarea>
        </div>

        <div>
            <label for="date" class="block font-semibold mb-1">Data</label>
            @php
                $dateValue = '';
                if ($editMode && $event) {
                    $dateValue = old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i'));
                } else {
                    $dateValue = old('date'); 
                }
            @endphp
            <input type="datetime-local"
                   name="date"
                   id="date"
                   class="w-full border border-gray-300 rounded px-3 py-2"
                   required
                   value="{{ $dateValue }}"
            />
        </div>

        <div>
            <label for="location" class="block font-semibold mb-1">Location</label>
            <input type="text"
                   name="location"
                   id="location"
                   class="w-full border border-gray-300 rounded px-3 py-2"
                   required
                   value="@if($editMode && $event){{ old('location', $event->location) }}@else{{ old('location') }}@endif"
            />
        </div>

        @if(Auth::user()->role === 'admin')
            <div>
                <label for="gestore_id" class="block font-semibold mb-1">Assegna a Gestore</label>
                <select name="gestore_id"
                        id="gestore_id"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Seleziona Gestore --</option>
                    @if($gestori && $gestori->isNotEmpty())
                        @foreach($gestori as $g)
                            @php
                                $selected = false;
                                if($editMode && $event) {
                                    $selected = old('gestore_id', $event->user_id) == $g->id;
                                } else {
                                    $selected = old('gestore_id') == $g->id;
                                }
                            @endphp

                            <option value="{{ $g->id }}" @if($selected) selected @endif>
                                {{ $g->name }} ({{ $g->email }})
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif

        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded">
            @if($editMode)
                Aggiorna
            @else
                Crea
            @endif
        </button>
    </form>
</div>
@endsection
