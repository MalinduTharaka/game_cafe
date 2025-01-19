<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bill;
use App\Models\GmSession;
use Carbon\Month;

class DashboardController extends Controller
{
    public function index()
{
    // Get bills for today in the default timezone (you can use 'Asia/Colombo' if needed)
    $bills = Bill::whereDate('date', today())->get();
    
    // Calculate totals
    $totalDurationToday = $bills->sum('duration');
    $totaloftotal_Amount = Bill::whereDate('date', Carbon::today('Asia/Colombo'))->sum('total_amount');
    $totalDiscountAmount = $bills->sum('discount_amount');
    $totalAmount = $bills->sum('amount');
    
    // Get current month and year in Asia/Colombo timezone
    $currentDate = Carbon::now('Asia/Colombo');
    $currentMonth = $currentDate->month;
    $currentYear = $currentDate->year;

    // Calculate the sum of total_amount for the current month and year
    $this_month_income = Bill::whereYear('date', $currentYear)
        ->whereMonth('date', $currentMonth)
        ->sum('total_amount');

    // Get today's formatted date
    $dateofbill = Carbon::today('Asia/Colombo')->format('Y-m-d');
    
    // Count today's sessions
    $total_session = GmSession::whereDate('start_time', today('Asia/Colombo'))->count();
    
    // Count active sessions (where 'end_time' is null and status is 'approve')
    $active_session_count = GmSession::whereNull('end_time')
        ->where('status', 'approve')
        ->count();
    
    // Retrieve all sessions (this can be optimized if you need specific session data)
    $sessions = GmSession::all();

    // Return view with all necessary data
    return view('home', compact(
        'totalDurationToday',
        'totaloftotal_Amount',
        'totalDiscountAmount',
        'totalAmount',
        'dateofbill',
        'total_session',
        'active_session_count',
        'this_month_income',
        'sessions'
    ));
}

}
