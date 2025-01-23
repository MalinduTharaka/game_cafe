@extends('layouts.app')

@section('content')
    @if (session('status'))
        <script>
            alert("{{ session('status') }}");
        </script>
    @endif

    {{-- Request Table --}}
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

    {{-- Session Tables --}}
    <div class="row">
        {{-- Active Sessions --}}
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

        {{-- Completed Sessions --}}
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
                                    @if (\Carbon\Carbon::parse($gmsession->start_time)->timezone('Asia/Colombo')->isToday())


                                        <tr>
                                            <td>{{ $gmsession->device->name }}</td>
                                            <td>{{ $gmsession->start_time }}</td>
                                            <td>{{ $gmsession->end_time }}</td>
                                            <td>
                                                @if ($gmsession->payment == 'done')
                                                    <button class="btn btn-success disabled" disabled>Paid</button>
                                                @else
                                                    <button class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop"
                                                        data-gmsession-id="{{ $gmsession->id }}"
                                                        data-device-id="{{ $gmsession->device->id }}"
                                                        data-device-type="{{ $gmsession->device->type }}"
                                                        data-device-name="{{ $gmsession->device->name }}"
                                                        data-start-time="{{ $gmsession->start_time }}"
                                                        data-end-time="{{ $gmsession->end_time }}">
                                                        Bill
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
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

    {{-- Modal for Billing --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="bill-form" action="{{ url('generate-bill') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Bill Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Device Name: <span id="modal-device-name"></span></p>
                        <p>Start Time: <span id="modal-start-time"></span></p>
                        <p>End Time: <span id="modal-end-time"></span></p>
                        <p>Duration: <span id="modal-duration"></span></p>

                        {{-- Hidden Inputs for Form --}}
                        <input type="hidden" name="device_id" id="form-device-id">
                        <input type="hidden" name="device_name" id="form-device-name">
                        <input type="hidden" name="device_type" id="form-device-type">
                        <input type="hidden" name="start_time" id="form-start-time">
                        <input type="hidden" name="end_time" id="form-end-time">
                        <input type="hidden" name="duration" id="form-duration">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('staticBackdrop');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const deviceId = button.getAttribute('data-device-id');
                const deviceName = button.getAttribute('data-device-name');
                const deviceType = button.getAttribute('data-device-type');
                const startTime = button.getAttribute('data-start-time');
                const endTime = button.getAttribute('data-end-time');

                // Parse start and end times as Date objects
                const startDate = new Date(startTime);
                const endDate = new Date(endTime);

                // Calculate duration in seconds
                const durationInSeconds = Math.round((endDate - startDate) / 1000);

                // Format duration into hours, minutes, and seconds
                const hours = Math.floor(durationInSeconds / 3600);
                let minutes = Math.floor((durationInSeconds % 3600) / 60);

                if (minutes < 10) {
                    minutes = 0;
                } else if (minutes > 10) {
                    minutes = 5;
                }

                const formattedDuration = `${hours}.${minutes}h`;

                // Set modal fields
                modal.querySelector('#modal-device-name').textContent = deviceName;
                modal.querySelector('#modal-start-time').textContent = startTime;
                modal.querySelector('#modal-end-time').textContent = endTime;
                modal.querySelector('#modal-duration').textContent = formattedDuration;

                // Set form fields
                modal.querySelector('#form-device-id').value = deviceId;
                modal.querySelector('#form-device-name').value = deviceName;
                modal.querySelector('#form-device-type').value = deviceType;
                modal.querySelector('#form-start-time').value = startTime;
                modal.querySelector('#form-end-time').value = endTime;
                modal.querySelector('#form-duration').value = formattedDuration;
            });
        });
    </script>
@endsection
