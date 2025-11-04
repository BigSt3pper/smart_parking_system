@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">My Bookings</h2>

<table class="w-full bg-white shadow rounded">
<tr><th>Slot</th><th>Date</th><th>Action</th></tr>
<tr>
<td>P1</td>
<td>10/02/2025</td>
<td><a href="#" class="text-red-600">Cancel</a></td>
</tr>
</table>
@endsection
