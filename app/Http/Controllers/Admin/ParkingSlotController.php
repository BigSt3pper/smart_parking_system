<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index()
    {
        $parkingSlots = ParkingSlot::all();
        return view('admin.parking_slots.index', compact('parkingSlots'));
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