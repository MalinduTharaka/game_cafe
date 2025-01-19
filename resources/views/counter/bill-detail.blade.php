@extends('layouts.app')

@section('content')

<input type="date" name="date" value="{{$dateofbill}}" hidden>
<input type="number" name="duration" value="{{$totalDurationToday}}" hidden>
<input type="number" name="amount" value="{{$totaloftotal_Amount}}" hidden>
<input type="number" name="discount_amount" value="{{$totalDiscountAmount}}" hidden>
<input type="number" name="total" value="{{$totalAmount}}" hidden>



<script>
     // Function to calculate the time remaining until 11:59 PM
     function getTimeUntilEndOfDay() {
         const now = new Date();
         const endOfDay = new Date();
         endOfDay.setHours(23, 59, 0, 0); // Set time to 11:59 PM
         return Math.max(0, endOfDay - now); // Ensure non-negative difference
     }
 
     // Set a timeout to trigger at 11:59 PM
     const timeUntilEndOfDay = getTimeUntilEndOfDay();
     if (timeUntilEndOfDay > 0) {
         setTimeout(() => {
             // Get input values
             const date = document.querySelector('input[name="date"]').value || new Date().toISOString().split('T')[0];
             const duration = document.querySelector('input[name="duration"]').value || "0";
             const amount = document.querySelector('input[name="amount"]').value || "0";
             const discount_amount = document.querySelector('input[name="discount_amount"]').value || "0";
             const total = document.querySelector('input[name="total"]').value || "0";
 
             // Post the data using fetch
             fetch('/store/daily/income', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure this is rendered by Blade
                 },
                 body: JSON.stringify({
                     date,
                     duration,
                     amount,
                     discount_amount,
                     total
                 })
             })
             .then(response => {
                 if (!response.ok) {
                     throw new Error(`HTTP error! Status: ${response.status}`);
                 }
                 return response.json();
             })
             .then(data => {
                 console.log('Data stored successfully:', data);
             })
             .catch(error => {
                 console.error('Error storing data:', error);
             });
         }, timeUntilEndOfDay);
     }
</script>
 

<div class="row">
    <div class="col-md-6 col-xl-3">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-4">
                             <div class="avatar-md bg-light bg-opacity-50 rounded">
                                  <iconify-icon icon="solar:leaf-bold-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                             </div>
                        </div> <!-- end col -->
                        <div class="col-8 text-end">
                             <p class="text-muted mb-0 text-truncate">Total duration Today</p>
                             <h3 class="text-dark mt-1 mb-0" id="duration">{{$totalDurationToday}} hrs</h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-3">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-6">
                             <div class="avatar-md bg-light bg-opacity-50 rounded">
                                  <iconify-icon icon="solar:cpu-bolt-line-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                             </div>
                        </div> <!-- end col -->
                        <div class="col-6 text-end">
                             <p class="text-muted mb-0 text-truncate">Full total amount</p>
                             <h3 class="text-dark mt-1 mb-0" id="amount">Rs. {{$totaloftotal_Amount}}/=</h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-3">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-4">
                             <div class="avatar-md bg-light bg-opacity-50 rounded">
                                  <iconify-icon icon="solar:layers-bold-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                             </div>
                        </div> <!-- end col -->
                        <div class="col-8 text-end">
                             <p class="text-muted mb-0 text-truncate">Total discount amount</p>
                             <h3 class="text-dark mt-1 mb-0" id="discount-amount">Rs. {{$totalDiscountAmount}}/=</h3>
                        </div> <!-- end col -->
                   </div> <!-- end row-->
              </div> <!-- end card body -->
         </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-6 col-xl-3">
         <div class="card">
              <div class="card-body">
                   <div class="row">
                        <div class="col-4">
                             <div class="avatar-md bg-light bg-opacity-50 rounded">
                                  <iconify-icon icon="solar:users-group-two-rounded-bold-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                             </div>
                        </div> <!-- end col -->
                        <div class="col-8 text-end">
                             <p class="text-muted mb-0 text-truncate">Total of amount</p>
                             <h3 class="text-dark mt-1 mb-0" id="total-amount">Rs. {{$totalAmount}}/=</h3>
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
                    <h5 class="card-title mb-1 anchor" id="basic">
                         Daily Bills
                    </h5>
                    <div class="table-responsive">
                         <table class="table table-hover table-centered">
                         <thead class="table-light">
                              <tr>
                                   <th scope="col">Device</th>
                                   <th scope="col">Duration (hrs)</th>
                                   <th scope="col">Amount (Rs)</th>
                                   <th scope="col">Discount Given</th>
                                   <th scope="col">Discount Amount (Rs)</th>
                                   <th scope="col">Total Amount (Rs)</th>
                              </tr>
                         </thead>
                         <tbody>
                              @foreach ($bills as $bill)
                                   <tr>
                                        <td>{{ $bill->device->name }}</td>
                                        <td>{{ $bill->duration }}</td>
                                        <td>{{ $bill->amount }}</td>
                                        <td>{{ $bill->discount_availability == 1 ? 'Yes' : 'No' }}</td>
                                        <td>{{ $bill->discount_amount }}</td>
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



@endsection