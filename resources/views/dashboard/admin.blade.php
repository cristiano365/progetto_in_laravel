<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Dashboard Admin</title>
    
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

        <h1>Benvenuto Admin, {{ Auth::user()->name }}</h1>
        <p>Qui puoi visualizzare e gestire TUTTI gli eventi.</p>

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

        <a href="{{ route('events.create') }}" class="btn btn-success">Crea un nuovo evento</a>
    </div>

</body>
</html>
