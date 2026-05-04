@extends('layouts.app')

@section('content')
<style>
    /* ===== Container & Section ===== */
    section.content {
        background-color: #f5f6f7; /* abu-abu muda netral */
        padding: 15px;
    }

    .container-fluid {
        background-color: transparent;
    }

    /* ===== Card ===== */
    .card {
        border-radius: 8px;
        border: none;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    /* ===== Card Header ===== */
    .card-header {
        background-color: #fff !important;
        border-bottom: 1px solid #e0e0e0;
        padding: 12px 15px;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }

    .card-title i {
        color: #5c6bc0; /* Biru SAP-style */
        margin-right: 8px;
    }

    /* ===== Table ===== */
  /* ===== Full Table Grid Style (SAP-like) ===== */
table.table {
    border-collapse: collapse; /* menyatukan border jadi grid */
    width: 100%;
    background-color: #fff;
    font-size: 13px; /* kecil tapi tetap terbaca */
    line-height: 1.4;
    border: 1px solid #ccc; /* border luar tabel */
}

/* Header */
table.table thead {
    background-color: #f1f3f4; /* abu muda header */
}

table.table thead th {
    border: 1px solid #ccc; /* garis grid */
    padding: 6px 8px; /* kecilkan padding */
    text-align: center;
    font-weight: 600;
    color: #295b8c;
    white-space: nowrap;
}

/* Body */
table.table tbody td {
    border: 1px solid #ccc; /* garis grid */
    padding: 5px 8px; /* kecilkan padding */
    vertical-align: middle;
    color: #333;
}

/* Hover effect */
table.table tbody tr:hover {
    background-color: #e6f0ff; /* highlight ringan */
}

/* Responsive text kecil */
@media (max-width: 768px) {
    table.table {
        font-size: 12px;
    }
}

    /* ===== Buttons ===== */
    .btn {
        border-radius: 6px;
        font-size: 13px;
        padding: 5px 10px;
    }

    /* ===== Form Controls ===== */
    .form-control {
        font-size: 13px;
        height: 34px;
    }

    input[type="file"] {
        padding: 3px;
        font-size: 13px;
    }

    #example1 th {
        font-weight: 600;
        color: #295b8c;
        border-bottom: 2px solid #dee2e6;
    }

    #example1 td {
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    #example1 tbody tr:hover {
        background-color: #82a8cf;
        cursor: pointer;
    }

    .card {
        border-radius: 8px;
        overflow: hidden;
    }

    .btn-sm {
        border-radius: 6px;
    }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">TABEL STOK SUBCONT</h1>
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
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background: linear-gradient(90deg, #f8f9fa, #e9ecef); border-bottom: 2px solid #dee2e6;">
                        <h3 class="card-title mb-0" style="font-weight: 600; color: #495057;">
                            <i class="fas fa-border-none me-2"></i>
                            DATA PART NO SUBCONT
                        </h3>
                        <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center mt-2 mt-md-0">
                            <form id="importForm" action="{{ route('tabelstoksbc.importSbc') }}" method="POST"
                                enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                                @csrf
                                <input type="file" id="fileInput" name="file" class="form-control form-control-sm me-2"
                                    style="width: auto; border-radius: 6px;" required>
                                <button id="importButton" class="btn btn-outline-primary btn-sm" type="submit" disabled>
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </form>
                          <!-- Tombol untuk membuka modal -->
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModal">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                        </div>                
                    </div>
                    <div class="card-body p-0">
                        <table id="example1" class="table table-hover table-striped align-middle mb-0">
                            <thead style="background-color: #f1f3f5;">
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th class="text-center">Part Name</th>
                                    <th class="text-center">Part No</th>
                                    <th class="text-center">Part No CS</th>
                                    <th class="text-center">Job No</th>
                                    <th class="text-center">Model</th>
                                    <th class="text-center">Costumer</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Qty / Kanban</th>
                                    <th class="text-center">Qty LS</th>
                                    <th class="text-center">Qty Preperation</th>
                                    <th width="80" class="text-center">Action</th>
                                </tr>
                            </thead>                    
                            <tbody>
                                <!-- Data akan di-load di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content shadow-sm border-0 rounded-3">

            <!-- Header -->
            <div class="modal-header bg-secondary text-white py-2 rounded-top">
                <h6 class="modal-title fw-bold" id="myModalLabel">Export Data</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center p-3">
                <p class="mb-3 text-muted small">Pilih jenis download yang Anda inginkan:</p>
                
                <a href="{{ route('formatsbc.export') }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                    <i class="fas fa-download me-1"></i> Download Format
                </a>
                
                <a href="{{ route('datatabelstoksbc.export') }}" class="btn btn-outline-primary btn-sm w-100 mb-3">
                    <i class="fas fa-download me-1"></i> Download Data
                </a>

                <!-- Close Button in Body -->
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="title1">Add Line</h4>
          <h4 class="modal-title" id="title2">Edit Line</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>
                <label class="col-sm-3 col-form-label">Name :</label>
                <div class="col-sm-9">
                    <input type="hidden" id="id" class="form-control" required>
                    <input type="text" id="nama" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">Description :</label>
                <div class="col-sm-9">
                    <input type="text" id="description" class="form-control form-control-sm" required>
                </div>

            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-primary Update">Update</button>
            <button type="button" class="btn btn-primary Save">Save</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            list();
        });

        function list(){
            var table = $('#example1').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 20,
                    ajax: {
                        url: "{{ route('tabelstoksbc.list') }}"
                    },
                    columns: [{
                            data: null,
                            sortable: false,
                            searchable: false,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'part_name',
                            name: 'part_name'
                        },
                        {
                            data: 'part_no',
                            name: 'part_no'
                        },
                        {
                            data: 'part_no2',
                            name: 'part_no2'
                        },
                        {
                            data: 'job_no',
                            name: 'job_no'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'customer',
                            name: 'customer'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
                        },
                        {
                            data: 'qty_kanban',
                            name: 'qty_kanban'
                        },
                        {
                            data: 'qty_act_ls',
                            name: 'qty_act_ls'
                        },
                        {
                            data: 'qty_act_prepare',
                            name: 'qty_act_prepare'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-warning btn-sm">'+
                                            '<i class="fas fa-pencil-alt"></i>'+
                                        '</a>'+
                                        '<a href="#" id="btn_delete" title="Delete" data-id="'+data+'" class="btn btn-danger btn-sm ml-1">'+
                                            '<i class="far fa-trash-alt"></i>'+
                                        '</a>';
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
                        sProcessing: '<img src="{{asset('dist/img/Hourglass.gif')}}">Loading . . .'
                    }
            });
        }

        $(document).on("click", "#btn_add", function () {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $(".Update").hide();
            $("#title2").hide();
            $(".Save").show();
            $("#title1").show();
        });

        $(document).on("click", "#btn_edit", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('tabelstoksbc.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#nama').val(result.name);
                        $('#description').val(result.description);
                    }else{
                        SweetAlert.fire({
                            icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 1500
                        });
                    }
                }
                });
        });

        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
        });

        function clear(){
            $("#id").val('');
            $("#nama").val('');
            $("#description").val('');
            $("#machine").val('');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('tabelstoksbc.store')}}",
                    data: {
                            nama: nama.value,
                            description: description.value,

                            _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> '+result.msg+'</div>');
                            list();
                            clear();
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }else{
                            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+result.msg+'</div>');
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function () {
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('tabelstoksbc.update')}}",
                    data: {
                            id: id.value,
                            nama: nama.value,
                            description: description.value,
                            _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $('#myModal2').modal('hide');
                            SweetAlert.fire({
                                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                            list();
                            clear();
                        }else{
                            SweetAlert.fire({
                                icon: 'error', title: 'Error', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }
                    }
                });
            }
        });

        function validasi(){
            $("#alert").show();
            if(nama.value != ''){
                return true;
            }else{
                $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>column name cannot be empty.</div>');
                setTimeout(() => { $("#alert").hide(); }, 1500);
            }
        }

        $(document).on("click", "#btn_delete", function () {
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
                    url: "{{route('tabelstoksbc.destroy')}}",
                    data: {id: id, _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(result) {
                        if(result.success){
                            SweetAlert.fire({
                            icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }else{
                            SweetAlert.fire({
                            icon: 'error', title: 'Error', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }
                        list();
                    }
                });
                }
            })
        });

         // Menyimpan referensi ke elemen
         const fileInput = document.getElementById('fileInput');
        const importButton = document.getElementById('importButton');
        // Menonaktifkan tombol jika tidak ada file yang dipilih
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                importButton.disabled = false; // Aktifkan tombol jika ada file yang dipilih
            } else {
                importButton.disabled = true; // Nonaktifkan tombol jika tidak ada file
            }
        });

        document.getElementById('importForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir default

            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengimpor Data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, impor!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Kirim formulir jika pengguna mengonfirmasi
                }
            });
        });

        function importData() {
            let formData = new FormData();
            formData.append('file', document.getElementById('fileInput').files[0]);

            $.ajax({
                url: "{{ route('tabelstoksbc.importSbc') }}", // Replace with your route name
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response); // Add this line
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },

                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengimpor data.'
                    });
                }
            });
        }
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
