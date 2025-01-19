<?php

namespace App\Http\Controllers;

use App\Models\GmSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SessionController extends Controller
{
    // Store request (without start time)
    public function toggleSession($id)
{
    // Check if there's a pending request for the given device ID
    $pendingRequest = GmSession::where('device_id', $id)
        ->where('status', 'pending')
        ->first();

    if ($pendingRequest) {
        // If status is pending, notify the user to wait for approval
        return "Wait for approval for device ID: " . $id;
    }

    // Check if there's an approved session for the given device ID
    $approvedSession = GmSession::where('device_id', $id)
        ->where('status', 'approve')
        ->whereNull('end_time')
        ->first();

    if ($approvedSession) {
        // End the session by updating the end_time
        $end_time = Carbon::now('Asia/Colombo');  // Get the current time in Asia/Colombo timezone
        $approvedSession->update(['end_time' => $end_time]);

        return "Session ended for device ID: " . $id . " at " . $end_time;
    }

    // If no pending or active sessions exist, create a new pending request
    GmSession::create([
        'device_id' => $id,
        'status' => 'pending', // Set status to pending
    ]);

    return "Request created for device ID: " . $id;
}

    // Approve the request and start the session
public function approveSession($id)
{
    $request = GmSession::where('device_id', $id)->where('status', 'pending')->first();

    if ($request) {
        $start_time = Carbon::now('Asia/Colombo');
        $request->update([
            'start_time' => $start_time,
            'status' => 'approve',
        ]);

        session()->flash('status', 'Session started for device ID: ' . $id . ' at ' . $start_time);
    } else {
        session()->flash('status', 'Request not found or already approved for this device.');
    }

    return redirect()->back();
}

// Decline the request
public function declineSession($id)
{
    $request = GmSession::where('device_id', $id)->where('status', 'pending')->first();

    if ($request) {
        $request->delete();
        session()->flash('status', 'Request declined for device ID: ' . $id);
    } else {
        session()->flash('status', 'Request not found for this device.');
    }

    return redirect()->back();
}

    // Stop the session (if device is in session)
    public function stopSession($id)
    {
        $activeSession = GmSession::where('device_id', $id)->whereNull('end_time')->first();

        if ($activeSession) {
            $end_time = Carbon::now('Asia/Colombo');
            $activeSession->update(['end_time' => $end_time]);

            session()->flash('status', 'Session ended for device ID: ' . $id . ' at ' . $end_time);
        } else {
            session()->flash('status', 'No active session found for device ID: ' . $id);
        }

        return redirect()->back();
    }

    public function emptSessionTable()
    {
        GmSession::truncate();

        return response()->json(['message' => 'Table truncated successfully']);
    }

}
