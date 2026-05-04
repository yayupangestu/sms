@extends('layouts.app')

@section('content')
    <style>
        /* ====== CARD HEADER ====== */
        .card-header {
            background-color: #2e3b4e;
            color: #fff;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
        }

        .card-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-tools .btn {
            padding: 6px 10px;
            border-radius: 6px;
        }

        /* ====== TABLE STYLE ====== */
        #example1 {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.95rem;
        }

        #example1 thead {
            background-color: #2e3b4e;
            color: #fff;
        }

        #example1 th {
            text-align: center;
            padding: 10px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        #example1 td {
            padding: 8px;
            vertical-align: middle;
        }

        #example1 tbody tr:hover {
            background-color: #f1f3f5;
            transition: background 0.2s ease;
        }

        /* Alternating row color */
        #example1 tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* ====== RESPONSIVE DATATABLES ====== */
        @media (max-width: 576px) {

            div.dataTables_length label,
            div.dataTables_filter label {
                width: 100%;
            }

            div.dataTables_length select,
            div.dataTables_filter input {
                width: 100%;
                margin-top: 0.25rem;
            }

            .dataTables_wrapper .d-flex {
                flex-direction: column;
                align-items: stretch;
            }

            .dataTables_filter {
                float: none !important;
                text-align: left !important;
            }

            .dataTables_length {
                margin-bottom: 10px;
            }
        }

        /* ====== MODAL SIZE ====== */
        .modal-xxxl {
            max-width: 95%;
            margin-top: 20px;
        }

        /* ====== EDIT MODAL TABLE ====== */
        #editModalTable th,
        #editModalTable td {
            vertical-align: middle;
            font-size: 0.85rem;
            padding: 6px;
        }

        #editModalTable thead {
            background-color: #f1f3f5;
        }

        /* ====== CUSTOM MODAL ====== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .modal-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.2em;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        .modal-content {
            font-size: 1em;
        }

        .qr-reader-container {
            position: relative;
            width: 100px;
            /* kecilkan dari 300px */
            height: 100px;
            /* atur tinggi sesuai proporsi */
            margin: auto;
            overflow: hidden;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .focus-box {
            position: absolute;
            top: 10%;
            left: 10%;
            width: 10px;
            height: 10px;
            transform: translate(-10%, -10%);
            /* border: 2px solid #00ff00; */
            border-radius: 4px;
            /* box-shadow: 0 0 10px #00ff00; */
            z-index: 10;
            pointer-events: none;
            /* agar tidak menghalangi klik di area kamera */
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">List Prepare Deliver D26</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List List Prepare Deliver D26</h3>
                            {{-- <div class="card-tools">
                    <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                  </div> --}}
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Date</th>
                                        <th>Resume Item</th>
                                        <th width="80">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xxxl" role="document">
            <div class="modal-content">

                <div class="modal-header py-2">
                    <h5 class="modal-title mb-0">
                        Dokumen: <span id="modalDocDN"></span>
                    </h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>

                </div>

                <div class="modal-body">
                    <!-- Notifikasi Scan Error -->

                    <!-- QR Camera -->
                    <div id="my-qr-reader" style="position: relative; width: 50%; max-width: 300px; margin: auto;">
                        <!-- Kotak fokus -->
                        <div class="focus-box"></div>
                    </div>




                    <!-- Tombol Kamera -->
                    <div class="text-center mb-4">
                        <button id="startCameraBtn" class="btn btn-success btn-sm mx-1">Nyalakan Kamera</button>
                        <button id="stopCameraBtn" class="btn btn-danger btn-sm mx-1">Matikan Kamera</button>
                    </div>

                    <div id="scanAlert" class="text-danger font-weight-bold text-center mb-2" style="display:none;"></div>
                    <!-- Kanban CS -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Kanban CS:</label>
                        <div class="col-sm-9">
                            <input type="text" id="scanResult" class="form-control form-control-sm" readonly
                                placeholder="QR Code akan muncul di sini">
                        </div>
                        <div class="col-sm-1" id="checkMark1" style="font-size: 20px; color: green;"></div>
                    </div>

                    <!-- Kanban ASI -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Kanban ASI:</label>
                        <div class="col-sm-9">
                            <input type="text" id="scanResult2" class="form-control form-control-sm" readonly
                                placeholder="QR Code akan muncul di sini">
                        </div>
                        <div class="col-sm-1" id="checkMark2" style="font-size: 20px; color: green;"></div>
                    </div>

                    <!-- Filter Cycle -->
                    <div class="form-group row align-items-center">
                        <label class="col-sm-2 col-form-label font-weight-bold">Cycle:</label>
                        <div class="col-sm-4">
                            <select id="cycleNumber" class="form-control form-control-sm">
                                <option value="">-- Pilih Cycle --</option>
                                <option value="1">Cycle 1</option>
                                <option value="2">Cycle 2</option>
                                <option value="3">Cycle 3</option>
                                <option value="4">Cycle 4</option>
                                <option value="5">Cycle 5</option>
                                <option value="6">Cycle 6</option>
                                <option value="7">Cycle 7</option>
                                <option value="8">Cycle 8</option>

                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="resetScan" class="btn btn-info btn-sm">Reset Scan</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="CekScan" class="btn btn-success btn-sm">Cek</button>
                        </div>
                    </div>
                    <div id="validationResult" style="margin-top:10px; font-weight:bold;"></div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="editModalTable" class="table table-bordered table-striped table-sm">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Manifest</th>
                                    <th>UniqNo</th>
                                    <th>Item (Order)</th>
                                    <th>Qty Order</th>
                                    <th>Qty/Kanban</th>
                                    <th>Jml</th>
                                    <th>Sts</th>
                                </tr>
                            </thead>
                            <tbody id="scanTableBody" class="text-center"></tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Area hasil scan -->
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            list();
        });


        // list data
        function list() {
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('listrekapd26adm.list') }}"
                },
                columns: [{
                        data: null,
                        className: 'text-center',
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center'
                    },
                    {
                        data: null,
                        name: 'total_data',
                        className: 'text-center',
                        render: function(data) {
                            return `
            <span style="
                display: inline-block;
                background-color: rgba(23, 162, 184, 0.1);
                color: #17a2b8;
                padding: 6px 12px;
                font-size: 14px;
                font-weight: bold;
                border: 1px solid #17a2b8;
                border-radius: 4px;
                min-width: 40px;
                text-align: center;
                margin-right: 5px;
            ">${data.total_data}</span>

            <span style="
                display: inline-block;
                background-color: rgba(40, 167, 69, 0.1);
                color: #28a745;
                padding: 6px 12px;
                font-size: 14px;
                font-weight: bold;
                border: 1px solid #28a745;
                border-radius: 4px;
                min-width: 40px;
                text-align: center;
                margin-right: 5px;
            ">${data.total_qty2}</span>

            <span style="
                display: inline-block;
                background-color: rgba(255, 193, 7, 0.1);
                color: #856404;
                padding: 6px 12px;
                font-size: 14px;
                font-weight: bold;
                border: 1px solid #ffc107;
                border-radius: 4px;
                min-width: 40px;
                text-align: center;
            ">${data.total_qty_gt0}</span>
        `;
                        }
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center',
                        render: function(data) {
                            return `
                        <a href="#" class="btn btn-primary btn-sm open-modal" data-docdn="${data}">
                            Lihat
                        </a>`;
                        }
                    }
                ],
                columnDefs: [{
                    "targets": [0],
                    "orderable": false,
                }],
                responsive: true,
                fixedColumns: true,
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                }
            });
        }



        // Saat open modal
        $(document).on('click', '.open-modal', function(e) {
            e.preventDefault();

            var docDn = $(this).data('docdn');
            $('#modalDocDN').text(docDn);
            $('#cycleNumber').val('');

            $('#editModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            // Simpan docDn di elemen untuk digunakan saat cycle dipilih
            $('#cycleNumber').data('docdn', docDn);

            // Panggil function untuk load count per cycle
            loadCycleCounts(docDn);
        });

        // Function ambil data count per cycle
        function loadCycleCounts(docDn) {
            $.ajax({
                url: "{{ route('get.qty.rekap') }}", // route Laravel untuk ambil jumlah per cycle
                type: "GET",
                data: {
                    docdn: docDn
                },
                success: function(response) {
                    // response format: { "1": { total: 12, total_gt0: 4, total_qty2: 7 }, ... }
                    $('#cycleNumber option').each(function() {
                        var val = $(this).val();
                        if (val) {
                            var data = response[val] || {
                                total: 0,
                                total_gt0: 0,
                                total_qty2: 0
                            };
                            $(this).text(
                                'Cycle ' + val + ' (' + data.total + '/' + data.total_gt0 + '/' +
                                data.total_qty2 + ')'
                            );
                        }
                    });
                },


                error: function() {
                    console.error("Gagal mengambil data count per cycle");
                }
            });
        }

        // Saat cycle dipilih
        $('#cycleNumber').on('change', function() {
            var selectedCycle = $(this).val();
            var docDnValue = $(this).data('docdn');

            if (selectedCycle) {
                listdetail(docDnValue, selectedCycle);
            }
        });



        let manifestList = []; // Global untuk menyimpan data manifest dari DataTable

        function listdetail(createdAtValue, cycleField) {
            $('#editModalTable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                autoWidth: false,
                responsive: true,
                pageLength: 150,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ route('listrekapd26adm.listdetail') }}",
                    data: {
                        created_at: createdAtValue,
                        cycle: cycleField
                    },
                    dataSrc: function(json) {
                        manifestList = json.data.map(item => item.manifest);
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'manifest',
                        name: 'manifest'
                    },
                    {
                        data: 'uniqNo',
                        name: 'uniqNo'
                    },
                    {
                        data: 'part_no',
                        name: 'part_no'
                    },
                    {
                        data: 'qty_order',
                        name: 'qty_order',
                        className: "text-center",
                        render: function(data) {
                            return '<span style="background-color:#d4edda; color:#155724; font-weight:bold; display:block;">' +
                                data + '</span>';
                        }
                    },
                    {
                        data: 'qty_kanban',
                        name: 'qty_kanban',
                        className: "text-center",
                        render: function(data) {
                            return '<span style="background-color:#fff3cd; color:#856404; font-weight:bold; display:block;">' +
                                data + '</span>';
                        }
                    },
                    {
                        data: 'jml_kanban',
                        name: 'jml_kanban',
                        className: "text-center"
                    },
                    {
                        data: 'sts',
                        name: 'sts',
                        className: "text-center",
                        render: function(data) {
                            if (data == 1) {
                                return '<i class="fa fa-check text-success" style="font-size: 24px; font-weight: bold;"></i>';
                            } else {
                                return '';
                            }
                        }
                    }


                ],
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}"> Loading...'
                },
                dom: '<"top d-flex align-items-center mb-2"<"me-3"l><"flex-grow-1"f>>rt<"bottom"ip>'
            });
        }





        $('#editModal').on('shown.bs.modal', function() {
            $('#scanResult').val('');
            $('#scanResult2').val('');
            $('#checkMark1').html('');
            $('#checkMark2').html('');
            scanStep = 1;
        });

        $('#resetScan').on('click', function() {
            $('#scanResult').val('');
            $('#scanResult2').val('');
            $('#checkMark1').html('');
            $('#checkMark2').html('');
            scanStep = 1;
        });



        let qrScanner = null;
        let scanStep = 1;
        let isCameraRunning = false;

        // Mulai kamera (hanya sekali)
        function showAlert(message, duration = 2000) {
            $('#scanAlert').text(message).show();
            setTimeout(() => {
                $('#scanAlert').fadeOut('slow');
            }, duration);
        }

        function playSuccessSound() {
            let audio = new Audio('{{ asset('sound/success_sound.mp3') }}');
            audio.play().catch(err => console.error("Gagal memutar suara sukses:", err));
        }

        function playErrorSound() {
            let audio = new Audio('{{ asset('sound/error_sound.mp3') }}'); // optional kalau ada
            audio.play().catch(err => console.error("Gagal memutar suara error:", err));
        }

        function startScanner() {
            if (!qrScanner) {
                qrScanner = new Html5Qrcode("my-qr-reader");
            }

            qrScanner.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 200
                },
                qrCodeMessage => {
                    const selectedCycle = $('#cycleNumber').val();

                    if (!selectedCycle) {
                        showAlert('⚠️ Silakan pilih Cycle terlebih dahulu.');
                        playErrorSound();
                        return;
                    }

                    if (scanStep === 1) {
                        if ($('#scanResult').val().trim() !== '') return;

                        // Ambil manifest sampai huruf 'A' pertama
                        let firstAIndex = qrCodeMessage.indexOf("A");
                        let substringToCheck = (firstAIndex !== -1) ?
                            qrCodeMessage.substring(0, firstAIndex + 1) :
                            qrCodeMessage;

                        // Ambil job_no = 7 karakter setelah manifest
                        let jobNoExtract = qrCodeMessage.substr(substringToCheck.length, 8).trim();

                        console.log("Manifest:", substringToCheck);
                        console.log("Job No:", jobNoExtract);

                        // AJAX cek sts ke server (route sudah diperbaiki)
                        $.ajax({
                            url: "{{ route('check.stsadm') }}",
                            type: "GET",
                            data: {
                                manifest: substringToCheck,
                                job_no: jobNoExtract
                            },
                            success: function(res) {
                                if (res.sts === 1) {
                                    showAlert('Kanban sudah Scan');
                                    playErrorSound();
                                    return;
                                }

                                let isValid = manifestList.includes(substringToCheck);
                                if (!isValid) {
                                    showAlert('⚠️ No manifest tidak ditemukan di Cycle ini!');
                                    playErrorSound();
                                    return;
                                } else {
                                    $('#scanAlert').hide();
                                    playSuccessSound();
                                }

                                // ✅ Update input dan checkmark
                                $('#scanResult').val(qrCodeMessage);
                                $('#checkMark1').html('✅');
                                scanStep = 2;

                                const table = $('#editModalTable').DataTable();
                                table.search(substringToCheck).draw();
                            },
                            error: function(xhr) {
                                if (xhr.status === 404) {
                                    showAlert('⚠️ Data tidak ditemukan di server.');
                                } else {
                                    showAlert('⚠️ Gagal cek status di server.');
                                }
                                playErrorSound();
                            }
                        });

                    } else if (scanStep === 2) {
                        if ($('#scanResult2').val().trim() !== '') return;

                        if (qrCodeMessage === $('#scanResult').val()) {
                            showAlert('⚠️ QR Code sudah discan sebelumnya!');
                            playErrorSound();
                        } else {
                            $('#scanAlert').hide();
                            $('#scanResult2').val(qrCodeMessage);
                            $('#checkMark2').html('✅');
                            playSuccessSound();
                        }
                    }

                },
                errorMessage => {
                    // error handling if needed
                }
            ).then(() => {
                isCameraRunning = true;
            }).catch(err => {
                console.error("Gagal nyalakan kamera:", err);
            });
        }




        function stopScanner() {
            if (qrScanner && isCameraRunning) {
                qrScanner.stop().then(() => {
                    qrScanner.clear();
                    isCameraRunning = false;
                }).catch(err => {
                    console.error("Gagal matikan kamera:", err);
                });
            }
        }
        // Tombol: Nyalakan Kamera
        $('#startCameraBtn').on('click', function() {
            if (!isCameraRunning) {
                startScanner();
            }
        });
        // Tombol: Matikan Kamera
        $('#stopCameraBtn').on('click', function() {
            stopScanner();
        });
        // Tutup Modal: otomatis matikan kamera
        $('#editModal').on('hidden.bs.modal', function() {
            stopScanner();
        });

        $('#cycleNumber').on('change', function() {
            const selectedCycle = $(this).val();
            if (selectedCycle && !isCameraRunning) {
                startScanner();
            }
        });

        function debugString(str, label) {
            console.log(label + ': "' + str + '" (length: ' + str.length + ')');
            for (let i = 0; i < str.length; i++) {
                console.log('Char ' + i + ': "' + str[i] + '" code: ' + str.charCodeAt(i));
            }
        }

        $('#CekScan').on('click', function() {
    let scan1 = $('#scanResult').val().trim();
    let scan2 = $('#scanResult2').val().trim();

    // Ambil job_no dari scan pertama (7 karakter setelah manifest)
    let firstAIndex = scan1.indexOf("A");
    let substringToCheck = (firstAIndex !== -1) ?
        scan1.substring(0, firstAIndex + 1) :
        scan1;
    let extractedScan1 = scan1.substr(substringToCheck.length, 8).trim();

    let firstDotIndex = scan2.indexOf('.');
    let secondDotIndex = scan2.indexOf('.', firstDotIndex + 1);
    let extractedScan2 = (firstDotIndex !== -1) ?
        scan2.substring(firstDotIndex + 1, secondDotIndex !== -1 ? secondDotIndex : scan2.length).trim() :
        scan2.trim();

    // Ambil manifest extract contoh seperti sebelumnya
    let manifestExtract = scan1.substr(0, 16);

    debugString(extractedScan1, 'Extracted Scan 1');
    debugString(extractedScan2, 'Extracted Scan 2');
    debugString(manifestExtract, 'Extracted Manifest');

    if (extractedScan1 === extractedScan2) {
        Swal.fire({
            icon: 'success',
            title: '✅ Data cocok!',
            html: `<p>QR CS: <b>${extractedScan1}</b></p>` +
                  `<p>QR ASI: <b>${extractedScan2}</b></p>` +
                  `<p>Manifest extract: <b>${manifestExtract}</b></p>`,
            confirmButtonText: 'OK, proses update',
            showCancelButton: true,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('listrekapd26adm.update') }}",
                    method: 'POST',
                    data: {
                        scan_first: extractedScan1,
                        manifest_extract: manifestExtract,
                        scan_second: scan2,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Qty order berhasil dikurangi.'
                        }).then(() => {
                            // Reset otomatis kolom scan dan checkmark
                            $('#scanResult').val('');
                            $('#scanResult2').val('');
                            $('#checkMark1').html('');
                            $('#checkMark2').html('');
                            scanStep = 1;
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error'
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Dibatalkan', 'Proses update dibatalkan.', 'info');
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: '❌ Data tidak cocok!',
            html: `<p>Job No CS: <b>${extractedScan1}</b></p>` +
                  `<p>Scan ASI: <b>${extractedScan2}</b></p>`
        });
    }
});

// Tombol manual reset
$('#resetScan').on('click', function() {
    $('#scanResult').val('');
    $('#scanResult2').val('');
    $('#checkMark1').html('');
    $('#checkMark2').html('');
    scanStep = 1;
});

    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
