@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan OUT BLANK 2</h1>
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

    <script>
                function domReady(fn) {
                  if (document.readyState === "complete" || document.readyState === "interactive") {
                    setTimeout(fn, 1);
                  } else {
                    document.addEventListener("DOMContentLoaded", fn);
                  }
                }

                domReady(function () {
                  function playSuccessSound() {
                    const audio = new Audio('/sound/success_sound.mp3');
                    audio.play();
                  }

                  let scannedOnce = false; // Flag to prevent multiple scans

                  function onScanSuccess(qrCodeMessage) {
                    if (!scannedOnce) {
                      scannedOnce = true; // Set flag to true
                      playSuccessSound();

                      const qrDataArray = qrCodeMessage.split('||');

                      // Validasi minimal data yang diperlukan
                      if (qrDataArray.length >= 2) {
                        const dataToSend = {
                          _token: '{{ csrf_token() }}', // Laravel CSRF protection
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

                        // Tampilkan SweetAlert untuk konfirmasi data
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
                            scannedOnce = false; // Reset flag jika dibatalkan
                          }
                        });
                      } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Invalid QR Code Data',
                          confirmButtonText: 'OK',
                        });
                        scannedOnce = false; // Reset flag
                      }
                    }
                  }

                  function validateAndSendData(dataToSend) {
  // Langsung cek apakah part_no sudah ada di rm_return_materials
  $.post("{{ route('scanoutblank2.checkLine') }}", dataToSend, function (checkLineResponse) {
    if (checkLineResponse.exists) {
      const lineIds = checkLineResponse.line_ids || 'N/A';

      Swal.fire({
        icon: 'warning',
        title: 'Material Sudah Ada di Line',
        html: `Material ini sudah berada di Line: <strong>${lineIds}</strong>.<br>Apakah kamu ingin tetap mengirim data?`,
        showCancelButton: true,
        confirmButtonText: 'Tetap Kirim',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          sendDataToServer(dataToSend);
        } else {
          scannedOnce = false;
        }
      });
    } else {
      // Kalau tidak ada di Line, langsung kirim
      sendDataToServer(dataToSend);
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




        function sendDataToServer(dataToSend) {
          // Kirim data ke server menggunakan AJAX
          $.ajax({
            url: "{{ route('scanoutblank2.store') }}",
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
                  location.reload(); // Reload halaman setelah user klik OK
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
                // Part number tidak ditemukan di tabel PlanningLineB3 untuk hari ini
                Swal.fire({
                  icon: 'warning',
                  title: 'Warning',
                  text: 'Part No tidak tersedia untuk Planning Hari ini',
                  confirmButtonText: 'OK',
                });
              } else {
                // Kesalahan lain
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


        const htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
    fps: 10,
    qrbox: 250,
    rememberLastUsedCamera: true, // Mengingat kamera terakhir yang digunakan
    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
    experimentalFeatures: {
        useBarCodeDetectorIfSupported: true // Gunakan fitur auto-focus browser jika tersedia
    }
});

htmlScanner.render(onScanSuccess);

// ** DETEKSI SCANNER DIHENTIKAN **
const originalClearMethod = htmlScanner.clear;
htmlScanner.clear = function () {
    return originalClearMethod.apply(this, arguments);
};


                });
      </script>
    </div>
  </div>
</section>
@endsection
