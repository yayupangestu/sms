@extends('layouts.app')

@section('content')
    <div class="content-header px-0">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold text-white dashboard-title">
                        <i class="ph-duotone ph-database me-2"></i>Data BOM
                    </h1>
                    <p class="text-muted mb-0">Manage Bill of Materials and FG Stamping data</p>
                </div>
                <div class="col-sm-6 text-end">
                    <nav aria-label="breadcrumb" class="d-inline-block">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="#" class="text-primary text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-muted" aria-current="page">Data BOM</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="content px-0">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col-12">
                    <div class="glass-card shadow-lg border-0">
                        <div class="card-header border-0 d-flex align-items-center py-2 px-4">
                            <div class="header-left d-flex align-items-center">
                                <div class="bg-primary-gradient rounded-2 p-2 me-3"
                                    style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    <i class="ph-bold ph-factory text-white fs-5"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-0">Tabel List BOM</h5>
                            </div>
                            <div class="header-right ms-auto d-flex align-items-center gap-3">
                                <div class="premium-stats-box sub-assy shadow-sm">
                                    <div class="stats-glow"></div>
                                    <div class="stats-icon-wrapper">
                                        <i class="ph-bold ph-assembly-facility"></i>
                                    </div>
                                    <div class="stats-content">
                                        <span class="stats-caption">Sub Assy</span>
                                        <div class="d-flex align-items-baseline">
                                            <span class="stats-number" id="count_sub_assy">0</span>
                                            <span class="stats-unit">Items</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="premium-stats-box direct shadow-sm">
                                    <div class="stats-glow"></div>
                                    <div class="stats-icon-wrapper">
                                        <i class="ph-bold ph-truck"></i>
                                    </div>
                                    <div class="stats-content">
                                        <span class="stats-caption">Direct</span>
                                        <div class="d-flex align-items-baseline">
                                            <span class="stats-number" id="count_direct">0</span>
                                            <span class="stats-unit">Items</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="toolbar d-flex flex-wrap justify-content-between align-items-center gap-3 px-4 py-3 border-bottom bg-white">
                                <div class="toolbar-left d-flex align-items-center gap-3">
                                    <button id="btn_add" class="btn btn-primary-gradient px-4 rounded-pill shadow-sm">
                                        <i class="ph-bold ph-plus-circle me-2"></i>Add Data
                                    </button>
                                    <div class="toolbar-divider"></div>
                                    <div class="filter-wrapper d-flex align-items-center bg-light-glass rounded-pill px-3 py-1 border shadow-sm">
                                        <i class="ph-bold ph-funnel text-primary me-2"></i>
                                        <span class="small fw-bold text-muted me-2 border-end pe-2" style="font-size: 0.75rem;">CUSTOMER</span>
                                        <select id="filter_customer" class="form-select form-select-sm border-0 bg-transparent ps-2 py-0" style="width: 140px; font-size: 0.85rem; font-weight: 600; color: #475569; outline: none; box-shadow: none; height: 24px;">
                                            <option value="">All Customer</option>
                                            @foreach($customers as $c)
                                                <option value="{{ $c->customer }}">{{ $c->customer }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="toolbar-right d-flex align-items-center gap-2">
                                    <form id="importForm" action="{{ route('databom.importDp') }}" method="POST"
                                        enctype="multipart/form-data" class="d-flex align-items-center gap-2 mb-0">
                                        @csrf
                                        <div class="custom-file-upload">
                                            <input type="file" id="fileInput" name="file" class="d-none" required>
                                            <label for="fileInput" class="btn btn-outline-warning rounded-pill px-3 mb-0 shadow-sm border-2 fw-bold" style="font-size: 0.8rem;">
                                                <i class="ph-bold ph-file-xls me-1"></i>Select File
                                            </label>
                                        </div>
                                        <button id="importButton" class="btn btn-emerald px-4 rounded-pill shadow-sm fw-bold"
                                            type="submit" disabled style="font-size: 0.8rem;">
                                            <i class="ph-bold ph-arrow-line-up me-1"></i>Import
                                        </button>
                                    </form>
                                    <div class="toolbar-divider mx-1"></div>
                                    <button type="button" class="btn btn-success px-4 rounded-pill shadow-sm fw-bold" data-toggle="modal"
                                        data-target="#modalExport" style="font-size: 0.8rem;">
                                        <i class="ph-bold ph-microsoft-excel-logo me-1"></i>Export Excel
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example1" class="table custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Part No</th>
                                            <th>Job No</th>
                                            <th>Customer</th>
                                            <th>Category</th>
                                            <th width="100" class="text-center">Action</th>
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
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade glass-modal" id="myModal2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content glass-card border-0 mt-4">
                <div class="modal-header border-bottom border-light-glass">
                    <h5 class="modal-title fw-bold text-white" id="title1">
                        <i class="ph-bold ph-plus-circle me-2"></i>Add Data DataBOM
                    </h5>
                    <h5 class="modal-title fw-bold text-white" id="title2">
                        <i class="ph-bold ph-pencil-circle me-2"></i>Edit Data DataBOM
                    </h5>
                    <button type="button" class="btn-close btn-close-white close" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="alert" class="mb-3"></div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-primary fw-bold mb-0">
                            <i class="ph-bold ph-info me-2"></i>BOM Part Information
                            <span id="lockWarning" class="ms-2 d-none animation-pulse"><i
                                    class="ph-bold ph-warning-circle text-danger"></i></span>
                        </h6>
                        <div class="form-check form-switch custom-switch">
                            <input class="form-check-input" type="checkbox" id="masterLock">
                            <label class="form-check-label fw-bold text-primary small" for="masterLock">LOCK BOM
                                DATA</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Part No</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-hash text-primary"></i></span>
                                    <input type="hidden" id="id">
                                    <input type="text" id="part_no" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter part no">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Uniq No</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-key text-primary"></i></span>
                                    <input type="text" id="uniqNo" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter uniq no">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Part Name</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-package text-primary"></i></span>
                                    <input type="text" id="part_name" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter part name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Job No</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-identification-card text-primary"></i></span>
                                    <input type="text" id="job_no" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter job no">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Category</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-list-numbers text-primary"></i></span>
                                    <select style="width: 100%;" id="category_id" class="form-control select2" required>
                                        <option value="" selected>- pilih -</option>
                                        <option value="1">SUB ASSY</option>
                                        <option value="2">DIRECT</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Vendor</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-buildings text-primary"></i></span>
                                    <input type="text" id="vendor" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter vendor">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Customer</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-user-circle text-primary"></i></span>
                                    <input type="text" id="customer" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter customer">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Model</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-cube text-primary"></i></span>
                                    <input type="text" id="model_id" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter model">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Child Part No</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-hash-straight text-primary"></i></span>
                                    <input type="text" id="part_no2" class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter child part no">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label small fw-bold text-uppercase mb-1">Child Part Name</label>
                                <div class="input-group-glass">
                                    <span class="input-group-text bg-transparent border-0"><i
                                            class="ph-bold ph-package text-primary"></i></span>
                                    <input type="text" id="part_name2"
                                        class="form-control bg-transparent border-0 text-dark"
                                        placeholder="Enter child part name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-2 border rounded-3 overflow-hidden">
                        <div class="bg-light px-3 py-1 border-bottom d-flex align-items-center">
                            <h6 class="text-primary fw-bold mb-0" style="font-size: 0.9rem;"><i class="ph-bold ph-list-bullets me-2"></i>BOM Details
                            </h6>
                        </div>
                        <table id="example2" class="table custom-table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">NO</th>
                                    <th>UNIQ NO</th>
                                    <th>VENDOR</th>
                                    <th width="50">CATEGORY</th>
                                    <th width="100">MODEL</th>
                                    <th width="150">CHILD PART</th>
                                    <th>CHILD NAME</th>
                                    <th width="80" class="text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top border-light-glass">
                    <button type="button" class="btn btn-outline-light-glass rounded-pill px-4 close"
                        data-dismiss="modal">Close</button>
                    <button type="button"
                        class="btn btn-primary-gradient rounded-pill px-4 Update shadow-sm">Update</button>
                    <button type="button" class="btn btn-primary-gradient rounded-pill px-4 Save shadow-sm" disabled>
                        <i class="ph-bold ph-floppy-disk me-1"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Export -->
    <div class="modal fade glass-modal" id="modalExport" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content glass-card border-0">
                <div class="modal-header border-bottom border-light-glass">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="ph-bold ph-file-xls me-2 text-success"></i>Export Options
                    </h5>
                    <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="text-muted small mb-4">Choose the type of excel file you want to download.</p>
                    <div class="d-grid gap-3">
                        <a href="{{ route('databom.exportTemplate') }}" class="btn btn-outline-light-glass rounded-pill py-2">
                            <i class="ph-bold ph-download-simple me-2 text-primary"></i>Download Template
                        </a>
                        <a href="{{ route('databom.export') }}" class="btn btn-emerald rounded-pill py-2 text-white">
                            <i class="ph-bold ph-microsoft-excel-logo me-2"></i>Download Data BOM
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-top border-light-glass justify-content-center">
                    <button type="button" class="btn btn-link text-muted small text-decoration-none close" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
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
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#myModal2')
            });
            list();
        });

        $(document).on("change", "#filter_customer", function() {
            list();
        });

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
                    url: "{{ route('databom.list') }}",
                    data: function(d) {
                        d.customer = $('#filter_customer').val();
                    }
                },
                columns: [{
                    data: null,
                    sortable: false,
                    searchable: false,
                    className: 'text-center border-end',
                    render: function (data, type, row, meta) {
                        return `<span class="badge badge-number">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                    }
                },
                {
                    data: 'part_no',
                    name: 'part_no',
                    className: 'border-end fw-bold'
                },
                {
                    data: 'job_no',
                    name: 'job_no',
                    className: 'border-end'
                },
                {
                    data: 'customer',
                    name: 'customer',
                    className: 'border-end',
                    render: function(data) {
                        return data || '<span class="text-muted small">-</span>';
                    }
                },
                {
                    data: 'category_id',
                    name: 'category_id',
                    className: 'text-center border-end',
                    render: function (data) {
                        if (data == 1) {
                            return `<span class="badge bg-success-subtle text-success border border-success-subtle px-2">SUB ASSY</span>`;
                        } else if (data == 2) {
                            return `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">DIRECT</span>`;
                        }
                        return '<span class="text-muted small">-</span>';
                    }
                },
                {
                    data: 'mix_id',
                    name: 'mix_id',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex justify-content-center gap-2">
                                <button id="btn_edit" title="Edit" 
                                    data-id="${data}" 
                                    data-part_no="${row.part_no}" 
                                    data-job_no="${row.job_no}" 
                                    data-part_name="${row.part_name}" 
                                    data-model_id="${row.model_id}" 
                                    data-category_id="${row.category_id}" 
                                    data-uniq_no="${row.uniqNo || ''}" 
                                    data-vendor="${row.vendor || ''}" 
                                    data-customer="${row.customer || ''}" 
                                    class="btn btn-action-edit">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </button>
                                <button id="btn_delete" title="Delete" 
                                    data-id="${data}" 
                                    data-part_no="${row.part_no}" 
                                    data-job_no="${row.job_no}" 
                                    data-customer="${row.customer || ''}" 
                                    class="btn btn-action-delete">
                                    <i class="ph-bold ph-trash"></i>
                                </button>
                            </div>`;
                    }
                }
                ],
                dom: '<"d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-bottom border-light-glass"lf>rt<"d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top border-light-glass"ip>',
                language: {
                    search: "",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ entries",
                    processing: '<div class="dataTables_processing_custom"><img src="{{asset("dist/img/Hourglass.gif")}}" width="40" class="mb-2"><br>Loading . . .</div>',
                    paginate: {
                        previous: '<i class="ph-bold ph-caret-left"></i>',
                        next: '<i class="ph-bold ph-caret-right"></i>'
                    }
                },
                drawCallback: function (settings) {
                    $('.dataTables_paginate > .pagination').addClass(
                        'pagination-rounded custom-pagination mb-0');
                    
                    // Update category counts from server response with animation
                    var json = settings.json;
                    if (json && json.count1 !== undefined) {
                        animateValue("count_sub_assy", parseInt($('#count_sub_assy').text()) || 0, json.count1, 1000);
                    }
                    if (json && json.count2 !== undefined) {
                        animateValue("count_direct", parseInt($('#count_direct').text()) || 0, json.count2, 1000);
                    }
                }
            });
        }

        function animateValue(id, start, end, duration) {
            var obj = document.getElementById(id);
            if (!obj) return;
            if (start === end) return;
            var range = end - start;
            var current = start;
            var increment = end > start ? 1 : -1;
            var stepTime = Math.abs(Math.floor(duration / range));
            if (stepTime < 10) stepTime = 10; // Prevent too fast intervals
            
            var timer = setInterval(function() {
                current += increment;
                obj.innerHTML = current;
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        function listdetail() {
            var table = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: false,
                bLengthChange: false,
                destroy: true,
                pageLength: 5,
                ajax: {
                    url: "{{ route('databom.listdetail') }}",
                    data: function (d) {
                        d.part_no = $('#part_no').val();
                        d.job_no = $('#job_no').val();
                        d.customer = $('#customer').val();
                    }
                },
                columns: [{
                    data: null,
                    sortable: false,
                    className: 'text-center border-end',
                    render: function (data, type, row, meta) {
                        return `<span class="badge badge-number">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                    }
                },
                {
                    data: 'uniqNo',
                    name: 'uniqNo',
                    className: 'border-end'
                },
                {
                    data: 'vendor',
                    name: 'vendor',
                    className: 'border-end'
                },
                {
                    data: 'category_id',
                    name: 'category_id',
                    className: 'text-center border-end',
                    render: function (data) {
                        if (data == 1) {
                            return `<span class="badge bg-success-subtle text-success border border-success-subtle px-2">SUB ASSY</span>`;
                        } else if (data == 2) {
                            return `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">DIRECT</span>`;
                        }
                        return '<span class="text-muted small">-</span>';
                    }
                },
                {
                    data: 'model_id',
                    name: 'model_id',
                    className: 'text-center border-end'
                },
                {
                    data: 'part_no2',
                    name: 'part_no2',
                    className: 'border-end'
                },
                {
                    data: 'part_name2',
                    name: 'part_name2'
                },
                {
                    data: 'id',
                    name: 'id',
                    className: 'text-center border-start',
                    render: function (data) {
                        return `
                            <button id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-action-delete mx-auto">
                                <i class="ph-bold ph-trash"></i>
                            </button>`;
                    }
                }
                ],
                language: {
                    processing: '<div class="dataTables_processing_custom"><img src="{{asset("dist/img/Hourglass.gif")}}" width="40" class="mb-2"><br>Loading . . .</div>',
                    paginate: {
                        previous: '<i class="ph-bold ph-caret-left"></i>',
                        next: '<i class="ph-bold ph-caret-right"></i>'
                    }
                },
                drawCallback: function () {
                    $('.dataTables_paginate > .pagination').addClass(
                        'pagination-rounded custom-pagination mb-0');
                }
            });
        }

        $(document).on("click", "#btn_add", function () {
            clear(true); // Force clear everything including ID and lock
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $("#title2").hide();
            $("#title1").show();
            $(".Update").hide();
            $(".Save").show();
        });

        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            $(".Save").hide();
            $(".Update").show();

            var edit_part_no = $(this).data('part_no');
            var edit_job_no = $(this).data('job_no');
            var edit_part_name = $(this).data('part_name');
            var edit_model_id = $(this).data('model_id');
            var edit_category_id = $(this).data('category_id');
            var edit_uniq_no = $(this).data('uniq_no');
            var edit_vendor = $(this).data('vendor');
            var edit_customer = $(this).data('customer');

            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            $('#part_no').val(edit_part_no);
            $('#job_no').val(edit_job_no);
            $('#part_name').val(edit_part_name);
            $('#model_id').val(edit_model_id);
            $('#category_id').val(edit_category_id).trigger('change');
            $('#uniqNo').val(edit_uniq_no);
            $('#vendor').val(edit_vendor);
            $('#customer').val(edit_customer);

            // Auto Lock Mother Part on Edit
            $('#masterLock').prop('checked', true).trigger('change');

            listdetail();
        });

        $(document).on("click", ".close", function () {
            // Modal is being closed by clicking X or Close button
            // Bootstrap's 'hidden.bs.modal' will handle the actual clearing
            $('#myModal2').modal('hide');
        });

        // Robust clearing when modal is fully hidden
        $('#myModal2').on('hidden.bs.modal', function () {
            clear(true);
            list(); // Refresh main table
        });

        function clear(force = false) {
            var isLocked = $('#masterLock').is(':checked');
            if (!isLocked || force) {
                // Clear all mother part fields including hidden ID
                $("#id, #part_no, #part_name, #job_no, #model_id, #uniqNo, #vendor, #customer").val('');
                $("#category_id").val('').trigger('change');
                
                if (force) {
                    $('#masterLock').prop('checked', false).trigger('change');
                }
            }
            // Always clear child part fields
            $("#part_no2, #part_name2").val('');
            $("#alert").html('');
            
            // Force clear detail table
            if (force) {
                if ($.fn.DataTable.isDataTable('#example2')) {
                    $('#example2').DataTable().clear().draw();
                } else {
                    $("#example2 tbody").empty();
                }
            }
        }

        $(document).on("click", "#masterLock", function (e) {
            var isChecked = $(this).is(':checked');
            if (isChecked) {
                var required = {
                    "Part No": $("#part_no").val(),
                    "Uniq No": $("#uniqNo").val(),
                    "Part Name": $("#part_name").val(),
                    "Job No": $("#job_no").val(),
                    "Category": $("#category_id").val(),
                    "Customer": $("#customer").val(),
                    "Model": $("#model_id").val()
                };

                var missing = [];
                for (var key in required) {
                    if (!required[key] || required[key] === "") {
                        missing.push(key);
                    }
                }

                if (missing.length > 0) {
                    e.preventDefault();
                    $(this).prop('checked', false);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Information Missing',
                        text: 'You must fill in ' + missing.join(', ') + ' before you can lock the data.',
                        confirmButtonColor: '#3a86ff'
                    });
                    return false;
                }
            }
        });

        $(document).on("change", "#masterLock", function () {
            var isChecked = $(this).is(':checked');
            var targets = "#part_no, #part_name, #job_no, #model_id, #uniqNo, #vendor, #customer";
            var selects = "#category_id";

            $(targets).prop('readonly', isChecked);
            $(selects).prop('disabled', isChecked);

            // Toggle Warning icon & Visual feedback
            if (isChecked) {
                $("#lockWarning").removeClass('d-none');
                $(targets).closest('.input-group-glass').css('background-color', '#f8fafc');
                $(selects).closest('.input-group-glass').css('background-color', '#f8fafc');
            } else {
                $("#lockWarning").addClass('d-none');
                $(targets).closest('.input-group-glass').css('background-color', 'transparent');
                $(selects).closest('.input-group-glass').css('background-color', 'transparent');
            }

            // Save is always allowed (to add children while locked or new parts while unlocked)
            $(".Save").prop('disabled', false);
            
            // Update only allowed when UNLOCKED (so you can actually edit the fields)
            $(".Update").prop('disabled', isChecked);
        });

        $(document).on("click", ".Save", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('databom.store') }}",
                    data: {
                        part_no: $("#part_no").val(),
                        part_name: $("#part_name").val(),
                        job_no: $("#job_no").val(),
                        model_id: $("#model_id").val(),
                        part_no2: $("#part_no2").val(),
                        part_name2: $("#part_name2").val(),
                        category_id: $("#category_id").val(),
                        uniqNo: $("#uniqNo").val(),
                        vendor: $("#vendor").val(),
                        customer: $("#customer").val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        if (result.success) {
                            $("#alert").html(
                                '<div class="alert alert-glass-success"><i class="ph-bold ph-check-circle me-2"></i>' +
                                result.msg + '</div>');
                            listdetail();
                            $("#part_no2").val('');
                            $("#part_name2").val('');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 2000);
                        } else {
                            $("#alert").html(
                                '<div class="alert alert-glass-danger"><i class="ph-bold ph-warning-circle me-2"></i>' +
                                result.msg + '</div>');
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('databom.update') }}",
                    data: {
                        part_no: $("#part_no").val(),
                        part_name: $("#part_name").val(),
                        job_no: $("#job_no").val(),
                        model_id: $("#model_id").val(),
                        category_id: $("#category_id").val(),
                        uniqNo: $("#uniqNo").val(),
                        vendor: $("#vendor").val(),
                        customer: $("#customer").val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        if (result.success) {
                            $("#alert").html(
                                '<div class="alert alert-glass-success"><i class="ph-bold ph-check-circle me-2"></i>' +
                                result.msg + '</div>');
                            list();
                            setTimeout(() => {
                                $("#alert").hide();
                                $("#alert").html('');
                                $("#alert").show();
                            }, 2000);
                        } else {
                            $("#alert").html(
                                '<div class="alert alert-glass-danger"><i class="ph-bold ph-warning-circle me-2"></i>' +
                                result.msg + '</div>');
                        }
                    }
                });
            }
        });

        // Enable Import button when file is selected
        $(document).on("change", "#fileInput", function() {
            if (this.files && this.files.length > 0) {
                $("#importButton").prop('disabled', false);
                $(this).next('label').html('<i class="ph-bold ph-file-xls me-1"></i> ' + this.files[0].name);
            } else {
                $("#importButton").prop('disabled', true);
                $(this).next('label').html('<i class="ph-bold ph-upload-simple me-1"></i> Select File');
            }
        });

        // Handle Import Form Submission
        $(document).on("submit", "#importForm", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $("#importButton").prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Importing...');

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        list();
                        $("#fileInput").val('');
                        $("#fileInput").next('label').html('<i class="ph-bold ph-upload-simple me-1"></i> Select File');
                        $("#importButton").prop('disabled', true).html('<i class="ph-bold ph-arrow-circle-up me-1"></i> Import');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.msg
                        });
                        $("#importButton").prop('disabled', false).html('<i class="ph-bold ph-arrow-circle-up me-1"></i> Import');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred during import.'
                    });
                    $("#importButton").prop('disabled', false).html('<i class="ph-bold ph-arrow-circle-up me-1"></i> Import');
                }
            });
        });

        function validasi() {
            if ($("#part_no").val() == '' || $("#job_no").val() == '') {
                $("#alert").html(
                    '<div class="alert alert-glass-danger"><i class="ph-bold ph-warning-circle me-2"></i>Part No and Job No are required.</div>'
                );
                return false;
            }
            return true;
        }

        $(document).on("click", "#btn_delete_line", function () {
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
                        url: "{{ route('databom.destroyline') }}",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function (result) {
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

        $(document).on("click", "#btn_delete", function () {
            var part_no = $(this).data('part_no');
            var job_no = $(this).data('job_no');
            var customer = $(this).data('customer');
            Swal.fire({
                title: 'Delete entire BOM?',
                text: "All lines for this Part No, Job No, and Customer will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef476f',
                confirmButtonText: 'Yes, delete all!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('databom.destroy') }}",
                        data: {
                            part_no: part_no,
                            job_no: job_no,
                            customer: customer,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                list();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg
                                });
                            }
                        }
                    });
                }
            })
        });
    </script>
