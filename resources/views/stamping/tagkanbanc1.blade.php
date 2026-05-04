@extends('layouts.app')

@section('content')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 10px;
        }

        .table thead th {
            background-color: #122d3f;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #63ddff5d;
        }

        .table tbody td {
            text-align: center;
            border-color: #e3dfdf;
        }

        .btn-info {
            background-color: #245a7e;
            border-color: #245a7e;
        }

        .btn-info:hover {
            background-color: #92d2fd;
            border-color: #122d3f;
        }
         /* Warna abu dan efek halus */
    .card {
        border: none;
        background-color: #f8f9fa;
    }

    .table thead {
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #e9ecef;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .table tbody tr:hover {
        background-color: #d6d8db;
        transition: background-color 0.2s ease;
    }

    .btn-sm {
        padding: 4px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 5px;
        background-color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #dee2e6;
        border: 1px solid #adb5bd;
        border-radius: 4px;
        margin: 2px;
        padding: 5px 10px;
        transition: background-color 0.2s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #6c757d;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #adb5bd;
        color: white;
    }

    .modal-header {
        background-color: #2c3e50;
        color: white;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        background-color: #f8f9fa;
    }

    .form-control,
    .form-select {
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 4px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .table thead {
        background-color: #495057;
        color: white;
    }

    .table tbody tr:nth-child(even) {
        background-color: #e9ecef;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .table tbody tr:hover {
        background-color: #ced4da;
        transition: background-color 0.2s ease-in-out;
    }

    .table-responsive {
        padding: 10px;
    }

    .select2-container .select2-selection--single {
        height: 33px;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .modal-footer {
        border-top: none;
        background-color: #f1f3f5;
        padding: 10px;
    }

    #btn_submit, .btn-secondary.close {
        margin-left: 10px;
    }

    .modal-title {
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    </style>
    </style>

    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Tag Kanban LINE C1</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
        <div class="row">
            <a href="dashboardplanning" style="margin-left: 20px;">
                <button class="btn btn-warning">
                    <i class="fa fas fa-arrow-left"></i> Kembali ke Dashboard
                </button>
            </a>
            <div class="col-12">
                <div class="card shadow-sm rounded">
                    <div class="modal-header" style="background-color: #2e3b4e; color:#ffffff">
                        <h3 class="card-title m-0">List Data Kanban</h3>
                        <div class="card-tools ml-auto">
                            <button class="btn btn-sm btn-light text-dark" id="btn_add">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body bg-light p-3">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead style="background-color: #495057; color:#ffffff">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Date</th>
                                    <th>Line</th>
                                    <th width="130">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>





    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div c class="modal-header" style="background-color: rgb(0, 11, 68); color:white">
                    <h4 class="modal-title" id="title1">Create Your Kanban</h4>
                    <h4 class="modal-title" id="title2">Edit Your Kanban</h4>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-primary btn-sm" id="btn_submit">Save</button>
                        {{-- <button class="btn btn-default btn-sm" id="btn_cancel">Cancel</button> --}}
                        <button type="button" class="close; btn btn-secondary" data-dismiss="modal"
                            aria-label="Close">Close</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group row">

                        <label for="qty" class="col-sm-2 col-form-label">Nomor Kanban :</label>
                        <div class="col-sm-3">
                            <input style="width: 100%" type="text" id="doc_no" class="form-control form-control-sm"
                                readonly>
                        </div>


                        <div class="col-sm-7"></div>
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-2 col-form-label">Date :</label>
                        <div class="col-sm-3">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>



                        <div class="col-sm-7"></div>
                        <label class="col-sm-2 col-form-label">Line :</label>
                        <div class="col-sm-2 mb-1">
                            <select style="width: 100%;" id="line_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($line_stmps as $line)
                                @if ($line->id == 1)
                                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-1 col-form-label">SHIFT:</label>
                        <div class="col-sm-2">
                            <select style="width: 100%;" id="shift" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value="SHIFT 1">SHIFT 1</option>
                                <option value="SHIFT 2">SHIFT 2</option>
                                {{-- <option value="SHIFT 3">SHIFT 3</option> --}}
                            </select>
                        </div>

                        {{-- <label class="col-sm-1 col-form-label">Kode Material:</label>
                <div class="col-sm-2">
                    <select id="kode_material" class="form-control form-control-sm" required>
                        <option value="">Pilih Kode Material</option>
                    </select>
                </div> --}}

                        <label class="col-sm-1 col-form-label">Kode Material:</label>
                        <div class="col-sm-2">
                            <select id="kode_material" class="form-control form-control-sm" required>
                                <option value="">Pilih Kode Material</option>
                            </select>
                        </div>


                        <label class="col-sm-1 col-form-label">Qty:</label>
                        <div class="col-sm-1">
                            <input type="text" id="qty_stamping" class="form-control form-control-sm" readonly>
                        </div>


                        <label class="col-sm-2 col-form-label">Item:</label>
                        <div class="col-sm-10 mb-2">
                            <select style="width: 100%;" id="item_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($data_fg_stampings as $part)
                                <option value="{{ $part->id }}"
                                    data-part_name="{{ $part->part_name }}"
                                    data-job_no="{{ $part->job_no }}"
                                    data-part_no="{{ $part->part_no2 }}"
                                    data-model="{{ $part->model_id }}"
                                    data-qty_plan2="{{ $part->qty_plan2 }}"
                                    data-status_proses="{{ $part->status_proses }}"
                                    {{ ($part->status_proses == 3 || $part->status_proses == 1 || $part->status_proses == 4 || is_null($part->status_proses)) ? 'disabled' : '' }}
                                    style="{{ $part->status_proses == 3 ? 'color: green;' : '' }}">
                                    {{ $part->part_no2 }} | {{ $part->model_id }} | {{ $part->qty_plan2 }}
                                    {{ $part->status_proses == 3 ? ' - [Selesai Proses]' : '' }}
                                    {{ $part->status_proses == 1 ? ' - [Material Ready]' : '' }}
                                    {{ $part->status_proses == 4 ? ' - [Proses Cancel]' : '' }}
                                    {{ is_null($part->status_proses) ? ' - [Prepare Material]' : '' }}
                                    ( {{ $part->actual_production }} )
                                </option>
                            @endforeach
                            </select>
                        </div>


                        <label class="col-sm-2 col-form-label">Qty Actual:</label>
                        <div class="col-sm-1">
                            <input type="text" id="qty_ok" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-1 col-form-label">Qty NG :</label>
                        <div class="col-sm-1">
                            <input type="text" id="qty_ng" class="form-control form-control-sm" required>
                        </div>

                        {{-- <label class="col-sm-1 col-form-label">Start Proses:</label>
                        <div class="col-sm-2">
                            <input type="time" id="time_start" class="form-control form-control-sm" required>
                        </div>
                        <label class="col-sm-1 col-form-label">End Proses:</label>
                        <div class="col-sm-2">
                            <input type="time" id="time_end" class="form-control form-control-sm" required>
                        </div> --}}

                        <div class="col-sm-1"></div>
                        <label class="col-sm-1 col-form-label">Destination:</label>
                        <div class="col-sm-2">
                            <select style="width: 100%;" id="tujuan" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value="PC-STORE">PC-STORE</option>
                                <option value="LINE STORE">LINE STORE</option>
                                   <option value="REPAIR">REPAIR</option>
                            </select>
                        </div>

                        <label class="col-sm-1 col-form-label">Uniq:</label>
                        <div class="col-sm-1">
                            <input type="text" id="uniqNo" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-sm-7"></div>
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" id="keterangan" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-7"></div>
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-success btn-sm Save">Insert</button>
                            <button type="button" class="btn btn-warning btn-sm Update">Edit</button>
                            <button type="button" class="btn btn-info btn-sm SumQty" data-bs-toggle="modal" data-bs-target="#sumQtyModal">Sum Qty</button>
                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped table-hover">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="50">No</th>
                                {{-- <th>Part Name</th> --}}
                                <th>Job No</th>
                                <th>Part NO</th>
                                <th>Model</th>
                                <th>Kode Material</th>
                                <th>QTY OK</th>
                                <th>QTY NG</th>
                                <th>Shift</th>
                                <th>Uniq No</th>
                                <th>Status</th>
                                <th>Tujuan</th>

                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <!-- Data akan dimasukkan secara dinamis di sini -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="sumQtyModal" tabindex="-1" aria-labelledby="sumQtyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div  class="modal-content">
            <div  style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%); color:white" class="modal-header">
                <h5 class="modal-title" id="sumQtyModalLabel">Jumlahkan Quantity Material</h5>
                <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <label for="km_part" class="form-label fw-bold">Part No</label>
                        <select class="form-control form-control-sm" id="km_part"></select>
                    </div>
                </div>
                <form id="sumQtyForm">
                    <div class="mb-2">
                        <label for="uniqNo1" class="form-label">Kode Material 1</label>
                        <select class="form-control form-control-sm" id="uniqNo1" name="uniqNo1" required></select>
                    </div>
                    <div class="mb-2">
                        <label for="uniqNo2" class="form-label">Kode Material 2</label>
                        <select class="form-control form-control-sm" id="uniqNo2" name="uniqNo2" required></select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 btn-sm">Jumlahkan</button>
                </form>
                <div id="totalQtyResult" class="mt-3" style="display:none;">
                    <div class="alert alert-success d-flex align-items-center p-2" role="alert">
                        <i class="bi bi-check-circle me-2" style="font-size: 1.2rem;"></i>
                        <strong>Total Quantity:</strong> <span id="totalQty"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="part_name" name="part_name">
<input type="hidden" id="job_no" name="job_no">
<input type="hidden" id="part_no" name="part_no">
<input type="hidden" id="model" name="model">
<input type="hidden" id="name_material" name="name_material">
<input type="hidden" id="part_no_rm" name="part_no_rm">
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
    {{-- <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script> --}}
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
               $(document).ready(function() {
            $("#example1").show();
            list();
        });

        $(document).ready(function () {
    $('#myModal2').on('shown.bs.modal', function () {
        $('#line_id').val('1').trigger('change'); // set value dan trigger select2 update jika pakai select2
    });
});

$(document).ready(function () {
    $('#myModal2').on('shown.bs.modal', function () {
        // Set default line_id ke 1
        $('#line_id').val('1').trigger('change');

        // Dapatkan jam saat ini
        const now = new Date();
        const hour = now.getHours();

        // Atur shift berdasarkan jam
        let selectedShift = '';
        if (hour >= 7 && hour < 20) {
            selectedShift = 'SHIFT 1';
        } else {
            selectedShift = 'SHIFT 2';
        }

        // Set nilai pada select shift
        $('#shift').val(selectedShift).trigger('change');
    });
});

$(document).ready(function () {
    $('#myModal2').on('shown.bs.modal', function () {
        // 1. Set default line_id
        $('#line_id').val('1').trigger('change');

        // 2. Set shift otomatis
        const now = new Date();
        const hour = now.getHours();
        let selectedShift = (hour >= 7 && hour < 20) ? 'SHIFT 1' : 'SHIFT 2';
        $('#shift').val(selectedShift).trigger('change');

        // 3. Set tanggal hari ini ke #date_plan
        $('#date_plan').val(now.toISOString().slice(0, 10));

        // 4. Pilih otomatis item dengan status_proses == 2
        let found = false;
        $('#item_id option').each(function () {
            const statusProses = $(this).data('status_proses');
            if (statusProses == 2 && !found) {
                $('#item_id').val($(this).val()).trigger('change');
                found = true;
            }
        });
    });
});

/// BATS ALAM LAIN


        const modal = new bootstrap.Modal(document.getElementById('sumQtyModal'));
        document.querySelector('.SumQty').addEventListener('click', () => {
            modal.show();
        });

        function timeToMinutes(timeStr) {
        const [hours, minutes] = timeStr.split(':').map(Number);
        return hours * 60 + minutes;
    }

    function checkShiftAvailability() {
        const now = new Date();
        const currentMinutes = now.getHours() * 60 + now.getMinutes();

        const shift1Start = timeToMinutes("07:00");
        const shift1End = timeToMinutes("20:00");

        const shift2Start = timeToMinutes("20:00");
        const shift2End = timeToMinutes("07:30");

        const shift1Option = document.querySelector('#shift option[value="SHIFT 1"]');
        const shift2Option = document.querySelector('#shift option[value="SHIFT 2"]');

        // Enable/disable based on time
        const isShift1 = currentMinutes >= shift1Start && currentMinutes <= shift1End;
        const isShift2 = currentMinutes >= shift2Start || currentMinutes <= shift2End;

        shift1Option.disabled = !isShift1;
        shift2Option.disabled = !isShift2;

        // Optional: clear selected if currently disabled
        const shiftSelect = document.getElementById("shift");
        if (shift1Option.disabled && shiftSelect.value === "SHIFT 1") {
            shiftSelect.value = "";
        }
        if (shift2Option.disabled && shiftSelect.value === "SHIFT 2") {
            shiftSelect.value = "";
        }
    }

    // Jalankan saat modal dibuka
    $('#myModal2').on('show.bs.modal', function () {
        checkShiftAvailability();
    });



    $(document).ready(function () {
    $.get("{{ route('kanbanstmpc1.getPartNos') }}", function (data) {
        if (data.length > 0) {
            let options = '<option value="">Pilih Part No nich</option>';

            data.forEach(item => {
                // Tampilkan hanya part_no dengan status_proses == 2
                if (item.status_proses == 2) {
                    const shiftLabel = item.shift ? ` (Shift ${item.shift})` : '';
                    const displayText = '🟩 ' + item.part_no + shiftLabel;

                    options += `<option value="${item.part_no}" style="background-color: #d4edda; border: 1px solid #28a745;">${displayText}</option>`;
                }
            });

            $('#km_part').html(options);
        } else {
            $('#km_part').html('<option value="">Data tidak ditemukan</option>');
        }
    }).fail(function () {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal mengambil data Part No!',
        });
    });
});


       $(document).ready(function() {
    // Menangani perubahan pada km_part
    $('#km_part').on('change', function() {
        var partNo = $(this).val();

        if (partNo) {
            $.get("{{ route('kanbanstmpc1.data2') }}", { part_no: partNo }, function(data) {
    if (data.length > 0) {
        let options = '<option value="">Pilih Kode Material</option>';
        data.forEach(item => {
            options += `<option value="${item.uniqNo}">${item.part_no} - ${item.uniqNo} - (${item.qty_stamping})</option>`;
        });

        $('#uniqNo1').html(options);
        $('#uniqNo2').html(options);
    } else {
        $('#uniqNo1').html('<option value="">Tidak ada data</option>');
        $('#uniqNo2').html('<option value="">Tidak ada data</option>');
    }
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal mengambil data dropdown!',
                });
            });
        } else {
            $('#uniqNo1, #uniqNo2').html('<option value="">Pilih Part No terlebih dahulu</option>');
        }
    });

    $('#uniqNo1').on('change', function () {
    var uniqNo1 = $(this).val();
    var partNo = $('#km_part').val();

    if (partNo) {
        $.get("{{ route('kanbanstmpc1.data2') }}", { part_no: partNo }, function (data) {
            let options = '<option value="">Pilih Kode Material</option>';
            data.forEach(item => {
                if (item.uniqNo !== uniqNo1) {
                     options += `<option value="${item.uniqNo}">${item.part_no} - ${item.uniqNo} - (${item.qty_stamping})</option>`;
                }
            });

            $('#uniqNo2').html(options);
        }).fail(function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengambil data dropdown untuk uniqNo2!',
            });
        });
    }
});


    // Submit form untuk sumQty
    $('#qtyForm').on('submit', function(e) {
        e.preventDefault();

        $.post("{{ route('kanbanstmpc1.totalQtyKm') }}", $(this).serialize(), function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Total Qty: ' + response.total_qty,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengirim data!',
            });
        });
    });
});



        $('#sumQtyForm').on('submit', function(event) {
            event.preventDefault();

            var uniqNo1 = $('#uniqNo1').val();
            var uniqNo2 = $('#uniqNo2').val();

            // SweetAlert konfirmasi sebelum penjumlahan
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan menjumlahkan Qty 2 Kode Material yang berbeda.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan "Ya, Lanjutkan"
                    $.ajax({
                        url: "{{ route('kanbanstmpc1.totalQtyKm') }}", // URL dengan nama route
                        method: 'POST',
                        data: {
                            uniqNo1: uniqNo1,
                            uniqNo2: uniqNo2,
                            _token: '{{ csrf_token() }}' // CSRF Token
                        },
                        success: function(response) {
                            console.log(response); // Tambahkan log untuk melihat response
                            if (response.success) {
                                $('#totalQty').text(response
                                .total_qty); // Menampilkan total qty di halaman
                                $('#totalQtyResult').show(); // Menampilkan hasil di modal

                                // Mengurangi nilai qty_stamping uniqNo1 setelah berhasil
                                var updatedQtyNo1 = response.updated_qty_no1;
                                $('#uniqNo1').val(updatedQtyNo1); // Perbarui input uniqNo1

                                // SweetAlert sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Penjumlahan berhasil dilakukan!',
                                    timer: 3000,
                                    showConfirmButton: false
                                }).then(() => {
                                });
                            } else {
                                // Menampilkan SweetAlert jika qty_stamping uniqNo1 lebih besar atau sama dengan qty_stamping uniqNo2
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Peringatan',
                                    text: response.message ||
                                        'Failed to calculate quantity.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal melakukan permintaan ke server.',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            // Menonaktifkan input qty_ok sampai kode_material dipilih
            $('#kode_material').change(function() {
                var selectedValue = $(this).val();

                // Jika ada pilihan di kode_material, aktifkan qty_ok
                if (selectedValue) {
                    $('#qty_ok').prop('disabled', false);
                } else {
                    // Jika tidak ada pilihan, nonaktifkan qty_ok
                    $('#qty_ok').prop('disabled', true);
                }
            });
        });

        $(document).ready(function() {
    $.get("{{ route('kanbanstmpc1.data') }}", function(data) {
        if (data.length > 0) {
            // Cek apakah ada uniqNo yang diawali dengan B
            let adaB = data.some(item => item.rm_uniqNo.startsWith("B"));

            let options = '<option value="">Pilih Kode Material</option>';

            data.forEach(item => {
                // Jika ada uniqNo B, tampilkan hanya yang B
                // Jika tidak ada uniqNo B, tampilkan semua data
                if (adaB) {
                    if (item.rm_uniqNo.startsWith("B")) {
                        options += `<option value="${item.rm_uniqNo}" data-partno="${item.part_no}">
                                        ${item.part_no} - ${item.rm_uniqNo}
                                    </option>`;
                    }
                } else {
                    options += `<option value="${item.rm_uniqNo}" data-partno="${item.part_no}">
                                    ${item.part_no} - ${item.rm_uniqNo}
                                </option>`;
                }
            });

            $('#kode_material').html(options);
        } else {
            $('#kode_material').html('<option value="">Data tidak ditemukan</option>');
        }
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal mengambil data dropdown!',
        });
    });

    // Event listener ketika dropdown berubah
    $('#kode_material').change(function() {
        let selectedOption = $(this).find(':selected');
        let partNo = selectedOption.data('partno'); // Ambil part_no dari atribut data
        $('#part_no_rm').val(partNo); // Set nilai input part_no_rm
    });
});





            // Event listener untuk dropdown
            $('#kode_material').change(function() {
                const selectedValue = $(this).val(); // Ambil nilai yang dipilih

                if (selectedValue) {
                    // Ambil nilai qty_stamping dari server
                    $.post("{{ route('kanbanstmpc1.getQtyStamping') }}", {
                        uniqNo: selectedValue,
                        _token: "{{ csrf_token() }}"
                    }, function(response) {
                        if (response.qty_stamping !== null) {
                            $('#qty_stamping').val(response.qty_stamping); // Tampilkan qty_stamping
                        } else {
                            $('#qty_stamping').val(''); // Kosongkan jika tidak ada data
                            Swal.fire({
                                icon: 'info',
                                title: 'Data Tidak Ditemukan',
                                text: 'Tidak ada nilai qty_stamping untuk kode material ini.',
                            });
                        }
                    }).fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Info',
                            text: 'Gagal Menampilkan data Material, tolong Periksa tabel Out RM!',
                        });
                    });
                } else {
                    $('#qty_stamping').val(''); // Kosongkan input jika tidak ada pilihan
                }
            });

            // // Validasi input qty_ok terhadap qty_stamping
            // document.getElementById('qty_ok').addEventListener('input', function() {
            //     const qtyStamping = parseFloat(document.getElementById('qty_stamping')
            //     .value); // Ambil qty_stamping
            //     const qtyOk = parseFloat(this.value); // Ambil qty_ok yang dimasukkan

            //     if (!isNaN(qtyStamping) && !isNaN(qtyOk)) {
            //         if (qtyOk > qtyStamping) {
            //             Swal.fire({
            //                 icon: 'warning',
            //                 title: 'Warning',
            //                 text: 'Maaf, Quantity Material Actual Melebihi sisa material',
            //                 toast: true,
            //                 position: 'top-end',
            //                 showConfirmButton: false,
            //                 timer: 3000,
            //                 timerProgressBar: true,
            //                 didOpen: (toast) => {
            //                     toast.addEventListener('mouseenter', Swal.stopTimer);
            //                     toast.addEventListener('mouseleave', Swal.resumeTimer);
            //                 }
            //             });
            //             this.value = ''; // Reset nilai input qty_ok
            //         }
            //     }
            // });

             // Validasi jika nilai ok lebih dari planning
             document.getElementById('qty_ok').addEventListener('input', function() {
                    const select = document.getElementById('item_id');
                    const selectedOption = select.options[select.selectedIndex];

                    const qtyPlan2 = parseFloat(selectedOption.getAttribute('data-qty_plan2'));
                    const qtyOk = parseFloat(this.value);

                    if (!isNaN(qtyPlan2) && !isNaN(qtyOk)) {
                        if (qtyOk > qtyPlan2) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: 'Maaf, Quantity Actual melebihi Qty Plan',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer);
                                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                                }
                            });
                            this.value = ''; // Reset nilai input qty_ok
                        }
                    }
                });


        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date_plan');

            // Mendapatkan tanggal hari ini
            const today = new Date();

            // Mengatur batas minimal (2 hari sebelumnya disembunyikan)
            const minDate = new Date(today);
            minDate.setDate(today.getDate() - 2);

            // Format tanggal ke YYYY-MM-DD
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            // Setel tanggal hari ini sebagai nilai default
            dateInput.value = formatDate(today);

            // Batasi input agar tidak bisa memilih tanggal sebelum batas minimal
            dateInput.min = formatDate(minDate);
        });


        ////// Batas

        $('#item_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var part_name = selectedOption.data('part_name');
            var job_no = selectedOption.data('job_no');
            var part_no = selectedOption.data('part_no');
            var model = selectedOption.data('model');
            var name_material = selectedOption.data('name_material');

            // Assign the values to hidden inputs or directly to an AJAX request payload
            $('#part_name').val(part_name);
            $('#job_no').val(job_no);
            $('#part_no').val(part_no);
            $('#model').val(model);
            $('#name_material').val(name_material);
        });

        // function getDoc() {
        //     var year = new Date().getFullYear(); // Mendapatkan tahun saat ini
        //     var month = ("0" + (new Date().getMonth() + 1)).slice(-2); // Mendapatkan bulan saat ini, dengan dua digit
        //     var day = ("0" + new Date().getDate()).slice(-2); // Mendapatkan tanggal saat ini, dengan dua digit
        //     $.ajax({
        //         type: 'GET',
        //         url: "{{ route('kanbanstmpc1.getdoc') }}",
        //         success: function(result) {
        //             $("#id").val('');
        //             $("#doc_no").val("KANBAN/B3/" + year + month + "/" + result.jml);
        //             $("#date_plan").val('');
        //             $('#line_id').val('');
        //             $('#item_id').val('');
        //             $("#qty_ok").val('');
        //             $('#qty_ng').val('');
        //             $('#shift').val('');
        //             $('#uniqNo').val('');

        //             $('#tujuan').val('');
        //             $('#keterangan').val('');


        //         }
        //     });
        // }

        function list() {
    var table = $('#example1').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        searching: true,
        bLengthChange: true,
        destroy: true,
        pageLength: 10,
        ajax: {
            url: "{{ route('kanbanstmpc1.list') }}"
        },
        order: [[1, 'desc']], // Urutkan berdasarkan `date_plan` terbaru di atas
        columns: [
            {
                data: null,
                sortable: false,
                searchable: false,
                orderable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'date_plan',
                name: 'date_plan'
            },
            {
                data: 'line',
                name: 'line'
            },
              {
                data: 'date_plan',
                name: 'date_plan',
                render: function(data, type, row, meta) {
                    var today = new Date();
                    var planDate = new Date(row.date_plan);
                    var isPast = planDate < new Date(today.setHours(0, 0, 0, 0));

                    var centang = isPast ? '<span class="text-success mr-2">✅</span>' : '';

                    return centang +
                        '<a href="#" id="btn_edit" title="Edit" data-id="' + data +
                        '" class="btn btn-info btn-sm">' +
                        '<i class="fas fa-search"></i>' +
                        '</a>' +
                        '<a href="#" id="btn_delete" title="Delete" data-id="' + data +
                        '" class="btn btn-danger btn-sm ml-1">' +
                        '<i class="far fa-trash-alt"></i>' +
                        '</a>';
                }
            }
        ],
        columnDefs: [{
            "targets": [0],
            "orderable": false,
        }],
        fixedColumns: true,
        oLanguage: {
            sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
        }
    });
}


        function listdetail() {
            var table = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 5,
                order: [[0, 'desc']], // Mengurutkan data dari yang terbaru
                ajax: {
                    url: "{{ route('kanbanstmpc1.listdetail') }}",
                    data: {
                        // doc_no: doc_no.value,
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    // { data: 'part_name', name: 'part_name' },
                    { data: 'job_no', name: 'job_no' },
                    { data: 'part_no', name: 'part_no' },
                    { data: 'model', name: 'model' },
                    { data: 'kode_material', name: 'kode_material' },
                    { data: 'qty_ok', name: 'qty_ok' },
                    { data: 'qty_ng', name: 'qty_ng' },
                    { data: 'shift', name: 'shift' },
                    { data: 'uniqNo', name: 'uniqNo' },
                    {
                        data: 'sts_scan',
                        name: 'sts_scan',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="badge badge-success">Sudah Scan</span>';
                            } else {
                                return '<span class="badge badge-warning">Belum Scan</span>';
                            }
                        }
                    },
                    { data: 'tujuan', name: 'tujuan' },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row) {
                            let deleteButton = `<a href="#" id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-sm">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>`;

                            // Jika sts == 1, tombol delete akan dinonaktifkan
                            if (row.sts_scan == 1) {
                                deleteButton = `<button title="Delete" class="btn btn-danger btn-sm" disabled>
                                                    <i class="far fa-trash-alt"></i>
                                                </button>`;
                            }

                            return `
                                <a href="#" id="btn_edit_line" title="Edit" data-id="${data}" class="btn btn-warning btn-sm">
                                    <i class="far fa-edit"></i>
                                </a>
                                ${deleteButton}
                                <a href="#" id="btn_pdf" title="Generate" data-id="${data}" class="btn btn-info btn-sm">
                                    <i class="fas fa-solid fa-qrcode"></i>
                                </a>
                            `;
                        }
                    }
                ],
                columnDefs: [
                    { "targets": [0], "orderable": false }
                ],
                responsive: true,
                fixedColumns: true,
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                }
            });
        }


        $(document).on('click', '#btn_pdf', function(e) {
            e.preventDefault();

            var id = $(this).data('id'); // Get the 'id' from data-id
            var printUrl = "{{ route('kanbanstmpc1.cetak', ':id') }}".replace(':id', id);

            window.open(printUrl, '_blank'); // Open PDF in a new tab or download directly
        });

        // $(document).on("click", "#btn_add", function() {
        //     $('#myModal2').modal({
        //         backdrop: 'static',
        //         keyboard: false,
        //         show: true
        //     });
        //     $("#title2").hide();
        //     $(".Update").hide();
        //     $("#title1").show();
        //     clear();
        //     getDoc();
        // });

        $(document).on("click", "#btn_add", function () {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $("#title2").hide();
            $(".Update").hide();
            $("#title1").show();
            clear();


            // Set tanggal hari ini secara otomatis
            let today = new Date().toISOString().split('T')[0];
            $("#date_plan").val(today);
        });

        $(document).on("click", "#btn_edit", function() {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $("#title1").hide();
            $("#title2").show();
            var date_plan = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('kanbanstmpc1.edit') }}",
                data: {
                    date_plan: date_plan,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    $('#date_plan').val(date_plan);
                    $('#line_id').val(result.line_id);
                    listdetail();

                }
            });

        });

        $(document).on("click", "#btn_edit", function() {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $("#title1").hide();
            $("#title2").show();
            var date_plan = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('kanbanstmpc1.edit') }}",
                data: {
                    date_plan: date_plan,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    $('#date_plan').val(date_plan);
                    $('#line_id').val(result.line_id);
                    listdetail();

                }
            });

        });

        $(document).on("click", "#btn_edit_line", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('kanbanstmpc1.edit') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({backdrop: 'static',keyboard: false,show: true});
                        $('#id').val(result.id);
                        $('#date_plan').val(result.date_plan).trigger('change');
                        $('#line_id').val(result.line_id).trigger('change');
                        $('#item_id').val(result.item_id).trigger('change');
                        $('#qty_ok').val(result.qty_ok).trigger('change');
                        $('#qty_ng').val(result.qty_ng).trigger('change');
                        $('#shift').val(result.shift).trigger('change');
                        $('#uniqNo').val(result.uniqNo).trigger('change');
                        $('#kode_material').val(result.kode_material).trigger('change');
                        $('#part_no_rm').val(result.part_no_rm).trigger('change');
                        // $('#time_end').val(result.time_end).trigger('change');
                        $('#tujuan').val(result.tujuan).trigger('change');
                        $('#keterangan').val(result.keterangan);
                    } else {
                        SweetAlert.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });

        $(document).on("click", ".close", function() {
            clear();
            $("#alert").html('');
            list();

        });

        function updt_submit() {
            $("#alert").html('');
            $("#alert").show();
            $.ajax({
                type: 'POST',
                url: "{{ route('kanbanstmpc1.submit') }}",
                data: {
                    date_plan: date_plan.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#modal_header').modal('hide');
                        SweetAlert.fire({
                            icon: 'success',
                            title: 'Success',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        list();
                    } else {
                        $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                            result.msg + '</div>');
                        setTimeout(() => {
                            $("#alert").hide();
                        }, 1500);
                    }
                }
            });
        }

        $(document).on("click", "#btn_submit", function() {
            updt_submit();
            location.reload();
        });

        $(document).on("click", "#btn_cancel", function() {
            $('#modal_konfirmasi').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        $(document).on("click", "#btn_tidak", function() {
            $('#modal_konfirmasi').modal('hide');
            $('#modal_header').modal('hide');
            delete_draft()
        });

        $(document).on("click", "#btn_ya", function() {
            $('#modal_konfirmasi').modal('hide');
            updt_submit();
        });

        function delete_draft() {
            $.ajax({
                type: 'POST',
                url: "{{ route('kanbanstmpc1.delete_draft') }}",
                data: {
                    date_plan: date_plan.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    //
                }
            });
        }

        function clear() {
            $("#id").val('');
            $("#date_plan").val('').trigger('change');
            $('#line_id').val('').trigger('change');
            $('#item_id').val('').trigger('change');
            $("#qty_ok").val('').trigger('change');
            $('#qty_ng').val('').trigger('change');
            $('#shift').val('').trigger('change');
            $('#uniqNo').val('').trigger('change');
            $("#time_start").val('').trigger('change');
            $("#kode_material").val('').trigger('change');
            // $("#time_end").val('').trigger('change');
            $("#tujuan").val('').trigger('change');
            $('#keterangan').val('').trigger('change');
        }

        $(document).on("click", ".Save", function() {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('kanbanstmpc1.store') }}",
                    data: {
                        // doc_no: doc_no.value,
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                        item_id: item_id.value,
                        part_name: part_name.value,
                        job_no: job_no.value,
                        part_no: part_no.value,
                        model: model.value,
                        name_material: name_material.value,
                        qty_ok: qty_ok.value,
                        qty_ng: qty_ng.value,
                        shift: shift.value,
                        uniqNo: uniqNo.value,
                        part_no_rm: part_no_rm.value,
                        // time_end: time_end.value,
                        tujuan: tujuan.value,
                        kode_material: kode_material.value,
                        keterangan: keterangan.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#alert").html(
                                '<div class="alert alert-success"><i class="fa fa-check"></i> ' +
                                result.msg + '</div>');
                            listdetail();
                            $('#item_id').val('').trigger('change');
                            $("#qty_ok").val('');
                            $("#qty_ng").val('');
                            $("#time_start").val('');
                            $("#time_end").val('');
                            $('#keterangan').val('').trigger('change');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 1500);
                        } else {
                            $("#alert").html(
                                '<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                                result.msg + '</div>');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 1500);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function() {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('kanbanstmpc1.update') }}",
                    data: {
                        id: id.value,
                        // doc_no: doc_no.value,
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                        part_name: part_name.value,
                        job_no: job_no.value,
                        part_no: part_no.value,
                        model: model.value,
                        name_material: name_material.value,
                        item_id: item_id.value,
                        qty_ok: qty_ok.value,
                        qty_ng: qty_ng.value,
                        shift: shift.value,
                        uniqNo: uniqNo.value,
                        part_no_rm: part_no_rm.value,
                        // time_end: time_end.value,
                        tujuan: tujuan.value,
                        kode_material: kode_material.value,
                        keterangan: keterangan.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            SweetAlert.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            listdetail();

                            $('#item_id').val('').trigger('change');
                            $("#qty_ok").val('');
                            $("#qty_ng").val('');
                            // $('#material_id').val('').trigger('change');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 150);
                        } else {
                            SweetAlert.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    }
                });
            }
        });

        function validasi() {
            $("#alert").show();
            if (date_plan.value != '' && line_id.value != '' && item_id.value != '' && qty_ok.value != '' && qty_ng.value !='' && shift.value != '' && tujuan.value != '' && kode_material.value != ''
                ) {
                return true;
            } else {
                $("#alert").html(
                    '<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
                setTimeout(() => {
                    $("#alert").hide();
                }, 1500);
            }
        }

        $(document).on("click", "#btn_delete_line", function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('kanbanstmpc1.destroyline') }}",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                SweetAlert.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                SweetAlert.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            listdetail();
                        }
                    });
                }
            })
        });

        $(document).on("click", "#btn_delete", function() {
            var date_plan = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('kanbanstmpc1.destroy') }}",
                        data: {
                            date_plan: date_plan,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                SweetAlert.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                SweetAlert.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            list();

                        }
                    });
                }
            })
        });
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
