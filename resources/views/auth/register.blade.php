@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Create Account</h2>

<form method="POST" action="/register">
    @csrf
    <input type="text" name="name" placeholder="Full Name" class="block mb-2 p-2 border rounded w-full">
    <input type="email" name="email" placeholder="Email" class="block mb-2 p-2 border rounded w-full">
    <input type="password" name="password" placeholder="Password" class="block mb-4 p-2 border rounded w-full">

    <button class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
</form>
@endsection
