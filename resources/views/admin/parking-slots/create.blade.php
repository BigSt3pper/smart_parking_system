@extends('admin.layouts.app')

@section('title', 'Create Parking Slot')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">
            <i class="bi bi-plus-circle me-2"></i> Create New Parking Slot
        </h2>
        <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Slots
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <form action="{{ route('admin.parking-slots.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slotNumber" class="form-label">Slot Number *</label>
                            <input type="text" name="slotNumber" class="form-control" 
                                   value="{{ old('slotNumber') }}" required
                                   placeholder="e.g., A1, B2, C3">
                            @error('slotNumber')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Occupied" {{ old('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" name="location" class="form-control" 
                                   value="{{ old('location') }}" required
                                   placeholder="e.g., Ground Floor, Section A, Near Entrance">
                            @error('location')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pricePerHour" class="form-label">Price Per Hour ($) *</label>
                            <input type="number" name="pricePerHour" step="0.01" min="0" 
                                   class="form-control" value="{{ old('pricePerHour', '5.00') }}" required
                                   placeholder="0.00">
                            @error('pricePerHour')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information (Optional) -->
                <div class="mb-3">
                    <label for="description" class="form-label">Additional Notes (Optional)</label>
                    <textarea name="description" class="form-control" rows="3" 
                              placeholder="Any additional information about this parking slot...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-1"></i> Create Parking Slot
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Help Text -->
    <div class="card card-custom mt-4">
        <div class="card-body">
            <h6 class="card-title">
                <i class="bi bi-info-circle me-2"></i> Creating Parking Slots
            </h6>
            <ul class="small text-muted mb-0">
                <li>Slot numbers should be unique and easily identifiable</li>
                <li>Set appropriate pricing based on location and demand</li>
                <li>Mark slots as "Under Maintenance" if they're temporarily unavailable</li>
                <li>Use location descriptions to help users find the slot easily</li>
            </ul>
        </div>
    </div>
</div>
@endsection
