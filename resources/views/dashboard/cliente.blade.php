<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Dashboard Cliente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">Gestionale Comune</span>
        <div>
     
            <form action="{{ route('logoutUser') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Benvenuto Cliente, {{ Auth::user()->name }}</h1>
        <p>Puoi solo visualizzare gli eventi creati dai gestori o dagli admin</p>

        @if($events->count() > 0)
            <ul>
                @foreach($events as $event)
                    <li>
                        <h2>{{ $event->title }}</h2>
                        (Creato da: {{ $event->user->name }})
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nessun evento presente.</p>
        @endif
    </div>

</body>
</html>
