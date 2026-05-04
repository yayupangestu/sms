@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <style>
        /* Modern CSS Reset & Variable Tokens */
        :root {
            --primary-blue: #003366;
            --secondary-blue: #005588;
            --accent-blue: #008fe2ff;
            --light-gray: #f4f7f6;
            --border-color: #dee2e6;
            --success-green: #28a745;
            --warning-yellow: #ffc107;
            --danger-red: #dc3545;
        }

        .table-hover tbody tr:hover {
            background: linear-gradient(to right, rgba(255,255,255,0.8) 0%, rgba(56, 107, 137, 0.1) 100%) !important;
            transition: all 0.3s ease;
        }

        .centered-text {
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: rgba(0, 51, 102, 0.03);
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .card-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
        }

        .card-title {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            border-bottom: none;
            padding: 20px 25px;
        }

        .modal-body {
            background-color: white;
            padding: 25px;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(0, 51, 102, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(0, 51, 102, 0.3);
            background: linear-gradient(135deg, #004477 0%, #0066aa) 100%);
        }

        /* Input Fields */
        .form-control {
            border-radius: 8px !important;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
            caret-color: black !important;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(56, 107, 137, 0.15);
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            caret-color: black !important;
        }

        /* Table Design */
        .table thead th {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 12px 15px;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #b0bec5 !important;
        }

        /* Status Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }

        .bg-warning { background-color: #f6e05e !important; color: #744210 !important; }
        .bg-primary { background: var(--secondary-blue) !important; color: white !important; }
        .bg-success { background-color: #48bb78 !important; color: white !important; }
        .bg-secondary { background-color: #a0aec0 !important; color: white !important; }

        .reorder-handle {
            cursor: grab !important;
            color: black !important;
        }

        /* Conditional Styling */
        .input-danger {
            background-color: #fff5f5 !important;
            border-color: #feb2b2 !important;
            color: #c53030 !important;
        }

        .input-warning {
            background-color: #f0fff4 !important;
            border-color: #9ae6b4 !important;
            color: #276749 !important;
        }

        .group {
            background-color: #e9ecef !important;
            border-top: 4px solid var(--primary-blue) !important;
            border-bottom: 2px solid var(--secondary-blue) !important;
        }

        .group td {
            font-size: 18px !important;
            color: var(--primary-blue) !important;
            padding: 15px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .separator-text {
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--accent-blue);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1px;
            margin: 20px 0;
        }

        .separator-text::before,
        .separator-text::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .separator-text:not(:empty)::before {
            margin-right: .5em;
        }

        .separator-text:not(:empty)::after {
            margin-left: .5em;
        }

        .blue-bg {
            background-color: #d0e7ff !important;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Planning Proses Stamping</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content" style="background-color: rgba(255, 255, 255, 1)">
        {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
            <div class="row">
                <!-- Tabel kiri -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-navy">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                PLANNING LINE PROSES STAMPING
                            </h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btn_add">
                                    <i class="fa fa-plus-circle mr-1"></i> Add New
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="30">No</th>
                                        <th>Date</th>
                                        <th>Line</th>
                                        <th width="120" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tabel kanan -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-navy">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-check mr-2"></i>
                                PLANNING LINE PROSES BLANK
                            </h3>
                            <div class="card-tools">
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-table mr-1"></i> TABEL BLANK
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example3" class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="30">No</th>
                                        <th>Date</th>
                                        <th>Line</th>
                                        <th width="120" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-sm-12 mt-4">
            <table id="example2" class="table table-bordered centered-text table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th width="30">No</th>
                        <th width="30">No</th>
                        <th width="40" class="text-center">Urutan</th>
                        <th>Mesin</th>
                        <th>Job No</th>
                        <th>Part NO</th>
                        <th>Model</th>
                        <th>Qty</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th width="120" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic Rows Here -->
                </tbody>
            </table>
        </div>
        </div>
    </section>

    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-xl" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title1">
                        <i class="fas fa-plus-circle mr-2"></i> <b>Add Item Planning</b>
                    </h4>
                    <h4 class="modal-title" id="title2">
                        <i class="fas fa-edit mr-2"></i> <b>Edit Item Planning</b>
                    </h4>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary btn-sm px-4 mr-2" id="btn_submit">
                            <i class="fas fa-save mr-1"></i> Save Plan
                        </button>
                        <!-- <button class="btn btn-secondary btn-sm px-4 mr-2" id="btn_cancel">
                            <i class="fas fa-undo mr-1"></i> Cancel
                        </button> -->
                        <button class="btn btn-secondary btn-sm px-4 mr-2" type="button" class="close text-white" data-dismiss="modal" aria-label="Close">Close
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="separator-text mb-3">
                        <span>PLANNING DETAILS</span>
                    </div>

                    <div class="row">
                        <!-- Kolom Kiri: Form Input -->
                        <div class="col-md-8">
                            <div class="form-group row">
                        <div class="col-12" id="alert"></div>

                        <label for="qty" class="col-sm-2 col-form-label">Tanggal:</label>
                        <div class="col-sm-6">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>


                        <div class="col-sm-12"></div>

                        <label class="col-sm-2 col-form-label">Line:</label>
                        <div class="col-sm-3 mb-1">
                            <select style="width: 100%;" id="line_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($line_stmps as $line)
                                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-1 col-form-label">Mesin:</label>
                        <div class="col-sm-3 mb-1">
                            <select style="width: 100%;" id="mesin" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value="LINE A1">LINE A1</option>
                                <option value="LINE A2">LINE A2</option>
                                <option value="LINE B1">LINE B1</option>
                                <option value="LINE B2">LINE B2</option>
                                <option value="LINE B3">LINE B3</option>
                                <option value="LINE C1">LINE C1</option>
                                <option value="LINE C2">LINE C2</option>
                                <option value="TRANSFERS">TRANSFERS</option>
                                {{-- <option value="KOMATSU">KOMATSU</option>
                                <option value="FUKUI">FUKUI</option>
                                <option value="AMINO">AMINO</option> --}}
                            </select>
                        </div>

                        <label class="col-sm-1 col-form-label">Shift:</label>
                        <div class="col-sm-2">
                            <select style="width: 100%;" id="shift" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value="1">SHFIT 1</option>
                                <option value="2">SHFIT 2</option>
                                <option value="3">SHFIT 3</option>
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Item:</label>
                        <div class="col-sm-10 mb-2">
                            <select style="width: 100%;" id="product_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($data_part_names as $part)
                                    <option value="{{ $part->id }}" data-job_no="{{ $part->job_no }}"
                                        data-part_no="{{ $part->part_no }}" data-part_no2="{{ $part->part_no2 }}"
                                        data-model_id="{{ $part->model }}" data-part_name="{{ $part->part_name }}"
                                        data-categoy="{{ $part->category }}" data-spec="{{ $part->spec }}"
                                        data-spec_bq="{{ $part->spec_bq }}">
                                        ({{ $part->job_no }})
                                        | ({{ $part->part_no2 }}) | ({{ $part->model }}) | ({{ $part->spec }}) |
                                        {{ $part->category }} |
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Qty Plan:</label>
                        <div class="col-sm-2">
                            <input type="text" input="number" id="qty_plan" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-1.5 col-form-label" id="label_qty_actual_rm">RM:</label>
                        <div class="col-sm-1">
                            <input type="text" id="actual_sheet" class="form-control form-control-sm input-warning"
                                readonly>
                        </div>

                        <label class="col-sm-1.5 col-form-label" id="label_qty_actual_blank">Blank:</label>
                        <div class="col-sm-1">
                            <input type="text" id="qty_kanban" class="form-control form-control-sm input-warning"
                                readonly>
                        </div>

                        <label class="col-sm-1 col-form-label" id="label_qty_actual_transit">Transit</label>
                        <div class="col-sm-1">
                            <input type="numeric" id="qty_stamping" class="form-control form-control-sm input-warning" readonly>
                        </div>

                        <label class="col-sm-1.5 col-form-label" id="label_qty_actual">LS:</label>
                        <div class="col-sm-2">
                            <input type="text" id="qty_actual" class="form-control form-control-sm" readonly>
                        </div>





                        {{-- <label class="col-sm-1 col-form-label">Proses:</label>
            <div class="col-sm-1">
                <input type="text" id="step_proses" class="form-control form-control-sm" readonly>
            </div> --}}

                        <div class="col-sm-7"></div>
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" id="description" class="form-control form-control-sm" maxlength="20"
                                required>
                        </div>
                        <div class="col-sm-10 mt-2">
                            <button type="button" class="btn btn-success btn-sm Save px-4">
                                <i class="fas fa-plus mr-1"></i> Add Item
                            </button>



                            <button type="button" class="btn btn-warning btn-sm Update px-4">
                                <i class="fas fa-edit mr-1"></i> Update Item
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Kolom Kanan: Tabel Lookup -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-gradient-navy py-2">
                            <h6 class="card-title mb-0 text-white" style="font-size: 14px;">
                                <i class="fas fa-chart-bar mr-1"></i>DATA ORDERING
                            </h6>
                        </div>
                        <div class="card-body p-0 table-responsive" style="max-height: 230px;">
                            <table class="table table-sm table-bordered table-striped mb-0" id="tbl_job_lookup" style="font-size: 12px;">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 10%; color: white;" class="text-center">Cycle</th>
                                        <th style="width: 10%; color: white;" class="text-center">Uniq No</th>
                                        <th style="width: 10%; color: white;" class="text-center">Total Order</th>
                                        <th style="width: 10%; color: white;" class="text-center">Qty Kanban</th>
                                        <th style="width: 10%; color: white;" class="text-center">Jml Kanban</th>
                                        <th style="width: 10%; color: white;" class="text-center">Arrival</th>
                                        <th style="width: 10%; color: white;" class="text-center">Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Select Part No first</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="job_no" name="job_no">
    <input type="hidden" id="part_no" name="part_no">
    <input type="hidden" id="part_no2" name="part_no2">
    <input type="hidden" id="model_id" name="model_id">
    <input type="hidden" id="part_name" name="part_name">
    <input type="hidden" id="spec_bq" name="spec_bq">
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

    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>

    <script>

        $('#myModal2').on('shown.bs.modal', function () {
            $('#line_id').val('1').trigger('change');
        });

        $(document).ready(function () {
        // Saat pilih item di select2
        $('#product_id').on('select2:select', function (e) {
            $('#qty_plan').focus(); // Pindah fokus ke input qty_plan
        });
    });


        $(document).on('keydown', function(e) {
            if (e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault();

                $(".Save").click();
            }
        });

        $(document).ready(function() {
            let selectedLine = null;

            $('#line_id').on('change', function() {
                selectedLine = $(this).val();

                if (selectedLine == 2) {
                    // Panggil AJAX untuk product_id
                    $.ajax({
                        url: "{{ route('planninglineb3.getProductsByLine') }}",
                        method: "GET",
                        data: {
                            line_id: selectedLine
                        },
                        success: function(data) {
                            $('#product_id').empty().append(
                                '<option value="">- pilih -</option>');
                            $.each(data, function(index, item) {
                                $('#product_id').append(
                                    `<option
                            value="${item.id}"
                            data-part_no="${item.part_no ?? ''}"
                            data-part_no2="${item.part_no2 ?? ''}"
                            data-model_id="${item.model_id ?? ''}"
                           data-job_no="${item.job_no ?? ''}">
                            ${item.job_no} | ${item.part_no2} | ${item.model_id} | ${item.spek}
                        </option>`
                                );
                            });
                        },
                        error: function() {
                            alert('Gagal mengambil data.');
                        }
                    });

                    // Filter dan tampilkan hanya mesin KOMATSU, FUKUI, AMINO
                    const mesinOptions = ['KOMATSU', 'FUKUI', 'AMINO'];
                    $('#mesin').empty().append('<option value="">- pilih -</option>');
                    mesinOptions.forEach(function(mesin) {
                        $('#mesin').append(`<option value="${mesin}">${mesin}</option>`);
                    });
                } else {
                    // Jika line_id bukan 2, kembalikan semua opsi
                    const allMesinOptions = [
                        'LINE A1', 'LINE A2', 'LINE B1', 'LINE B2', 'LINE B3',
                        'LINE C1', 'LINE C2', 'TRANSFERS'
                    ];
                    $('#mesin').empty().append('<option value="">- pilih -</option>');
                    allMesinOptions.forEach(function(mesin) {
                        $('#mesin').append(`<option value="${mesin}">${mesin}</option>`);
                    });
                }
            });


            $('#product_id').on('change', function() {
    const selectedOption = $(this).find(':selected');
    const partNo = selectedOption.data('part_no');
    const partNo2 = selectedOption.data('part_no2');

    $('#qty_actual').removeClass('input-danger input-warning is-invalid is-valid');

    if (!partNo2 && !partNo) return;

    const url = selectedLine == 2 ?
        "{{ route('get.qty.blank') }}" :
        "{{ route('get.stock') }}";

    const data = selectedLine == 2 ? { part_no: partNo } : { part_no2: partNo2 };

    // AJAX: qty_actual
    $.ajax({
        url: url,
        method: "GET",
        data: data,
        success: function(response) {
            $('#qty_actual').val(response.qty_actual);
            const actual = parseInt(response.qty_actual);
            const min = parseInt(response.qty_min);

            if (actual < min) {
                $('#qty_actual')
                    .addClass('input-danger is-invalid')
                    .removeClass('input-warning is-valid');
            } else {
                $('#qty_actual')
                    .addClass('input-warning is-valid')
                    .removeClass('input-danger is-invalid');
            }

            // AJAX: Lookup Job Details (Baru)
            var jobNo = selectedOption.data('job_no');
            var datePlan = $('#date_plan').val();

            if (jobNo && datePlan) {
                $.ajax({
                    url: "{{ route('planninglineb3.getJobDetails') }}",
                    method: "GET",
                    data: {
                        job_no: jobNo,
                        date: datePlan
                    },
                    success: function(response) {
                        var tbody = $('#tbl_job_lookup tbody');
                        tbody.empty();

                        if (response.length > 0) {
                            $.each(response, function(index, item) {
                                tbody.append(`
                                    <tr>
                                        <td class="text-center">${item.cycle}</td>
                                        <td class="text-center">${item.uniqNo}</td>
                                        <td class="text-center">${item.qty_order}</td>
                                        <td class="text-center">${item.qty_kanban}</td>
                                        <td class="text-center">${item.jml_kanban}</td>
                                        <td class="text-center">${item.cycle_arrival}</td>
                                        <td class="text-center">${item.source}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            tbody.append('<tr><td colspan="7" class="text-center text-muted">No data found</td></tr>');
                        }
                    },
                    error: function() {
                        $('#tbl_job_lookup tbody').html('<tr><td colspan="7" class="text-center text-danger">Error fetching data</td></tr>');
                    }
                });
                $('#tbl_job_lookup tbody').html('<tr><td colspan="7" class="text-center text-muted">Job No or Date not found</td></tr>');
            }
        },
        error: function() {
            $('#qty_actual').val('Error').addClass('input-danger is-invalid').removeClass('input-warning is-valid');
        }
    });

    // AJAX: actual_sheet dari rm_stoks
    $.ajax({
        url: "{{ route('get.raw.material') }}",
        method: "GET",
        data: { part_no: partNo },
        success: function(response) {
            $('#actual_sheet').val(response.actual_sheet);
        },
        error: function() {
            $('#actual_sheet').val('Error');
        }
    });

    // AJAX: qty_stamping dari tabel_transit_materials
    $.ajax({
        url: "{{ route('get.qty.transit') }}",
        method: "GET",
        data: { part_no: partNo },
        success: function(response) {
            $('#qty_stamping').val(response.qty_stamping);
        },
        error: function() {
            $('#qty_stamping').val('Error');
        }
    });

    // ✅ AJAX: qty_kanban dari tabel_stok_blanks
    $.ajax({
        url: "{{ route('get.qty.kanban') }}", // Route baru
        method: "GET",
        data: { part_no: partNo },
        success: function(response) {
            $('#qty_kanban').val(response.qty_kanban);
        },
        error: function() {
            $('#qty_kanban').val('Error');
        }
    });
});



        });

        $(document).ready(function() {
            list();
        });

        document.getElementById('description').addEventListener('input', function() {
            if (this.value.length >= 20) {
                this.value = this.value.slice(0, 20); // Memastikan input tidak lebih dari 20 karakter
            }
        });


        $(document).ready(function() {
            $('#product_id').select2();
            $('#tbl_job_lookup tbody').html('<tr><td colspan="7" class="text-center text-muted">Select Part No and Date first</td></tr>');
        });

        // Event listener untuk perubahan tanggal
        $('#date_plan').on('change', function() {
             $('#product_id').trigger('change');
        });

        $('#product_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var job_no = selectedOption.data('job_no');
            var part_no = selectedOption.data('part_no');
            var model_id = selectedOption.data('model_id');
            var spek = selectedOption.data('spek');
            var part_no2 = selectedOption.data('part_no2');
            var part_name = selectedOption.data('part_name');
            var spec_bq = selectedOption.data('spec_bq');

            // Assign the values to hidden inputs or directly to an AJAX request payload
            $('#job_no').val(job_no);
            $('#part_no').val(part_no);
            $('#model_id').val(model_id);
            $('#spek').val(spek);
            $('#part_no2').val(part_no2);
            $('#part_name').val(part_name);
            $('#spec_bq').val(spec_bq);
        });

        function list(tableId, line_id) {
    $('#' + tableId).DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: false,
        searching: true,
        bLengthChange: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "{{ route('planninglineb3.list') }}",
            data: {
                line_id: line_id
            }
        },
        order: [
            [1, 'desc']
        ],
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
                data: 'mix_id',
                name: 'mix_id',
                render: function(data, type, row, meta) {
                    var today = new Date();
                    var planDate = new Date(row.date_plan);
                    var isPast = planDate < new Date(today.setHours(0, 0, 0, 0));

                    var centang = isPast ? '<span class="text-success mr-2">✅</span>' : '';

                    return `<div class="d-flex justify-content-center align-items-center">
                        ${centang}
                        <a href="#" id="btn_edit" title="Edit" data-id="${data}" class="btn btn-info btn-sm mx-1">
                            <i class="fas fa-search"></i>
                        </a>
                        <a href="#" id="btn_delete" title="Delete" data-id="${data}" class="btn btn-danger btn-sm mx-1">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>`;
                }
            }
        ],
        columnDefs: [
            {
                targets: [0],
                orderable: false,
            }
        ],
        fixedColumns: true,
        oLanguage: {
            sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
        }
    });
}

$(document).ready(function() {
    list('example1', 1); // untuk Planning Line Proses 1
    list('example3', 2); // untuk Planning Line Proses 2
});



        function listdetail() {
            var table = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 500,
                order: [
                    [3, 'asc'],
                    [0, 'asc']
                ], // Urutkan berdasarkan MESIN, lalu posisi
                rowReorder: {
                    selector: '.reorder-handle',
                    dataSrc: 'mesin', // Menggunakan 'mesin' agar seluruh grup ikut pindah
                    update: false // Mencegah perubahan satu per satu
                },
                ajax: {
                    url: "{{ route('planninglineb3.listdetail') }}",
                    data: {
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                    }
                },
                columns: [{
                        data: 'position',
                        name: 'position',
                        visible: false
                    }, // Posisi untuk drag
                    {
                        data: null,
                        orderable: false,
                        className: 'reorder-handle text-center',
                        render: function() {
                            return '<i class="fas fa-arrows-alt" style="cursor: grab; color: black;"></i>';
                        }
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, // Nomor urut otomatis
                    {
                        data: 'mesin',
                        name: 'mesin'
                    },
                    {
                        data: 'job_no',
                        name: 'job_no'
                    },
                    {
                        data: 'part_no2',
                        name: 'part_no2'
                    },
                    {
                        data: 'model_id',
                        name: 'model_id'
                    },
                    {
                        data: 'qty_plan',
                        name: 'qty_plan'
                    },
                    {
                        data: 'shift',
                        name: 'shift'
                    },
                    {
                        data: 'status_proses',
                        name: 'status_proses',
                        render: function(data, type, row) {
                            let badge ='';
                            switch (parseInt(data)) {
                                case 1 :
                                    badge = '<span class="badge bg-warning">READY RM</span>';
                                    break;
                                case 2:
                                    badge = '<span class="badge bg-primary">PROSES</span>';
                                    break;
                                case 3:
                                    badge = '<span class="badge bg-success">FINISH</span>';
                                    break;
                                default:
                                    badge = '<spam class="badge bg-secondary">PREPARE</span>';
                            }
                            return badge;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="#" id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-sm mx-1">
                                <i class="far fa-trash-alt"></i>
                            </a>
                            <a href="#" id="btn_edit_line" title="Edit" data-id="${data}" class="btn btn-warning btn-sm mx-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </div>
                    `;
                        }
                    }
                ],
                columnDefs: [{
                        "targets": [0],
                        "orderable": false
                    },
                    {
                        "targets": [2],
                        "orderable": false
                    }
                ],
                responsive: true,
                fixedColumns: true,
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(3, {
                        page: 'current'
                    }).data().each(function(mesin, i) {
                        if (last !== mesin) {
                            $(rows).eq(i).before(
                                `<tr class="group">
                            <td colspan="11"><i class="fas fa-server mr-2"></i> MESIN: ${mesin}</td>
                        </tr>`
                            );
                            last = mesin;
                        }
                    });
                }
            });

            // Event ketika baris dipindahkan (Drag & Drop)
            table.on('row-reorder', function(e, diff, edit) {
                var newOrder = [];

                diff.forEach(function(row) {
                    var rowData = table.row(row.node).data();
                    newOrder.push({
                        id: rowData.id,
                        mesin: rowData.mesin, // Ambil nilai mesin
                        part_no: rowData.part_no, // Ambil nilai part_no
                        position: row.newPosition + 1 // Posisi baru
                    });
                });

                console.log("Data yang dikirim ke server:", newOrder); // Debugging

                $.ajax({
                    url: "{{ route('planninglineb3.reorder') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order: newOrder // Gunakan `order` sebagai parameter
                    },
                    success: function(response) {
                        console.log('Order updated successfully:', response);
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.error('Failed to update order', xhr);
                    }
                });
            });


        }


        $(document).on("click", "#btn_add", function() {
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $("#title2").hide();
            $(".Update").hide();
            $("#title1").show();
            clear();

            // Set tanggal hari ini secara otomatis
            let today = new Date().toISOString().split('T')[0];
            $("#date_plan").val(today);
        });


        $(document).on("click", "#btn_edit", function() {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idline = id.substr(10);
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('#date_plan').val(date_plan);
            $('#line_id').val(idline).trigger('change');
            listdetail();
        });

        $(document).on("click", "#btn_edit_line", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('planninglineb3.edit') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                        $('#id').val(result.id);
                        $('#mesin').val(result.mesin).trigger('change');
                        $('#product_id').val(result.product_id).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#part_no2').val(result.part_no2).trigger('change');
                        $('#model_id').val(result.model_id).trigger('change');
                        $('#qty_plan').val(result.qty_plan).trigger('change');
                        // $('#spek').val(result.spek).trigger('change');
                        $('#part_name').val(result.part_name).trigger('change');
                        $('#shift').val(result.shift).trigger('change');
                        $('#step_proses').val(result.step_proses).trigger('cahnge');
                        $('#description').val(result.description).trigger('cahnge');
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
                url: "{{ route('planninglineb3.submit') }}",
                data: {
                    date_plan: date_plan.value,
                    line_id: line_id.value,
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
            location.reload(); // Refresh halaman setelah berhasil
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

        function clear() {
            $("#id").val('');
            $("#date_plan").val('');
            $('#line_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $('#mesin').val('').trigger('change');
            $("#qty_plan").val('');
            $("#model_id").val('');
            $("#shift").val('');
            $("#part_name").val('');
            $('#spek').val('').trigger('change');
            $('#step_proses').val('').trigger('change');
            $('#description').val('').trigger('change');
            // $('#material_id').val('').trigger('change');
        }



        $(document).on("click", ".Save", function () {
    $("#alert").html('');
    $("#alert").show();

    if (validasi()) {
        const part_no2 = $("#part_no2").val();
        const token = '{{ csrf_token() }}';

        // Cek ke server apakah part_no2 sudah ada
        $.ajax({
            type: 'POST',
            url: "{{ route('check.partno2') }}", // Buat route ini di Laravel
            data: {
                part_no2: part_no2,
                _token: token
            },
            success: function (response) {
    if (response.exists) {
        Swal.fire({
            title: 'Part No sudah ada!',
            html: `Part No tersebut sudah ada di <b>Mesin ${response.mesin}</b> pada <b>Shift ${response.shift}</b>.<br>Apakah Anda ingin tetap menambahkan data yang sama?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, tambahkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                simpanData(); // Lanjutkan simpan jika dikonfirmasi
            }
        });
    } else {
        simpanData(); // Lanjutkan simpan jika tidak ditemukan duplikat
    }
}

        });
    }
});

function simpanData() {
    $.ajax({
        type: 'POST',
        url: "{{ route('planninglineb3.store') }}",
        data: {
            date_plan: $("#date_plan").val(),
            line_id: $("#line_id").val(),
            product_id: $("#product_id").val(),
            mesin: $("#mesin").val(),
            job_no: $("#job_no").val(),
            part_no: $("#part_no").val(),
            part_no2: $("#part_no2").val(),
            model_id: $("#model_id").val(),
            spek: $("#spek").val(),
            part_name: $("#part_name").val(),
            qty_plan: $("#qty_plan").val(),
            shift: $("#shift").val(),
            step_proses: $("#step_proses").val(),
            description: $("#description").val(),
            actual_sheet: $("#actual_sheet").val(),
            spec_bq: $("#spec_bq").val(),
            _token: '{{ csrf_token() }}'
        },
        success: function (result) {
            if (result.success) {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: result.msg,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#d4edda',
                    color: '#155724'
                });

                $("#step_proses").val(result.step_proses);
                listdetail();
                $('#product_id').val('').trigger('change');
                $("#part_no").val('');
                $("#job_no").val('');
                $("#model_id").val('');
                $("#qty_plan").val('');
                $("#description").val('');
            } else {
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: result.msg,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#f8d7da',
                    color: '#721c24'
                });
            }
        }
    });
}



        // $(document).on("click", ".Save", function() {
        //     $("#alert").html('');
        //     $("#alert").show();
        //     if (validasi()) {
        //         $.ajax({
        //             type: 'POST',
        //             url: "{{ route('planninglineb3.store') }}",
        //             data: {
        //                 date_plan: $("#date_plan").val(),
        //                 line_id: $("#line_id").val(),
        //                 product_id: $("#product_id").val(),
        //                 mesin: $("#mesin").val(),
        //                 job_no: $("#job_no").val(),
        //                 part_no: $("#part_no").val(),
        //                 part_no2: $("#part_no2").val(),
        //                 model_id: $("#model_id").val(),
        //                 spek: $("#spek").val(),
        //                 part_name: $("#part_name").val(),
        //                 qty_plan: $("#qty_plan").val(),
        //                 shift: $("#shift").val(),
        //                 step_proses: $("#step_proses").val(),
        //                 description: $("#description").val(),
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function(result) {
        //                 if (result.success) {
        //                     Swal.fire({
        //                         toast: true,
        //                         icon: 'success',
        //                         title: result.msg,
        //                         position: 'top-end',
        //                         showConfirmButton: false,
        //                         timer: 2000,
        //                         timerProgressBar: true,
        //                         background: '#d4edda', // hijau muda
        //                         color: '#155724'
        //                     });

        //                     $("#step_proses").val(result.step_proses); // Update input step_proses
        //                     listdetail();
        //                     $('#product_id').val('').trigger('change');
        //                     $("#part_no").val('');
        //                     $("#job_no").val('');
        //                     $("#model_id").val('');
        //                     $("#qty_plan").val('');
        //                     $("#description").val('');
        //                 } else {
        //                     Swal.fire({
        //                         toast: true,
        //                         icon: 'error',
        //                         title: result.msg,
        //                         position: 'top-end',
        //                         showConfirmButton: false,
        //                         timer: 2000,
        //                         timerProgressBar: true,
        //                         background: '#f8d7da', // merah muda
        //                         color: '#721c24'
        //                     });
        //                 }
        //             }

        //         });
        //     }
        // });

        $(document).on("click", ".Update", function() {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('planninglineb3.update') }}",
                    data: {
                        id: id.value,
                        product_id: product_id.value,
                        mesin: mesin.value,
                        part_no: part_no.value,
                        part_no2: part_no2.value,
                        job_no: job_no.value,
                        qty_plan: qty_plan.value,
                        shift: shift.value,
                        model_id: model_id.value,
                        spec_bq: spec_bq.value,
                        part_name: part_name.value,
                        description: description.value,
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
                            $('#product_id').val('').trigger('change');
                            $("#part_no").val('');
                            $("#part_no2").val('');
                            $("#job_no").val('');
                            $("#qty_plan").val('');
                            $("#shift").val('');
                            $("#step_proses").val('');
                            $('#description').val('').trigger('change');
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
            if (date_plan.value != '' && line_id.value != '' && product_id.value != '' && qty_plan.value != '' && shift
                .value != '' && mesin.value != '') {
                return true;
            } else {
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: 'Semua kolom harus terisi',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#f8d7da',
                    color: '#721c24',
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
                return false;
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
                        url: "{{ route('planninglineb3.destroyline') }}",
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
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idline = id.substr(10);
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
                        url: "{{ route('planninglineb3.destroy') }}",
                        data: {
                            date_plan: date_plan,
                            idline: idline,
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



