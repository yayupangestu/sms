@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan IN Line Store Repair</h1>
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
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        var scannedOnce = false; // Initialize the scannedOnce variable

                        // Function to play sound when QR scan is successful
                        function playSuccessSound() {
                            var audio = new Audio('/sound/success_sound.mp3'); // Path to the MP3 file
                            audio.play();
                        }

                        // Handle QR scan success
                        function onScanSuccess(qrCodeMessage) {
    if (!scannedOnce) {
        scannedOnce = true;

        console.log("QR Code scanned:", qrCodeMessage);
        let qrDataArray = qrCodeMessage.split('.');

        if (qrDataArray.length === 10) {
            let dataToSend = {
                _token: '{{ csrf_token() }}',
                part_no2: qrDataArray[0],
                job_no: qrDataArray[1],
                qty: qrDataArray[2],
                id_data: qrDataArray[3],
                uniqNo: qrDataArray[4],
                model: qrDataArray[5],
                part_no: qrDataArray[6],
                date_plan: qrDataArray[7],
                kode_material: qrDataArray[8],
                qty_ng: qrDataArray[9],
            };

            // --- CEK KE BACKEND scan_out_stmps ---
            $.ajax({
                url: "{{ route('scaninlsrepair.check') }}", // bikin route khusus validasi
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                data: { uniqNo: dataToSend.uniqNo },
                success: function(response) {
                    if (response.status_valid === false) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Tidak Bisa Scan',
                            text: 'Scan ini untuk DARI REPAIR, tidak bisa lanjut proses.',
                            confirmButtonText: 'Okay'
                        }).then(() => {
                            scannedOnce = false; // reset biar bisa scan lagi
                        });
                    } else {
                        // --- LANJUTKAN SWAL INPUT QTY ---
                        Swal.fire({
                            title: 'Confirm Data',
                            html: `<strong>Data Scanned:</strong><br>
                                Uniq No: ${dataToSend.uniqNo}<br>
                                Job: ${dataToSend.job_no}<br>
                                Model: ${dataToSend.model}<br>
                                Part: ${dataToSend.part_no}<br>
                                Tanggal: ${dataToSend.date}<br>
                                Quantity: ${dataToSend.qty}<br><br>
                                <label>Qty:</label>
                                <input id="swal-qty" type="text" class="swal2-input numeric" placeholder="Masukkan qty manual" />`,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const inputQty = parseInt(document.getElementById('swal-qty').value);
                                if (isNaN(inputQty) || inputQty <= 0) {
                                    Swal.showValidationMessage('Masukkan jumlah (qty) yang valid.');
                                    return false;
                                }
                                const maxQty = parseInt(dataToSend.qty);
                                if (inputQty > maxQty) {
                                    Swal.showValidationMessage(`Qty tidak boleh lebih dari ${maxQty}.`);
                                    return false;
                                }
                                return inputQty;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const inputQty = result.value;
                                const qtyAwal = parseInt(dataToSend.qty);

                                dataToSend.qty = inputQty;
                                dataToSend.ng_repair = qtyAwal - inputQty;

                                $.ajax({
                                    url: "{{ route('scaninlsrepair.store') }}",
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                    data: dataToSend,
                                    success: function(response) {
                                        let alertIcon = response.success ? 'success' : 'info';
                                        Swal.fire({
                                            icon: alertIcon,
                                            title: response.success ? 'Success' : 'Info',
                                            text: response.message,
                                            confirmButtonText: 'Okay'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    },
                                    error: function() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Failed to save the scanned data.',
                                            confirmButtonText: 'Okay'
                                        });
                                    }
                                });
                            } else {
                                scannedOnce = false;
                            }
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal melakukan validasi uniqNo.',
                        confirmButtonText: 'Okay'
                    });
                    scannedOnce = false;
                }
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Invalid QR Data',
                text: 'The QR code format is incorrect. It should contain 10 pieces of data.',
                confirmButtonText: 'Okay'
            });
        }
    }
}

                        // Create HTML5 QR Code scanner instance
                        var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                            fps: 10, // Frames per second for scanning
                            qrbox: 250 // Size of the scanning box
                        });

                        // Start rendering the scanner
                        htmlScanner.render(onScanSuccess);
                    });
                </script>
            </div>
        </div>
    </section>
@endsection
