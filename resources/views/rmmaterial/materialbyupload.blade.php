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
        <h1 class="m-0">DN INPUT</h1>
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
                  <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">Dn List</b></h3>
                  <div class="card-tools">
                    <form id="importForm" action="{{ route('importDn') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                        @csrf
                        <input type="file" id="fileInput" name="file" class="form-control me-2" style="width: auto;" required>
                        <button id="importButton" class="btn btn-success" type="submit" disabled>Import DN</button>
                    </form>
                </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-hover table-striped">
                    <thead class="table" style="background-color: #c0bcbcf8">
                        <tr>
                            <th width="50">No</th>
                            <th>No DN</th>
                            <th>No PO</th>
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
          <h4 class="modal-title" id="title1">LIST ITEM DN</h4>
          <h4 class="modal-title" id="title2">LIST ITEM DN</h4>
          <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>              
                <div class="col-sm-7"></div>
                    <div class="col-sm-7">
                        {{-- <button type="button" class="btn btn-success btn-sm Save">Insert</button> --}}
                        <button id="saveChanges" class="btn btn-primary">Save Changes</button>

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example2" class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Part No</th>
                            <th>Kanban</th>
                            <th>Model</th>
                            <th>Supplier</th>
                            <th>Spec</th>
                            <th>T</th>
                            <th>W</th>
                            <th>L</th>
                            <th>Order Sheet</th>
                            <th>Order Sheet</th> <!-- Periksa duplikasi ini -->
                            <th>Qty IN</th>
                            <th>No DN</th>
                            <th width="80">Action</th>
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
<input type="hidden" id="doc_dn">
<input type="hidden" id="doc_po">
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
                        url: "{{ route('rmdnincoming.list') }}"
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
                            data: 'doc_dn',
                            name: 'doc_dn'
                        },
                        {
                            data: 'doc_po',
                            name: 'doc_po'
                        },
                        {
                            data: 'doc_dn',
                            name: 'doc_dn',
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
                        url: "{{ route('rmdnincoming.listdetail') }}",
                        data: {
                            doc_dn: doc_dn.value,
                            doc_po: doc_po.value,
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
                            data: 'part_no',
                            name: 'part_no'
                        },
                        {
                            data: 'kanban',
                            name: 'kanban'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
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
                            data: 'order_sheet',
                            name: 'order_sheet'
                        },
                        {
                            data: 'order_kg',
                            name: 'order_kg'
                        },
                        {
                            data: 'actual_sheet',
                            name: 'actual_sheet',
                            render: function(data, type, row) {
                                let id = row.id;  // Assuming each row has a unique `id`
                                return `<input type="text" style="width:100px" class="form-control form-control-sm actual-sheet" 
                                        data-id="${id}" value="${data ? data : ''}" />`;
                            }
                        },
                        {
                            data: 'no_dn',
                            name: 'no_dn'
                        },
                        {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `
                                 <a href="#" id="btn_pdf" title="Generate" data-id="${data}" class="btn btn-info btn-sm">
                                <i class="fas fa-solid fa-qrcode"></i>
                                </a>
                            `;
                        }
                    },
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

                $(document).on('click', '#btn_pdf', function(e) {
            e.preventDefault();

            var doc_dn = $(this).data('id');
            var printUrl = "{{ route('rmdnincoming.cetak', ':doc_dn') }}".replace(':doc_dn', doc_dn);

            // For mobile compatibility, ensure window.open works correctly
            var newWindow = window.open(printUrl, '_blank');

            // If the browser blocks the new tab, this ensures it's opened
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                window.location.href = printUrl; // Fallback to open in the same window
            }
        });

        $('#saveChanges').on('click', function() {
            let dataToSend = [];

            $('.actual-sheet').each(function() {
                let actualSheet = $(this).val();
                let id = $(this).data('id');

                dataToSend.push({
                    id: id,
                    actual_sheet: actualSheet
                });
            });

    // Send the data to the server via AJAX
    $.ajax({
        url: "{{ route('rmdnincoming.update') }}", // Your update route here
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",  // Include CSRF token for security
            data: dataToSend
        },
        success: function(response) {
        // Handle success with SweetAlert
        Swal.fire({
            title: 'Sukses!',
            text: 'Data berhasil diperbarui.',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    },
    error: function(xhr, status, error) {
        // Handle error with SweetAlert
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat memperbarui data: ' + error,
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    }
});
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
            var doc_dn = id;
           
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#doc_dn').val(doc_dn);
        
            listdetail();
        });
       
        $(document).on("click", "#btn_delete", function () {
            var id = $(this).data('id');
            var doc_dn = id;
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
                    url: "{{route('rmdnincoming.destroy')}}",
                    data: {doc_dn: doc_dn,  _token: '{{csrf_token()}}'},
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
