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

        <!-- Rate Table -->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Device Type</th>
                    <th>Rate Per Hour</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rates as $rate)
                    <tr>
                        <td>{{ $rate->id }}</td>
                        <td>{{ $rate->type }}</td>
                        <td>{{ $rate->rate }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRateModal"
                                data-id="{{ $rate->id }}" data-type="{{ $rate->type }}"
                                data-rate="{{ $rate->rate }}">
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
        <div class="modal fade" id="createRateModal" tabindex="-1" aria-labelledby="createRateModalLabel"
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
                                <label for="rate" class="form-label">Rate Per Hour</label>
                                <input type="number" step="0.01" class="form-control" id="rate" name="rate"
                                    required>
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
        <div class="modal fade" id="editRateModal" tabindex="-1" aria-labelledby="editRateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editRateForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRateModalLabel">Edit Rate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editRateId" name="id">
                            <div class="mb-3">
                                <label for="editType" class="form-label">Device Type</label>
                                <input type="text" class="form-control" id="editType" name="type" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRate" class="form-label">Rate Per Hour</label>
                                <input type="number" step="0.01" class="form-control" id="editRate" name="rate"
                                    required>
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
            const rate = button.getAttribute('data-rate');

            // Populate the form fields with the rate data
            document.getElementById('editRateId').value = id;
            document.getElementById('editType').value = type;
            document.getElementById('editRate').value = rate;

            // Set the form action dynamically
            editRateForm.action = `/rates/${id}`;
        });

        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.opacity = '0'; // Fade out
                setTimeout(() => successMessage.remove(), 500); // Remove after fade-out
            }, 2000); // 2 seconds
        }
    });
</script>