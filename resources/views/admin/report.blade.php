@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Filter Options</h1>
    <form id="filter-form" action="{{ route('report.index') }}" method="GET">
        <div class="row">
            <!-- Device Filter -->
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title mb-1">Device</h5>
                    <div class="w-100 mb-3">
                        <select class="form-control" id="device_id" name="device_id">
                            <option value="">All</option>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Discount Availability Filter -->
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title mb-1">Discount Availability</h5>
                    <div class="w-100 mb-3">
                        <select class="form-control" id="discount_availability" name="discount_availability">
                            <option value="">All</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Date Filter -->
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title mb-1">Select Date</h5>
                    <input type="date" id="basic-datepicker" class="form-control" name="date" placeholder="Select Date">
                    <script>document.getElementById('basic-datepicker').flatpickr();</script>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-info">Filter</button>
            </div>
        </div>
    </form>
</div>

<div class="container">
    <div class="col-md-4">
        <div class="card-body">
            <h5 class="card-title mb-1 anchor" id="options-add-no-search">
                Select Month
            </h5>
            <div class="w-100 mb-3">
                <form method="GET" action="{{ route('reports.filter') }}">
                    <select class="form-control" id="choices-single-no-search" name="month">
                        <option value="" selected>All</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-info">Filter</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-4">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-12 text-start">
                             <p class="text-muted mb-0 text-truncate">Duration</p>
                             <h3 class="text-dark mt-1 mb-0" id="duration"></h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-2">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-12 text-start">
                             <p class="text-muted mb-0 text-truncate">Amount</p>
                             <h3 class="text-dark mt-1 mb-0" id="amount"></h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-2">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-12 text-start">
                             <p class="text-muted mb-0 text-truncate">Discount Amount</p>
                             <h3 class="text-dark mt-1 mb-0" id="discount-amount"></h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-2">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-12 text-start">
                             <p class="text-muted mb-0 text-truncate">Total Amount</p>
                             <h3 class="text-dark mt-1 mb-0" id="total-amount"></h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-2">
        <div class="card">
             <div class="card-body">
                  <div class="row">
                       <div class="col-12 text-start">
                            <p class="text-muted mb-0 text-truncate">Number of Transactions</p>
                            <h3 class="text-dark mt-1 mb-0" id="transaction-count"></h3>
                       </div> <!-- end col -->
                  </div> <!-- end row-->
             </div> <!-- end card body -->
        </div> <!-- end card -->
   </div> <!-- end col -->
</div> <!-- end row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-1 anchor" id="basic">Reports</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless table-centered" id="report-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Device Name</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Discount Availability</th>
                                <th scope="col">Discount Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                            <tr>
                                <td>{{ $bill->device->name }}</td>
                                <td>{{ $bill->duration }}</td>
                                <td>{{ $bill->amount }}</td>
                                <td>{{ $bill->discount_availability }}</td>
                                <td>{{ $bill->discount_amount }}</td>
                                <td>{{ $bill->date }}</td>
                                <td>{{ $bill->total_amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to calculate totals and update the DOM
    function calculateReport() {
        const table = document.getElementById("report-table");
        const rows = table.querySelectorAll("tbody tr");

        let totalDuration = 0;
        let totalAmount = 0;
        let totalDiscountAmount = 0;
        let totalTotalAmount = 0;

        rows.forEach(row => {
            const duration = parseFloat(row.cells[1].textContent) || 0;
            const amount = parseFloat(row.cells[2].textContent) || 0;
            const discountAmount = parseFloat(row.cells[4].textContent) || 0;
            const totalAmountRow = parseFloat(row.cells[6].textContent) || 0;

            totalDuration += duration;
            totalAmount += amount;
            totalDiscountAmount += discountAmount;
            totalTotalAmount += totalAmountRow;
        });

        // Update the DOM with calculated values
        document.getElementById("duration").textContent = `${totalDuration} hrs`;
        document.getElementById("amount").textContent = `Rs. ${totalAmount}`;
        document.getElementById("discount-amount").textContent = `Rs. ${totalDiscountAmount}`;
        document.getElementById("total-amount").textContent = `Rs. ${totalTotalAmount}`;
        document.getElementById("transaction-count").textContent = `${rows.length}`;
    }

    // Run the calculation after the page has loaded
    window.onload = calculateReport;
</script>



@endsection