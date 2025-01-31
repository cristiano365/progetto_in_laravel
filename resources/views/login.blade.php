@extends('layouts.app')

@section('title', 'Login Utente')

@section('content')
<div class="bg-white shadow p-6 rounded max-w-md mx-auto mt-8">
    <h1 class="text-xl font-bold mb-4">Login Utente</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('loginUser') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block font-semibold mb-1">Email:</label>
            <input type="email" id="email" name="email"
                   class="w-full border border-gray-300 rounded px-3 py-2"
                   value="{{ old('email') }}" required />
        </div>

        <div>
            <label for="password" class="block font-semibold mb-1">Password:</label>
            <input type="password" id="password" name="password"
                   class="w-full border border-gray-300 rounded px-3 py-2"
                   required />
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Login
        </button>
    </form>
</div>
@endsection
