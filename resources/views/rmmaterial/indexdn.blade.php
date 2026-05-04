@extends('layouts.app')

@section('content')
<style>
/* Modern Premium Styles */
:root {
    --primary-blue: #0284c7;  /* Smooth Blue */
    --light-blue: #e0f2fe;    /* Light Blue Backgrounds */
    --bg-white: #ffffff;
    --bg-gray-soft: #f8fafc;
    --border-gray: #e2e8f0;
    --text-main: #1e293b;
    --text-muted: #64748b;
}

.table-responsive {
    overflow-x: auto;
}

.table th, .table td {
    white-space: nowrap;
}

body, .content-wrapper, section.content {
    background-color: var(--bg-gray-soft) !important;
}

/* Card Styling */
.card-modern {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    background-color: var(--bg-white);
    margin-bottom: 24px;
}

.card-header-modern {
    background-color: var(--bg-white);
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-gray);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    border-radius: 16px 16px 0 0;
}

.card-title-modern {
    color: var(--primary-blue);
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Form controls above table */
.action-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
    background-color: var(--bg-gray-soft);
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid var(--border-gray);
}

.form-group-custom {
    display: flex;
    align-items: center;
    gap: 10px;
}

.input-modern {
    border: 1px solid var(--border-gray);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 14px;
    color: var(--text-main);
    background-color: var(--bg-white);
    transition: all 0.3s;
}

.input-modern:focus {
    border-color: var(--primary-blue);
    outline: none;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
}

