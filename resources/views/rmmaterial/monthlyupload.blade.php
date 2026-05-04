@extends('layouts.app')

@section('content')
<style>
.table-responsive {
    overflow-x: auto; /* Memungkinkan scroll horizontal */
}

.table th, .table td {
    white-space: nowrap; /* Mencegah teks dibungkus untuk kolom tertentu */
}

/* Tambahan untuk kolom-kolom yang sangat lebar */
.table td {
    padding: 8px; /* Mengatur padding untuk sel */
}

@media (max-width: 768px) {
    .table th, .table td {
        font-size: 12px; /* Mengurangi ukuran font pada perangkat kecil */
    }
}

   .breadcrumb {
       display: flex;
       list-style: none;
       padding: 0;
       margin: 0;
   }
   .breadcrumb li {
       display: flex;
       align-items: center;
       padding: 10px 20px;
       border: 1px solid #ffffff;
       border-right: none;
       background-color: #f9f9f9;
       color: #ffffff;
       position: relative;
   }
   .breadcrumb li:last-child {
       border-right: 1px solid #ffffff;
   }
   .breadcrumb li::after {
       content: '';
       position: absolute;
       top: 0;
       right: -10px;
       width: 0;
       height: 0;
       border-top: 20px solid transparent;
       border-bottom: 20px solid transparent;
       border-left: 10px solid #6e6e6e52;
       z-index: 1;
   }
   .breadcrumb li::before {
       content: '';
       position: absolute;
       top: 0;
       right: -11px;
       width: 0;
       height: 0;
       border-top: 20px solid transparent;
       border-bottom: 20px solid transparent;
       border-left: 10px solid #ddd;
       z-index: 0;
   }
   .btn-secondary:hover {
   background-color: #2f6081;
   border-color: #122d3f2e;
}
   .breadcrumb li.active {
       background-color: #15508fad;
       color: white;
   }
   .breadcrumb li.active::after {
       border-left-color: #00ff11;
   }
   .breadcrumb li.active::before {
       border-left-color: #0056b3;
   }
   .breadcrumb li.unassigned {
       background-color: #f8d7da;
       color: #721c24;
   }
   .breadcrumb li.unassigned::after {
       border-left-color: #f8d7da;
   }
   .breadcrumb li.unassigned::before {
       border-left-color: #f5c6cb;
   }
   .breadcrumb li i {
       margin-left: 10px;
   }
.card {
   border-radius: 10px;
   box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
}

.table th, .table td {
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
   background-color: #adadad96;
}

.table tbody td {
   text-align: center;
   border-color: #e3dfdf;
}

.btn-edit {
   background-color: #ede434;
   border-color: #245a7e;
}

.btn-info {
   background-color: #245a7e;
   border-color: #245a7e;
}

.btn-info:hover {
   background-color: #92d2fd;
   border-color: #122d3f;
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Monthly Planning Material</h1>
      </div>
      <div class="col-sm-6">
      </div>
    </div>
  </div>
</div>

<section class="content" style="background-color: rgb(130, 129, 129)">
    {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header" style="background-color: #245a7e">
                  <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">Import PO Material</b></h3>
                  <div class="card-tools">
                    <form id="importForm" action="{{ route('rmmonthly.importMonthly') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                        @csrf
                        <input type="file" id="fileInput" name="file" class="form-control me-2" style="width: auto;" required>
                        <button id="importButton" class="btn btn-success" type="submit" disabled>Import PO Material</button>
                    </form>
                </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-hover table-striped">
                    <thead class="table" style="background-color: #c0bcbcf8">
                        <tr>
                            <th width="50">No</th>
                            <th>PERIODE</th>
                            <th>Tahun</th>
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

<div class="modal fade" id="myModal2">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #245a7e; color:white" >
          <h4 class="modal-title" id="title1">LIST ITEM PO</h4>
          <h4 class="modal-title" id="title2">LIST ITEM PO</h4>
          <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>              
                <div class="col-sm-7"></div>
                    <div class="col-sm-7">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example2" class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>PO NO</th>
                            <th>Periode</th>
                            <th>Tahun</th>
                            <th>Part No</th>
                            <th>Kanban</th>
                            <th>Spec</th>
                            <th>T</th>
                            <th>W</th>
                            <th>L</th>
                            <th>PO Sheet</th>
                            <th>PO KG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data tabel akan diisi di sini -->
                    </tbody>
                </table>
            </div>
            
        </div>
      </div>
    </div>
</div>
<input type="hidden" id="month">
<input type="hidden" id="year">

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
                    pageLength: 10,
                    ajax: {
                        url: "{{ route('rmmonthly.list') }}"
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
                            data: 'month',
                            name: 'month'
                        },
                        {
                            data: 'year',
                            name: 'year'
                        },
                        {
                            data: 'month',
                            name: 'month',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm">'+
                                    '<i class="fas fa-search"></i>'+
                                    '</a>'+
                                    '<a href="#" id="btn_delete" title="Delete" data-id="'+data+'" class="btn btn-danger btn-sm ml-1">'+
                                        '<i class="far fa-trash-alt"></i>'+
                                        '</a>';
                                        // '<a href="/edit?id='+data+'" title="Edit" class="btn btn-info btn-sm">'+
                                        //     '<i class="fas fa-search"></i>'+
                                        // '</a>'+
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

        function listdetail(){
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
                        url: "{{ route('rmmonthly.listdetail') }}",
                        data: {
                            month: month.value,
                            year: year.value,
                           
                        }
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
                            data: 'po_no',
                            name: 'po_no'
                        },
                        {
                            data: 'month',
                            name: 'month'
                        },
                        {
                            data: 'year',
                            name: 'year'
                        },
                        {
                            data: 'part_no',
                            name: 'part_no'
                        },
                        {
                            data: 'kanban',
                            name: 'kanban'
                        },
                        {
                            data: 'spec',
                            name: 'spec'
                        },
                        {
                            data: 'spec_t',
                            name: 'spec_t'
                        },
                        {
                            data: 'spec_w',
                            name: 'spec_w'
                        },
                        {
                            data: 'spec_l',
                            name: 'spec_l'
                        },
                        {
                            data: 'po_sheet',
                            name: 'po_sheet'
                        },
                        {
                            data: 'po_kg',
                            name: 'po_kg'
                        }
                    ],

                    rowCallback: function(row, data, index) {
        // Kondisi untuk kolom order_sheet
                        if (data.order_sheet) {
                            $('td:eq(9)', row).css('background-color', '#ffeb3b'); 
                            $('td:eq(1)', row).css('background-color', '#ffeb3b');
                            // Mengubah index sesuai urutan kolom, 4 adalah contoh
                        }
                    },
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

    // Menambahkan event listener untuk konfirmasi sebelum mengirim formulir
    document.getElementById('importForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman formulir default
        
        // Tampilkan SweetAlert konfirmasi
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengimpor DN?',
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
        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var month = id;
           
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#month').val(month);
        
            listdetail();
        });
       
    </script>
@endpush

@push('stylesheets')
<style>
    .centered-text {
      text-align: center;
  }
  
  
  tr:nth-child(even) {
    background-color:   
    #efefeff8
  
  ;
  }

  </style>
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
