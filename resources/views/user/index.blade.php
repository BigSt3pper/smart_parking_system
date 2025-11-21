<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Homepage - Smart Parking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto p-6">
    <!-- HEADER -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Smart Parking System</h1>
        <p class="text-gray-600">Welcome! Choose what you want to do below.</p>

```
    <!-- NAVIGATION -->
    <div class="flex flex-wrap gap-3 mt-4">
        <a href="{{ route('view-slots') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View Parking Slots</a>
        <a href="{{ route('user.reservations.index') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">My Reservations</a>
        @auth
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Profile</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Register</a>
        @endauth
        <a href="{{ route('admin.login') }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Admin Login</a>
    </div>
</div>

<!-- AVAILABLE PARKING SLOTS -->
<div class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Available Parking Slots</h2>

    @if($slots->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($slots as $slot)
                <div class="border rounded-lg p-4 shadow-sm hover:shadow-md transition">
                    <h3 class="text-lg font-bold text-gray-700">Slot: {{ $slot->slotNumber }}</h3>
                    <p class="text-gray-600">Location: {{ $slot->location ?? 'N/A' }}</p>
                    <p class="text-gray-600">Price/hr: KES {{ number_format($slot->pricePerHour, 2) }}</p>
                    <p class="text-green-600 font-semibold mt-1">{{ $slot->status }}</p>
                    @auth
                        <a href="{{ route('user.slots.book', $slot->slotID) }}" 
                           class="inline-block mt-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Book Slot
                        </a>
                    @else
                        <p class="mt-3 text-sm text-gray-500">Login to book this slot</p>
                    @endauth
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No available parking slots at the moment.</p>
    @endif
</div>
```

</div>

</body>
</html>
