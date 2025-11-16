<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container-fluid { padding: 20px; }
        .btn-primary-custom { background: linear-gradient(45deg, #007bff, #0056b3); border: none; }
        .form-section { margin-bottom: 1.5rem; }
        .section-title { 
            color: #2c3e50; 
            border-bottom: 1px solid #eaeaea; 
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-plus-circle me-2"></i> Create New Reservation</h2>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Reservations
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-custom">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Reservation Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.reservations.store') }}" method="POST">
                            @csrf
                            
                            <!-- User Information Section -->
                            <div class="form-section">
                                <h6 class="section-title">User Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="user_name" class="form-label">User Name *</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" 
                                               placeholder="Enter user's full name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_email" class="form-label">User Email *</label>
                                        <input type="email" class="form-control" id="user_email" name="user_email" 
                                               placeholder="Enter user's email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Vehicle Information Section -->
                            <div class="form-section">
                                <h6 class="section-title">Vehicle Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="vehicle_type" class="form-label">Vehicle Type *</label>
                                        <select class="form-control" id="vehicle_type" name="vehicle_type" required>
                                            <option value="">Select Vehicle Type</option>
                                            <option value="car">Car</option>
                                            <option value="suv">SUV</option>
                                            <option value="motorcycle">Motorcycle</option>
                                            <option value="truck">Truck</option>
                                            <option value="van">Van</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="license_plate" class="form-label">License Plate *</label>
                                        <input type="text" class="form-control" id="license_plate" name="license_plate" 
                                               placeholder="Enter license plate number" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Parking Slot Selection -->
                            <div class="form-section">
                                <h6 class="section-title">Parking Details</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="slot_id" class="form-label">Parking Slot *</label>
                                        <select class="form-control" id="slot_id" name="slot_id" required>
                                            <option value="">Select Available Slot</option>
                                            @foreach($slots as $slot)
                                                <option value="{{ $slot->slotID }}" data-price="{{ $slot->pricePerHour }}">
                                                    {{ $slot->slotNumber }} - ${{ $slot->pricePerHour }}/hour 
                                                    ({{ $slot->location }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Price Per Hour</label>
                                        <input type="text" class="form-control" id="display_price" readonly value="Select a slot">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Time Selection -->
                            <div class="form-section">
                                <h6 class="section-title">Time Selection</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="start_time" class="form-label">Start Time *</label>
                                        <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="end_time" class="form-label">End Time *</label>
                                        <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Reservation Summary -->
                            <div class="form-section">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Reservation Summary</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Duration:</strong> <span id="duration_display">0 hours</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Total Cost:</strong> $<span id="total_cost">0.00</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Status:</strong> <span class="badge bg-success">Active</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="form-section">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="reset" class="btn btn-outline-secondary me-2">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="bi bi-calendar-plus me-1"></i> Create Reservation
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Calculate duration and cost
        function calculateCost() {
            const startTime = new Date(document.getElementById('start_time').value);
            const endTime = new Date(document.getElementById('end_time').value);
            const slotSelect = document.getElementById('slot_id');
            const pricePerHour = slotSelect.options[slotSelect.selectedIndex]?.dataset.price || 0;
            
            if (startTime && endTime && endTime > startTime) {
                const durationMs = endTime - startTime;
                const durationHours = Math.ceil(durationMs / (1000 * 60 * 60));
                const totalCost = durationHours * pricePerHour;
                
                document.getElementById('duration_display').textContent = durationHours + ' hours';
                document.getElementById('total_cost').textContent = totalCost.toFixed(2);
            } else {
                document.getElementById('duration_display').textContent = '0 hours';
                document.getElementById('total_cost').textContent = '0.00';
            }
        }
        
        // Event listeners
        document.getElementById('slot_id').addEventListener('change', function() {
            const price = this.options[this.selectedIndex]?.dataset.price || 0;
            document.getElementById('display_price').value = '$' + price + '/hour';
            calculateCost();
        });
        
        document.getElementById('start_time').addEventListener('change', calculateCost);
        document.getElementById('end_time').addEventListener('change', calculateCost);
        
        // Set minimum datetime to now
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('start_time').min = now.toISOString().slice(0, 16);
        
        // Set default values for demo purposes
        document.addEventListener('DOMContentLoaded', function() {
            // Set default user name and email (admin)
            document.getElementById('user_name').value = "System Administrator";
            document.getElementById('user_email').value = "admin@smartparking.com";
            
            // Set default times (today, 1:30 PM to 8:00 PM)
            const today = new Date();
            const startTime = new Date(today);
            startTime.setHours(13, 30, 0, 0);
            
            const endTime = new Date(today);
            endTime.setHours(20, 0, 0, 0);
            
            document.getElementById('start_time').value = formatDateTimeLocal(startTime);
            document.getElementById('end_time').value = formatDateTimeLocal(endTime);
            
            // Set default parking slot
            const slotSelect = document.getElementById('slot_id');
            for (let i = 0; i < slotSelect.options.length; i++) {
                if (slotSelect.options[i].text.includes('A01')) {
                    slotSelect.selectedIndex = i;
                    document.getElementById('display_price').value = '$20.00/hour';
                    break;
                }
            }
            
            // Calculate initial cost
            calculateCost();
        });
        
        function formatDateTimeLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    </script>
</body>
</html>