@extends('layouts.app')

@section('content')

<h1>Bill Details</h1>
<p>Device Name: {{ $data['device_name'] }}</p>
<p>Device ID: {{ $data['device_id'] }}</p>
<p>Device Type: {{ $data['device_type'] }}</p>
<p>Start Time: {{ $data['start_time'] }}</p>
<p>End Time: {{ $data['end_time'] }}</p>
<p>Duration: <span id="duration">{{ $data['duration'] }}</span> hours</p>

<!-- Discount Selection -->
<label for="discount">Release Hours:</label>
<select id="discount">
    <option value="0">No Discount</option>
    <option value="0.5">First 30 minutes</option>
    <option value="1">First 1 hour</option>
    <option value="2">First 2 hours</option>
    <option value="3">First 3 hours</option>
    <option value="4">First 4 hours</option>
    <option value="5">First 5 hours</option>
    <option value="full">Total hours</option>
</select>

<!-- Amount Button and Display -->
<button id="calculate-amount-btn">Calculate Amount</button>
<p>Total Amount: <span id="total-amount">0</span></p>

<script>
    console.log('Script loaded'); // Debug to confirm script runs

    const rates = @json($rates); // Pass rates from the controller
    console.log('Rates:', rates); // Debug rates data

    const deviceType = "{{ $data['device_type'] }}"; // Get the device type
    console.log('Device Type:', deviceType); // Debug device type

    document.getElementById('calculate-amount-btn').addEventListener('click', function () {
        console.log('Button clicked'); // Debug button click

        let duration = parseFloat(document.getElementById('duration').innerText);
        const discount = document.getElementById('discount').value; // Get the selected discount
        console.log('Duration Before Discount:', duration); // Debug original duration
        console.log('Selected Discount:', discount); // Debug selected discount

        // Find the rate object for the given device type
        const rate = rates.find(r => r.type === deviceType);
        console.log('Rate:', rate); // Debug rate object

        if (!rate || isNaN(rate.rate1) || isNaN(rate.rate2) || isNaN(rate.rate3) || isNaN(rate.rate2half) || isNaN(rate.rate3half)) {
            alert('Invalid rate data. Please check the rates table.');
            return;
        }

        // Parse the rates as numbers (since they are strings in the data)
        const rate1 = parseFloat(rate.rate1);
        const rate2 = parseFloat(rate.rate2);
        const rate2half = parseFloat(rate.rate2half); // Half hour rate for rate2
        const rate3 = parseFloat(rate.rate3);
        const rate3half = parseFloat(rate.rate3half); // Half hour rate for rate3
        console.log('Parsed Rates:', rate1, rate2, rate2half, rate3, rate3half); // Debug parsed rates

        if (isNaN(rate1) || isNaN(rate2) || isNaN(rate3)) {
            alert('Rates must be numeric values.');
            return;
        }

        let totalAmount = 0;
        let hours = Math.floor(duration); // Full hours
        let halfHours = (duration % 1) >= 0.5 ? 1 : 0; // Check if there is a half-hour

        // If the duration is 0.5, treat it as rate1
        if (duration === 0.5) {
            totalAmount += rate1; // Add rate1 for 0.5 hours
            halfHours = 0; // Reset half hours to avoid double counting
        } else if (hours >= 1) {
            totalAmount += rate1;
            hours--; // Deduct the first hour
        }

        // Calculate the next 4 hours (rate2)
        if (hours > 0) {
            if (hours <= 4) {
                totalAmount += rate2 * hours; // If less than 4 hours remaining
                hours = 0;
            } else {
                totalAmount += rate2 * 4; // Full 4 hours at rate2
                hours -= 4;
            }
        }

        // Calculate the next hours (rate3)
        if (hours > 0) {
            if (hours <= 4) {
                totalAmount += rate3 * hours; // If less than 4 hours remaining
                hours = 0;
            } else {
                totalAmount += rate3 * 4; // Full 4 hours at rate3
                hours -= 4;
            }
        }

        // Handle the half hour
        if (halfHours === 1) {
            if (duration > 1 && duration <= 5) {
                totalAmount += rate2half; // Half hour at rate2half within rate2 range
            } else {
                totalAmount += rate3half; // Half hour at rate3half outside rate2 range
            }
        }



        console.log('Total Amount:', totalAmount); // Debug the final amount

        // Apply the discount
        let discountAmount = 0;

        if (discount === '0.5') {
            discountAmount = rate1 / 2; // 30 minutes = half of rate1
        } else if (discount === '1') {
            discountAmount = rate1; // First hour rate
        } else if (discount === '2') {
            discountAmount = rate1 + rate2; // First 2 hours = rate1 + 1 hour of rate2
        } else if (discount === '3') {
            discountAmount = rate1 + 2 * rate2; // First 3 hours = rate1 + 2 hours of rate2
        } else if (discount === '4') {
            discountAmount = rate1 + 3 * rate2; // First 4 hours = rate1 + 3 hours of rate2
        } else if (discount === '5') {
            discountAmount = rate1 + 4 * rate2; // First 5 hours = rate1 + 4 hours of rate2
        } else if (discount === 'full') {
            totalAmount = 0; // Full duration released
            alert('Full duration released. Amount is 0.');
            document.getElementById('total-amount').innerText = '0.00';
            return;
        }

        console.log('Discount Amount:', discountAmount); // Debug discount amount

        // Subtract the discount amount from the total amount
        totalAmount -= discountAmount;

        if (totalAmount < 0) totalAmount = 0; // Prevent negative total

        console.log('Total Amount After Discount:', totalAmount); // Debug final amount

        // Display the calculated amount
        document.getElementById('total-amount').innerText = totalAmount.toFixed(2);
    });
</script>

@endsection
