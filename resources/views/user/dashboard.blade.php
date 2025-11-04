@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold">Welcome to Smart Parking</h2>
<p>Choose an option below:</p>

<div class="grid grid-cols-2 gap-4 mt-4">
    <a href="/view-slots" class="p-4 bg-white shadow rounded text-center">View Slots</a>
    <a href="/my-bookings" class="p-4 bg-white shadow rounded text-center">My Bookings</a>
</div>
@endsection
