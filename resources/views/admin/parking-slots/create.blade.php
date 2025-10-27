@extends('admin.layouts.app')

@section('content')
<div class="container-fuild">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Add New Parking Slot</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-secondary">
               <- Back to Slots
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.parking-slots.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="slot_number">Slot Number</label>
                    <input type="text" name="slot_number" class="form-control"
                        value="{{ old('slot_number') }}" required>
                    @error('slot_number')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control"
                        value="{{ old('location') }}" placeholder="e.g., Level 1 - A3" required>
                </div>

                <div class="form-group">
                    <label for="price_per_hour">Price per Hour ($) </label>
                    <input type="number" name="price_per_hour" class="form-control" 
                        value="{{ old('price_per_hour', 50.00) }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                        <option value="Maintenance">Under Maintenance</option>    
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Create Parking Slot</button>
                <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection