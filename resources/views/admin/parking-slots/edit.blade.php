<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking Slot - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container-fluid { padding: 20px; }
        .btn-primary-custom { background: linear-gradient(45deg, #007bff, #0056b3); border: none; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-pencil me-2"></i> Edit Parking Slot</h2>
            <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Parking Slots
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Edit Parking Slot Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.parking-slots.update', $parkingSlot) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="slot_number" class="form-label">Slot Number *</label>
                                    <input type="text" class="form-control" id="slot_number" name="slot_number" 
                                           value="{{ old('slot_number', $parkingSlot->slotNumber) }}" required>
                                    @error('slot_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" 
                                           value="{{ old('location', $parkingSlot->location) }}">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Available" {{ $parkingSlot->status == 'Available' ? 'selected' : '' }}>Available</option>
                                        <option value="Occupied" {{ $parkingSlot->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="Maintenance" {{ $parkingSlot->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="price_per_hour" class="form-label">Price Per Hour ($) *</label>
                                    <input type="number" class="form-control" id="price_per_hour" name="price_per_hour" 
                                           step="0.01" min="0" value="{{ old('price_per_hour', $parkingSlot->pricePerHour) }}" required>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-outline-secondary me-2">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary-custom">
                                            <i class="bi bi-save me-1"></i> Update Parking Slot
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>