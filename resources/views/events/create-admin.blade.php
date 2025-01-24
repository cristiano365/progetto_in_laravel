<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Crea Nuovo Evento (Admin)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Crea Nuovo Evento (Admin)</h2>

        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title">Titolo:</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="description">Descrizione:</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="date">Data e Ora:</label>
                <input type="datetime-local" id="date" name="date" class="form-control" value="{{ old('date') }}" required>
            </div>

            <div class="mb-3">
                <label for="location">Luogo:</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}" required>
            </div>

            <div class="mb-3">
                <label for="gestore_id">Assegna a Gestore:</label>
                <select id="gestore_id" name="gestore_id" required>
                    <option value="">Seleziona un gestore</option>
                    @foreach($gestori as $gestore)
                        <option value="{{ $gestore->id }}" {{ old('gestore_id') == $gestore->id ? 'selected' : '' }}>
                            {{ $gestore->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class= "btn btn-success">Crea Evento</button>
        </form>
    </div>
</body>
</html>