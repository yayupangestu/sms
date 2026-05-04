{{-- @extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan IN Stamping A1 A2</h1>
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
                            url: '{{ route("getA12.qtyTransit") }}',
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
                    url: "{{ route('scaninstmpa12.store2') }}",
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
@endsection --}}



@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan IN Stamping A1 A2</h1>
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

                    let scannedOnce = false;
                    let selectedPartNo2Global = null; // simpan pilihan dari scan sebelumnya

                    function onScanSuccess(qrCodeMessage) {
                        // ✅ Cegah double scan, tapi bisa lanjut lagi nanti
                        if (scannedOnce) return;
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

                            // ✅ Cek apakah uniqNo sudah digunakan di kolom stmp_in_uniqNo*
                            $.ajax({
                                url: '{{ route('check.uniqNoUsedA12') }}',
                                method: 'GET',
                                data: {
                                    uniqNo: dataToSend.uniqNo
                                },
                                success: function(checkResponse) {
                                    if (checkResponse.exists) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Scan Ditolak',
                                            text: 'Label ini sudah digunakan di proses Stamping!',
                                        });
                                        scannedOnce = false; // reset agar bisa scan ulang
                                        return; // ⛔ stop semua proses
                                    }

                                    // ✅ Lanjut ke pengecekan part_no planning
                                    $.ajax({
                                        url: '{{ route('check.partNoPlanningA12') }}',
                                        method: 'GET',
                                        data: {
                                            part_no: dataToSend.part_no
                                        },
                                        success: function(result) {
                                            if (result.exists && result.data && result.data.length > 0) {
                                                let checkboxList = `
                                                        <div style="margin-bottom:6px;">
                                                        <label>
                                                            <input type="radio" name="partno2" value="SPRATING">
                                                            <strong>PART NO sprating</strong>
                                                        </label>
                                                        </div>
                                                        <hr>
                                                        ` + result.data.map(item => `
                                                        <div style="text-align:left; margin-bottom:4px;">
                                                        <label>
                                                            <input type="radio" name="partno2" value="${item.part_no2}">
                                                            <strong>${item.part_no2 ?? '-'}</strong> | ${item.mesin ?? '-'} | ${item.date_plan}
                                                        </label>
                                                        </div>
                                                        `).join('');

                                                let previousChoiceText = selectedPartNo2Global ?
                                                    `<p style="margin-top:6px;color:#007bff;">
                                                        Pilihan sebelumnya: ${selectedPartNo2Global.join(', ')}
                                                    </p>` :
                                                    '';

                                                Swal.fire({
                                                    title: 'Pilih Part No Tambahan',
                                                    icon: 'info',
                                                    width: 520,
                                                    confirmButtonText: 'Gunakan',
                                                    cancelButtonText: 'Batal',
                                                    showCancelButton: true,
                                                    focusConfirm: false,
                                                    html: `
        <div style="text-align:left; font-size:14px;">

            <div style="margin-bottom:10px;">
                <span style="color:#6c757d;">Part No Utama</span><br>
                <strong style="font-size:15px;">${dataToSend.part_no}</strong>
            </div>

            <hr style="margin:10px 0">

            <div style="margin-bottom:8px; font-weight:600;">
                Pilih Part No yang akan diproses
            </div>

            <div style="
                max-height:220px;
                overflow-y:auto;
                border:1px solid #dee2e6;
                border-radius:6px;
                padding:8px;
                background:#f8f9fa;
            ">
                ${checkboxList}
            </div>

            ${previousChoiceText ? `
                                <div style="
                                    margin-top:10px;
                                    padding:8px;
                                    background:#e9f5ff;
                                    border-left:4px solid #0d6efd;
                                    border-radius:4px;
                                    font-size:13px;
                                ">
                                    ${previousChoiceText}
                                </div>
                            ` : ''}
                                </div>
                            `,
                                                    preConfirm: () => {
                                                        const selected = document.querySelector(
                                                            'input[name="partno2"]:checked'
                                                        )?.value;

                                                        if (!selected && !selectedPartNo2Global) {
                                                            Swal.showValidationMessage(
                                                                'Pilih salah satu Part No');
                                                            return false;
                                                        }

                                                        return selected ? [selected] :
                                                            selectedPartNo2Global;
                                                    }
                                                }).then((swalResult) => {
                                                    if (swalResult.isConfirmed) {
                                                        selectedPartNo2Global = swalResult.value;
                                                        dataToSend.selected_part_no2 = swalResult.value;
                                                        lanjutScanRM(dataToSend);
                                                    } else {
                                                        scannedOnce = false;
                                                    }
                                                });
                                            } else {
                                                // jika tidak ada planning hari ini
                                                lanjutScanRM(dataToSend);
                                            }
                                        },
                                        error: function() {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Gagal mengecek part_no di planning_line_b3_s'
                                            });
                                            scannedOnce = false;
                                        }
                                    });
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Gagal memeriksa uniqNo di server.'
                                    });
                                    scannedOnce = false;
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Invalid QR Code Data',
                            });
                            scannedOnce = false;
                        }

                        // ✅ Timeout aman supaya tidak nge-freeze
                        setTimeout(() => scannedOnce = false, 4000);
                    }

                    // === Fungsi lanjutan ===
                    function lanjutScanRM(dataToSend) {
                        $.ajax({
                            url: '{{ route('getA12.qtyTransit') }}',
                            method: 'GET',
                            data: {
                                uniqNo: dataToSend.uniqNo
                            },
                            success: function(response) {
                                let qtyStamping = response.qty_stamping ?? '0';
                                let isValidQty = parseInt(qtyStamping) > 0;
                                let hideQtyAwal = dataToSend.uniqNo.startsWith("B");

                                Swal.fire({
                                    icon: isValidQty ? 'question' : 'warning',
                                    title: isValidQty ? 'Confirm Scan' : 'Qty label ini 0',
                                    html: `
                                <strong>Uniq No:</strong> ${dataToSend.uniqNo}<br>
                                <strong>Part No:</strong> ${dataToSend.part_no}<br>
                                <strong>Material Name:</strong> ${dataToSend.spec}<br>
                                <strong>Supplier:</strong> ${dataToSend.supplier}<br>
                                ${hideQtyAwal ? '' : `<strong>Qty Sheet Awal:</strong> ${dataToSend.qty_out_sheet}<br>`}
                                <strong>Qty Sisa/Blank:</strong>
                                <span style="color:${isValidQty ? 'black' : 'red'}">${qtyStamping}</span>
                            `,
                                    showCancelButton: true,
                                    showConfirmButton: isValidQty,
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed && isValidQty) {
                                        sendDataToServer(dataToSend);
                                    } else {
                                        scannedOnce = false;
                                    }
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Info',
                                    text: 'Tolong periksa apakah sudah scan Out RM',
                                });
                                scannedOnce = false;
                            }
                        });
                    }

                    // === Kirim data ke server ===
                    function sendDataToServer(dataToSend) {
                        $.ajax({
                            url: "{{ route('scaninstmpa12.store2') }}",
                            method: 'POST',
                            data: dataToSend,
                            success: function(response) {
                                Swal.fire({
                                    icon: response.icon || (response.success ? 'success' : 'info'),
                                    title: response.success ? 'Berhasil' : 'Info',
                                    text: response.message,
                                }).then(() => {
                                    scannedOnce = false; // ✅ reset setelah selesai
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Kesalahan',
                                    text: 'Label Sudah Di Scan',
                                });
                                scannedOnce = false;
                            }
                        });
                    }

                    // === Inisialisasi QR Scanner ===
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
