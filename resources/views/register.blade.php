<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrazione Utente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>


    <div class="container mt-5">
        <h1>Registrazione Utente</h1>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registerUser') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required> 
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Conferma password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" required> 
            </div>

            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>

</body>

</html>
