@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Data LINE BLANK</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid" style="background-color: rgb(219, 215, 215)">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: rgb(255, 255, 202)">
                            <h3 class="card-title">
                                <i class="fas fa-border-none"></i>
                                Data BLANK
                            </h3>
                            <div
                                class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center mt-2 mt-md-0">
                                <input type="text" class="form-control" placeholder="Search"
                                    style="width: 150px; margin-right: 10px;">
                                <form id="importForm" action="{{ route('datablank.importDp') }}" method="POST"
                                    enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                                    @csrf
                                    <input type="file" id="fileInput" name="file" class="form-control me-2"
                                        style="width: auto;" required>
                                    <button id="importButton" class="btn btn-outline-secondary" type="submit"
                                        disabled>Import</button>
                                </form>
                                <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                    data-target="#exportModal">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead style="background-color: rgb(252, 252, 177)">
                                    <tr>
                                        <th width="50">No</th>
                                        <th class="text-center">Name Part</th>
                                        <th class="text-center">Part No (/)</th>
                                        <th class="text-center">Part No</th>
                                        <th class="text-center">Model</th>
                                        <th class="text-center">spek</th>
                                        <th class="text-center">T</th>
                                        <th class="text-center">W</th>
                                        <th class="text-center">L</th>
                                        <th class="text-center">Home Line</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title1">Add Data datablank</h4>
                    <h4 class="modal-title" id="title2">Edit Data datablank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-3 col-form-label">Name datablank:</label>
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
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            list();
        });

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
                    url: "{{ route('datablank.list') }}"
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
                        data: 'model_id',
                        name: 'model_id'
                    },
                    {
                        data: 'spek',
                        name: 'spek'
                    },
                    {
                        data: 'spek_t',
                        name: 'spek_t'
                    },
                    {
                        data: 'spek_w',
                        name: 'spek_w'
                    },
                    {
                        data: 'spek_l',
                        name: 'spek_l'
                    },
                    {
                        data: 'home_line',
                        name: 'home_line'
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

        $(document).on("click", "#btn_add", function() {
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $(".Update").hide();
            $("#title2").hide();
            $(".Save").show();
            $("#title1").show();
        });

        $(document).on("click", "#btn_edit", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('datablank.edit') }}",
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
                        $('#nama').val(result.name);
                        $('#description').val(result.description);
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
            $("#nama").val('');
            $("#description").val('');
            $("#machine").val('');
        }

        $(document).on("click", ".Save", function() {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('datablank.store') }}",
                    data: {
                        nama: nama.value,
                        description: description.value,

                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#alert").html(
                                '<div class="alert alert-success"><i class="fa fa-check"></i> ' +
                                result.msg + '</div>');
                            list();
                            clear();
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
                    url: "{{ route('datablank.update') }}",
                    data: {
                        id: id.value,
                        nama: nama.value,
                        description: description.value,
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
                url: "{{ route('datablank.importDp') }}", // Replace with your route name
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


        function validasi() {
            $("#alert").show();
            if (nama.value != '') {
                return true;
            } else {
                $("#alert").html(
                    '<div class="alert alert-danger"><i class="fa fa-warning"></i>column name cannot be empty.</div>');
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
                        url: "{{ route('datablank.destroy') }}",
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