@endpush

@push('stylesheets')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f1f5f9;
            --card-bg: #ffffff;
            --glass-border: #e2e8f0;
            --primary-gradient: linear-gradient(135deg, #3a86ff 0%, #4361ee 100%);
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body) !important;
            color: var(--text-main);
        }

        .content-wrapper {
            background-color: transparent !important;
        }

        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .bg-primary-gradient {
            background: var(--primary-gradient);
        }

        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(58, 134, 255, 0.3);
            opacity: 0.9;
            color: white;
        }

        .btn-primary-gradient:disabled {
            background: #cbd5e1;
            box-shadow: none;
            transform: none;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-outline-light-glass {
            background: #ffffff;
            border: 1px solid var(--glass-border);
            color: var(--text-main) !important;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline-light-glass:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #000000 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Themed Buttons */
        .btn-indigo {
            background: #4f46e5;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-indigo:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .btn-amber {
            background: #f59e0b;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-amber:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            color: white;
        }

        .btn-emerald {
            background: #10b981;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-emerald:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-emerald:disabled {
            background: #a7f3d0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-excel {
            background: #1D6F42;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-excel:hover {
            background: #165633;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 111, 66, 0.3);
            color: white;
        }

        .custom-table {
            color: var(--text-main);
            border-collapse: separate;
            border-spacing: 0;
            width: 100% !important;
        }

        .custom-table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #cbd5e1;
            border-right: 1.5px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            padding: 15px 20px;
            color: var(--text-muted);
        }
        
        .custom-table thead th:last-child {
            border-right: none;
        }

        .custom-table tbody td {
            padding: 12px 20px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 0.85rem;
        }

        .custom-table tbody tr:hover {
            background: #f8fafc;
        }

        .border-end {
            border-right: 1.5px solid #cbd5e1 !important;
        }

        .border-start {
            border-left: 1px solid #f1f5f9 !important;
        }

        .fw-600 {
            font-weight: 600;
        }

        .badge-number {
            background: #f1f5f9;
            color: var(--text-muted);
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .btn-action-edit,
        .btn-action-delete {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-action-edit {
            background: rgba(58, 134, 255, 0.1);
            color: #3a86ff;
        }

        .btn-action-edit:hover {
            background: #3a86ff;
            color: white;
            transform: scale(1.1);
        }

        .btn-action-delete {
            background: rgba(239, 71, 111, 0.1);
            color: #ef476f;
        }

        .btn-action-delete:hover {
            background: #ef476f;
            color: white;
            transform: scale(1.1);
        }

        .dataTables_wrapper .dataTables_length {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .dataTables_wrapper .dataTables_length select {
            background: #ffffff !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 8px !important;
            color: var(--text-main) !important;
            padding: 4px 12px !important;
            margin: 0 8px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: #ffffff !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            color: var(--text-main) !important;
            padding: 8px 15px 8px 40px !important;
            width: 250px !important;
        }

        .custom-pagination .page-link {
            background: #ffffff;
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
            margin: 0 3px;
            border-radius: 8px !important;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border: none;
            color: white;
            box-shadow: 0 4px 10px rgba(58, 134, 255, 0.3);
        }

        .input-group-glass {
            background: #ffffff;
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            display: flex;
            transition: all 0.3s ease;
        }

        .input-group-glass:focus-within {
            border-color: #3a86ff;
            box-shadow: 0 0 0 4px rgba(58, 134, 255, 0.1);
            background: #ffffff;
        }

        .input-group-glass .form-control {
            background: transparent;
            border: none;
            color: var(--text-main);
            padding: 10px;
        }

        .input-group-glass .form-control:focus {
            box-shadow: none;
            outline: none;
        }

        .alert-glass-success {
            background: rgba(6, 214, 160, 0.1);
            border: 1px solid rgba(6, 214, 160, 0.2);
            color: #059669;
            border-radius: 12px;
        }

        .alert-glass-danger {
            background: rgba(239, 71, 111, 0.1);
            border: 1px solid rgba(239, 71, 111, 0.2);
            color: #dc2626;
            border-radius: 12px;
        }

        .text-white {
            color: var(--text-main) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .dashboard-title {
            letter-spacing: -0.02em;
            color: var(--text-main) !important;
        }

        .modal-header .btn-close {
            filter: none;
        }

        .breadcrumb-item.active {
            color: var(--text-muted) !important;
        }

        .btn-emerald {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }

        .btn-emerald:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .premium-stats-box {
            position: relative;
            background: #ffffff;
            border-radius: 12px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 140px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }

        .premium-stats-box:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .stats-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .premium-stats-box:hover .stats-glow {
            opacity: 1;
        }

        .stats-icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            position: relative;
            z-index: 1;
        }

        .sub-assy .stats-icon-wrapper {
            background: linear-gradient(135deg, #06d6a0 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(6, 214, 160, 0.3);
        }

        .direct .stats-icon-wrapper {
            background: linear-gradient(135deg, #ef476f 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(239, 71, 111, 0.3);
        }

        .stats-content {
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .stats-caption {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: -2px;
        }

        .stats-number {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.2;
        }

        .sub-assy .stats-number { color: #059669; }
        .direct .stats-number { color: #dc2626; }

        .stats-unit {
            font-size: 10px;
            font-weight: 600;
            color: #94a3b8;
            margin-left: 4px;
        }

        /* Pulse Animation */
        @keyframes stats-pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        .premium-stats-box:hover .stats-icon-wrapper i {
            animation: stats-pulse 1s infinite;
        }

        /* Center DataTables Processing */
        .dataTables_processing {
            position: absolute;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 999;
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
            padding: 20px !important;
            width: auto !important;
            margin: 0 !important;
            text-align: center;
            font-weight: 600;
            color: var(--text-main);
        }
        
        .dataTables_processing_custom {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .toolbar-divider {
            width: 1px;
            height: 30px;
            background: #e2e8f0;
        }

        .filter-wrapper {
            background: #f8fafc;
            border-color: #e2e8f0 !important;
            transition: all 0.3s ease;
        }

        .filter-wrapper:hover {
            border-color: var(--primary-light) !important;
            box-shadow: 0 4px 12px rgba(58, 134, 255, 0.1) !important;
        }
        
        .btn-emerald {
            background-color: #10b981;
            border: none;
            color: white;
        }
        .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
        .btn-emerald:disabled { background-color: #a7f3d0; color: #6ee7b7; cursor: not-allowed; }

        .bg-light-glass {
            background: rgba(248, 250, 252, 0.8);
            backdrop-filter: blur(4px);
        }
    </style>
@endpush