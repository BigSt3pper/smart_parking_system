<h1>Book Slot: {{ $slot->slot_number }}</h1>

<form method="POST" action="{{ route('user.slots.book.store', $slot->id) }}">
    @csrf
    <button type="submit">Confirm Booking</button>
</form>
