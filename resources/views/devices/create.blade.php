@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-xl-12">
         <div class="card">
              <div class="card-body">
                   <h5 class="card-title mb-1 anchor" id="basic">
                        Device Registration 
                   </h5>
                   <form action="/devices/store" method="POST">
                    @csrf
                        <div>
                             <div class="mb-3">
                                  <label for="simpleinput" class="form-label">Device Name</label>
                                  <input type="text" id="device_name" class="form-control" name="name" required>
                             </div>

                             <div class="mb-3">
                                <label for="simpleinput" class="form-label">Device Type</label>
                                <select class="form-control" id="device_type" name="type" data-choices data-choices-search-false data-choices-removeItem>
                                    @foreach ($rates as $rate)
                                        <option value="{{$rate->type}}">{{$rate->type}}</option>
                                    @endforeach
                                </select>
                             </div>

                            <button type="submit" class="btn btn-success">Register Device</button>

                        </div>

                   </form>
              </div>
         </div>


         {{-- Update Model --}}
         <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Device</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editDeviceForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Device Name</label>
                                <input type="text" id="device_name_update" class="form-control" name="name" required>
                            </div>
                    
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Device Type</label>
                                <select class="form-control" id="device_type_update" name="type" data-choices data-choices-search-false data-choices-removeItem>
                                    @foreach ($rates as $rate)
                                        <option value="{{$rate->type}}">{{$rate->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                 <div class="card">
                      <div class="card-body">
                           <h5 class="card-title mb-1 anchor" id="basic">
                                Devices
                           </h5>
                           <div class="table-responsive">
                                <table class="table table-centered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Device Name</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Registered date</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">QR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($devices as $device)
                                            <tr>
                                                <td>{{ $device->id }}</td>
                                                <td>{{ $device->name }}</td>
                                                <td>{{ $device->type }}</td>
                                                <td>{{ $device->created_at }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button 
                                                            class="btn btn-outline-info me-2" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#staticBackdrop"
                                                            data-id="{{ $device->id }}"
                                                            data-name="{{ $device->name }}"
                                                            data-type="{{ $device->type }}"
                                                        >Edit</button>
                                                        <form action="/devices/delete/{{$device->id}}" method="POST" class="mb-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('qr.generator', $device->id) }}" class="btn btn-outline-success">QR</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                           </div>
                      </div>
                 </div>
            </div>
        </div>
    </div>

<script>
    const editButtons = document.querySelectorAll('[data-bs-target="#staticBackdrop"]');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Get the data attributes from the clicked button
                const deviceId = this.getAttribute('data-id');
                const deviceName = this.getAttribute('data-name');
                const deviceType = this.getAttribute('data-type');

                // Populate the form fields in the modal
                document.querySelector('#device_name_update').value = deviceName;

                // Set the selected option in the device type dropdown
                const typeSelect = document.querySelector('#device_type_update');
                // Loop through the options to find the one that matches deviceType
                for (let option of typeSelect.options) {
                    if (option.value === deviceType) {
                        option.selected = true;
                        break;
                    }
                }

                // Set the form action URL dynamically with the device ID
                const form = document.querySelector('#editDeviceForm');
                form.action = `/devices/update/${deviceId}`;
            });
        });
</script>
@endsection