@extends('layouts.app')

@section('content')
    @if (session('status'))
        <script>
            alert("{{ session('status') }}");
        </script>
    @endif


    {{-- Request table --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1 anchor" id="basic">
                        Session Start Requests show here
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-centered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Device Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gmsessions as $gmsession)
                                    @if ($gmsession->status == 'pending')
                                        <tr>
                                            <td>{{ $gmsession->device->name }}</td>
                                            <td>{{ $gmsession->status }}</td>
                                            <td>
                                                <a href="{{ url('session/approve/' . $gmsession->device_id) }}"
                                                    class="btn btn-success">Approve</a>
                                                <a href="{{ url('session/decline/' . $gmsession->device_id) }}"
                                                    class="btn btn-danger">Decline</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Session table --}}
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1 anchor" id="basic">
                        Active Sessions
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-centered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Device Name</th>
                                    <th scope="col">Start at</th>
                                    <th scope="col">End at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gmsessions as $gmsession)
                                    @if ($gmsession->status == 'approve' && $gmsession->end_time == '')
                                        <tr>
                                            <td>{{ $gmsession->device->name }}</td>
                                            <td>{{ $gmsession->start_time }}</td>
                                            <td>{{ $gmsession->end_time ? $gmsession->end_time : 'Counting...' }}</td>
                                            <td>
                                                <a href="{{ url('session/stop/' . $gmsession->device_id) }}"
                                                    class="btn btn-danger">Stop</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Complete Table --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1 anchor" id="basic">
                        Complete Sessions
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-centered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Device Name</th>
                                    <th scope="col">Start at</th>
                                    <th scope="col">End at</th>
                                    <th scope="col">Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gmsessions as $gmsession)
                                    @if ($gmsession->status == 'approve' && !empty($gmsession->end_time))
                                
                                    @if (\Carbon\Carbon::parse($gmsession->start_time)->toDateString() == \Carbon\Carbon::today('Asia/Colombo')->toDateString())

                                
                                            <tr>
                                                <td>{{ $gmsession->device->name }}</td>
                                                <td>{{ $gmsession->start_time }}</td>
                                                <td>{{ $gmsession->end_time ? $gmsession->end_time : 'Counting...' }}</td>
                                                <td>
                                                    @if ($gmsession->payment == 'done')
                                                        <button class="btn btn-success disabled" disabled>Paid</button>
                                                    @else
                                                        <button class="btn btn-success" data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop"
                                                            data-gmsession-id="{{ $gmsession->id }}"
                                                            data-device-id="{{ $gmsession->device->id }}"
                                                            data-device-name="{{ $gmsession->device->name }}"
                                                            data-device-type="{{ $gmsession->device->type }}"
                                                            data-start-time="{{ $gmsession->start_time }}"
                                                            data-end-time="{{ $gmsession->end_time }}"
                                                            data-duration="{{ $gmsession->end_time ? floor(\Carbon\Carbon::parse($gmsession->end_time)->diffInMinutes($gmsession->start_time)) : 'Counting...' }}"
                                                            data-date="{{ \Carbon\Carbon::parse($gmsession->start_time)->toDateString() }}">
                                                            Payment
                                                        </button>
                                                </td>
                                            </tr>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Device ID:</strong> <span id="modal-device-id"></span></p>
                    <p><strong>Device Type:</strong> <span id="modal-device-type"></span></p>
                    <p><strong>Device Name:</strong> <span id="modal-device-name"></span></p>
                    <p><strong>Start Time:</strong> <span id="modal-start-time"></span></p>
                    <p><strong>End Time:</strong> <span id="modal-end-time"></span></p>
                    <p><strong>Real Duration:</strong> <span id="modal-real-duration"></span></p>
                    <p><strong>Rate:</strong> <span id="modal-rate"></span></p>
                    <p><strong>Billing Duration:</strong> <span id="modal-calculated-duration"></span></p>
                    <p id="modal-amount"><strong>Amount:</strong> </p>
                    <div class="mb-3">
                        <label for="discount-input" class="form-label">Discount (%)</label>
                        <input type="number" class="form-control" id="discount-input" min="0" max="100"
                            placeholder="Enter discount percentage">
                    </div>
                    <p id="modal-total"><strong>Total after discount:</strong> </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Paid</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rates = @json($rates); // Inject PHP variable as a JavaScript object

            const modal = document.getElementById('staticBackdrop');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal

                // Get data attributes from the button
                const deviceId = button.getAttribute('data-device-id');
                const deviceName = button.getAttribute('data-device-name');
                const startTime = new Date(button.getAttribute('data-start-time'));
                const endTime = new Date(button.getAttribute('data-end-time'));
                const deviceType = button.getAttribute(
                'data-device-type'); // Ensure this is set in the button's attributes

                // Calculate real duration (hours and minutes)
                const diffInMilliseconds = endTime - startTime;
                const realHours = Math.floor(diffInMilliseconds / (1000 * 60 * 60));
                const realMinutes = Math.floor((diffInMilliseconds % (1000 * 60 * 60)) / (1000 * 60));
                const realDuration = `${realHours} hour(s) ${realMinutes} minute(s)`;

                // Calculate billing duration
                const totalMinutes = Math.ceil(diffInMilliseconds / (1000 *
                60)); // Total duration in minutes
                let billingDuration = Math.floor(totalMinutes / 60); // Whole hours
                const remainingMinutes = totalMinutes % 60;

                if (remainingMinutes > 10) {
                    billingDuration += 0.5; // Add half an hour if over 10 minutes
                }

                // Find the rate for the device type
                const rateEntry = rates.find(rate => rate.type === deviceType);
                const rate = rateEntry ? rateEntry.rate : 0;
                const amount = billingDuration * rate;

                // Update modal content
                modal.querySelector('#modal-device-id').textContent = deviceId;
                modal.querySelector('#modal-device-name').textContent = deviceName;
                modal.querySelector('#modal-start-time').textContent = button.getAttribute(
                    'data-start-time');
                modal.querySelector('#modal-end-time').textContent = button.getAttribute('data-end-time');
                modal.querySelector('#modal-device-type').textContent = deviceType;
                modal.querySelector('#modal-rate').textContent = rate;
                modal.querySelector('#modal-real-duration').textContent = realDuration;
                modal.querySelector('#modal-calculated-duration').textContent =
                `${billingDuration} hour(s)`;
                modal.querySelector('#modal-amount').textContent = `Amount: Rs. ${amount.toFixed(2)}/=`;

                // Handle discount input
                const discountInput = modal.querySelector('#discount-input');
                const totalDisplay = modal.querySelector('#modal-total');
                discountInput.value = ""; // Clear previous input
                totalDisplay.textContent = ""; // Clear previous total

                discountInput.addEventListener('input', function() {
                    const discount = parseFloat(discountInput.value) ||
                    0; // Get discount or default to 0
                    const discountedTotal = amount - (amount * discount) / 100;
                    totalDisplay.textContent =
                        `Total after discount: Rs. ${discountedTotal.toFixed(2)}/=`;
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('staticBackdrop');
            const paidButton = modal.querySelector('.btn-primary');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const gmsessionId = button.getAttribute('data-gmsession-id'); // Get gmsession ID
                modal.setAttribute('data-gmsession-id', gmsessionId); // Store gmsession ID in the modal for later use
            });

            paidButton.addEventListener('click', function() {
                const gmsessionId = modal.getAttribute('data-gmsession-id'); // Retrieve stored gmsession ID
                const deviceId = modal.querySelector('#modal-device-id').textContent;
                const duration = parseFloat(modal.querySelector('#modal-calculated-duration').textContent);
                const amount = parseFloat(modal.querySelector('#modal-amount').textContent.replace('Amount: Rs.', ''));
                const discountInput = modal.querySelector('#discount-input').value;
                const discount = parseFloat(discountInput) || 0;
                const discountAvailability = discount > 0 ? 1 : 0;
                const discountAmount = amount * (discount / 100);
                const totalAmount = amount - discountAmount;
                const colomboDate = new Intl.DateTimeFormat('en-GB', {
                timeZone: 'Asia/Colombo',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                }).format(new Date());

                // Format the date as YYYY-MM-DD
                const [day, month, year] = colomboDate.split('/');
                const currentDate = `${year}-${month}-${day}`; // Current date in YYYY-MM-DD format

                const data = {
                    device_id: deviceId,
                    duration,
                    amount,
                    discount_availability: discountAvailability,
                    discount_amount: discountAmount.toFixed(2),
                    date: currentDate,
                    total_amount: totalAmount.toFixed(2),
                };

                // Send data to the backend using fetch
                fetch(`/save-bill/${gmsessionId}`, { // Include gmsession ID in the URL
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Bill saved successfully!');
                        location.reload(); // Close the modal
                    } else {
                        alert('Error saving bill: ' + (result.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the bill.');
                });
            });
        });
        
    </script>

@endsection
