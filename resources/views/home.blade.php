<!DOCTYPE html>
<html lang="en">

@include('partials.head', ['pageTitle' => 'Home Page', 'metaTitle' => 'Home Page del sito laravel'])

<body>
    @include('partials.menu')
    <h1>HOME</h1>

    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @auth
        <form action="{{ route('logoutUser')}}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            
        @endauth
    </div>


</body>

</html>
