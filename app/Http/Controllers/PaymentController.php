<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Discount;
use App\Models\GmSession;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $rates = Rate::all()->map(function ($rate) {
            return [
                'type' => $rate->type,
                'rate1' => (float) $rate->rate1, // Ensure it's a float
                'rate2' => (float) $rate->rate2,
                'rate3' => (float) $rate->rate3,
                'rate2half' => (float) $rate->rate2half,
                'rate3half' => (float) $rate->rate3half,
            ];
        });

        $customers = Customer::all();

        $gmid = GmSession::find($request->id);
        
        $devices = Device::all();

        $discounts = Discount::all();
        return view('counter.bill', compact('data', 'rates', 'devices','customers','gmid','discounts'));
    }

}
