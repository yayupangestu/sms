@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan In PC-STORE FIX</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div id="you-qr-result"></div>
                <div id="my-qr-reader" style="width: 500px;"></div>

                <!-- Load Library -->
                {{-- <script src="https://unpkg.com/html5-qrcode"></script> --}}
                <!-- Load SweetAlert2 -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>         
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
                <script>
                var scannedOnce = false; // Variable to prevent multiple scans
    function onScanSuccess(qrCodeMessage) {
        if (!scannedOnce) {
            scannedOnce = true; // Prevent multiple scans

            // Split the QR data
            let qrDataArray = qrCodeMessage.split('.');

            // Ensure the QR code contains exactly 10 parts of data
            if (qrDataArray.length === 10) {
                // Assign QR data to variables with proper index values
                let dataToSend = {
                    _token: '{{ csrf_token() }}', // CSRF token for Laravel
                    part_no2: qrDataArray[0],
                    part_no: qrDataArray[1],
                    job_no: qrDataArray[2],
                    model: qrDataArray[3],
                    qty: qrDataArray[4],
                    date: qrDataArray[5],
                    uniqNo: qrDataArray[6],
                    kodeMaterial: qrDataArray[7],
                    qty_ng: qrDataArray[8],
                    id_data: qrDataArray[9],
                };

                Swal.fire({
                    title: 'Confirm Scanned Data',
                    html: `
                        <p><strong>Unique No:</strong> ${dataToSend.uniqNo}</p>
                        <p><strong>Part Job:</strong> ${dataToSend.job_no}</p>
                        <p><strong>Part No:</strong> ${dataToSend.part_no}</p>
                        <p><strong>Part No:</strong> ${dataToSend.part_no2}</p>
                        <p><strong>Model:</strong> ${dataToSend.model}</p>
                        <p><strong>Quantity:</strong> ${dataToSend.qty}</p>
                        <hr>
                        <p>Are you sure you want to save this data?</p>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, save it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim data ke server tanpa pilih store
                        $.ajax({
                            url: "{{ route('scaninpcs.store') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: dataToSend,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Data Tersimpan',
                                        text: 'QR Code data berhasil disimpan!',
                                        confirmButtonText: 'Okay'
                                    }).then(() => location.reload());
                                } else {
                                    // 🚀 default swal jika success==false
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Info',
                                        text: response.message,
                                        confirmButtonText: 'Okay'
                                    });
                                }
                            },
                            error: function(xhr) {
                                let res = xhr.responseJSON;

                                // 🚀 Khusus uniqNo duplicate → pakai toastr
                                if (res && res.toast) {
                                    toastr.options = {
                                        closeButton: true,
                                        progressBar: true,
                                        timeOut: 5000,
                                        positionClass: "toast-top-right"
                                    };
                                    toastr.error(res.message);
                                    scannedOnce = false; // biar bisa scan lagi
                                } else if (xhr.status === 404) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Part Not Found',
                                        text: 'Warning.',
                                        confirmButtonText: 'Okay'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Info',
                                        text: '',
                                        confirmButtonText: 'Okay'
                                    });
                                }
                            }
                        });
                    } else {
                        scannedOnce = false;
                        Swal.fire({
                            icon: 'info',
                            title: 'Cancelled',
                            text: 'The scanned data was not saved.',
                            confirmButtonText: 'Okay'
                        });
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

    // Initialize QR code scanner
    var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
        fps: 10,
        qrbox: 250
    });

    // Request camera permissions and render the scanner
    htmlScanner.render(onScanSuccess);
                </script>

            </div>
        </div>
    </section>
@endsection
