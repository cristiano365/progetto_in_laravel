<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Gestionale Eventi')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

</head>
<body class="min-h-screen bg-gray-100">

    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <div class="text-lg font-bold">
            <a class="border-2 p-2 bg-blue-500 transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500" href="{{ route('home') }}">HOME</a>
        </div>
        <div>
            @auth
                <span class="mr-4 text-gray-700">Ciao, {{ Auth::user()->name }}</span>
                <form action="{{ route('logoutUser') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded">
                        Logout
                    </button>
                </form>
            @endauth
            
        </div>
    </nav>

    
    <div class="container mx-auto mt-8 px-4">
        @yield('content')
    </div>
</body>
</html>
