@extends('admin.layouts.app')

@section('content')
<div class=""container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Parking Slots Management</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('admin.parking-slots.create')}}" class="btn btn-primary">
                Add New Slot
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thread>
                    <tr>
                        <th>Slot ID</th>
                        <th>Slot Number </th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Price/Hour</th>
                        <th>Actions</th>
                    </tr>
                </thread>
                <tbody>
                    @foreach($slots as $slot)
                    <tr>
                        <td>{{ $slot->id }}</td>
                        <td>{{ $slot->slot_number }}</td>
                        <td>{{ $slot->location }}</td>
                        <td>
                            <span class="badge badge-{{$slot->status == 'Available' ? 'success' : 'danger'}}">
                                {{ $slot->status }}
                            </span>
                        </td>
                        <td>${{ $slot->price_per_hour }}</td>
                        <td>
                            <a href="{{ route('admin.parking-slots.edit', $slot->id) }}" class="btn btn-sm btn-warning">Edit</a>
    <form action="{{ route('admin.parking-slots.destroy', $slot->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" 
                onclick="return confirm('Are you sure you want to delete this slot?')">
            Delete
        </button>
    </form>
</td>
            </table>
        </div>
    </div>
</div>
@endsection