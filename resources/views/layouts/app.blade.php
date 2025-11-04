<!DOCTYPE html>
<html>
<head>
    <title>Smart Parking System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100">

<nav class="bg-blue-600 p-4 text-white flex justify-between">
    <h1 class="font-bold text-lg">Smart Parking</h1>

    <div>
        <a href="/dashboard" class="px-3">Dashboard</a>
        <a href="/view-slots" class="px-3">View Slots</a>
        <a href="/my-bookings" class="px-3">My Bookings</a>
        <a href="/logout" class="px-3">Logout</a>
    </div>
</nav>

<div class="container mx-auto p-6">
    @yield('content')
</div>

</body>
</html>
