@extends('layouts.admin')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Parking Slot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Create New Parking Slot</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-secondary">Back to Slots</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.parking-slots.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Slot Number *</label>
                        <input type="text" name="slotNumber" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g., Ground Floor, Section A">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price Per Hour ($) *</label>
                        <input type="number" name="pricePerHour" step="0.01" class="form-control" value="50.00" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="Available">Available</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Under Maintenance</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Slot</button>
                    <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>