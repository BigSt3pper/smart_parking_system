@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">User Login</h2>

<form method="POST" action="/login">
    @csrf
    <input type="text" name="email" placeholder="Email" class="block mb-2 p-2 border rounded w-full">
    <input type="password" name="password" placeholder="Password" class="block mb-4 p-2 border rounded w-full">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
</form>

<p class="mt-3">No account? <a class="text-blue-600" href="/register">Register</a></p>
@endsection
