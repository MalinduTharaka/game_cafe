<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = Rate::all(); // Fetch all rates from the database
        $discounts = Discount::all();
        return view('admin.paying-rates', compact('rates','discounts')); // Pass rates to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate only the type and rate fields
        $request->validate([
            'type' => 'required|string|max:255',
            'rate1' => 'required|numeric', // Removed device_type
            'rate2' => 'nullable|numeric',
            'rate3' => 'nullable|numeric',
            'rate2half' => 'nullable|numeric',
            'rate3half' => 'nullable|numeric',
        ]);

        // Create a new rate record in the database
        Rate::create($request->all());

        // Redirect back with success message
        return redirect()->back()->with('success', 'Rate added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate only the type and rate fields
        $request->validate([
            'type' => 'required|string|max:255',
            'rate1' => 'required|numeric', // Removed device_type
            'rate2' => 'nullable|numeric',
            'rate3' => 'nullable|numeric',
            'rate2half' => 'nullable|numeric',
            'rate3half' => 'nullable|numeric',
        ]);

        // Find the rate and update it with the new values
        $rate = Rate::findOrFail($id);
        $rate->update($request->all());

        // Redirect back with success message
        return redirect()->back()->with('success', 'Rate updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the rate and delete it
        $rate = Rate::findOrFail($id);
        $rate->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Rate deleted successfully!');
    }

    public function updateDiscounts(Request $request, $id)
    {
        $dicount = Discount::findOrFail(1);
        $dicount->update($request->all());
        return redirect()->back()->with('success', 'Discount updated successfully!');
    }
}