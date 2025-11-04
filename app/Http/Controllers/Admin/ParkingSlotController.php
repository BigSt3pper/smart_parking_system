<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index(Request $request)
    {
        $query = ParkingSlot::query();
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('slotNumber', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('pricePerHour', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('pricePerHour', '<=', $request->max_price);
        }
        $parkingSlots = $query->latest()->get();
        return view('admin.parking-slots.index', compact('parkingSlots'));
    }

    public function create()
    {
        return view('admin.parking_slots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_number' => 'required|unique:parking_slots,slot_number',
            'status' => 'required|in:Available,Occupied,Maintenance',
            'location' => 'required',
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        ParkingSlot::create($request->all());

        return redirect()->route('admin.parking_slots.index')
                         ->with('success', 'Parking slot created successfully.');
    }

    public function edit(ParkingSlot $parkingSlot)
    {
        return view('admin.parking_slots.edit', compact('parkingSlot'));
    }

    public function update(Request $request, ParkingSlot $parkingSlot)
    {
        $request->validate([
            'slot_number' => 'required|unique:parking_slots,slot_number,' . $parkingSlot->id,
            'status' => 'required|in:Available,Occupied,Maintenance',
            'location' => 'required',
            'price_per_hour' => 'required|numeric|min:0',
        ]);

        $parkingSlot->update($request->all());

        return redirect()->route('admin.parking_slots.index')
                         ->with('success', 'Parking slot updated successfully.');
    }

    public function destroy(ParkingSlot $parkingSlot)
    {
        $parkingSlot->delete();

        return redirect()->route('admin.parking_slots.index')
                         ->with('success', 'Parking slot deleted successfully.');
    }
}