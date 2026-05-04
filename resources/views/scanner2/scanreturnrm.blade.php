@extends('layouts.app')

@section('content')

<style>
    /* Buat tampilan responsif untuk elemen scanner */
    .qr-reader {
        width: 100%;
        max-width: 500px; /* Batas maksimal untuk desktop */
        margin: 0 auto; /* Center untuk tampil lebih baik di berbagai perangkat */
    }

    /* Media query untuk layar kecil */
    @media (max-width: 600px) {
        .qr-reader {
            width: 100%; /* Lebar penuh pada perangkat kecil */
            max-width: 100%; /* Tidak ada batas maksimal di layar kecil */
        }

        .content-header h1 {
            font-size: 1.5rem; /* Ukuran font lebih kecil pada layar kecil */
        }
    }
  </style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Scan Sisa Material</h1>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div id="you-qr-result"></div>
      <div id="my-qr-reader" class="qr-reader"></div> <!-- Menambahkan class qr-reader -->

      <!-- Load Library -->
      <script src="https://unpkg.com/html5-qrcode"></script>
      <!-- Load SweetAlert2 -->
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
        domReady(function () {
    var scannedOnce = false;



    const loggedInUsername = "{{ auth()->user()->username }}";

 function onScanSuccess(qrCodeMessage) {
    if (!scannedOnce) {
        scannedOnce = true;

        let qrDataArray = qrCodeMessage.split('||');
        console.log("Scanned Data:", qrDataArray); // Debugging

        // ✅ Support untuk 8 atau 9 kolom
        if (qrDataArray.length === 8 || qrDataArray.length === 9) {
            let uniqNo = qrDataArray[3];

            // Ambil qty_awal dari server berdasarkan uniqNo
            $.ajax({
                url: "{{ route('get.qty.stamping') }}",
                method: "GET",
                data: { uniqNo: uniqNo },
                success: function (response) {
                    if (!response.success && response.icon === 'info') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Informasi',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        scannedOnce = false;
                        return;
                    }

                    if (response.success) {
                        let qty_out_kg = parseFloat(qrDataArray[6]);
                        let extraData = qrDataArray.length === 9 ? qrDataArray[8] : null; // kolom tambahan

                        let dataToSend = {
                            _token: '{{ csrf_token() }}',
                            part_no: qrDataArray[0],
                            spec: qrDataArray[1],
                            supplier: qrDataArray[2],
                            uniqNo: uniqNo,
                            id_data: qrDataArray[4],
                            id: qrDataArray[5],
                            qty_out_kg: qty_out_kg,
                            qty_awal: response.qty_awal,
                        };

                        if (extraData !== null) {
                            dataToSend.extra_info = extraData;
                        }

                        // Buat opsi line berdasarkan user login
                        let lineOptions = '';
                        if (loggedInUsername === 'Massahid' || loggedInUsername === 'Urief') {
                            lineOptions = `
                                <option value="">-- Pilih Line --</option>
                                <option value="LINE B3">LINE B3</option>
                                <option value="LINE C1">LINE C1</option>
                                <option value="LINE C2">LINE C2</option>
                            `;
                        } else if (loggedInUsername === 'Super') {
                            lineOptions = `
                                <option value="">-- Pilih Line --</option>
                                <option value="LINE B3">LINE B3</option>
                                <option value="LINE C1">LINE C1</option>
                                <option value="LINE C2">LINE C2</option>
                                <option value="LINE A1">LINE A1</option>
                                <option value="LINE A2">LINE A2</option>
                                <option value="LINE B1">LINE B1</option>
                            `;
                        } else {
                            lineOptions = `<option value="">Tidak ada line untuk user ini</option>`;
                        }

                        Swal.fire({
                            title: 'Scanned Successfully!',
                            html: `
                                <p><strong>Unique No:</strong> ${uniqNo}</p>
                                <p><strong>Name Material:</strong> ${qrDataArray[1]}</p>
                                <p><strong>Supplier:</strong> ${qrDataArray[2]}</p>
                                <p><strong>Qty Awal:</strong> ${response.qty_awal}</p>
                                <hr>
                                <p>Masukan Jumlah Sisa Material:</p>
                                <input id="qty_return_input" type="number" class="swal2-input" placeholder="Qty Return">
                                <p>Pilih Line:</p>
                                <select id="line_select" class="swal2-select">
                                    ${lineOptions}
                                </select>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const qtyInput = document.getElementById('qty_return_input');
                                const lineSelect = document.getElementById('line_select');

                                const qty_return = parseFloat(qtyInput.value);
                                const maxQty = parseFloat(response.qty_awal);
                                const line_id = lineSelect.value;

                                if (isNaN(qty_return) || qty_return <= 0) {
                                    Swal.showValidationMessage('Masukkan jumlah Qty Return yang valid.');
                                    return false;
                                }

                                if (qty_return > maxQty) {
                                    Swal.showValidationMessage(`Qty Return tidak boleh lebih dari ${maxQty}.`);
                                    return false;
                                }

                                if (!line_id) {
                                    Swal.showValidationMessage('Silakan pilih Line tujuan.');
                                    return false;
                                }

                                return { qty_return, line_id };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                dataToSend.qty_return = result.value.qty_return;
                                dataToSend.line_id = result.value.line_id;

                                console.log("Final Data to Send:", dataToSend); // Debugging

                                $.ajax({
                                    url: "{{ route('scanreturnrm.store') }}",
                                    method: 'POST',
                                    data: dataToSend,
                                    success: function (response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Data Saved Successfully',
                                                text: response.message,
                                                confirmButtonText: 'Okay'
                                            }).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: response.icon || 'error',
                                                title: response.icon === 'info' ? 'Informasi' : 'Error',
                                                text: response.message,
                                                confirmButtonText: 'Okay'
                                            });
                                            scannedOnce = false;
                                        }
                                    },
                                    error: function (xhr) {
                                        let message = xhr.responseJSON?.message || 'Failed to save scanned data';
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: message,
                                            confirmButtonText: 'Okay'
                                        });
                                        scannedOnce = false;
                                    }
                                });
                            } else {
                                scannedOnce = false;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonText: 'Okay'
                        });
                        scannedOnce = false;
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to retrieve qty_awal',
                        confirmButtonText: 'Okay'
                    });
                    scannedOnce = false;
                }
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'QR data format is incorrect. Expected 8 or 9 columns.',
                confirmButtonText: 'Okay'
            });
            scannedOnce = false;
        }
    }
}





    var htmlScanner = new Html5QrcodeScanner("my-qr-reader", { fps: 10, qrbox: 250 });
    htmlScanner.render(onScanSuccess);
});


    </script>

    </div>
  </div>
</section>
@endsection
