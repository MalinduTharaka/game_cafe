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
    $totalDiscountAmount = $bills->sum('discount_amount');
    $totalAmount = $bills->sum('amount');
    
    // Get the formatted date for today's bills
    $dateofbill = Carbon::today('Asia/Colombo')->format('Y-m-d');
    
    // Pass data to the view
    return view('counter.bill-detail', compact('bills', 'rates', 'totalDurationToday', 'totaloftotal_Amount', 'totalDiscountAmount', 'totalAmount', 'dateofbill'));
}


    public function store(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'duration' => 'required',
            'amount' => 'required|numeric',
            'discount_availability' => 'required|boolean',
            'discount_amount' => 'required|numeric',
            'date' => 'required|date',
            'total_amount' => 'required|numeric',
        ]);

        // Find the GmSession by ID
        $gmsession = GmSession::find($id);

        if (!$gmsession) {
            return response()->json([
                'success' => false,
                'message' => 'GmSession not found.',
            ], 404);
        }

        // Update the payment status of the GmSession
        $gmsession->payment = 'done';
        $gmsession->save();

        // Create a new Bill with the validated data
        $bill = Bill::create($validated);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Bill saved successfully.',
            'bill' => $bill,
        ]);
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
            'amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        // Create a new record in the income_daily table
        IncomeDaily::create([
            'date' => $validated['date'],
            'duration' => $validated['duration'],
            'amount' => $validated['amount'],
            'discount_amount' => $validated['discount_amount'],
            'total' => $validated['total'],
        ]);

        // Return a response
        return response()->json(['message' => 'Income data stored successfully']);
    }
}
