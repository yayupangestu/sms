@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Out Blank</h1>
        <i class="ph-fill ph-scan" style="font-size:40px;color:rgb(0, 0, 0);"></i>
      </div>
      <div class="col-sm-6">
        <!-- Optional header -->
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
            function domReady(fn) {
                if (document.readyState === "complete" || document.readyState === "interactive") {
                    setTimeout(fn, 1);
                } else {
                    document.addEventListener("DOMContentLoaded", fn);
                }
            }

            domReady(function() {
                var qrResult = document.getElementById('you-qr-result');
                var scannedOnce = false;

                function playSuccessSound() {
                    var audio = new Audio('/sound/success_sound.mp3');
                    audio.play();
                }

                function onScanSuccess(qrCodeMessage) {
                    if (!scannedOnce) {
                        scannedOnce = true;
                        console.log("QR Code scanned:", qrCodeMessage);

                        let qrDataArray = qrCodeMessage.split('||');
                        console.log("QR Data Array Length: ", qrDataArray.length);
                        console.log("QR Data Array: ", qrDataArray);

                        if (qrDataArray.length === 8) {
    let dataToSend = {
        _token: '{{ csrf_token() }}',
        part_no         : qrDataArray[0],
        spec            : qrDataArray[1],
        line_id         : qrDataArray[2],
        uniqNo          : qrDataArray[3],
        part_no2        : qrDataArray[4],
        id_data         : qrDataArray[5],
        kode_material   : qrDataArray[6],
        qty_act         : qrDataArray[7],
    };

    // 🔹 Ambil daftar line dari server dulu
    $.ajax({
        url: "{{ route('getAvailableLines') }}",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: { part_no: dataToSend.part_no },
        success: function(lines) {
            if (!lines || lines.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'No Line Available',
                    text: 'Tidak ada line yang tersedia untuk part ini hari ini.',
                }).then(() => {
                    scannedOnce = false;
                });
                return;
            }

            // 🔹 Build options dropdown dari hasil query
            let optionsHtml = `<option value="">-- Choose Line --</option>`;
            lines.forEach(line => {
                optionsHtml += `<option value="${line}">${line}</option>`;
            });

            Swal.fire({
                title: 'Confirm Data',
                html: `<strong>Data Scanned:</strong><br>
                       Part No: ${dataToSend.part_no}<br>
                       Spec: ${dataToSend.spec}<br>
                       Line ID: ${dataToSend.line_id}<br>
                       Quantity: ${dataToSend.qty_act}<br><br>
                       <label for="line_select">Pilih Line Tujuan:</label><br>
                       <select id="line_select" class="swal2-select" style="width:100%;margin-top:8px;">
                         ${optionsHtml}
                       </select>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const selectedLine = document.getElementById('line_select').value;
                    if (!selectedLine) {
                        Swal.showValidationMessage('Please select a line!');
                    }
                    return selectedLine;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    dataToSend.line_selected = result.value;

                    $.ajax({
                        url: "{{ route('scanoutblank.store') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: dataToSend,
                        success: function(response) {
                            if (response.success) {
                                playSuccessSound();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Good Job !!!',
                                    text: 'Data berhasil di simpan!',
                                    confirmButtonText: 'Okay'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 409) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Data Already Exists',
                                    text: 'Data with this UniqNo has already been scanned today.',
                                    confirmButtonText: 'Okay'
                                }).then(() => {
                                    location.reload();
                                });
                            } else if (xhr.status === 404) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Part Not Found',
                                    text: 'Part Number not found in stock.',
                                    confirmButtonText: 'Okay'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to save the scanned data.',
                                    confirmButtonText: 'Okay'
                                }).then(() => {
                                    scannedOnce = false;
                                });
                            }
                        }
                    });
                } else {
                    scannedOnce = false;
                }
            });
        }
    });
}
 else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid QR Data',
                                text: 'The QR code format is incorrect. It should contain 7 pieces of data, separated by "|".',
                                confirmButtonText: 'Okay'
                            }).then(() => {
                                scannedOnce = false;
                            });
                        }
                    }
                }

                var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                    fps: 10,
                    qrbox: 250
                });

                htmlScanner.render(onScanSuccess);
            });
        </script>
</section>
@endsection
