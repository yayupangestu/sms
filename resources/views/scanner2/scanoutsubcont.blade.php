@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Out Subcont</h1>
        <i class="ph-fill ph-scan" style="font-size:40px;color:rgb(0, 0, 0);"></i></h1>
      </div>
      <div class="col-sm-6">
        <!-- You can add breadcrumb or other headers here if needed -->
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
        <div id="you-qr-result"></div>
        <div id="my-qr-reader" style="width: 500px;"></div>

        <!-- Load Libraries -->
        <script src="https://unpkg.com/html5-qrcode"></script>
        <!-- Load SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

        <script>
            // Function to ensure DOM is fully loaded before running script
            function domReady(fn) {
                if (document.readyState === "complete" || document.readyState === "interactive") {
                    setTimeout(fn, 1);
                } else {
                    document.addEventListener("DOMContentLoaded", fn);
                }
            }

            domReady(function() {
    var qrResult = document.getElementById('you-qr-result');
    var lastResult = null;
    var scannedOnce = false;  // Initialize the scannedOnce variable

    // Function to play sound when QR scan is successful
    function playSuccessSound() {
        var audio = new Audio('/sound/success_sound.mp3'); // Path to the MP3 file
        audio.play();
    }

    // Handle QR scan success
    function onScanSuccess(qrCodeMessage) {
        if (!scannedOnce) {
            scannedOnce = true; // Prevent multiple scans

            // Log the result to check if it's scanning
            console.log("QR Code scanned:", qrCodeMessage);

            // Split the QR data
            let qrDataArray = qrCodeMessage.split('||');

            // Log the length of qrDataArray to debug
            console.log("QR Data Array Length: ", qrDataArray.length);
            console.log("QR Data Array: ", qrDataArray);

            // Check if the QR code contains exactly 5 parts of data (6 elements in the array after splitting)
            if (qrDataArray.length === 8) {
                let dataToSend = {
                    _token: '{{ csrf_token() }}',  // CSRF token for Laravel
                    part_no         : qrDataArray[0],
                    spec            : qrDataArray[1],
                    supplier        : qrDataArray[2],
                    uniqNo          : qrDataArray[3],
                    id_data         : qrDataArray[4],
                    id         : qrDataArray[5],
                    qty_out_kg          : qrDataArray[6],
                    qty_out_sheet          : qrDataArray[7],
                };

                // Display the scanned data in an alert before sending to the server
                Swal.fire({ 
                    title: 'Confirm Data',
                    html: `<strong>Data Scanned:</strong><br>
                           Part No: ${dataToSend.part_no}<br>
                           Spec: ${dataToSend.spec}<br>
                           Supplier: ${dataToSend.supplier}<br>
                           Berat: ${dataToSend.qty_out_kg}<br>
                           Quantity: ${dataToSend.qty_out_sheet}`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send scanned data to the server using AJAX
                        $.ajax({
                            url: "{{ route('scanoutsubcont.store') }}",  // Route untuk menyimpan data
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'  // CSRF token di headers
                            },
                            data: dataToSend,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil Good Job !!!',
                                        text: 'Data berhasil di simpan!',
                                        confirmButtonText: 'Okay'
                                    }).then(() => {
                                        location.reload();  // Reload halaman setelah sukses
                                    });
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 400 && xhr.responseJSON.message) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Data Sudah Ada',
                                        text: xhr.responseJSON.message,  // Pesan error dari server
                                        confirmButtonText: 'Okay'
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Sweat Alert!',
                                        text: 'Periksa kolom Qr Sudah Di Scan.',
                                        confirmButtonText: 'Okay'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            }
                        });
                    } else {
                        // Allow rescanning if user cancels the alert
                        scannedOnce = false;
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid QR Data',
                    text: 'The QR code format is incorrect. It should contain 5 pieces of data, separated by "||".',
                    confirmButtonText: 'Okay'
                });
            }
        }
    }
    // Create HTML5 QR Code scanner instance
  // Create HTML5 QR Code scanner instance with autofocus enabled
var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
    fps: 10, // Frames per second for scanning
    qrbox: 250, // Size of the scanning box
    experimentalFeatures: { useBarCodeDetectorIfSupported: true } // Enable barcode detector for better accuracy
});

// Start rendering the scanner
htmlScanner.render(onScanSuccess);

});

        </script>
</section>
@endsection
