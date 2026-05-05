@extends('layouts.app')

@section('content')
  <!-- Icon Libraries -->
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <style>
    :root {
      --primary-bg: #f1f5f9;
      --card-bg: #ffffff;
      --glass-bg: rgba(255, 255, 255, 0.7);
      --accent-blue: #0284c7;
      --accent-cyan: #0891b2;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --success: #059669;
      --warning: #d97706;
      --danger: #dc2626;
    }

    .content-wrapper {
      background-color: var(--primary-bg) !important;
      background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
      background-size: 24px 24px;
      color: var(--text-main);
    }

    /* Smooth Card */
    .card {
      background: var(--card-bg) !important;
      border: 1px solid var(--border-color);
      border-radius: 20px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
      margin-bottom: 2rem;
    }

    .card-header {
      background: transparent !important;
      border-bottom: 1px solid var(--border-color);
      padding: 1.5rem;
    }

    .card-title {
      font-size: 1.15rem;
      font-weight: 700;
      letter-spacing: -0.2px;
      color: var(--text-main);
    }

    /* Custom Status Bar (Orange - Cyan - Red) */
    .status-pill-bar {
      display: inline-flex;
      height: 14px;
      width: 100px;
      border-radius: 10px;
      overflow: hidden;
      background: #e2e8f0;
      vertical-align: middle;
    }

    .status-segment {
      height: 100%;
      flex-grow: 1;
    }

    .segment-orange {
      background: #f59e0b;
    }

    .segment-cyan {
      background: #06b6d4;
    }

    .segment-red {
      background: #ef4444;
    }

    /* Typography */
    h1,
    h3,
    h4,
    label {
      font-family: 'Inter', system-ui, sans-serif;
    }

    /* DataTables Refinement */
    .dataTables_wrapper {
      padding: 1rem;
      color: var(--text-main);
    }

    table.dataTable {
      border-collapse: collapse !important;
      border-spacing: 0 !important;
      border: 1px solid var(--border-color) !important;
      width: 100% !important;
    }

    table.dataTable thead th {
      background: #f8fafc !important;
      color: var(--text-muted);
      text-transform: uppercase;
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.8px;
      padding: 10px 12px !important;
      border: 1px solid var(--border-color) !important;
    }

    table.dataTable tbody tr {
      background: #ffffff !important;
      transition: background 0.2s ease;
    }

    .table-bordered {
      border: 1px solid var(--border-color) !important;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid var(--border-color) !important;
    }

    .table-hover tbody tr:hover {
      background-color: #f8fafc;
    }

    table.dataTable tbody tr:hover {
      background: #f1f5f9 !important;
    }

    table.dataTable tbody td {
      padding: 10px 12px !important;
      border: 1px solid var(--border-color) !important;
      vertical-align: middle !important;
      color: var(--text-main);
      font-size: 0.85rem;
    }

    /* Remove button shadows in tables for cleaner look */
    table .btn {
      box-shadow: none !important;
    }

    /* Form Elements */
    .form-control,
    .form-select {
      background: #ffffff !important;
      border: 1.5px solid var(--border-color) !important;
      border-radius: 10px !important;
      color: var(--text-main) !important;
      padding: 0.6rem 1rem !important;
      font-size: 0.9rem !important;
    }

    .form-control:focus {
      border-color: var(--accent-blue) !important;
      box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1) !important;
    }

    label {
      color: var(--text-main);
      font-weight: 600;
      font-size: 0.8rem;
      margin-bottom: 0.4rem;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    /* Buttons Modernization */
    .btn {
      border-radius: 12px;
      font-weight: 700;
      font-size: 0.8rem;
      padding: 0.6rem 1.25rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      border: none;
      letter-spacing: 0.2px;
    }

    .btn i {
      font-size: 1.1rem;
      display: inline-block !important;
      vertical-align: middle;
      line-height: 1;
    }

    /* Native Date Picker Helper */
    input[type="date"] {
      cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
      cursor: pointer;
    }

    /* Force icon visibility for ph and fa classes */
    .ph,
    .fa-solid,
    .fas,
    .fa {
      display: inline-block !important;
      line-height: 1;
      -webkit-font-smoothing: antialiased;
    }

    .btn-primary {
      background: #0284c7;
      color: white;
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
    }

    .btn-primary:hover {
      background: #0369a1;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(2, 132, 199, 0.3);
    }

    .btn-success {
      background: #10b981;
      color: white;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-success:hover {
      background: #059669;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-danger {
      background: #ef4444;
      color: white;
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .btn-danger:hover {
      background: #dc2626;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    .btn-warning {
      background: #f59e0b;
      color: white;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
    }

    .btn-warning:hover {
      background: #d97706;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    .btn-info {
      background: #06b6d4;
      color: white;
      box-shadow: 0 4px 12px rgba(6, 182, 212, 0.2);
    }

    .btn-info:hover {
      background: #0891b2;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(6, 182, 212, 0.3);
    }

    /* Square Icon Buttons */
    .btn-icon-square {
      width: 32px !important;
      height: 32px !important;
      padding: 0 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      border-radius: 8px !important;
    }

    .btn-icon-square i {
      font-size: 1.1rem !important;
      margin: 0 !important;
      color: #ffffff !important;
    }

    /* Action Buttons in Table */
    .btn-group .btn {
      border-radius: 0;
    }

    /* Select2 Custom Styling */
    .select2-container--default .select2-selection--single {
      border: 1.5px solid var(--border-color) !important;
      border-radius: 10px !important;
      height: 45px !important;
      padding-top: 8px !important;
      background-color: #ffffff !important;
      transition: all 0.2s ease;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
      border-color: var(--accent-blue) !important;
      box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 43px !important;
      right: 10px !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      padding-left: 1rem !important;
      color: var(--text-main) !important;
      font-size: 0.9rem !important;
    }

    .select2-dropdown {
      border: 1px solid var(--border-color) !important;
      border-radius: 12px !important;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
      overflow: hidden;
      margin-top: 5px;
    }

    /* Modal Styling */
    .modal-content {
      background: #ffffff !important;
      border: none;
      border-radius: 24px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
      border-bottom: 1px solid var(--border-color);
      padding: 1.75rem 2rem;
    }

    .modal-body {
      padding: 2rem;
    }

    .form-section {
      background: #f8fafc;
      padding: 1.5rem;
      border-radius: 16px;
      margin-bottom: 1.5rem;
      border: 1px solid var(--border-color);
    }

    .section-title {
      font-size: 0.7rem;
      font-weight: 800;
      color: var(--accent-blue);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-title::after {
      content: "";
      height: 1px;
      flex-grow: 1;
      background: var(--border-color);
    }

    /* Legend Item */
    .legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 500;
    }
  </style>

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <h1 class="m-0" style="font-weight: 800; letter-spacing: -0.5px;">
            Material <span style="color: var(--accent-cyan)">In</span>
          </h1>
          <p class="text-muted small">Warehouse management & material receipt logs</p>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center gap-4">
                <h3 class="card-title mb-0"><i class="ph-list-bold mr-2"></i> List Material Logs</h3>
                <div class="d-none d-md-flex gap-3 border-left pl-4"
                  style="border-color: var(--border-color) !important;">
                  <div class="legend-item">
                    <div class="status-pill-bar" style="width: 20px;">
                      <div class="status-segment segment-cyan"></div>
                    </div> Actual
                  </div>
                </div>
              </div>
              <div class="card-tools ml-auto">
                <button class="btn btn-primary" id="btn_add">
                  <i class="fa-solid fa-plus"></i> Add New Receipt
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table id="example1" class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th width="50">No</th>
                      <th>Doc DN</th>
                      <th>Date</th>
                      <th>Supplier</th>
                      <th width="120" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Dynamic Rows Here -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for Adding/Editing Material -->
    <div class="modal fade" id="myModal2">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <div class="d-flex align-items-center">
              <i class="ph-package-bold mr-3" style="font-size: 24px; color: var(--accent-cyan)"></i>
              <div>
                <h4 class="modal-title mb-0" id="title1">New Material Receipt</h4>
                <h4 class="modal-title mb-0" id="title2">Edit Material Receipt</h4>
                <span class="text-muted small">Fill in the material details below</span>
              </div>
            </div>
            <div class="ml-auto d-flex gap-2">
              <button class="btn btn-primary" id="btn_submit"><i class="fa-solid fa-floppy-disk"></i> Save Final</button>
              <!-- <button class="btn btn-danger" id="btn_cancel"><i class="fa-solid fa-circle-xmark"></i> Cancel</button> -->
              <button class="btn btn-light" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
          </div>
          <div class="modal-body">
            <div id="alert"></div>

            <div class="row">
              <!-- Left Column: Main Info -->
              <div class="col-lg-5">
                <div class="form-section">
                  <span class="section-title">Document Reference</span>
                  <div class="form-group">
                    <label>Document No (Auto)</label>
                    <input type="text" id="doc_no" class="form-control" readonly
                      style="font-weight: 700; color: var(--accent-blue) !important;">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Date Order</label>
                        <input type="date" id="date_plan" class="form-control">
                        <input type="hidden" id="id">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Date Delivery</label>
                        <input type="date" id="date_delivery" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-section">
                  <span class="section-title">Material Details</span>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group mb-3">
                        <label>Supplier Source</label>
                        <select id="suplai_id" class="form-control select2">
                          <option value="" selected>- Pilih Supplier -</option>
                          @foreach ($rm_supplier_nuts as $suplai)
                            <option value="{{ $suplai->id }}">{{ $suplai->name_suplai }} / {{$suplai->pt}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group mb-3">
                        <label>Material Name</label>
                        <select id="material_id" class="form-control select2">
                          <option value="" selected>- Pilih Material -</option>
                          @foreach ($rm_standart_nuts as $material)
                            <option value="{{ $material->id }}">{{ $material->part_nut }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Category</label>
                        <select id="category_id" class="form-control">
                          <option value="" selected>- Pilih -</option>
                          <option value="STD PART">STANDART PART</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" class="form-control" placeholder="...">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Qty Input</label>
                        <input type="number" id="qty_in" class="form-control text-center" placeholder="0"
                          style="border-color: var(--success) !important;">
                      </div>
                    </div>
                  </div>

                  <div class="mt-4 d-flex gap-2">
                    <button type="button" class="btn btn-success Save flex-grow-1">
                      <i class="fa-solid fa-circle-plus"></i> Insert Item to Receipt
                    </button>
                    <button type="button" class="btn btn-warning Update flex-grow-1" style="display:none">
                      <i class="fa-solid fa-pen-to-square"></i> Update Receipt Item
                    </button>
                  </div>
                </div>
              </div>

              <!-- Right Column: List of Items -->
              <div class="col-lg-7">
                <div class="form-section h-100"
                  style="background: #ffffff; border: 1.5px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="section-title mb-0">Items in Receipt</span>
                    <button id="print_selected" class="btn btn-info btn-sm">
                      <i class="fa-solid fa-print"></i> Print Selected
                    </button>
                  </div>
                  <div class="table-responsive">
                    <table id="example2" class="table table-sm table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Supplier</th>
                          <th>Material</th>
                          <th>IN</th>
                          <th class="text-center">Action</th>
                          <th class="text-center">Print</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Dynamic Rows Here -->
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

  </section>

  <div class="modal fade" id="modal_konfirmasi">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(195, 255, 249)">
          <h4 class="modal-title"><b>Are you sure you want to cancel the transaction?</b></h4>
        </div>
        <div class="modal-body" style="background-color: rgb(255, 255, 255)">
          <button class="btn btn-success btn-sm" id="btn_tidak">Yes</button>
          <button class="btn btn-warning btn-sm" id="btn_ya">No</button>
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
      $("#example1").show();
      list();

      // Initialize Select2 with Modal Support
      $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        dropdownParent: $('#myModal2')
      });
    });


    function getDoc() {
      var year = new Date().getFullYear();
      var month = ("0" + (new Date().getMonth() + 1)).slice(-2);
      var day = ("0" + new Date().getDate()).slice(-2);
      $.ajax({
        type: 'GET',
        url: "{{route('innut.getdoc')}}",
        cache: false,
        success: function (result) {
          $("#id").val('');
          // The server already returns the next available number in result.jml
          var nextNum = parseInt(result.jml);
          var sequence = nextNum < 10 ? "0" + nextNum : nextNum;
          $("#doc_no").val(year + "-" + month + day + sequence);
        }
      });
    }

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
          url: "{{ route('innut.list') }}"
        },
        columns: [{
          data: null,
          sortable: false,
          searchable: false,
          orderable: false,
          render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: 'doc_no',
          name: 'doc_no'
        },
        {

          data: 'date_plan',
          name: 'date_plan'
        },
        {
          data: 'suplai',
          name: 'suplai'
        },
        {
          data: 'doc_no',
          name: 'doc_no',
          render: function (data) {
            return '<div class="d-flex gap-2 justify-content-center">' +
              '<button id="btn_edit" title="Edit" data-id="' + data + '" class="btn btn-warning btn-icon-square"><i class="fa-solid fa-pen-to-square"></i></button>' +
              '<button id="btn_print" title="Print" data-id="' + data + '" class="btn btn-info btn-icon-square"><i class="fa-solid fa-print"></i></button>' +
              '<button id="btn_delete" title="Delete" data-id="' + data + '" class="btn btn-danger btn-icon-square"><i class="fa-solid fa-trash-can"></i></button>' +
              '</div>';
          }
        }
        ],
        columnDefs: [{
          "targets": [0, 4],
          "className": "text-center"
        }],
        order: [[1, "desc"]], // Newest doc_no at the top
        responsive: true,
        oLanguage: {
          sProcessing: '<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>'
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
        pageLength: 10,
        ajax: {
          url: "{{ route('innut.listdetail') }}",
          data: {
            doc_no: doc_no.value,
            date_plan: date_plan.value,
            suplai_id: suplai_id.value,
          }
        },
        columns: [
          {
            data: null,
            sortable: false,
            searchable: false,
            orderable: false,
            render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            data: 'suplai_id',
            name: 'suplai_id',
            render: function (data) {
              return `<div style="font-size: 0.85rem; font-weight: 500">${data}</div>`;
            }
          },
          {
            data: 'material_id',
            name: 'material_id',
            render: function (data, type, row) {
              return `<div style="font-weight: 600; color: var(--accent-cyan)">${data}</div>
                                                        <div class="small text-muted">${row.category_id}</div>`;
            }
          },
          {
            data: 'qty_in',
            name: 'qty_in',
            render: function (data) {
              return `<span class="badge" style="background: rgba(16, 185, 129, 0.2); color: var(--success); font-weight: 700">${data}</span>`;
            }
          },
          {
            data: 'id',
            name: 'id',
            render: function (data) {
              return `
                                  <div class="d-flex gap-2 justify-content-center">
                                    <button id="btn_edit_line" title="Edit" data-id="${data}" class="btn btn-warning btn-icon-square">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-icon-square">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                  </div>
                              `;
            }
          },
          {
            data: 'no',
            name: 'no',
            render: function (data, type, row) {
              return `
                                                  <div class="d-flex align-items-center justify-content-center gap-3">
                                                      <input type="checkbox" class="checkbox-row" value="${row.id}" style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--accent-blue)">
                                                      <a href="#" id="btn_pdf" title="QR Code" data-id="${row.id}" class="btn btn-info btn-icon-square">
                                                            <i class="fa-solid fa-qrcode"></i>
                                                      </a>
                                                  </div>
                                              `;
            },
            orderable: false,
            searchable: false
          }
        ],
        columnDefs: [{
          "targets": [0, 4, 5],
          "className": "text-center",
          "orderable": false
        }],
        order: [[5, "desc"]], // Newest item sequence (no) at the top
        responsive: true,
        oLanguage: {
          sProcessing: '<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>'
        }
      });
    }


    $(document).on('click', '#btn_pdf', function (e) {
      e.preventDefault();

      // Ambil data-id dari tombol yang diklik
      var id = $(this).data('id');

      // Bangun URL untuk mencetak PDF
      var printUrl = "{{ route('innut.cetak', ':id') }}".replace(':id', id);

      // Coba buka di tab baru
      var newWindow = window.open(printUrl, '_blank');

      // Fallback: jika tab baru diblokir oleh browser, buka di jendela saat ini
      if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
        window.location.href = printUrl;
      }
    });

    $('#print_selected').on('click', function () {
      // Ambil semua checkbox yang dipilih
      var selectedItems = [];
      $('.checkbox-row:checked').each(function () {
        selectedItems.push($(this).val());
      });

      if (selectedItems.length > 0) {
        // Kirimkan data ke backend untuk mencetak
        $.ajax({
          url: "{{ route('innut.printMultiple') }}", // Pastikan rute ini diatur di backend
          type: 'POST',
          data: {
            ids: selectedItems,
            _token: '{{ csrf_token() }}'
          },
          success: function (response) {
            // Handle success (misalnya: membuka PDF di tab baru)
            window.open(response.pdf_url, '_blank');
          },
          error: function (xhr) {
            alert('Terjadi kesalahan saat mencetak.');
          }
        });
      } else {
        alert('Pilih setidaknya satu item untuk dicetak.');
      }
    });

    $(document).on('click', '#btn_print', function (e) {
      e.preventDefault();

      var doc_no = $(this).data('id');
      var printUrl = "{{ route('innut.print', ':doc_no') }}".replace(':doc_no', doc_no);

      window.open(printUrl, '_blank'); // Membuka PDF di tab baru atau langsung mengunduhnya
    });

    $(document).on("click", "#btn_print", function () {
      var doc_no = $(this).data('id');
      var url = "{{ route('innut.print', ':doc_no') }}";
      url = url.replace(':doc_no', doc_no);
      window.open(url, '_blank');
    });


    $(document).on("click", "#btn_add", function () {
      clear(); // Clear first
      $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
      $("#title2").hide();
      $("#title1").show();
      $(".Save").show();
      $(".Update").hide();
      getDoc();
    });

    $(document).on("click", "#btn_edit", function () {
      $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
      $("#title1").hide();
      $("#title2").show();
      var doc_no = $(this).data('id');
      $.ajax({
        type: 'GET',
        url: "{{route('inmaterial.edit')}}",
        data: {
          doc_no: doc_no,
          _token: '{{csrf_token()}}'
        },
        success: function (result) {
          $('#doc_no').val(doc_no);
          $('#date_plan').val(result.date_plan);
          $('#suplai_id').val(result.suplai_id);
          listdetail();

        }
      });
      // getDoc();
    });


    $(document).on("click", ".close", function () {
      clear();
      $("#alert").html('');
      list();
      getDoc();
    });

    function clear() {
      // Clear all hidden and text inputs
      $("#id").val('');
      $('#doc_no').val('');
      $('#qty_in').val('');
      $('#keterangan').val('');

      // Clear date inputs
      $("#date_plan").val('');
      $("#date_delivery").val('');

      // Clear Select2 dropdowns
      $('#suplai_id').val(null).trigger('change');
      $('#category_id').val(null).trigger('change');
      $('#material_id').val(null).trigger('change');

      // Refresh the detail table to show an empty state
      listdetail();

      // Reset UI elements
      $("#alert").hide().html('');
      $(".Save").show();
      $(".Update").hide();
      $("#title1").show();
      $("#title2").hide();
    }

    $(document).on("click", ".Save", function () {
      $("#alert").html('');
      $("#alert").show();
      if (validasi()) {
        $.ajax({
          type: 'POST',
          url: "{{route('innut.store')}}",
          data: {
            doc_no: doc_no.value,
            date_plan: date_plan.value,
            suplai_id: suplai_id.value,
            category_id: category_id.value,
            material_id: material_id.value,
            qty_in: qty_in.value,
            keterangan: keterangan.value,
            date_delivery: date_delivery.value,
            _token: '{{csrf_token()}}'
          },
          success: function (result) {
            if (result.success) {
              $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + result.msg + '</div>');
              listdetail();
              $('#item_id').val('').trigger('change');
              $("#qty_in").val('');
              $("#keterangan").val('');
              $('#date_delivery').val('').trigger('change');
              setTimeout(() => { $("#alert").hide(); }, 1500);
            } else {
              $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + result.msg + '</div>');
              setTimeout(() => { $("#alert").hide(); }, 1500);
            }
          }
        });
      }
    });

    $(document).on("click", "#btn_edit_line", function () {
      $(".Save").hide();
      $("#title1").hide();
      $(".Update").show();
      $("#title2").show();
      var id = $(this).data('id');
      $.ajax({
        type: 'GET',
        url: "{{route('innut.edit')}}",
        data: {
          id: id,
          _token: '{{csrf_token()}}'
        },
        success: function (result) {
          if (result.success) {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#id').val(result.id);
            $('#date_plan').val(result.date_plan).trigger('change');
            $('#suplai_id').val(result.suplai_id).trigger('change');
            $('#material_id').val(result.material_id).trigger('change');
            $('#qty_in').val(result.qty_in).trigger('change');
            $('#category_id').val(result.category_id).trigger('change');
            $('#keterangan').val(result.keterangan).trigger('change');
            $('#date_delivery').val(result.date_delivery).trigger('change');
          } else {
            SweetAlert.fire({
              icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 1500
            });
          }
        }
      });
    });

    $(document).on("click", ".Update", function () {
      if (validasi()) {
        $.ajax({
          type: 'POST',
          url: "{{route('innut.update')}}",
          data: {
            id: id.value,
            date_plan: date_plan.value,
            suplai_id: suplai_id.value,
            material_id: material_id.value,
            qty_in: qty_in.value,
            category_id: category_id.value,
            keterangan: keterangan.value,
            date_delivery: date_delivery.value,
            _token: '{{csrf_token()}}'
          },
          success: function (result) {
            if (result.success) {
              SweetAlert.fire({
                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
              });

              listdetail();
              $('#material_id').val('').trigger('change');
              $("#qty_in").val('');
              $("#category_id").val('').trigger('change');
              $('#keterangan').val('').trigger('change');
              $('#date_delivery').val('').trigger('change');
              setTimeout(() => { $("#alert").hide(); }, 150);
            } else {
              SweetAlert.fire({
                icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 2500
              });
            }
          }
        });
      }
    });

    function updt_submit() {
      $("#alert").html('');
      $("#alert").show();
      $.ajax({
        type: 'POST',
        url: "{{route('innut.submit')}}",
        data: {
          doc_no: doc_no.value,
          _token: '{{csrf_token()}}'
        },
        success: function (result) {
          if (result.success) {
            $('#modal_header').modal('hide');
            SweetAlert.fire({
              icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
            });
            list();
            setTimeout(() => { location.reload(); }, 1500); // Reload after showing success message
          } else {
            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + result.msg + '</div>');
            setTimeout(() => { $("#alert").hide(); }, 1500);
          }
        }
      });
    }

    $(document).on("click", "#btn_submit", function () {
      updt_submit();
    });

    $(document).on("click", "#btn_cancel", function () {
      $('#modal_konfirmasi').modal({ backdrop: 'static', keyboard: false, show: true });
    });

    $(document).on("click", "#btn_tidak", function () {
      $('#modal_konfirmasi').modal('hide');
      $('#modal_header').modal('hide');
      delete_draft()
    });

    $(document).on("click", "#btn_ya", function () {
      $('#modal_konfirmasi').modal('hide');
      updt_submit();
    });

    function delete_draft() {
      $.ajax({
        type: 'POST',
        url: "{{route('innut.delete_draft')}}",
        data: {
          doc_no: doc_no.value,
          _token: '{{csrf_token()}}'
        },
        success: function (result) {
          //
        }
      });
    }

    function validasi() {
      $("#alert").show();
      if (date_plan.value != '' && suplai_id.value != '' && material_id.value != '') {
        return true;
      } else {
        $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>All Column Cannot be Empty.</div>');


        setTimeout(() => { $("#alert").hide(); }, 2000);
      }
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
            url: "{{route('innut.destroyline')}}",
            data: { id: id, _token: '{{csrf_token()}}' },
            dataType: 'json',
            success: function (result) {
              if (result.success) {
                SweetAlert.fire({
                  icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                });
              } else {
                SweetAlert.fire({
                  icon: 'error', title: 'Error', text: result.msg, showConfirmButton: false, timer: 1500
                });
              }
              listdetail();

            }
          });
        }
      })
    });
    $(document).on("click", "#btn_delete", function () {
      var doc_no = $(this).data('id');
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
            url: "{{ route('innut.destroy') }}",
            data: {
              doc_no: doc_no,
              _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.msg,
                  showConfirmButton: false,
                  timer: 1500
                });
                // Refresh the list or update the view as needed
                list();
                getDoc();
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.msg,
                  showConfirmButton: false,
                  timer: 1500
                });
              }
            }
          });
        }
      });
    });


  </script>
@endpush

@push('stylesheets')
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush