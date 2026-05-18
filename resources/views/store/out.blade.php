@extends('layouts.app')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/store-out.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="st-container" id="st-wrapper">
        <!-- SECTION 1: ORIGINAL OUT -->
        <div id="section_out">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <h1 class="m-0 font-weight-bold" style="color: var(--st-text);">List Item Out ASI-1</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="st-card card">
                                <div class="st-card-header card-header d-flex align-items-center">
                                    <h3 class="st-card-title card-title mb-0"><i class="fas fa-layer-group mr-2"></i>
                                        Dashboard Store Out</h3>
                                    <div class="card-tools ml-auto d-flex align-items-center">
                                        <div class="st-theme-toggle mr-3" onclick="toggleLocalTheme()"
                                            title="Switch Theme" style="cursor: pointer; color: white;">
                                            <i id="st-theme-icon" class="fas fa-moon"></i>
                                        </div>
                                        <button class="btn btn-info btn-sm mr-2"
                                            style="background: rgba(255,255,255,0.2) !important; border: 1px solid rgba(255,255,255,0.4); font-weight: 600; color: white;"
                                            onclick="toggleSection('out2')">
                                            <i class="fas fa-file-invoice mr-1"></i> E-SPB STAMPING
                                        </button>
                                        <button class="btn btn-primary btn-sm" id="btn_add"
                                            style="background: #ffffff !important; color: #245a7e !important; border: none; font-weight: 700;">
                                            <i class="fa fa-plus-circle mr-1"></i> Add Record
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Original Filters -->
                                    <div class="form-inline mb-3">
                                        <div class="input-group input-group-sm mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-light border-right-0">Dari</div>
                                            </div>
                                            <input type="date" id="start_date" class="form-control">
                                        </div>
                                        <div class="input-group input-group-sm mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-light border-right-0">Sampai</div>
                                            </div>
                                            <input type="date" id="end_date" class="form-control">
                                        </div>
                                        <button class="btn btn-success btn-sm mb-2" id="btn_export">
                                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example1" class="st-table table table-hover mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Date Plan</th>
                                                    <th>Line Store</th>
                                                    <th width="120">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Table for Section 1 -->
                    <div class="row mt-4" id="detail_area_out" style="display:none;">
                        <div class="col-12">
                            <div class="st-card card">
                                <div class="st-card-header card-header bg-secondary">
                                    <h3 class="st-card-title card-title mb-0"><i class="fas fa-info-circle mr-2"></i> Detail
                                        Items</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example2" class="st-table table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Dept</th>
                                                <th>Item</th>
                                                <th>Return</th>
                                                <th>Out</th>
                                                <th>UoM</th>
                                                <th>Note</th>
                                                <th width="100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- SECTION 2: OUT2 (E-SPB STAMPING) -->
        <div id="section_out2" style="display: none;">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <h1 class="m-0 font-weight-bold" style="color: var(--st-text);">E-SPB STAMPING</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="st-card card">
                                <div class="st-card-header card-header d-flex align-items-center">
                                    <h3 class="st-card-title card-title mb-0"><i class="fas fa-store mr-2"></i> Surat
                                        Permintaan Barang</h3>
                                    <div class="card-tools ml-auto d-flex align-items-center">
                                        <div class="st-theme-toggle mr-3" onclick="toggleLocalTheme()"
                                            title="Switch Theme" style="cursor: pointer; color: white;">
                                            <i id="st-theme-icon-2" class="fas fa-moon"></i>
                                        </div>
                                        <button class="btn btn-info btn-sm mr-2"
                                            style="background: rgba(255,255,255,0.2) !important; border: 1px solid rgba(255,255,255,0.4); font-weight: 600; color: white;"
                                            onclick="toggleSection('out')">
                                            <i class="fas fa-arrow-left mr-1"></i> Dashboard
                                        </button>
                                        <button class="btn btn-primary btn-sm" id="btn_add_out2"
                                            style="background: #ffffff !important; color: #245a7e !important; border: none; font-weight: 700;">
                                            <i class="fa fa-plus-circle mr-1"></i> Add SPB
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label-custom">Start Date</label>
                                            <input type="date" id="start_date_out2" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom">End Date</label>
                                            <input type="date" id="end_date_out2" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                                    data-toggle="dropdown">
                                                    <i class="fa fa-file-excel mr-1"></i> Export
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item out2-export-option" data-type="history"
                                                        href="#">Export History</a>
                                                    <a class="dropdown-item out2-export-option" data-type="data"
                                                        href="#">Export Summary</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tableHeader_out2" class="st-table table table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Doc No</th>
                                                    <th>Date</th>
                                                    <th>Dept</th>
                                                    <th>Status</th>
                                                    <th width="80">Detail</th>
                                                    <th width="80">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- EDIT AREA: SPB Permintaan (With Inputs) -->
                            <div class="st-card card mt-4" id="out2_edit_area" style="display:none;">
                                <div class="st-card-header card-header d-flex align-items-center"
                                    style="background: #245a7e !important;">
                                    <h3 class="st-card-title card-title mb-0"><i class="fas fa-edit mr-2"></i> SPB
                                        Permintaan</h3>
                                    <button class="btn btn-info btn-sm ml-auto" id="out2_btn_update_all"
                                        style="background: #00bcd4 !important; border: none; font-weight: 700; border-radius: 4px;">
                                        <i class="fas fa-plus mr-1"></i> Update
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="st-table table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Line</th>
                                                    <th>Tanggal</th>
                                                    <th>Item Name</th>
                                                    <th>Qty Return</th>
                                                    <th>Qty Request</th>
                                                    <th width="100">Qty Out</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                    <th>Qty Out Standing</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb_edit_out2"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- VIEW AREA: Report List Pengambilan Barang (SPB) -->
                            <div class="st-card card mt-4" id="out2_report_area" style="display:none;">
                                <div class="st-card-header card-header" style="background: #245a7e !important;">
                                    <h3 class="st-card-title card-title mb-0"><i class="fas fa-file-invoice mr-2"></i>
                                        Report List Pengambilan Barang (SPB)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="st-table table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>line</th>
                                                    <th>Tanggal</th>
                                                    <th>Item Name</th>
                                                    <th>Qty Retrun</th>
                                                    <th>Qty Request</th>
                                                    <th>Qty Out</th>
                                                    <th>Description</th>
                                                    <th>Qty Out Standing</th>
                                                    <th>Update</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb_report_out2"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <!-- MODALS SECTION -->

    <!-- Modal Add/Edit (Section 1) -->
    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-lg">
            <div class="st-modal-content modal-content">
                <div class="st-modal-header modal-header">
                    <h4 class="modal-title font-weight-bold" id="title1" style="color:white;">Add Item Out ASI-1</h4>
                    <h4 class="modal-title font-weight-bold" id="title2" style="color:white; display:none;">Edit Item Out
                        ASI-1</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label-custom">Date</label>
                                <input type="hidden" id="id">
                                <input type="date" id="date_plan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label-custom">Department</label>
                                <select id="line_id" class="select2" style="width: 100%;">
                                    <option value="">--</option>
                                    @foreach ($departements as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name_dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="form-label-custom">Item</label>
                                <select id="item_id" class="select2" style="width: 100%;">
                                    <option value="">- -</option>
                                    @foreach ($master_list_strs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->name }} / {{ $barang->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label-custom">UoM</label>
                                <select id="satuan" class="select2" style="width: 100%;">
                                    <option value="">--</option>
                                    @foreach ($str_uoms as $uom)
                                        <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label-custom">Qty Request</label>
                                <input type="number" id="qty_request" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label-custom">Qty Out</label>
                                <input type="number" id="qty_out" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-custom">Remarks</label>
                                <input type="text" id="keterangan" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_save"
                        style="background: var(--st-accent)!important; border:none;">Insert</button>
                    <button type="button" class="btn btn-warning" id="btn_update" style="display:none;">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Header/Add (Out2) -->
    <div class="modal fade" id="modal_header_out2">
        <div class="modal-dialog modal-lg">
            <div class="st-modal-content modal-content">
                <div class="st-modal-header modal-header">
                    <h4 class="modal-title font-weight-bold" id="out2_title1" style="color:white;">Add SPB STAMPING</h4>
                    <h4 class="modal-title font-weight-bold" id="out2_title2" style="color:white; display:none;">Edit SPB
                        STAMPING</h4>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label class="form-label-custom">No SPB</label>
                            <input type="text" id="out2_doc_no" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom">Date</label>
                            <input type="date" id="out2_date_plan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Dept</label>
                            <select id="out2_line_id" class="select2" style="width: 100%;">
                                <option value="">--</option>
                                <option value="LINE C1">LINE C1</option>
                                <option value="LINE C2">LINE C2</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-9">
                            <label class="form-label-custom">Item</label>
                            <select id="out2_item_id" class="select2" style="width: 100%;">
                                <option value="">--</option>
                                @foreach ($master_list_strs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->name }} / {{ $barang->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom">Current Stock</label>
                            <input type="text" id="out2_actual_value" class="form-control text-center font-weight-bold"
                                readonly style="background: #f8fafc;">
                        </div>
                    </div>

                    <div class="row mb-4 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label-custom">Qty Return</label>
                            <input type="number" id="out2_qty_return" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom">Qty Request</label>
                            <input type="number" id="out2_qty_request" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom">UoM</label>
                            <select id="out2_satuan" class="select2" style="width: 100%;">
                                <option value="">--</option>
                                @foreach ($str_uoms as $uom)
                                    <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block" id="out2_btn_insert"
                                style="height: 38px; font-weight: 700;">
                                <i class="fas fa-plus mr-1"></i> INSERT
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="out2_example2" class="st-table table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Dept</th>
                                    <th>Item</th>
                                    <th>Ret</th>
                                    <th>Req</th>
                                    <th>UoM</th>
                                    <th width="60">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="out2_btn_submit_final">Finalize SPB</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Details Checklist (Out2) -->
    <div class="modal fade" id="out2_detailsModal">
        <div class="modal-dialog modal-lg">
            <div class="st-modal-content modal-content">
                <div class="st-modal-header modal-header bg-info">
                    <h5 class="modal-title text-white">SPB Checklist</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-0">
                    <table class="st-table table table-striped mb-0">
                        <thead>
                            <tr>
                                <th width="40"><input type="checkbox" id="out2_check_all"></th>
                                <th>Line</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Ret</th>
                                <th>Req</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" id="out2_saveChecked">Approve Selected</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        // Global navigation functions
        function toggleSection(type) {
            if (type === 'out2') {
                $('#section_out').fadeOut(200, function () {
                    $('#section_out2').fadeIn(300);
                    out2_list();
                });
            } else {
                $('#section_out2').fadeOut(200, function () {
                    $('#section_out').fadeIn(300);
                    list();
                });
            }
            localStorage.setItem('st_active_view', type);
        }

        function toggleLocalTheme() {
            const body = document.body;
            const isDark = body.classList.toggle('dark-mode-st');
            
            // Update all icon instances
            const icons = document.querySelectorAll('[id^="st-theme-icon"]');
            icons.forEach(icon => {
                icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            });
            
            localStorage.setItem('st_theme', isDark ? 'dark' : 'light');
        }

        // --- DATA LOADING FUNCTIONS (GLOBAL SCOPE) ---
        function list() {
            $('#example1').DataTable({
                processing: true, serverSide: true, destroy: true,
                ajax: {
                    url: "{{ route('strout.list') }}",
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    { data: null, render: (d, t, r, m) => m.row + 1 },
                    { data: 'date_plan', name: 'date_plan' },
                    { data: 'line', name: 'line' },
                    {
                        data: 'mix_id',
                        render: function (data, type, row) {
                            return `<div class="btn-group">
                                                                        <button class="btn btn-xs btn-warning out-btn-edit" data-id="${data}"><i class="fas fa-edit"></i></button>
                                                                        <button class="btn btn-xs btn-danger out-btn-delete" data-id="${data}"><i class="fas fa-trash"></i></button>
                                                                    </div>`;
                        }
                    }
                ]
            });
        }

        function listdetail_out(date, line) {
            $('#example2').DataTable({
                processing: true, serverSide: true, destroy: true,
                ajax: { url: "{{ route('strout.listdetail') }}", data: { date_plan: date, line_id: line } },
                columns: [
                    { data: null, render: (d, t, r, m) => m.row + 1 },
                    { data: 'line_id' }, { data: 'name' }, { data: 'qty_request' }, { data: 'qty_out' }, { data: 'satuan' }, { data: 'keterangan' },
                    { data: 'id', render: (d) => `<button class="btn btn-danger btn-xs out-delete-line" data-id="${d}"><i class="fas fa-trash"></i></button>` }
                ]
            });
        }

        function out2_list() {
            $('#tableHeader_out2').DataTable({
                processing: true, serverSide: true, destroy: true,
                ajax: {
                    url: "{{ route('strout2.list') }}",
                    data: function (d) {
                        d.start_date = $('#start_date_out2').val();
                        d.end_date = $('#end_date_out2').val();
                    }
                },
                columns: [
                    { data: null, render: (d, t, r, m) => m.row + 1 },
                    { data: 'doc_no' }, { data: 'date_plan' }, { data: 'line_id' },
                    {
                        data: 'status',
                        render: function (d) {
                            let cls = '';
                            let text = '';
                            if (d == 1) {
                                cls = 'status-cek-complete';
                                text = 'Cek Item Complete';
                            } else if (d >= 2) {
                                cls = 'status-trans-complete';
                                text = 'Transcation Complete';
                            } else {
                                cls = 'status-waiting-leader';
                                text = 'Waiting Approval';
                            }
                            return `<span class="status-badge ${cls}">${text}</span>`;
                        }
                    },
                    { data: 'doc_no', render: (d) => `<button class="btn btn-info btn-xs out2-btn-details" data-doc_no="${d}" style="background: #00bcd4 !important; border:none; padding: 4px 12px; font-weight: 700; border-radius: 4px;"><i class="fas fa-eye mr-1"></i> Details</button>` },
                    {
                        data: null,
                        render: function (d, t, row) {
                            let btns = `<div class="btn-group">
                                                                <button class="btn btn-success btn-xs out2-btn-view" data-id="${row.doc_no}" title="View Report" style="background: #2e7d32 !important; border:none; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-search"></i></button>
                                                                <button class="btn btn-warning btn-xs out2-btn-edit" data-id="${row.doc_no}" title="Edit SPB" style="background: #ffc107 !important; border:none; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-left: 4px;"><i class="fas fa-edit"></i></button>`;
                            if (row.status == 0) btns += `<button class="btn btn-primary btn-xs out2-approve-btn" data-doc_no="${row.doc_no}" style="width: 32px; height: 32px; margin-left: 4px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-check"></i></button>`;
                            btns += `<button class="btn btn-danger btn-xs out2-btn-delete-group" data-doc_no="${row.doc_no}" style="width: 32px; height: 32px; margin-left: 4px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-trash"></i></button></div>`;
                            return btns;
                        }
                    }
                ]
            });
        }

        function out2_listdetail(doc_no) {
            $('#out2_example2').DataTable({
                processing: true, serverSide: true, destroy: true,
                searching: false, lengthChange: false, info: false,
                ajax: {
                    url: "{{ route('strout2.listdetail') }}",
                    data: {
                        doc_no: doc_no,
                        date_plan: $('#out2_date_plan').val(),
                        line_id: $('#out2_line_id').val()
                    }
                },
                columns: [
                    { data: null, render: (d, t, r, m) => m.row + 1 },
                    { data: 'line_id' }, { data: 'name' }, { data: 'qty_return' }, { data: 'qty_request' }, { data: 'satuan' },
                    { data: 'id', render: (d) => `<button class="btn btn-danger btn-xs out2-delete-line" data-id="${d}"><i class="fas fa-trash"></i></button>` }
                ]
            });
        }

        $(document).ready(function () {
            // Init Plugins
            $('.select2').select2({ theme: 'bootstrap4' });

            // Load Theme
            if (localStorage.getItem('st_theme') === 'dark') {
                document.body.classList.add('dark-mode-st');
                document.querySelectorAll('[id^="st-theme-icon"]').forEach(icon => {
                    icon.className = 'fas fa-sun';
                });
            }

            // Load Active Section
            const activeView = localStorage.getItem('st_active_view');
            if (activeView === 'out2') { toggleSection('out2'); } else { list(); }


            $('#start_date, #end_date').change(function () { list(); });

            $('#btn_add').click(function () {
                $('#id').val(''); $('#title1').show(); $('#title2').hide();
                $('#btn_save').show(); $('#btn_update').hide();
                $('#myModal2').modal('show');
            });

            $(document).on('click', '.out-btn-edit', function () {
                var id = $(this).data('id');
                var date = id.substr(0, 10);
                var line = id.substr(10);
                $('#date_plan').val(date);
                $('#line_id').val(line).trigger('change');
                $('#title1').hide(); $('#title2').show();
                $('#btn_save').hide(); $('#btn_update').show();
                $('#detail_area_out').show();
                listdetail_out(date, line);
                $('#myModal2').modal('show');
            });

            $('#btn_save').click(function () {
                $.post("{{ route('strout.store') }}", {
                    date_plan: $('#date_plan').val(), line_id: $('#line_id').val(),
                    item_id: $('#item_id').val(), qty_request: $('#qty_request').val(),
                    qty_out: $('#qty_out').val(), satuan: $('#satuan').val(),
                    keterangan: $('#keterangan').val(), _token: "{{ csrf_token() }}"
                }, function (res) {
                    if (res.success) {
                        Swal.fire('Success', res.msg, 'success');
                        listdetail_out($('#date_plan').val(), $('#line_id').val());
                        list();
                    } else {
                        Swal.fire('Error', res.msg, 'error');
                    }
                });
            });

            $('#btn_update').click(function () {
                $.post("{{ route('strout.update') }}", {
                    id: $('#id').val(), item_id: $('#item_id').val(),
                    qty_request: $('#qty_request').val(), qty_out: $('#qty_out').val(),
                    satuan: $('#satuan').val(), keterangan: $('#keterangan').val(),
                    _token: "{{ csrf_token() }}"
                }, function (res) {
                    if (res.success) {
                        Swal.fire('Success', res.msg, 'success');
                        listdetail_out($('#date_plan').val(), $('#line_id').val());
                        list();
                    }
                });
            });

            $(document).on('click', '.out-btn-delete', function () {
                let id = $(this).data('id');
                let date = id.substr(0, 10);
                let line = id.substr(10);
                Swal.fire({ title: 'Delete Group?', text: 'This will delete all items for this date and line.', icon: 'warning', showCancelButton: true }).then((r) => {
                    if (r.isConfirmed) {
                        $.post("{{ route('strout.destroy') }}", { date_plan: date, idline: line, _token: "{{ csrf_token() }}" }, function () {
                            Swal.fire('Deleted!', '', 'success'); list();
                        });
                    }
                });
            });

            $(document).on('click', '.out-delete-line', function () {
                let id = $(this).data('id');
                $.post("{{ route('strout.destroyline') }}", { id: id, _token: "{{ csrf_token() }}" }, function () {
                    listdetail_out($('#date_plan').val(), $('#line_id').val());
                });
            });

            $('#btn_export').click(function () {
                let start = $('#start_date').val();
                let end = $('#end_date').val();
                if (!start || !end) return Swal.fire('Warning', 'Select date range', 'warning');
                window.location.href = "{{ route('strout.export') }}?start_date=" + start + "&end_date=" + end;
            });



            $('#btn_add_out2').click(function () {
                $('#out2_doc_no').val('SPB/STMP/' + Date.now()); // Fallback if getdoc fails
                $.get("{{ route('strout2.getdoc') }}", (res) => { $('#out2_doc_no').val("SPB/ASI/STAMPING/" + new Date().getFullYear() + "/" + res.jml); });
                $('#modal_header_out2').modal('show');
                out2_listdetail($('#out2_doc_no').val());
            });


            $('#out2_btn_insert').click(function () {
                $.post("{{ route('strout2.store') }}", {
                    doc_no: $('#out2_doc_no').val(), date_plan: $('#out2_date_plan').val(),
                    line_id: $('#out2_line_id').val(), item_id: $('#out2_item_id').val(),
                    qty_return: $('#out2_qty_return').val(), qty_request: $('#out2_qty_request').val(),
                    satuan: $('#out2_satuan').val(), _token: "{{ csrf_token() }}"
                }, function (res) {
                    if (res.success) out2_listdetail($('#out2_doc_no').val());
                    else Swal.fire('Error', res.msg, 'error');
                });
            });

            $(document).on('click', '.out2-btn-details', function () {
                let doc = $(this).attr('data-doc_no');
                $('#out2_detailsModal').modal('show');
                $.get("{{ route('strout2.listdetail2') }}", { doc_no: doc }, function (res) {
                    let h = '';
                    let items = res.data || res;
                    items.forEach(v => {
                        h += `<tr>
                                                        <td><input type="checkbox" class="out2-check" value="${v.id}"></td>
                                                        <td>${v.line_id}</td>
                                                        <td>${v.date_plan}</td>
                                                        <td class="text-left">${v.name}</td>
                                                        <td>${v.qty_return || 0}</td>
                                                        <td>${v.qty_request || 0}</td>
                                                        <td><span class="badge badge-warning">Pending</span></td>
                                                    </tr>`;
                    });
                    $('#out2_detailsModal tbody').html(h);
                    $('#out2_saveChecked').data('doc', doc);
                });
            });

            $('#out2_saveChecked').click(function () {
                let ids = []; $('.out2-check:checked').each(function () { ids.push($(this).val()); });
                $.post("{{ route('strout2.saveChecked') }}", { items: ids, doc_no: $(this).data('doc'), _token: "{{ csrf_token() }}" }, function () {
                    $('#out2_detailsModal').modal('hide'); out2_list();
                });
            });

            $(document).on('click', '.out2-btn-view', function () {
                let doc = $(this).attr('data-id');
                $('#out2_edit_area').hide();
                $.get("{{ route('strout2.listdetail2') }}", { doc_no: doc }, function (res) {
                    let h = '';
                    let no = 1;
                    let items = res.data || res;
                    $.each(items, function (key, v) {
                        let line_id = v.line_id || '';
                        let date_plan = v.date_plan || '';
                        let qty_standing = v.qty_standing || '';
                        let qty_request = v.qty_request || '';
                        let qty_return = v.qty_return || '';
                        let createdby = v.createdby || '';
                        let qty_out = v.qty_out || '';
                        let keterangan = v.keterangan || '';

                        h += `<tr class="text-center">
                                                        <td>${no++}</td>
                                                        <td>${line_id}</td>
                                                        <td>${date_plan}</td>
                                                        <td class="text-left">${v.name}</td>
                                                        <td>${qty_return}</td>
                                                        <td>${qty_request}</td>
                                                        <td>${qty_out}</td>
                                                        <td>${keterangan}</td>
                                                        <td class="font-weight-bold text-primary">${qty_standing}</td>
                                                        <td>${createdby}</td>
                                                    </tr>`;
                    });
                    $('#tb_report_out2').html(h);
                    $('#out2_report_area').fadeIn();
                    document.getElementById("out2_report_area").scrollIntoView({ behavior: 'smooth' });
                });
            });

            $(document).on('click', '.out2-btn-edit', function () {
                let doc = $(this).attr('data-id');
                $('#out2_report_area').hide();
                $.get("{{ route('strout2.listdetail2') }}", { doc_no: doc }, function (res) {
                    let h = '';
                    let no = 1;
                    let idline = 1;
                    let qty_out_counter = 1;
                    let idket = 1;
                    let keterangan_counter = 1;
                    let items = res.data || res;

                    $.each(items, function (key, v) {
                        let qty_standing = v.qty_standing || '';
                        let qty_return = v.qty_return || '';
                        let qty_request = v.qty_request || '';
                        let qty = v.qty_out || '';
                        let ket = v.keterangan || '';
                        let createdby = v.createdby || '';

                        h += `<tr class="text-center" data-id="${v.id}">
                                                        <td>${no++}</td>
                                                        <td>${v.line_id}</td>
                                                        <td>${v.date_plan}</td>
                                                        <td class="text-left">${v.name}</td>
                                                        <td>${qty_return}</td>
                                                        <td>${qty_request}</td>
                                                        <td>
                                                            <input type="hidden" name="idline[${idline++}]" value="${v.id}">
                                                            <input type="number" class="form-control form-control-sm edit-qty-out" name="qty[${qty_out_counter++}]" value="${qty}">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="idket[${idket++}]" value="${v.id}">
                                                            <input type="text" class="form-control form-control-sm edit-ket" style="width:100%" name="ket[${keterangan_counter++}]" value="${ket}">
                                                        </td>
                                                        <td>${createdby}</td>
                                                        <td class="font-weight-bold text-primary standing-text">${qty_standing}</td>
                                                    </tr>`;
                    });
                    $('#tb_edit_out2').html(h);
                    $('#out2_edit_area').fadeIn();
                    document.getElementById("out2_edit_area").scrollIntoView({ behavior: 'smooth' });
                });
            });

            $(document).on('input', '.edit-qty-out', function () {
                let row = $(this).closest('tr');
                let req = parseInt(row.find('td:eq(5)').text()) || 0;
                let out = parseInt($(this).val()) || 0;
                row.find('.standing-text').text(req - out);
            });

            $(document).on('click', '.out2-btn-update-line', function () {
                let row = $(this).closest('tr');
                let id = row.data('id');
                let out = row.find('.edit-qty-out').val();
                let ket = row.find('.edit-ket').val();

                $.post("{{ route('strout2.update2') }}", {
                    id: id, qty_out: out, keterangan: ket, _token: "{{ csrf_token() }}"
                }, function (res) {
                    if (res.success) toastr.success('Line updated');
                    else Swal.fire('Error', res.msg, 'error');
                });
            });

            $('#out2_btn_update_all').click(function () {
                let data = [];
                $('#tb_edit_out2 tr').each(function () {
                    data.push({
                        id: $(this).data('id'),
                        qty_out: $(this).find('.edit-qty-out').val(),
                        keterangan: $(this).find('.edit-ket').val()
                    });
                });

                $.post("{{ route('strout2.update2') }}", {
                    items: data, bulk: true, _token: "{{ csrf_token() }}"
                }, function (res) {
                    if (res.success) {
                        Swal.fire('Success', 'All items updated', 'success');
                        out2_list();
                    } else {
                        Swal.fire('Error', res.msg, 'error');
                    }
                });
            });

            $('#out2_btn_submit_final').click(function () {
                $.post("{{ route('strout2.submit') }}", { doc_no: $('#out2_doc_no').val(), _token: "{{ csrf_token() }}" }, function (res) {
                    if (res.success) {
                        $('#modal_header_out2').modal('hide');
                        Swal.fire('Success', 'SPB submitted', 'success');
                        out2_list();
                    }
                });
            });

            $(document).on('click', '.out2-delete-line', function () {
                let id = $(this).data('id');
                Swal.fire({ title: 'Delete?', icon: 'warning', showCancelButton: true }).then((r) => {
                    if (r.isConfirmed) {
                        $.post("{{ route('strout2.destroyline') }}", { id: id, _token: "{{ csrf_token() }}" }, function () {
                            if ($('#modal_header_out2').is(':visible')) {
                                out2_listdetail($('#out2_doc_no').val());
                            } else {
                                out2_list();
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.out2-btn-delete-group', function () {
                let doc = $(this).data('doc_no');
                Swal.fire({
                    title: 'Delete Entire Group?',
                    text: "All items in SPB " + doc + " will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((r) => {
                    if (r.isConfirmed) {
                        $.post("{{ route('strout2.destroy') }}", { doc_no: doc, _token: "{{ csrf_token() }}" }, function (res) {
                            if (res.success) {
                                Swal.fire('Deleted!', 'SPB group has been deleted.', 'success');
                                out2_list();
                            } else {
                                Swal.fire('Error', res.msg, 'error');
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.out2-approve-btn', function () {
                let doc = $(this).data('doc_no');
                Swal.fire({ title: 'Approve SPB?', icon: 'question', showCancelButton: true }).then((r) => {
                    if (r.isConfirmed) {
                        $.post("{{ route('strout2.approve') }}", { doc_no: doc, _token: "{{ csrf_token() }}" }, function () {
                            Swal.fire('Approved!', '', 'success');
                            out2_list();
                        });
                    }
                });
            });

            $('#out2_check_all').click(function () {
                $('.out2-check').prop('checked', this.checked);
            });
        });
    </script>
@endpush