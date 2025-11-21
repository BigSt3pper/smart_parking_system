<h1>My Reservations</h1>

@foreach ($reservations as $r)
    <p>
        Slot: {{ $r->slot->slot_number }}  
        Status: {{ $r->status }}

        <form method="POST" action="{{ route('user.reservations.cancel', $r->id) }}">
            @csrf
            @method('DELETE')
            <button>Cancel</button>
        </form>
    </p>
@endforeach
