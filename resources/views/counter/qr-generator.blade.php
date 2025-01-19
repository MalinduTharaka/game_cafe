@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <style>
        .card-body {
            position: relative; /* Make this element the reference point for positioning the icon */
        }

        .widget-icon {
            position: absolute;
            top: 25%; /* Vertically center */
            right: 0px; /* Adjust the distance from the right edge */
            transform: translateY(-50%); /* Offset the vertical position to truly center */
            font-size: 80px; /* Adjust size as needed */
            color: #6c757d; /* Adjust color as needed */
        }

    </style>
</head>
<body>

    <div class="row">
        <div class="col-md-12 col-xl-2"></div>
        <div class="col-md-8 col-xl-8">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <h3 class="mb-0 fw-bold mt-3 mb-1">QR Code Generator</h3>
                    <p class="text-muted">Link below to generate its QR code:</p>
                    <i class='bx bx-qr widget-icon'></i>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div>
        <div class="col-md-4 col-xl-2">
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
             <div class="card">
                  <div class="card-body">
                       <div class="row">
                            <div class="col-6">
                                 <div class="avatar-md bg-light bg-opacity-50 rounded">
                                      <iconify-icon icon="solar:leaf-bold-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                                 </div>
                            </div> <!-- end col -->
                            <div class="col-6 text-end">
                                 <p class="text-muted mb-0 text-truncate">Device ID</p>
                                 <h3 class="text-dark mt-1 mb-0">{{$device->id}}</h3>
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
                                 <p class="text-muted mb-0 text-truncate">Device Name</p>
                                 <h3 class="text-dark mt-1 mb-0">{{$device->name}}</h3>
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
                                      <iconify-icon icon="solar:layers-bold-duotone" class="fs-32 text-success avatar-title"></iconify-icon>
                                 </div>
                            </div> <!-- end col -->
                            <div class="col-6 text-end">
                                 <p class="text-muted mb-0 text-truncate">Device Type</p>
                                 <h3 class="text-dark mt-1 mb-0">{{$device->type}}</h3>
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
                                 <p class="text-muted mb-0 text-truncate">Added Date</p>
                                 <h3 class="text-dark mt-1 mb-0">{{ $device->created_at->format('Y-m-d') }}</h3>
                            </div> <!-- end col -->
                       </div> <!-- end row-->
                  </div> <!-- end card body -->
             </div> <!-- end card -->
        </div> <!-- end col -->
   </div> <!-- end row -->

    <div class="mb-3">
        <input type="text" id="linkInput" class="form-control" placeholder="Enter your link here" value="http://127.0.0.1:8000/session/toggle/{{$device->id}}">
    </div>
    <div class="mb-3">
        <button onclick="generateQRCode()" class="btn btn-outline-success">Generate QR Code</button>
    </div>
    <div id="qrCodeContainer"></div>

    <script>
        function generateQRCode() {
            const link = document.getElementById('linkInput').value.trim();
            const deviceName = "{{ $device->name }}"; // Directly inject the device name into JavaScript
            if (link) {
                const encodedLink = encodeURIComponent(link);
                const qrCodeURL = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodedLink}`;
                
                // Create an image element to display the QR code
                const qrCodeContainer = document.getElementById('qrCodeContainer');
                qrCodeContainer.innerHTML = ''; // Clear previous content
                
                const img = document.createElement('img');
                img.src = qrCodeURL;
                img.alt = 'QR Code';
                
                // Add a button to open QR code in a new tab
                const openButton = document.createElement('button');
                openButton.classList.add('btn', 'btn-outline-primary');
                openButton.textContent = 'View QR';
                openButton.style.marginTop = '10px';
                
                // Handle the open in new tab functionality
                openButton.onclick = function() {
                    const link = document.createElement('a');
                    link.href = qrCodeURL;
                    link.target = "_blank"; // Open in a new tab
                    link.click(); // Simulate the click to open the QR code in a new tab
                };
    
                qrCodeContainer.appendChild(img);
                
            } else {
                alert('Please enter a valid link.');
            }
        }
    </script>
    
</body>
@endsection
