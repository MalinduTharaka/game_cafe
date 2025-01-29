@extends('layouts.app')

@section('content')
    {{-- <div class="container">
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
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Logo & title -->
                    <div class="clearfix">
                        <div class="float-sm-end">
                            <div class="auth-logo">
                                <img class="logo-dark me-1" src="{{ asset('assets/images/playdium.jpg') }}" alt="logo-dark"
                                    height="24" />
                                <img class="logo-light me-1" src="{{ asset('assets/images/playdium.jpg') }}" alt="logo-dark"
                                    height="24" />
                            </div>
                            <address class="mt-3">
                                Ward City,<br>
                                Gampaha <br>
                            </address>
                        </div>
                        <div class="float-sm-start">
                            <h5 class="card-title mb-2">Bill {{ $data['id'] }}</h5>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="fs-16">Device Name : {{ $data['device_name'] }}</h6>
                            <h6 class="fs-16">Device ID : {{ $data['device_id'] }}</h6>
                            <h6 class="fs-16">Device Type : {{ $data['device_type'] }}</h6>
                        </div> <!-- end col -->
                        <div class="col-md-6 d-flex justify-content-end"> <!-- Added d-flex and justify-content-end -->
                            <div>
                                <h6 class="fs-16">Start Time : {{ $data['start_time'] }}</h6>
                                <h6 class="fs-16">End Time : {{ $data['end_time'] }}</h6>
                                <h6 class="fs-16">Duration: <span id="duration">{{ $data['duration'] }}</span></h6>
                            </div>
                        </div> <!-- end col -->
                    </div>

                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive table-borderless text-nowrap mt-3 table-centered">
                                <table class="table mb-0">
                                    <thead class="bg-light bg-opacity-50">
                                        <tr>
                                            <th class="border-0 py-2">Device Name</th>
                                            <th class="border-0 py-2">Duration</th>
                                            <th class="text-end border-0 py-2">Discount</th>
                                        </tr>
                                    </thead> <!-- end thead -->
                                    <tbody>
                                        <tr>
                                            <td>{{ $data['device_name'] }}</td>
                                            <td><span id="duration">{{ $data['duration'] }}</td>
                                            <td class="text-end">
                                                <select id="discount" class="form-control" hidden>
                                                    @foreach ($discounts as $discount)
                                                        <option value="{{ $discount->time }}">Discount</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                        </tr>
                                    </tbody> <!-- end tbody -->
                                </table> <!-- end table -->
                            </div> <!-- end table responsive -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row mt-3">
                        <div class="col-sm-7">
                            <div class="clearfix pt-xl-3 pt-0">
                                <h6 class="text-muted">Notes:</h6>

                                <small class="text-muted">
                                    This is automatic generate bill from playdium (pvt) Ltd.
                                </small>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="float-end">
                                <link rel="stylesheet"
                                    href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
                                <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

                                <select id="users" class="form-control" data-choices name="choices-single-default">
                                    <option value="0" selected>Search for a customer...</option>
                                </select>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const customers = [
                                            @foreach ($customers as $customer)
                                                @if (
                                                    $customer->created_at->toDateString() != \Carbon\Carbon::today()->toDateString() &&
                                                        !$billtoday->contains('customer_id', $customer->id))
                                                    {
                                                        id: "{{ $customer->id }}",
                                                        name: "{{ $customer->name }} : {{ $customer->phone }}"
                                                    },
                                                @endif
                                            @endforeach
                                        ];

                                        const selectElement = document.getElementById('users');
                                        const choices = new Choices(selectElement, {
                                            searchEnabled: true,
                                            shouldSort: false,
                                            removeItemButton: true,
                                            placeholderValue: 'Search for a customer...',
                                            noResultsText: 'No customer found',
                                            noChoicesText: 'Type to search',
                                        });

                                        // Show results only when searching
                                        selectElement.addEventListener('search', function(event) {
                                            const searchText = event.detail.value.toLowerCase();
                                            const filteredCustomers = customers.filter(customer =>
                                                customer.name.toLowerCase().includes(searchText)
                                            );

                                            choices.clearChoices(); // Clear previous options
                                            if (filteredCustomers.length > 0) {
                                                choices.setChoices(filteredCustomers.map(c => ({
                                                    value: c.id,
                                                    label: c.name
                                                })));
                                            }
                                        });
                                    });
                                </script>


                                <p><span class="fw-medium">hours : </span>
                                    <span class="float-end"><span id="duration">{{ $data['duration'] }}</span>
                                </p>
                                <p><span class="fw-medium">
                                        <button id="calculate-amount-btn" class="btn btn-outline-primary">Calculate
                                            Amount</button>
                                    </span>
                                </p>
                                <h3>Total Amount: Rs. <span id="total-amount">0</span>/=</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="mt-5 mb-1">
                        <div class="text-end d-print-none">
                            <a class="btn btn-outline-success" id="pay-btn" style="display: none;">Pay</a>
                            <a class="btn btn-outline-success" id="paid-btn" style="display: none;">Paid</a>
                        </div>

                        <script>
                            // Ensure that $gmid is available in the view
                            var paymentStatus = "{{ $gmid->payment }}"; // Injecting the payment status directly into JavaScript

                            if (paymentStatus === 'done') {
                                document.getElementById('paid-btn').style.display = 'inline-block'; // Show the 'Paid' button
                                document.getElementById('paid-btn').style.pointerEvents = 'none';
                            } else {
                                document.getElementById('pay-btn').style.display = 'inline-block'; // Show the 'Pay' button
                            }
                        </script>
                    </div>


                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->


    <script>
        console.log('Script loaded'); // Debug to confirm script runs

        const rates = @json($rates); // Pass rates from the controller
        console.log('Rates:', rates); // Debug rates data

        const deviceType = "{{ $data['device_type'] }}"; // Get the device type
        console.log('Device Type:', deviceType); // Debug device type

        document.getElementById('calculate-amount-btn').addEventListener('click', function() {
            console.log('Button clicked'); // Debug button click

            let duration = parseFloat(document.getElementById('duration').innerText);
            const discount = document.getElementById('discount').value; // Get the selected discount
            const user_id = document.getElementById('users').value;
            console.log('Duration Before Discount:', duration); // Debug original duration
            console.log('Selected Discount:', discount); // Debug selected discount

            // Find the rate object for the given device type
            const rate = rates.find(r => r.type === deviceType);
            console.log('Rate:', rate); // Debug rate object


            if (!rate || isNaN(rate.rate1) || isNaN(rate.rate2) || isNaN(rate.rate3) || isNaN(rate.rate2half) ||
                isNaN(rate.rate3half)) {
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

            if (user_id != 0) {
                totalAmount = 0; // Full duration released
                alert('Full duration released. Amount is 0.');
                document.getElementById('total-amount').innerText = '0.00';
                return;
            } else if (discount === '0.5') {
                discountAmount = rate1 / 2; // 30 minutes = half of rate1
            } else if (discount === '1.00') {
                discountAmount = rate1; // First hour rate
            } else if (discount === '5.00') {
                discountAmount = rate1 / 12; // First 2 hours = rate1 + 1 hour of rate2
            } else if (discount === '10.00') {
                discountAmount = (rate1 / 60) * 10; // First 3 hours = rate1 + 2 hours of rate2
            } else if (discount === '15.00') {
                discountAmount = (rate1 / 60) * 15; // First 4 hours = rate1 + 3 hours of rate2
            } else if (discount === '45.00') {
                discountAmount = (rate1 / 60) * 45; // First 5 hours = rate1 + 4 hours of rate2
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


    <script>
        document.getElementById('pay-btn').addEventListener('click', function() {
            const id = "{{ $data['id'] }}";
            const deviceId = "{{ $data['device_id'] }}"; // Device ID
            const duration = parseFloat(document.getElementById('duration').innerText); // Duration
            const discount = document.getElementById('discount').value; // Discount value
            const discountAvailability = discount === "0" ? 0 : 1; // Discount availability (0 or 1)
            const discountHours = discount; // Discount hours
            const customer_id = document.getElementById('users').value;


            // Get the total amount after discount
            const totalAmount = parseFloat(document.getElementById('total-amount').innerText);

            console.log(customer_id);

            // Send data to the controller via AJAX
            fetch('{{ route('payBill') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id,
                        device_id: deviceId,
                        duration: duration,
                        discount_availability: discountAvailability,
                        discount_hours: customer_id != 0 ? '0.01' : discountHours,
                        total_amount: totalAmount,
                        customer_id: customer_id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment successful and bill saved!');
                        window.location.href = '{{ route('counter.index') }}'; // Redirect to bill history page
                    } else {
                        alert('Error while processing payment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error while processing payment.');
                });
        });
    </script>
@endsection
