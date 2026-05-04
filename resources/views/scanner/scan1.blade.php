@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Qr-Code</h1>
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
                var lastResult, countResults = 0;
        
                // Fungsi untuk memainkan suara ketika hasil pemindaian berhasil
                function playSuccessSound() {
                    var audio = new Audio('/sound/success_sound.mp3'); // Menggunakan URL file MP3
                    audio.play();
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
