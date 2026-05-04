@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan IN Line Store D</h1>
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
        scannedOnce = true;

        let qrDataArray = qrCodeMessage.split('.');

        if (qrDataArray.length === 10) {
            let uniqNoVal = qrDataArray[6]; // uniqNo ada di index 6

            // Cek dulu apakah uniqNo ini dari Repair
            $.ajax({
                url: "{{ route('scaninls2.checkRepair') }}",
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: { uniqNo: uniqNoVal },
                success: function(resp) {
                    if (resp.inRepair) {
                        scannedOnce = false; // allow rescan
                        Swal.fire({
                            icon: 'warning',
                            title: 'Part dari Area Repair',
                            text: 'Part ini berasal dari area REPAIR. Tidak bisa diproses!',
                            confirmButtonText: 'Okay'
                        });
                    } else {
                        // lanjut proses simpan
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
                            KodeMaterial: qrDataArray[8],
                            qty_ng: qrDataArray[9],
                        };

                        $.ajax({
                            url: "{{ route('scaninls2.store') }}",
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
                                        title: 'Info',
                                        text: response.message,
                                        confirmButtonText: 'Okay'
                                    });
                                }
                            },
                            error: function(xhr) {
                                scannedOnce = false;
                                if (xhr.status === 404) {
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
                                        text: 'Sudah Di scan.',
                                        confirmButtonText: 'Okay'
                                    });
                                }
                            }
                        });
                    }
                }
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Invalid QR Data',
                text: 'The QR code format is incorrect. It should contain 10 pieces of data.',
                confirmButtonText: 'Okay'
            });
            scannedOnce = false;
        }
    }
}


                    // QR Scanner Init
                    var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                        fps: 10,
                        qrbox: 250
                    });

                    htmlScanner.render(onScanSuccess);
                </script>


            </div>
        </div>
    </section>
@endsection
