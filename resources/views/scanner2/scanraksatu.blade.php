@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan QR Code Type Nut</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div id="you-qr-result" class="mb-3"></div>
                <div id="my-qr-reader" style="width: 500px;"></div>
            </div>
        </div>

        <table id="scan-result-table" border="2" cellpadding="10">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu Scan</th>
                    <th>Data QR Code</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan ditambahkan di sini -->
            </tbody>
        </table>

    </section>



    <!-- Load Libraries -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const qrResult = document.getElementById('you-qr-result');
            const htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            });

            let firstScanData = null;
            let secondScanData = null;
            let isScanningEnabled = true;
            let isSecondScanProcessed = false;

            function playSuccessSound() {
                const audio = new Audio('/sound/success_sound.mp3');
                audio.play();
            }

            let scanCount = 0;

            function appendScanResult(qrText) {
                scanCount++;
                const tableBody = document.querySelector("#scan-result-table tbody");
                const row = document.createElement("tr");

                const timeNow = new Date().toLocaleTimeString();

                row.innerHTML = `
                    <td>${scanCount}</td>
                    <td>${timeNow}</td>
                    <td>${qrText}</td>
                `;
                tableBody.prepend(row);
            }

            function onScanSuccess(decodedText, decodedResult) {
    if (!isScanningEnabled || isSecondScanProcessed) return;

    qrResult.innerHTML = ``;
    appendScanResult(decodedText);
    playSuccessSound();

    if (!firstScanData) {
        if (!decodedText.includes("||")) {
            Swal.fire({
                title: 'Format Tidak Valid',
                text: 'QR pertama harus mengandung "||". Silakan scan ulang.',
                icon: 'warning'
            }).then(() => {
                location.reload(); // tambahkan reload di sini
            });
            return;
        }

        firstScanData = decodedText;
        isScanningEnabled = false;
        Swal.fire({
            title: 'QR Code Terscan!',
            text: `Hasil scan pertama: ${decodedText}`,
            icon: 'info',
            showConfirmButton: true,
            confirmButtonText: 'Lanjutkan ke scan kedua'
        }).then((result) => {
            if (result.isConfirmed) {
                isScanningEnabled = true;
            }
        });
    } else if (firstScanData && !secondScanData) {
        secondScanData = decodedText;

        const firstCode = firstScanData.split("||")[0];
        const secondCode = secondScanData.split("||")[0];

        if (firstCode === secondCode) {
            // Validasi dan Simpan Data Setelah Kedua Scan Valid
            Swal.fire({
                title: 'QR Code Valid!',
                text: `Hasil scan kedua cocok: ${decodedText}`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Buka Rak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simpan QR pertama ke database setelah scan kedua valid
                    $.ajax({
                        url: "{{ route('scanraksatu.storeScanOutNut') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            qr_code: firstScanData // Kirim hasil scan pertama setelah scan kedua valid
                        },
                        success: function(response) {
                            console.log("Scan pertama disimpan:", response);
                        },
                        error: function(xhr, status, error) {
                            console.error("Gagal simpan scan pertama:", error);
                        }
                    });

                    // Aktifkan Relay Berdasarkan Kode Scan Pertama
                    if (firstCode === "9004A-17210") {
                        $.ajax({
                            url: "{{ route('scanraksatu.activateRelay') }}",
                            method: 'GET',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Relay 1 Activated!',
                                    text: 'Rak 1 berhasil dibuka.',
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });

                                setTimeout(function() {
                                    $.ajax({
                                        url: "{{ route('scanraksatu.deactivateRelay') }}",
                                        method: 'GET',
                                        success: function() {
                                            console.log("Relay 1 dimatikan otomatis setelah 5 detik");
                                        },
                                        error: function() {
                                            console.error("Gagal mematikan relay 1 secara otomatis.");
                                        }
                                    });
                                }, 1000);
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menyalakan relay 1.',
                                    icon: 'error'
                                });
                            }
                        });
                    } else if (firstCode === "9004A-17204") {
                                    $.ajax({
                                        url: "{{ route('scanraksatu.activateRelayDua') }}",
                                        method: 'GET',
                                        success: function (response) {
                                            Swal.fire({
                                                title: 'Relay 2 Activated!',
                                                text: 'Rak 2 berhasil dibuka.',
                                                icon: 'success'
                                            }).then(() => {
                                                location.reload();
                                            });

                                            setTimeout(function () {
                                                $.ajax({
                                                    url: "{{ route('scanraksatu.deactivateRelayDua') }}",
                                                    method: 'GET',
                                                    success: function () {
                                                        console.log("Relay 2 dimatikan otomatis setelah 5 detik");
                                                    },
                                                    error: function () {
                                                        console.error("Gagal mematikan relay 2 secara otomatis.");
                                                    }
                                                });
                                            }, 2000);
                                        },
                                        error: function (error) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Gagal menyalakan relay 2.',
                                                icon: 'error'
                                            });
                                        }
                                    });
                                } else if (firstCode === "9004A-11376") {
                                    $.ajax({
                                        url: "{{ route('scanraksatu.activateRelayTiga') }}",
                                        method: 'GET',
                                        success: function (response) {
                                            Swal.fire({
                                                title: 'Relay 3 Activated!',
                                                text: 'Rak 3 berhasil dibuka.',
                                                icon: 'success'
                                            }).then(() => {
                                                location.reload();
                                            });

                                            setTimeout(function () {
                                                $.ajax({
                                                    url: "{{ route('scanraksatu.deactivateRelayTiga') }}",
                                                    method: 'GET',
                                                    success: function () {
                                                        console.log("Relay 2 dimatikan otomatis setelah 5 detik");
                                                    },
                                                    error: function () {
                                                        console.error("Gagal mematikan relay 3 secara otomatis.");
                                                    }
                                                });
                                            }, 2000);
                                        },
                                        error: function (error) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Gagal menyalakan relay 2.',
                                                icon: 'error'
                                            });
                                        }
                                    });
                                }
                }
            });
            isSecondScanProcessed = true;
        } else {
            Swal.fire({
                title: 'QR Code Tidak Valid!',
                text: 'Hasil scan kedua tidak cocok dengan yang pertama.',
                icon: 'error'
            }).then(() => {
                firstScanData = null;
                secondScanData = null;
                isScanningEnabled = true;
                isSecondScanProcessed = false;
                location.reload();
            });
        }
    }
}

            htmlScanner.render(onScanSuccess);
        });
    </script>
@endsection
