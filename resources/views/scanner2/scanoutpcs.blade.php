@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan OUT PC Store</h1>
      </div>
      <div class="col-sm-6"></div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12"> <!-- Make the column full width on small screens -->
        <div class="d-flex flex-column flex-lg-row mb-3">
          <!-- Area select input -->
          <div class="form-group mr-lg-2 mb-2 mb-lg-0"> <!-- Added responsive margin classes -->
            <label for="area-select">Select Area:</label>
            <select id="area-select" class="form-control">
              <option value="">-Pilih-</option>
              <option value="Ducking 1">Ducking 1</option>
              <option value="Ducking 2">Ducking 2</option>
              <!-- Add more areas if needed -->
            </select>
          </div>
        
          <!-- Cycle select input -->
          <div class="form-group mb-2 mb-lg-0"> <!-- Added responsive margin classes -->
            <label for="cycle-select">Select Cycle:</label>
            <select id="cycle-select" class="form-control">
              <option value="">-Pilih-</option>
              <option value="Cycle 1">Cycle 1</option>
              <option value="Cycle 2">Cycle 2</option>
              <option value="Cycle 3">Cycle 3</option>
            </select>
          </div>
        </div>        

        <div class="row">
          <!-- Camera scanner on the left -->
          <div class="col-lg-6 col-md-10 mb-3"> <!-- Make scanner full-width on small screens -->
            <div id="my-qr-reader" style="width: 70%;"></div> <!-- Set to 100% width for responsiveness -->
          </div>

          <!-- Result display (Table) on the right -->
          <div class="col-lg-6 col-md-9"> <!-- Make table full-width on small screens -->
            <div id="you-qr-result" class="table-responsive"> <!-- Make the table responsive -->
              <table class="table table-bordered">
                <thead>
                  <tr style="background-color: rgb(0, 0, 0); color:aliceblue">
                    <th class="text-center">No</th>
                    <th class="text-center">UniqNo</th>
                    <th class="text-center">Part Name</th>
                    <th class="text-center">Part No</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Cycle</th>
                    <th class="text-center">Area</th>
                  </tr>
                </thead>
                <tbody id="scan-result-table-body">
                  <!-- QR scan results will be inserted here -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Submit button -->
        <button id="submit-scan-data" class="btn btn-primary mt-3">Submit All Scans</button>
        <button id="cancel" class="btn btn"></button>

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
                var scanResultTableBody = document.getElementById('scan-result-table-body');
                var scannedDataSet = new Set();
                var scannedDataArray = [];
                var scanCount = 1;
                var clearScanDelay = 2000;

                function playSuccessSound() {
                    var audio = new Audio('/sound/success_sound.mp3');
                    audio.play();
                }

                let warningDisplayed = false;

                function onScanSuccess(qrCodeMessage) {
                    var selectedArea = document.getElementById('area-select').value;
                    var selectedCycle = document.getElementById('cycle-select').value;
                    if (selectedArea === "") {
                        if (!warningDisplayed) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Silakan pilih area sebelum melakukan pemindaian.',
                                confirmButtonText: 'OK'
                            });
                            warningDisplayed = true;
                        }
                        return;
                    } else {
                        warningDisplayed = false; 
                    }

                    if (selectedCycle === "") {
                        if (!warningDisplayed) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Silakan pilih siklus sebelum melakukan pemindaian.',
                                confirmButtonText: 'OK'
                            });
                            warningDisplayed = true;
                        }
                        return;
                    } else {
                        warningDisplayed = false; 
                    }

                    if (!scannedDataSet.has(qrCodeMessage)) {
                        scannedDataSet.add(qrCodeMessage);

                        let qrDataArray = qrCodeMessage.split('||');

                        scannedDataArray.push({
                            uniq_no_outpcs1: qrDataArray[0],
                            job_no_outpcs1: qrDataArray[1],
                            part_no_outpcs1: qrDataArray[2],
                            qty_outpcs1: qrDataArray[3],
                            cycle_outpcs1: selectedCycle,
                            area_outpcs1: selectedArea
                        });

                        playSuccessSound();

                        let newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${scanCount}</td>
                            <td>${qrDataArray[0]}</td>
                            <td>${qrDataArray[1]}</td>
                            <td>${qrDataArray[2]}</td>
                            <td>${qrDataArray[3]}</td>
                            <td>${selectedCycle}</td>
                            <td>${selectedArea}</td>
                        `;
                        scanResultTableBody.appendChild(newRow);

                        scanCount++;

                        Swal.fire({
                            icon: 'success',
                            title: 'Scan Successful',
                            text: `Data scanned: ${qrDataArray[0]}, ${qrDataArray[1]}, ${qrDataArray[2]}, ${qrDataArray[3]}`,
                            confirmButtonText: 'OK'
                        });

                        setTimeout(() => {
                            lastResult = null;
                        }, clearScanDelay);
                    }
                }

                function submitScannedData() {
                    if (scannedDataArray.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'No Scanned Data',
                            text: 'No scans available to submit.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    $.ajax({
                        url: "{{ route('scanoutpcs.store') }}",
                        method: 'POST',
                        data: {
                            scannedData: scannedDataArray,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Submitted',
                                text: 'Data Sudah di Masukan!',
                                confirmButtonText: 'OK'
                            });

                            scannedDataSet.clear();
                            scannedDataArray = [];
                            scanResultTableBody.innerHTML = '';
                            scanCount = 1;
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: 'An error occurred while submitting the data.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }

                document.getElementById('submit-scan-data').addEventListener('click', submitScannedData);

                var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                    fps: 10,
                    qrbox: 250
                });

                htmlScanner.render(onScanSuccess);
            });
        </script>
      </div>
    </div>
  </div>
</section>
@endsection
