@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Rate List</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div id="success-message" class="alert alert-success position-fixed"
                style="top: 80px; right: 10px; z-index: 1050; margin: 0;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to Open Modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createRateModal">
            New Rate
        </button>

        <div class="mt-5 mb-5">
            <form id="discountForm" action="/discountUpdate/1" method="POST">
                @csrf
                @method('PUT')
                <label class="mb-2">Choose Today Discount</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio1" value="0.00">
                    <label class="form-check-label" for="inlineRadio1">No Discount</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio2" value="5.00">
                    <label class="form-check-label" for="inlineRadio2">5 minutes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio3" value="10.00">
                    <label class="form-check-label" for="inlineRadio3">10 minutes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio4" value="15.00">
                    <label class="form-check-label" for="inlineRadio4">15 minutes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio5" value="0.5">
                    <label class="form-check-label" for="inlineRadio5">30 minutes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio6" value="45.00">
                    <label class="form-check-label" for="inlineRadio6">45 minutes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="time" id="inlineRadio7" value="1.00">
                    <label class="form-check-label" for="inlineRadio7">1 hour</label>
                </div>
            </form>
            @foreach ($discounts as $discount)
                <input type="text" readonly class="form-control" style = "width:25%" value="{{ 
                    $discount->time == 0.00 ? '0 minutes' : (
                    $discount->time == 0.50 ? '30 minutes' : (
                    $discount->time == 1.00 ? '1 hour' : (
                    $discount->time == 5.00 ? '5 minutes' : (
                    $discount->time == 10.00 ? '10 minutes' : (
                    $discount->time == 15.00 ? '15 minutes' : (
                    $discount->time == 45.00 ? '45 minutes' : $discount->time
                    )))))) 
                }}">
            @endforeach
        </div>

        <script>
            // Add an event listener to all radio buttons
            document.querySelectorAll('input[name="time"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // Submit the form when a radio button is selected
                    document.getElementById('discountForm').submit();
                });
            });
        </script>

        

        <!-- Rate Table -->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Device Type</th>
                    <th>1st hour</th>
                    <th>next 4 hour</th>
                    <th>next 4 hours half hour rate</th>
                    <th>next hours</th>
                    <th>next hours half hour rate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rates as $rate)
                    <tr>
                        <td>{{ $rate->id }}</td>
                        <td>{{ $rate->type }}</td>
                        <td>{{ $rate->rate1 }}</td>
                        <td>{{ $rate->rate2 }}</td>
                        <td>{{ $rate->rate2half }}</td>
                        <td>{{ $rate->rate3 }}</td>
                        <td>{{ $rate->rate3half }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRateModal"
                                data-id="{{ $rate->id }}" data-type="{{ $rate->type }}"
                                data-rate1="{{ $rate->rate1 }}" data-rate2="{{ $rate->rate2 }}"
                                data-rate2half="{{ $rate->rate2half }}" data-rate3="{{ $rate->rate3 }}"
                                data-rate3half="{{ $rate->rate3half }}">
                                Edit
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('rates.destroy', $rate->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this rate?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Create Rate Modal -->
        <div class="modal fade" id="createRateModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="createRateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('rates.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createRateModalLabel">Add New Rate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="type" class="form-label">Device Type</label>
                                <input type="text" class="form-control" id="type" name="type" required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Rate 1st hour</label>
                                <input type="number" step="0.01" class="form-control" id="rate1" name="rate1"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Rate next 4 hours</label>
                                <input type="number" step="0.01" class="form-control" id="rate2" name="rate2"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Half rate for next 4 hours </label>
                                <input type="number" step="0.01" class="form-control" id="rate2half"
                                    name="rate2half" required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Rate next hours</label>
                                <input type="number" step="0.01" class="form-control" id="rate3" name="rate3"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Half rate for next hours </label>
                                <input type="number" step="0.01" class="form-control" id="rate3half"
                                    name="rate3half" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Rate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Rate Modal -->
        <div class="modal fade" id="editRateModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editRateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editRateForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRateModalLabel">Edit Rate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editRateId" name="id">
                            <div class="mb-3">
                                <label for="editType" class="form-label">Device Type</label>
                                <input type="text" class="form-control" id="editType" name="type" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRate" class="form-label">Rate 1st hour</label>
                                <input type="number" step="0.01" class="form-control" id="editRate1" name="rate1"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editRate" class="form-label">Rate next 4 hours</label>
                                <input type="number" step="0.01" class="form-control" id="editRate2" name="rate2"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Half rate for next 4 hours </label>
                                <input type="number" step="0.01" class="form-control" id="editRate2half"
                                    name="rate2half" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRate" class="form-label">Rate next hours</label>
                                <input type="number" step="0.01" class="form-control" id="editRate3" name="rate3"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="rate" class="form-label">Half rate for next hours </label>
                                <input type="number" step="0.01" class="form-control" id="editrate3half"
                                    name="rate3half" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editRateModal = document.getElementById('editRateModal');
        const editRateForm = document.getElementById('editRateForm');

        editRateModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const type = button.getAttribute('data-type');
            const rate1 = button.getAttribute('data-rate1');
            const rate2 = button.getAttribute('data-rate2');
            const rate2half = button.getAttribute('data-rate2half');
            const rate3 = button.getAttribute('data-rate3');
            const rate3half = button.getAttribute('data-rate3half');

            // Populate the form fields with the rate data
            document.getElementById('editRateId').value = id;
            document.getElementById('editType').value = type;
            document.getElementById('editRate1').value = rate1;
            document.getElementById('editRate2').value = rate2;
            document.getElementById('editRate2half').value = rate2half;
            document.getElementById('editRate3').value = rate3;
            document.getElementById('editrate3half').value = rate3half;

            // Set the form action dynamically
            editRateForm.action = `/rates/${id}`;
        });
    });
</script>
