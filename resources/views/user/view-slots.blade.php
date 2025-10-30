@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Available Parking Slots</h2>

<table class="w-full bg-white shadow rounded">
    <tr><th>Slot</th><th>Status</th><th>Action</th></tr>
    <tr>
        <td>P1</td>
        <td>Available</td>
        <td><a href="/book-slot" class="text-blue-600">Book</a></td>
    </tr>
</table>
@endsection
