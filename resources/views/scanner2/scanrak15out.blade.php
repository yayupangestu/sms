@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan QR Code</h1>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body text-center">

            <!-- Hasil Scan -->
            <div id="you-qr-result" class="mb-4 h4 text-success"></div>

            <!-- Tombol Manual Scan -->
            <div class="mb-4">
              <h5 class="mb-3">Pilih Kode Part Terlebih Dahulu</h5>
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="btn btn-outline-primary scan-btn" data-code="9004A-17269||">9004A-17269</button>
                <button class="btn btn-outline-primary scan-btn" data-code="9004A-17222||">9004A-17222</button>
                <button class="btn btn-outline-primary scan-btn" data-code="90041-74048||">90041-74048</button>
                <button class="btn btn-outline-primary scan-btn" data-code="90174-74065||">90174-74065</button>
                <button class="btn btn-outline-primary scan-btn" data-code="90174-10038||">90174-10038</button>
              </div>
            </div>

            <!-- QR Scanner -->
            <div id="my-qr-reader" class="mx-auto" style="width: 100%; max-width: 500px;"></div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Library -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script -->
<script>
  function domReady(fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
      setTimeout(fn, 1);
    } else {
      document.addEventListener("DOMContentLoaded", fn);
    }
  }

  domReady(function () {
    var myqr = document.getElementById('you-qr-result');
    var lastResult = "";
    var selectedCode = "";

    // Tombol pilihan part
    document.querySelectorAll('.scan-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        selectedCode = this.getAttribute('data-code');

        document.querySelectorAll('.scan-btn').forEach(b => b.classList.remove('active', 'btn-success'));
        this.classList.add('active', 'btn-success');

        Swal.fire({
          icon: 'info',
          title: 'Kode Part Dipilih',
          text: selectedCode,
          timer: 1500,
          showConfirmButton: false
        });
      });
    });

    function onScanSuccess(decodedText, decodedResult = null) {
      if (decodedText !== lastResult) {
        lastResult = decodedText;

        if (!selectedCode) {
          Swal.fire({
            icon: 'warning',
            title: 'Pilih Part Dulu',
            text: 'Silakan pilih tombol part sebelum scan!',
          });
          return;
        }

        myqr.innerText = `Hasil Scan: ${decodedText}`;

        if (decodedText === selectedCode) {
          playSuccessSound();

          Swal.fire({
            icon: 'success',
            title: 'Scan Berhasil',
            text: 'QR Code sesuai dengan part yang dipilih!',
            timer: 2000,
            showConfirmButton: false
          });

          // ==== 🔁 AKTIFKAN RELAY BERDASARKAN KODE ====
          let relayOn = '';
          let relayOff = '';

          if (selectedCode === "9004A-17269||") {
            relayOn = "{{ route('scanraklimabelasout.activateRelayOut') }}";
            relayOff = "{{ route('scanraklimabelasout.deactivateRelayOut') }}";
          } else if (selectedCode === "9004A-17222||") {
            relayOn = "{{ route('scanraklimabelasout.activateRelayOut2') }}";
            relayOff = "{{ route('scanraklimabelasout.deactivateRelayOut2') }}";
          } else if (selectedCode === "90041-74048||") {
            relayOn = "{{ route('scanraklimabelasout.activateRelayOut3') }}";
            relayOff = "{{ route('scanraklimabelasout.deactivateRelayOut3') }}";
          } else {
            console.warn("Tidak ada relay untuk part ini.");
            return;
          }

          $.ajax({
            url: relayOn,
            method: 'GET',
            success: function () {
              console.log("Relay diaktifkan untuk " + selectedCode);

              setTimeout(function () {
                $.ajax({
                  url: relayOff,
                  method: 'GET',
                  success: function () {
                    console.log("Relay dimatikan otomatis setelah 5 detik.");
                  },
                  error: function () {
                    console.error("Gagal mematikan relay.");
                  }
                });
              }, 5000);
            },
            error: function () {
              console.error("Gagal mengaktifkan relay.");
            }
          });

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Scan Gagal',
            html: `Kode QR <strong>${decodedText}</strong> tidak cocok dengan pilihan <strong>${selectedCode}</strong>.`,
            showConfirmButton: true
          });
        }
      }
    }

    function playSuccessSound() {
      var audio = new Audio('/sound/success_sound.mp3');
      audio.play();
    }

    var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
      fps: 10,
      qrbox: 250
    });
    htmlScanner.render(onScanSuccess);
  });
</script>
@endsection
