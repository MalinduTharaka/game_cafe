<?php

namespace App\Http\Controllers;

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
        return view('admin.paying-rates', compact('rates')); // Pass rates to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate only the type and rate fields
        $request->validate([
            'type' => 'required|string|max:255',
            'rate' => 'required|numeric', // Removed device_type
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
            'rate' => 'required|numeric', // Removed device_type
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
}