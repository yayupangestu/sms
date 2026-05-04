@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Label Material</h1>
        <i class="ph-fill ph-scan" style="font-size:40px;color:rgb(0, 0, 0);"></i>
      </div>
      <div class="col-sm-6">
        <!-- Add breadcrumb or other headers here if needed -->
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
          document.addEventListener("DOMContentLoaded", function() {
              var qrResult = document.getElementById('you-qr-result');
              var scannedOnce = false;
      
              function playSuccessSound() {
                  var audio = new Audio('/sound/success_sound.mp3');
                  audio.play();
              }
      
              function onScanSuccess(qrCodeMessage) {
                  if (!scannedOnce) {
                      scannedOnce = true;
      
                      let qrDataArray = qrCodeMessage.split('||');
      
                      if (qrDataArray.length === 5) {
                          let uniqNo = qrDataArray[0];
                          let productName = qrDataArray[1];
                          let batchNo = qrDataArray[2];
                          let quantity = qrDataArray[3];
                          let expirationDate = qrDataArray[4];
      
                          let dataToSend = {
                              _token: '{{ csrf_token() }}',
                              uniq_no: uniqNo,
                              product_name: productName,
                              batch_no: batchNo,
                              quantity: quantity,
                              expiration_date: expirationDate,
                              status_rak: statusRak
                          };
      
                          Swal.fire({
                              title: 'Confirm Data',
                              html: `<strong>Data Scanned:</strong><br>
                                     Uniq No: ${uniqNo}<br>
                                     Product Name: ${productName}<br>
                                     Batch No: ${batchNo}<br>
                                     Quantity: ${quantity}<br>
                                     Expiration Date: ${expirationDate}`,
                              icon: 'info',
                              showCancelButton: true,
                              confirmButtonText: 'Save',
                              cancelButtonText: 'Cancel'
                          }).then((result) => {
                              if (result.isConfirmed) {
                                  // Save data to the server
                                  $.ajax({
                                      url: "{{ route('store.scan') }}",
                                      method: 'POST',
                                      headers: {
                                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                      },
                                      data: dataToSend,
                                      success: function(response) {
                                          if (response.success) {
                                              Swal.fire({
                                                  icon: 'success',
                                                  title: 'Data Saved',
                                                  text: 'QR Code data has been saved successfully!',
                                                  confirmButtonText: 'Okay'
                                              }).then(() => {
                                                  // Activate relay if status_rak is 1
                                                  if (statusRak === 1) {
                                                      $.ajax({
                                                          url: 'http://192.168.11.188/activate-relay',  // NodeMCU IP
                                                          method: 'GET',
                                                          success: function(response) {
                                                              console.log("Relay activated on NodeMCU");
                                                              Swal.fire({
                                                                  title: 'Relay Activated!',
                                                                  text: 'NodeMCU relay has been activated successfully.',
                                                                  icon: 'success'
                                                              }).then(() => {
                                                                  location.reload();
                                                              });
                                                          },
                                                          error: function(error) {
                                                              console.log("Error activating relay", error);
                                                              Swal.fire({
                                                                  title: 'Error!',
                                                                  text: "Failed to activate relay.",
                                                                  icon: 'error'
                                                              });
                                                          }
                                                      });
                                                  } else {
                                                      location.reload();
                                                  }
                                              });
                                          } else {
                                              Swal.fire({
                                                  icon: 'error',
                                                  title: 'Error',
                                                  text: response.message,
                                                  confirmButtonText: 'Okay'
                                              });
                                          }
                                      },
                                      error: function() {
                                          Swal.fire({
                                              icon: 'error',
                                              title: 'Error',
                                              text: 'Failed to save the scanned data.',
                                              confirmButtonText: 'Okay'
                                          });
                                      }
                                  });
                              } else {
                                  scannedOnce = false;
                              }
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Invalid QR Data',
                              text: 'The QR code format is incorrect. Expected 5 pieces of data.',
                              confirmButtonText: 'Okay'
                          });
                          scannedOnce = false;
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
      
    </div>
  </div>
</section>
@endsection
