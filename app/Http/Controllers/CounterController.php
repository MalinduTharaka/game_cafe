<?php

namespace App\Http\Controllers;

use App\Models\GmSession;
use App\Models\Rate;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $gmsessions = GmSession::all();
        $rates = Rate::all();
        return view('counter.count', compact('gmsessions','rates'));
    }
}
