<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Dashboard Gestore</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">Gestionale Comune</span>
        <form action="{{ route('logoutUser') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        
    </nav>

    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Benvenuto Gestore, {{ Auth::user()->name }}</h1>
        <p>Hai accesso a TUTTI gli eventi, ma puoi modificare o cancellare solo quelli creati da te.</p>

        @if($events->count() > 0)
            <ul>
                @foreach($events as $event)
                    <li>
                        <strong>{{ $event->title }}</strong>
                        (Creato da: {{ $event->user->name }})
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nessun evento presente.</p>
        @endif

        <a href="{{ route('events.create') }}" class="btn btn-success">Crea Evento (assegnato a te stesso)</a>
    </div>

</body>
</html>
