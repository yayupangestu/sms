@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan OUT Material</h1>
        <a href="dashboardmps" style="margin-left: 20px;">
          <button class="btn btn-warning">
              <i class="fa fas fa-arrow-left"></i> Kembali ke Dashboard
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div id="you-qr-result"></div>
      <div id="my-qr-reader" style="width: 500px;"></div>
    </div>
  </div>
</section>

{{-- Library --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    function playSuccessSound() {
        const audio = new Audio('/sound/success_sound.mp3');
        audio.play();
    }

    let scannedOnce = false;

    function onScanSuccess(qrCodeMessage) {
        if (scannedOnce) return; // Hindari scan ganda
        scannedOnce = true;

        playSuccessSound();

        const qrDataArray = qrCodeMessage.split('||');

        if (qrDataArray.length >= 2) {
            const dataToSend = {
                _token: '{{ csrf_token() }}',
                part_no: qrDataArray[0] || '',
                spec: qrDataArray[1] || '',
                supplier: qrDataArray[2] || '',
                uniqNo: qrDataArray[3] || '',
                id_data: qrDataArray[4] || '',
                id: qrDataArray[5] || '',
                qty_out_kg: qrDataArray[6] || '',
                qty_out_sheet: qrDataArray[7] || '',
                category: qrDataArray[8] || '',
            };

            Swal.fire({
                icon: 'question',
                title: 'Confirm Scan',
                html: `
                    <strong>Uniq No:</strong> ${dataToSend.uniqNo || 'N/A'}<br>
                    <strong>Part No:</strong> ${dataToSend.part_no || 'N/A'}<br>
                    <strong>Material Name:</strong> ${dataToSend.spec || 'N/A'}<br>
                    <strong>Supplier:</strong> ${dataToSend.supplier || 'N/A'}<br>
                    <strong>Berat:</strong> ${dataToSend.qty_out_kg || 'N/A'}<br>
                    <strong>Quantity:</strong> ${dataToSend.qty_out_sheet || 'N/A'}<br>
                `,
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    validateAndSendData(dataToSend);
                } else {
                    scannedOnce = false;
                }
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid QR Code Data',
                confirmButtonText: 'OK',
            });
            scannedOnce = false;
        }
    }

    function validateAndSendData(dataToSend) {
        $.post("{{ route('scanoutrm.check') }}", dataToSend, function (response) {
            if (response.exists) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Duplikat',
                    text: 'Data Part No ini sudah ada dan tidak bisa diinput lagi.',
                });
                scannedOnce = false;
            } else {
                $.post("{{ route('scanoutrm.checkLine') }}", dataToSend, function (checkLineResponse) {
                    if (checkLineResponse.exists) {
                        const lineIds = checkLineResponse.line_ids || 'N/A';
                        Swal.fire({
                            icon: 'warning',
                            title: 'Material Sudah Ada di Line',
                            html: `Material ini sudah berada di Line: <strong>${lineIds}</strong>.<br>Data Ada di 2 SHIFT berbeda pilih tujuan Shift:`,
                            input: 'select',
                            inputOptions: {
                                '1': 'Shift 1',
                                '2': 'Shift 2'
                                // '3': 'Shift 3'
                            },
                            inputPlaceholder: 'Pilih shift',
                            showCancelButton: true,
                            confirmButtonText: 'Kirim',
                            cancelButtonText: 'Batal',
                            inputValidator: (value) => {
                                if (!value) return 'Silakan pilih shift';
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                dataToSend.shift_target = result.value;
                                sendDataToServer(dataToSend);
                            } else {
                                scannedOnce = false;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'question',
                            title: 'Pilih Shift Tujuan',
                            input: 'select',
                            inputOptions: {
                                '1': 'Shift 1',
                                '2': 'Shift 2'
                                // '3': 'Shift 3'
                            },
                            inputPlaceholder: 'Pilih shift',
                            showCancelButton: true,
                            confirmButtonText: 'Kirim',
                            cancelButtonText: 'Batal',
                            inputValidator: (value) => {
                                if (!value) return 'Silakan pilih shift';
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                dataToSend.shift_target = result.value;
                                sendDataToServer(dataToSend);
                            } else {
                                scannedOnce = false;
                            }
                        });
                    }
                }).fail(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Cek Material di Line',
                        text: 'Tidak bisa memeriksa keberadaan material di line.',
                    });
                    scannedOnce = false;
                });
            }
        }).fail(function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Cek Duplikat',
                text: 'Terjadi kesalahan saat memeriksa data.',
            });
            scannedOnce = false;
        });
    }

    function sendDataToServer(dataToSend) {
        $.ajax({
            url: "{{ route('scanoutrm.store') }}",
            method: 'POST',
            data: dataToSend,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data Stok Sudah Di Perbaharui!',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: response.message,
                        confirmButtonText: 'OK',
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 404) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Part No tidak tersedia untuk Planning Hari ini',
                        confirmButtonText: 'OK',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                        confirmButtonText: 'OK',
                    });
                }
            },
        });
    }

    // Inisialisasi Scanner
    const htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
        fps: 10,
        qrbox: 250,
        rememberLastUsedCamera: true,
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
        experimentalFeatures: {
            useBarCodeDetectorIfSupported: true
        }
    });

    htmlScanner.render(onScanSuccess);
});
</script>
@endsection
