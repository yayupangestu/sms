@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan QR-Code</h1>
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <!-- Scanner Section -->
      <div class="col-md-5">
        <div id="you-qr-result" class="mb-3"></div>
        <div id="my-qr-reader" style="width: 100%; height: 400px;"></div>
      </div>

      <!-- Table Section -->
      <div class="col-md-7">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>QR Code Result</th>
              <th>Timestamp</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="scan-results">
            <!-- Results will be added here dynamically -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Load Libraries -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function domReady(fn){
            if(document.readyState ==="complete" || document.readyState ==="interactive" ){
                setTimeout(fn,1)
            }else{
                document.addEventListener("DOMContentLoaded",fn)
            }
        }

        domReady(function(){
            var myqr = document.getElementById('you-qr-result');
            var resultsTable = document.getElementById('scan-results');
            var scanCount = 0;

            function playSuccessSound() {
                var audio = new Audio('/sound/success_sound.mp3');
                audio.play();
            }

            function onScanSuccess(decodedText, decodedResult) {
                playSuccessSound();
                
                // Menambahkan hasil ke tabel
                scanCount++;
                const timestamp = new Date().toLocaleString();
                const rowId = `scan-row-${scanCount}`;
                const newRow = `
                    <tr id="${rowId}">
                        <td>${scanCount}</td>
                        <td>${decodedText}</td>
                        <td>${timestamp}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeRow('${rowId}')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `;
                resultsTable.insertAdjacentHTML('beforeend', newRow);

                // Menampilkan hasil di atas scanner
                myqr.innerHTML = `<strong>Scanned Result:</strong> ${decodedText}`;
                console.log(`Scan result: ${decodedText}`);
            }

            window.removeRow = function(rowId) {
                const row = document.getElementById(rowId);
                if (row) row.remove();
            }

            var htmlScanner = new Html5QrcodeScanner(
                "my-qr-reader", { 
                    fps: 15, 
                    qrbox: { width: 350, height: 350 } 
                });

            htmlScanner.render(onScanSuccess);
        });
    </script>
  </div>
</section>
@endsection
