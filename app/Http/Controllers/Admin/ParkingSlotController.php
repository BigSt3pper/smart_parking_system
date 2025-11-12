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
        
        $parkingSlots = $query->orderBy('slotID')->get();
        return view('admin.parking-slots.index', compact('parkingSlots'));
    }

    public function create()
    {
        return view('admin.parking-slots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'slotNumber' => 'required|unique:ParkingSlot,slotNumber',
            'location' => 'required|string|max:255',
            'pricePerHour' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Occupied,Maintenance',
            'description' => 'nullable|string|max:500'
        ]);

        ParkingSlot::create([
            'slotNumber' => $request->slotNumber,
            'location' => $request->location,
            'pricePerHour' => $request->pricePerHour,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect()->route('admin.parking-slots.index')
                         ->with('success', 'Parking slot created successfully.');
    }

    public function edit($id)
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        return view('admin.parking-slots.edit', compact('parkingSlot'));
    }

    public function update(Request $request, $id)
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        
        $request->validate([
            'slotNumber' => 'required|unique:ParkingSlot,slotNumber,' . $id . ',slotID',
            'location' => 'required|string|max:255',
            'pricePerHour' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Occupied,Maintenance',
            'description' => 'nullable|string|max:500'
        ]);

        $parkingSlot->update([
            'slotNumber' => $request->slotNumber,
            'location' => $request->location,
            'pricePerHour' => $request->pricePerHour,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect()->route('admin.parking-slots.index')
                         ->with('success', 'Parking slot updated successfully.');
    }

    public function destroy($id)
    {
        $parkingSlot = ParkingSlot::findOrFail($id);
        $parkingSlot->delete();
        
        return redirect()->route('admin.parking-slots.index')
                         ->with('success', 'Parking slot deleted successfully.');
    }
}