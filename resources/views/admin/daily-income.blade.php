@extends('layouts.app')

@section('content')

{{-- <div class="row">
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
</div> <!-- end row --> --}}

<div class="col-12 col-sm-12">
     <div class="alert alert-primary px-2" role="alert">
          <h3 class="mb-0">Daily Income</h3>
          <p class="mb-0">Today :{{$date}}</p>
     </div>
</div>

<div class="row">
     <div class="col-xl-12">
          <div class="card">
               <div class="card-body">
                    <h5 class="card-title mb-1 anchor" id="basic">
                         Daily Income
                    </h5>
                    <div class="table-responsive">
                         <table class="table table-hover table-centered">
                         <thead class="table-dark">
                              <tr>
                                   <th scope="col">Date</th>
                                   <th scope="col">Duration (hrs)</th>
                                   <th scope="col">Discount Hours (Hrs)</th>
                                   <th scope="col">Total (Rs)</th>
                              </tr>
                         </thead>
                         <tbody>
                              @foreach ($dailyincomes as $dailyincome)
                                   <tr>
                                        <td>{{ $dailyincome->date }}</td>
                                        <td>{{ $dailyincome->duration }}</td>
                                        <td>{{ $dailyincome->discount_time }}</td>
                                        <td>{{ $dailyincome->total }}</td>
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