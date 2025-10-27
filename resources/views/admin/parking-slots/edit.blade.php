@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Edit Parking Slot</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-secondary">
                ← Back to Slots
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.parking-slots.update', $parkingSlot->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="slotNumber">Slot Number *</label>
                    <input type="text" name="slotNumber" class="form-control" 
                           value="{{ old('slotNumber', $parkingSlot->slotNumber) }}" required>
                    @error('slotNumber')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control" 
                           value="{{ old('location', $parkingSlot->location) }}">
                </div>

                <div class="form-group">
                    <label for="pricePerHour">Price Per Hour ($) *</label>
                    <input type="number" name="pricePerHour" step="0.01" class="form-control" 
                           value="{{ old('pricePerHour', $parkingSlot->pricePerHour) }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="Available" {{ $parkingSlot->status == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Occupied" {{ $parkingSlot->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="Maintenance" {{ $parkingSlot->status == 'Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Parking Slot</button>
                <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
