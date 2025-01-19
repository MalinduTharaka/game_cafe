<?php

namespace App\Http\Controllers;
use App\Models\Device;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function index($id)
    {
        $device = Device::findOrFail($id);
        return view('counter.qr-generator', compact('device'));
    }
}
