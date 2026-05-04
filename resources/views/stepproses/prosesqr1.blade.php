@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Scan TRACE</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div id="you-qr-result"></div>
                <div id="my-qr-reader" style="width: 100%; max-width: 500px;"></div>
            </div>
        </div>

        <!-- Modal untuk menampilkan detail material -->
        <div class="modal fade" id="materialsModal" tabindex="-1" role="dialog" aria-labelledby="materialsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="materialsModalLabel">Material Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary" id="save-changes">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load Libraries -->
        <script src="https://unpkg.com/html5-qrcode"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var lastResult, countResults = 0;

                // Function to play sound on successful scan
                function playSuccessSound() {
                    var audio = new Audio('/sound/success_sound.mp3');
                    audio.play();
                }

                // Function called when QR code is scanned successfully
                function onScanSuccess(decodedText, decodedResult) {
                    // If no scan result has been processed yet, process the scan
                    if (!lastResult) {
                        lastResult = decodedText;
                        countResults++;
                        playSuccessSound();

                        // Display the result in a SweetAlert
                        Swal.fire({
                            title: 'Scan successful!',
                            text: 'Result: ' + decodedText,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                        location.reload();  // Reload the page after success
                        });
                    }
                }

                // Initialize QR code scanner
                var htmlScanner = new Html5QrcodeScanner(
                    "my-qr-reader", { fps: 10, qrbox: 250 }
                );

                // Render QR code scanner
                htmlScanner.render(onScanSuccess);
            });
        </script>
    </div>
</section>
@endsection
