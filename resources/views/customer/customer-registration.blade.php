@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Customer List</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div id="success-message" class="alert alert-success position-fixed"
                style="top: 80px; right: 10px; z-index: 1050; margin: 0;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to Open Modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
            New Customer
        </button>

        <!-- Customer Table -->
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <!-- Edit Button -->

                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCustomerModal"
                                data-id="{{ $customer->id }}" data-name="{{ $customer->name }}"
                                data-phone="{{ $customer->phone }}" data-email="{{ $customer->email }}">
                                Edit
                            </button>


                            <!-- Delete Button -->
                            <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                @if (Auth::check() && Auth::user()->role === 'admin')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this customer?')">
                                    Delete
                                </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="createCustomerModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="createCustomerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('customer.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCustomerModalLabel">Add New Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="nic" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Customer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Customer Modal -->
        <div class="modal fade" id="editCustomerModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editCustomerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editCustomerForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editCustomerId" name="id">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPhone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="editPhone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="editNIC" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
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
        const editCustomerModal = document.getElementById('editCustomerModal');
        const editCustomerForm = document.getElementById('editCustomerForm');

        editCustomerModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const phone = button.getAttribute('data-phone');
            const email = button.getAttribute('data-email');

            // Populate the form fields with the customer data
            document.getElementById('editCustomerId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editEmail').value = email;

            // Set the form action dynamically
            editCustomerForm.action = `/customers/${id}`;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.opacity = '0'; // Fade out
                setTimeout(() => successMessage.remove(), 500); // Remove after fade-out
            }, 2000); // 2 seconds
        }
    });
</script>