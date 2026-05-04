@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan IN Stamping BLANK</h1>
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
        <script src="https://unpkg.com/html5-qrcode"></script>
        <!-- Load SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

        <script>
            function playSuccessSound() {
                var audio = new Audio('/sound/success_sound.mp3');
                audio.play();
            }

            var scannedOnce = false;

            function onScanSuccess(qrCodeMessage) {
                if (!scannedOnce) {
                    scannedOnce = true;
                    playSuccessSound();

                    let qrDataArray = qrCodeMessage.split('||');

                    if (qrDataArray.length >= 8) {
                        let dataToSend = {
                            _token: '{{ csrf_token() }}',
                            part_no: qrDataArray[0],
                            spec: qrDataArray[1],
                            supplier: qrDataArray[2],
                            uniqNo: qrDataArray[3],
                            id_data: qrDataArray[4],
                            id: qrDataArray[5],
                            qty_out_kg: qrDataArray[6],
                            qty_out_sheet: qrDataArray[7],
                        };

                        // Ambil qty_stamping dari uniqNo lewat AJAX
                        $.ajax({
                            url: '{{ route("getBlank.qtyTransit") }}',
                            method: 'GET',
                            data: {
                                _token: '{{ csrf_token() }}',
                                uniqNo: dataToSend.uniqNo
                            },
                            success: function (response) {
                                let qtyStamping = (response.qty_stamping !== null && response.qty_stamping !== undefined)
                                    ? response.qty_stamping
                                    : '0';

                                // Cek apakah qty_stamping valid (> 0)
                                let isValidQty = parseInt(qtyStamping) > 0;

                                let hideQtyAwal = dataToSend.uniqNo.startsWith("B"); // true kalau diawali "B"

                                Swal.fire({
                                    icon: isValidQty ? 'question' : 'warning',
                                    title: isValidQty ? 'Confirm Scan' : 'Qty label ini 0',
                                    html: `
                                        <strong>Uniq No:</strong> ${dataToSend.uniqNo}<br>
                                        <strong>Part No:</strong> ${dataToSend.part_no}<br>
                                        <strong>Material Name:</strong> ${dataToSend.spec}<br>
                                        <strong>Supplier:</strong> ${dataToSend.supplier}<br>
                                        ${hideQtyAwal ? '' : `<strong>Qty Sheet Awal:</strong> ${dataToSend.qty_out_sheet}<br>`}
                                        <strong>Qty Sisa/Blank</strong>
                                        <span style="color:${isValidQty ? 'black' : 'red'}">${qtyStamping}</span><br>
                                        ${!isValidQty ? '<small style="color:red">Maaf untuk label ini Qty 0 coba label lain :)</small>' : ''}
                                    `,
                                    showCancelButton: true,
                                    showConfirmButton: isValidQty,
                                    cancelButtonText: isValidQty ? 'Cancel' : 'Tutup',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed && isValidQty) {
                                        sendDataToServer(dataToSend);
                                    } else {
                                        scannedOnce = false;
                                    }
                                });

                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'info',
                                    text: 'Tolong periksa apakah sudah scan Out RM',
                                });
                                scannedOnce = false;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid QR Code Data',
                            confirmButtonText: 'OK'
                        });
                        scannedOnce = false;
                    }
                }
            }

            function sendDataToServer(dataToSend) {
                $.ajax({
                    url: "{{ route('scaninblank.store2') }}",
                    method: 'POST',
                    data: dataToSend,
                    success: function (response) {
                        Swal.fire({
                            icon: response.icon || (response.success ? 'success' : 'info'),
                            title: response.success ? 'Berhasil' : 'Info',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (response.success) {
                                location.reload();
                            } else {
                                scannedOnce = false;
                            }
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'info',
                            title: 'Kesalahan',
                            text: 'Label Sudah Di Scan',
                            confirmButtonText: 'OK'
                        });
                        scannedOnce = false;
                    }
                });
            }

            // Inisialisasi scanner
            var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                fps: 10,
                qrbox: 250,
                rememberLastUsedCamera: true,
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true
                }
            });

            htmlScanner.render(onScanSuccess);
        </script>


    </div>
  </div>
</section>
@endsection
