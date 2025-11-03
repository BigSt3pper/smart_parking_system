<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Reports & Analytics</h1>
        <p>Basic reports page - Working!</p>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Revenue</h5>
                        <h3>${{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Active Reservations</h5>
                        <h3>{{ $activeReservations }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4>Recent Reservations</h4>
            @if($recentReservations->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Slot</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentReservations as $reservation)
                        <tr>
                            <td>#{{ $reservation->reservationID }}</td>
                            <td>{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</td>
                            <td>${{ number_format($reservation->totalCost, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No reservations found.</p>
            @endif
        </div>
    </div>
</body>
</html>
