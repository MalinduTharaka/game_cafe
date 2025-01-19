<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Device;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Fetch filter values
        $deviceId = $request->input('device_id');
        $discountAvailability = $request->input('discount_availability');
        $date = $request->input('date');
        
        // Apply filters to the bills query
        $billsQuery = Bill::query();

        if ($deviceId) {
            $billsQuery->where('device_id', $deviceId);
        }
        if ($discountAvailability !== null) {
            $billsQuery->where('discount_availability', (int)$discountAvailability);
        }
        
        if ($date) {
            $billsQuery->whereDate('date', $date);
        }

        // Get the filtered bills
        $bills = $billsQuery->get();
        
        // Fetch devices for the filter dropdown
        $devices = Device::all();

        // Return the filtered bills to the view
        return view('admin.report', compact('bills', 'devices'));
    }

    public function filterReports(Request $request)
    {
        $month = $request->input('month');
    
        // Fetch bills, and filter by month if it is set
        $bills = Bill::when($month, function ($query, $month) {
            return $query->whereMonth('date', $month);
        })
        ->get();

        $devices = Device::all();
    
        return view('admin.report', compact('bills','devices'));
    }

}
