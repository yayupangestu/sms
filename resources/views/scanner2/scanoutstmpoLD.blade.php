@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan OUT Stamping</h1>
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
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
                <script>
                    var scannedOnce = false; // Variable to prevent multiple scans
                    function onScanSuccess(qrCodeMessage) {
                        if (!scannedOnce) {
                            scannedOnce = true; // Prevent multiple scans

                            // Split the QR data
                            let qrDataArray = qrCodeMessage.split('.');

                            // Ensure the QR code contains exactly 5 parts of data
                            if (qrDataArray.length === 10) {
                                // Assign QR data to variables with proper index values
                                let dataToSend = {
                                    _token: '{{ csrf_token() }}', // CSRF token for Laravel
                                    part_no2: qrDataArray[0],
                                    part_no: qrDataArray[1], // Second value to name_material
                                    job_no: qrDataArray[2], // First value to uniqNo
                                    model: qrDataArray[3], // Fourth value to suplier
                                    qty: qrDataArray[4], // Fifth value to qty_out
                                    date: qrDataArray[5],
                                    uniqNo: qrDataArray[6], // Third value to spek
                                    kodeMaterial: qrDataArray[7],
                                    // part_no_rm: qrDataArray[8], // Fourth value to suplier
                                    qty_ng: qrDataArray[8],
                                    id_data: qrDataArray[9], // Fifth value to qty_out
                                };
                                
                                Swal.fire({
                                    title: 'Confirm Scanned Data',
                                    html: `
                                        <p><strong>Unique No:</strong> ${dataToSend.uniqNo}</p>
                                        <p><strong>Part Job:</strong> ${dataToSend.job_no}</p>
                                        <p><strong>Part No:</strong> ${dataToSend.part_no}</p>
                                        <p><strong>Model:</strong> ${dataToSend.model}</p>
                                        <p><strong>Quantity:</strong> ${dataToSend.qty}</p>
                                        <p><strong>Kode Material:</strong> ${dataToSend.kodeMaterial}</p>
                                        <hr>
                                        <label for="storeSelect"><strong>Select Store:</strong></label>
                                        <select id="storeSelect" class="swal2-select" style="width: 100%; padding: 0.4em; margin-top: 0.4em;">
                                            <option value="" disabled selected>Select</option>
                                            <option value="Line Store">Line Store</option>
                                            <option value="Repair">Repair</option>
                                            <option value="PC Store">PC Store</option>
                                        </select>
                                        <p>Are you sure you want to save this data?</p>
                                    `,
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, save it!',
                                    cancelButtonText: 'No, cancel!',
                                    preConfirm: () => {
                                        const storeValue = document.getElementById('storeSelect').value;
                                        if (!storeValue) {
                                            Swal.showValidationMessage('Please select a store!');
                                        }
                                        return storeValue;
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Add selected store to dataToSend
                                        dataToSend.store = result.value;

                                        // Kirim data ke server
                                        $.ajax({
                                            url: "{{ route('scanoutstmp.store') }}",
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
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'info',
                                                        text: response.message,
                                                        confirmButtonText: 'Okay'
                                                    });
                                                }
                                            },
                                            error: function(xhr) {
                                                if (xhr.status === 404) {
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'Label Sudah Scan atau Cek Status Proses',
                                                        // text: 'Warning.',
                                                        confirmButtonText: 'Okay'
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'Info',
                                                        text: 'Failed to save the scanned data.',
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
                                    text: 'The QR code format is incorrect. It should contain 5 pieces of data.',
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
