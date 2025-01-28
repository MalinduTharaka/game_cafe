<?php

namespace App\Http\Controllers;
use App\Models\Bill;
use App\Models\GmSession;
use App\Models\Rate;
use App\Models\IncomeDaily;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
{
    // Get bills for today in 'Asia/Colombo' timezone
    $bills = Bill::whereDate('date', Carbon::today('Asia/Colombo'))
                ->with('device')
                ->get();

    // Retrieve all rates
    $rates = Rate::all();

    // Calculate totals
    $totalDurationToday = $bills->sum('duration');
    $totaloftotal_Amount = $bills->sum('total_amount');
    $totalDiscountTime = $bills->sum('discount_time');
    $totalAmount = $bills->sum('total_amount');
    
    // Get the formatted date for today's bills
    $dateofbill = Carbon::today('Asia/Colombo')->format('Y-m-d');
    
    // Pass data to the view
    return view('counter.bill-detail', compact('bills', 'rates', 'totalDurationToday', 'totaloftotal_Amount', 'totalDiscountTime', 'totalAmount', 'dateofbill'));
}


public function payBill(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'device_id' => 'required|integer',
            'duration' => 'required|numeric',
            'discount_availability' => 'required|boolean',
            'discount_hours' => 'required|string',
            'total_amount' => 'required|numeric',
        ]);

        $discountHour = 0;
        if($request->discount_hours == '0.00'){
            $discountHour = 0;
        }elseif($request->discount_hours == '5.00'){
            $discountHour = 0.05;
        }elseif($request->discount_hours == '10.00'){
            $discountHour = 0.10;
        }elseif($request->discount_hours == '15.00'){
            $discountHour = 0.25;
        }elseif($request->discount_hours == '0.50'){
            $discountHour = 0.50;
        }elseif($request->discount_hours == '45.00'){
            $discountHour = 0.75;
        }elseif($request->discount_hours == '0.01'){
            $discountHour = $request->duration;
        }

        // Create a new bill entry
        $bill = new Bill();
        $bill->device_id = $request->device_id;
        $bill->duration = $request->duration;
        $bill->discount_availability = $request->discount_availability;
        $bill->discount_time = $discountHour;
        $bill->date = Carbon::today();  // Ensure date is correctly parsed
        $bill->total_amount = $request->total_amount;
        $bill->customer_id = $request->customer_id;
        $gmSession = GmSession::find($request->id);
        $gmSession->payment = 'done'; // Assuming this is the correct column
        $gmSession->save();

        // Save the bill
        if ($bill->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


    public function indexDailyIncome()
    {
        $dailyincomes = IncomeDaily::all();
        $date = Carbon::today()->toDateString();
        return view('admin.daily-income', compact('dailyincomes', 'date'));
    }


    public function storedailyincome(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'date' => 'required|date',
            'duration' => 'required|numeric',
            'discount_time' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        // Create a new record in the income_daily table
        IncomeDaily::create([
            'date' => $validated['date'],
            'duration' => $validated['duration'],
            'discount_time' => $validated['discount_time'],
            'total' => $validated['total'],
        ]);

        // Return a response
        return response()->json(['message' => 'Income data stored successfully']);
    }
}
