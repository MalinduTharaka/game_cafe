<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Rate;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        $rates = Rate::all();
        return view('devices.create', compact('devices', 'rates'));
    }


    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $device = Device::create($request->all());

        return redirect()->back()->with('success', 'Device registered successfully. Links generated:');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        ]);
        $device = Device::find($id);
        $device->update($request->all());
        return redirect()->back()->with('success', 'Device updated successfully.');
    }

    public function delete($id)
    {
        $device = Device::find($id);
        $device->delete();
        return redirect()->back()->with('success', 'Device deleted successfully.');
    }
}

