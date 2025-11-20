<h1>Available Parking Slots</h1>

@foreach ($slots as $slot)
    <p>
        Slot: {{ $slot->slot_number }}  
        <a href="{{ route('user.slots.book', $slot->id) }}">Book</a>
    </p>
@endforeach