.btn-modern {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    border: none;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-primary-custom {
    background-color: var(--primary-blue);
    color: white;
}
.btn-primary-custom:hover {
    background-color: #0369a1;
    color: white;
}

.btn-success-custom {
    background-color: #10b981;
    color: white;
}
.btn-success-custom:hover {
    background-color: #059669;
    color: white;
}
.btn-success-custom:disabled {
    background-color: #9ca3af;
    cursor: not-allowed;
}

/* Table Styling */
.table-modern-custom {
    width: 100%;
    margin-bottom: 0;
}

.table-modern-custom thead th {
    background-color: var(--light-blue);
    color: var(--primary-blue);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 13px;
    padding: 15px;
    border-top: none;
    border-bottom: 2px solid #bae6fd;
    text-align: center;
    vertical-align: middle;
}

.table-modern-custom tbody td {
    padding: 12px 15px;
    vertical-align: middle;
    text-align: center;
    border-bottom: 1px solid var(--border-gray);
    color: var(--text-main);
    font-size: 14px;
}

.table-modern-custom tbody tr:hover {
    background-color: var(--bg-gray-soft);
}

/* Modal Styling */
.modal-header-custom {
    background-color: var(--primary-blue);
    color: white;
    border-bottom: none;
    border-radius: 12px 12px 0 0;
}
.modal-header-custom .close {
    color: white;
    opacity: 0.8;
    text-shadow: none;
}
.modal-header-custom .close:hover {
    opacity: 1;
}

.content-header-title {
    color: var(--text-main);
    font-weight: 700;
    letter-spacing: -0.5px;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    padding: 0;
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 content-header-title">UPLOAD DN MATERIAL</h1>
      </div>
    </div>
  </div>
</div>

<section class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <div class="card card-modern">
                  <div class="card-header-modern">
                      <h3 class="card-title-modern">
                          <i class="fas fa-list-alt"></i> DN List
                      </h3>

                      <div class="action-container">
                          <!-- Download Template Button -->
                          <a href="{{ route('rmdnincoming.template') }}" class="btn-modern btn-success-custom" style="background-color: #10b981; text-decoration: none;">
                              <i class="fas fa-file-excel"></i> Template Excel
                          </a>

                          <!-- Divider line for visual separation -->
                          <div style="width: 1px; height: 35px; background-color: var(--border-gray); margin: 0 5px;" class="d-none d-md-block"></div>

                          <!-- Import Form -->
                          <form id="importForm" action="{{ route('importDn') }}" method="POST" enctype="multipart/form-data" class="form-group-custom m-0">
                              @csrf
                              <input type="file" id="fileInput" name="file" class="input-modern" required>
                              <button id="importButton" class="btn-modern btn-success-custom" type="submit" disabled>
                                  <i class="fas fa-file-import"></i> Import DN
                              </button>
                          </form>

                          <!-- Divider line for visual separation -->
                          <div style="width: 1px; height: 35px; background-color: var(--border-gray); margin: 0 5px;" class="d-none d-md-block"></div>

                          <!-- Export Form -->
                          <form action="{{ route('exportDn') }}" method="POST" class="form-group-custom m-0">
                              @csrf
                              <select name="year" class="input-modern" required>
                                  <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                                  <option value="{{ now()->subYear()->year }}">{{ now()->subYear()->year }}</option>
                              </select>
                              <select name="month" class="input-modern" required>
                                  <option value="1" {{ now()->month == 1 ? 'selected' : '' }}>January</option>
                                  <option value="2" {{ now()->month == 2 ? 'selected' : '' }}>February</option>
                                  <option value="3" {{ now()->month == 3 ? 'selected' : '' }}>March</option>
                                  <option value="4" {{ now()->month == 4 ? 'selected' : '' }}>April</option>
                                  <option value="5" {{ now()->month == 5 ? 'selected' : '' }}>May</option>
                                  <option value="6" {{ now()->month == 6 ? 'selected' : '' }}>June</option>
                                  <option value="7" {{ now()->month == 7 ? 'selected' : '' }}>July</option>
                                  <option value="8" {{ now()->month == 8 ? 'selected' : '' }}>August</option>
                                  <option value="9" {{ now()->month == 9 ? 'selected' : '' }}>September</option>
                                  <option value="10" {{ now()->month == 10 ? 'selected' : '' }}>October</option>
                                  <option value="11" {{ now()->month == 11 ? 'selected' : '' }}>November</option>
                                  <option value="12" {{ now()->month == 12 ? 'selected' : '' }}>December</option>
                              </select>
                              <button type="submit" class="btn-modern btn-primary-custom" id="exportButton">
                                  <i class="fas fa-file-export"></i> Export DN
                              </button>
                          </form>
                      </div>
                  </div>

                  <div class="card-body p-0">
                      <div class="table-responsive table-bordered">
                          <table id="example1" class="table table-hover table-modern-custom">
                              <thead>
                                  <tr>
                                      <th width="50">No</th>
                                      <th>Tanggal DN</th>
                                      <th width="150" class="text-center">Action</th>
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

<div class="modal fade" id="myModal2">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="modal-header modal-header-custom" >
          <h4 class="modal-title" id="title1" style="font-weight: 600;"><i class="fas fa-clipboard-list mr-2"></i> LIST ITEM DN</h4>
          <h4 class="modal-title" id="title2" style="font-weight: 600;"><i class="fas fa-clipboard-list mr-2"></i> LIST ITEM DN</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; border: none; background: transparent; font-size: 1.5rem;">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div id="alert" class="flex-grow-1 mr-3"></div>
                <div>
                    <button id="saveChanges" class="btn-modern btn-primary-custom px-4">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="example2" class="table table-hover table-bordered table-modern-custom">
                    <thead>
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
                            <th>Order Kg</th>
                            <th>Qty IN</th>
                            <th>No DN</th>
                            <th>Tg Delivery</th>
                            <th width="80" class="text-center">Action</th>
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
<input type="hidden" id="created_at">
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
                            data: 'created_at',
                            name: 'created_at',
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm">'+
                                    '<i class="fas fa-search"></i>'+
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
                            created_at: created_at.value,
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
                            data: 'delivery',
                            name: 'delivery'
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

    // Aktifkan tombol saat file dipilih
    document.getElementById('fileInput').addEventListener('change', function () {
        document.getElementById('importButton').disabled = !this.files.length;
    });

    // Konfirmasi sebelum submit form
    document.getElementById('importForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Cegah submit otomatis

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
                this.submit(); // Submit jika konfirmasi
            }
        });
    });

    // Tampilkan toast sukses jika ada session success
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    @endif

    // Tampilkan toast error jika ada session error
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
    @endif



        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var created_at = id;

            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#created_at').val(created_at);

            listdetail();
        });

        $(document).on("click", "#btn_delete", function () {
            var id = $(this).data('id');
            var created_at = id;
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
                    data: {created_at: created_at,  _token: '{{csrf_token()}}'},
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
</style>
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush









