@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Qr-Code OUT</h1>
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
    
        <!-- load Library -->
        <script src="https://unpkg.com/html5-qrcode"></script>
        <!-- Load SweetAlert2 -->
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
                var lastResult = null;
        
                // Fungsi untuk memainkan suara ketika hasil pemindaian berhasil
                function playSuccessSound() {
                    var audio = new Audio('/sound/success_sound.mp3'); // Menggunakan URL file MP3
                    audio.play();
                }
        
                // Fungsi untuk menangani hasil pemindaian QR code
                function onScanSuccess(decodedText, decodedResult) {
    if (decodedText !== lastResult) {
        lastResult = decodedText;

        // Assume decodedText contains a string with values separated by a delimiter (e.g., '||')
        let scanData = decodedText.split('||');
        let part_nut_out = scanData[0];        // Assuming the 'part_nut' value is the first part
        let suplaier_out = scanData[1];    // Assuming the 'suplaier' value is the second part
        let qty_plan_out = scanData[2];    // Assuming the 'qty_plan' value is the third part
        let uniq_no_out = scanData[3];    // Assuming the 'uniq_no' value is the fourth part

        // Play success sound
        playSuccessSound();

        // Temporarily pause scanning until the user confirms
        htmlScanner.pause();

        // Show SweetAlert2 notification
        Swal.fire({
            icon: 'success',
            title: 'Scan Berhasil',
            text: `Hasil: ${decodedText}`,
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to save the scan result
                $.ajax({
                    url: "{{ route('scan3.saveScanOutResult') }}",
                    method: "POST",
                    data: {
                        part_nut_out: part_nut_out,
                        suplaier_out: suplaier_out,
                        qty_plan_out: qty_plan_out,
                        uniq_no_out: uniq_no_out,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: 'Data berhasil disimpan!',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error saving scan result:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan data',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                        });
                    }
                }).always(function() {
                    // Reset lastResult to allow further scanning
                    lastResult = null;
                    // Reopen the camera for scanning
                    htmlScanner.resume(); 
                });
            } else {
                // Reset lastResult to allow further scanning if user cancels
                lastResult = null;
                // Reopen the camera for scanning
                htmlScanner.resume();
            }
        });
    }
}
                var htmlScanner = new Html5QrcodeScanner(
                    "my-qr-reader", { fps: 10, qrbox: 250 });
        
                htmlScanner.render(onScanSuccess);
            });
        </script>
    </div>
  </div>
</section>
@endsection
