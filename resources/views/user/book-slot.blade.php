@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Book Parking Slot</h2>

<form method="POST" action="/book-slot">
@csrf
<input type="text" name="slot" placeholder="Slot ID" class="block mb-2 p-2 border rounded w-full">
<input type="datetime-local" name="time" class="block mb-2 p-2 border rounded w-full">

<button class="bg-blue-600 text-white px-4 py-2 rounded">Confirm Booking</button>
</form>
@endsection
