@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Label Material Opsional</h1>
        <i class="ph-fill ph-scan" style="font-size:40px;color:rgb(0, 0, 0);"></i>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid text-center">
    <div id="you-qr-result"></div>
    <div id="my-qr-reader" style="width: 100%; max-width: 500px; margin: auto;"></div>
    {{-- <small class="text-muted d-block mt-2">📸 Pastikan kamera fokus & cukup pencahayaan saat memindai QR code.</small> --}}
  </div>

  <!-- Load Libraries -->
  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    let scannedOnce = false;

    function playSuccessSound() {
        let audio = new Audio('/sound/success_sound.mp3');
        audio.play();
    }

    function onScanSuccess(qrCodeMessage) {
        if (!scannedOnce) {
            scannedOnce = true;
            console.log("QR Code scanned:", qrCodeMessage);
            let qrDataArray = qrCodeMessage.split('||');
            if (qrDataArray.length === 9) {
                let dataToSend = {
                    _token: '{{ csrf_token() }}',
                    part_no: qrDataArray[0],
                    spek: qrDataArray[1],
                    supplier: qrDataArray[2],
                    uniqNo: qrDataArray[3],
                    id: qrDataArray[4],
                    doc_po: qrDataArray[5],
                    actual_kg: qrDataArray[6],
                    actual_sheet: qrDataArray[7],
                    category: qrDataArray[8],
                };

                Swal.fire({
                    title: 'Konfirmasi Data',
                    html: `<strong>Data Hasil Scan:</strong><br>
                           Part No: ${dataToSend.part_no}<br>
                           Spec: ${dataToSend.spek}<br>
                           Supplier: ${dataToSend.supplier}<br>
                           Berat: ${dataToSend.actual_kg}<br>
                           Quantity: ${dataToSend.actual_sheet}`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('scaninlabel2.store') }}",
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
                                        title: 'Berhasil',
                                        text: 'Data berhasil disimpan!',
                                        confirmButtonText: 'Oke'
                                    }).then(() => location.reload());
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 400 && xhr.responseJSON.message) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Data Sudah Ada',
                                        text: xhr.responseJSON.message,
                                        confirmButtonText: 'Oke'
                                    }).then(() => location.reload());
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Periksa QR, kemungkinan sudah pernah discan.',
                                        confirmButtonText: 'Oke'
                                    }).then(() => location.reload());
                                }
                            }
                        });
                    } else {
                        scannedOnce = false;
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Format QR Tidak Valid',
                    text: 'Pastikan format QR label sesuai.',
                    confirmButtonText: 'Oke'
                });
                scannedOnce = false;
            }
        }
    }

    function onScanError(errorMessage) {
        console.warn("Scan error:", errorMessage);
    }

    Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
            let backCamera = cameras.find(c => c.label.toLowerCase().includes('back')) || cameras[0];

            const config = {
                fps: 15,
                qrbox: { width: 300, height: 300 },
                rememberLastUsedCamera: true,
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                experimentalFeatures: { useBarCodeDetectorIfSupported: true }
            };

            const htmlScanner = new Html5QrcodeScanner("my-qr-reader", config, false);
            htmlScanner.render(onScanSuccess, onScanError);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Tidak ada kamera terdeteksi',
                text: 'Pastikan perangkat memiliki akses kamera.'
            });
        }
    }).catch(err => {
        console.error("Camera error:", err);
    });
  </script>
</section>
@endsection
