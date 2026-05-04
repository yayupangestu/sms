@extends('layouts.app')

@section('content')
    <style>
        .nav-tabs .nav-item .btn {
            border: none;
            padding: 5px 15px;
            margin: 0 5px;
            font-weight: 500;
            color: #ffffff;
            background-color: transparent;
            border-radius: 25px;
        }

        .card-body tbody tr:hover {
            background-color: #5055665d;
        }

        .nav-tabs .nav-item .btn.active {
            background-color: #f0f0f0;
            color: #000000;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-outline-secondary {
            border-radius: 25px;
            padding: 5px 15px;
            font-weight: 500;
        }

        /* Style Header Seperti CKEditor */
        .custom-header {
            background: linear-gradient(to bottom, #EDEDED, #DADADA);
            border: 1px solid #C0C0C0;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        /* Style Tombol Toolbar */
        .toolbar-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .toolbar-buttons button {
            background: #F8F8F8;
            border: 1px solid #B0B0B0;
            color: #333;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        .toolbar-buttons button:hover {
            background: #DADADA;
        }

        .toolbar-buttons .btn-active {
            background: #040404;
            color: white;
        }

        .file-import {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-import input {
            border: 1px solid #201e1e;
            padding: 5px;
        }

        .btn-icon {
            background: #F0F0F0;
            border: 1px solid #A0A0A0;
            padding: 5px 8px;
            font-size: 16px;
        }

        .btn-icon:hover {
            background: #DADADA;
        }
    </style>
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Tabel Stok Line store</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid" style="background-color: rgb(255, 255, 255)">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="custom-header">
                            <!-- Filter & Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center">
                                <ul class="nav nav-tabs flex-wrap">
                                    <li class="nav-item">
                                        <button style="color: #000000" class="btn btn-outline-info line-filter-btn" data-line-id="INHOUSE,OUTHOUSE">All</button>
                                    </li>
                                    <li class="nav-item">
                                        <button style="color: #000000" class="btn btn-info line-filter-btn" data-line-id="INHOUSE">INHOUSE</button>
                                    </li>
                                    <li class="nav-item">
                                        <button style="color:#000000" class="btn btn-info line-filter-btn" data-line-id="OUTHOUSE">OUTHOUSE</button>
                                    </li>
                                </ul>
                        
                                <!-- Form and Export Button aligned to the right -->
                                <div class="d-flex align-items-center ms-auto">
                                    <form id="importForm" action="{{ route('linestorestok.importLs') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0 me-2">
                                        @csrf
                                        <input type="file" id="fileInput" name="file" class="form-control me-2" style="width: auto;" required>
                                        <button id="importButton" class="btn-icon" type="submit" disabled>Import</button>
                                    </form>
                                    <button type="button" class="btn-icon" data-toggle="modal" data-target="#exportModal">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table  table-bordered table-striped">
                                    <thead style="background: linear-gradient(to bottom, #EDEDED, #DADADA); ">
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>category</th>
                                            <th>Job No</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <th>Costumer</th>
                                            <th>Model</th>
                                            <th>Minimal</th>
                                            <th>Qty / Kanban</th>
                                            <th>Actual</th>
                                            <th>Home Line</th>
                                            <th>Upload By</th>
                                            <th style="background-color: #0000002a">Time Upload</th>
                                            <th>Action</th>
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
        </div>
    </section>

    <!-- Export Filter Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="background-color: #adadad" class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="exportForm" action="{{ route('linestorestok.export') }}" method="GET">
                        <div class="form-group">
                            <select id="filterLine" name="line" class="form-control">
                                <option value="All">All</option>
                                <option value="INHOUSE">INHOUSE</option>
                                <option value="OUTHOUSE">OUTHOUSE</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="exportForm" class="btn btn-primary">Export</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom, #003366 52%, #006699 78%); color:white">
                    <h4 class="modal-title" id="title1">Tambah Item</h4>
                    <h4 class="modal-title" id="title2">Edit Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12" id="alert"></div>

                    <input type="hidden" id="id" class="form-control" required>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category:</label>
                                <input type="text" id="category" class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <label>Job No:</label>
                                <input type="text" id="job_no" class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <label>Part Name:</label>
                                <input type="text" id="part_name" class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <label>Part No:</label>
                                <input type="text" id="part_no" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Model:</label>
                                <input type="text" id="model" class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <label>Home Line:</label>
                                <input type="text" id="home_line" class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <label>Customer:</label>
                                <input type="text" id="customer" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Qty Minimal:</label>
                                <input type="text" id="qty_min" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Qty Actual:</label>
                                <input type="text" id="qty_actual" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Qty Kanban:</label>
                                <input type="text" id="qty_kanban" class="form-control form-control-sm" required>
                            </div>
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
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $('#exportModal').on('show.bs.modal', function(event) {
            // You can add additional logic here if needed when the modal is about to be shown
        });

        // Select all buttons with the 'line-filter-btn' class
        const buttons = document.querySelectorAll('.line-filter-btn');

        buttons.forEach(button => {
            // Add click event listener to each button
            button.addEventListener('click', function() {
                // Remove the 'active' class from all buttons
                buttons.forEach(btn => btn.classList.remove('active'));

                // Add 'active' class to the clicked button
                this.classList.add('active');
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


        function importData() {
            let formData = new FormData();
            formData.append('file', document.getElementById('fileInput').files[0]);

            $.ajax({
                url: "{{ route('linestorestok.importLs') }}", // Replace with your route name
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

        // Menambahkan event listener untuk konfirmasi sebelum mengirim formulir

        $(document).ready(function() {
            list(); // Inisialisasi DataTable tanpa filter

            // Event listener untuk tombol filter berdasarkan line
            $('.line-filter-btn').on('click', function() {
                var homeLine = $(this).data('line-id'); // Ambil nilai home_line dari data-line-id
                list(homeLine); // Panggil fungsi list dengan filter home_line
            });
        });

        // Fungsi untuk memuat ulang DataTable dengan filter home_line
        function list(homeLine = '') {
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
                    url: "{{ route('linestorestok.list') }}",
                    data: {
                        home_line: homeLine.split(',') // Ubah string home_line menjadi array jika ada koma
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
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'job_no',
                        name: 'job_no'
                    },
                    {
                        data: 'part_no',
                        name: 'part_no'
                    },
                    {
                        data: 'part_name',
                        name: 'part_name'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'qty_min',
                        name: 'qty_min'
                    },
                    {
                        data: 'qty_actual',
                        name: 'qty_actual'
                    },
                    {
                        data: 'qty_kanban',
                        name: 'qty_kanban'
                    },
                    {
                        data: 'home_line',
                        name: 'home_line'
                    },
                    {
                        data: 'createdby',
                        name: 'createdby'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return '<a href="#" id="btn_edit" title="Edit" data-id="' + data +
                                '" class="btn btn-warning btn-sm">' +
                                '<i class="fas fa-pencil-alt"></i>' +
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
                responsive: true,
                fixedColumns: true,
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                }
            });
        }



        $(document).on("click", "#btn_edit", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('linestorestok.edit') }}",
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
                        $('#category').val(result.category);
                        $('#job_no').val(result.job_no);
                        $('#part_name').val(result.part_name);
                        $('#part_no').val(result.part_no);
                        $('#customer').val(result.customer).trigger('change');
                        $('#model').val(result.model);
                        $('#qty_min').val(result.qty_min);
                        $('#qty_actual').val(result.qty_actual);
                        $('#qty_kanban').val(result.qty_kanban);
                        $('#home_line').val(result.home_line).trigger('change');
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
        });

        function clear() {
            $("#id").val('');
            $("#category").val('');
            $("#job_no").val('');
            $("#part_name").val('');
            $("#part_no").val('');
            $('#customer').val('').trigger('change');
            $('#model').val('').trigger('change');
            $("#qty_min").val('');
            $("#qty_actual").val('');
            $("#qty_kanban").val('');
            $('#home_line').val('').trigger('change');


        }

        $(document).on("click", ".Update", function() {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('linestorestok.update') }}",
                    data: {
                        id: id.value,
                        category: category.value,
                        job_no: job_no.value,
                        part_name: part_name.value,
                        part_name: part_name.value,
                        part_no: part_no.value,
                        customer: customer.value,
                        model: model.value,
                        qty_actual: qty_actual.value,
                        qty_kanban: qty_kanban.value,
                        qty_min: qty_min.value,
                        home_line: home_line.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            $('#myModal2').modal('hide');
                            SweetAlert.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            list();
                            clear();
                        } else {
                            SweetAlert.fire({
                                icon: 'error',
                                title: 'Error',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }
        });

        function validasi() {
            $("#alert").show();
            if (qty_actual.value != '') {
                return true;
            } else {
                $("#alert").html(
                    '<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
                setTimeout(() => {
                    $("#alert").hide();
                }, 1500);
            }
        }

        $(document).on("click", "#btn_delete", function() {
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
                        url: "{{ route('linestorestok.destroy') }}",
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
