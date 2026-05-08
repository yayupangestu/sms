@extends('layouts.app')

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <style>
        /* Professional Smooth White Theme for Content Area */
        .content-wrapper {
            background-color: #f8fafc !important;
        }

        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            background-color: #ffffff !important;
            margin-bottom: 2rem !important;
        }

        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.25rem 1.5rem !important;
        }

        .card-title {
            font-weight: 700 !important;
            color: #1e293b !important;
            font-size: 1.1rem !important;
        }

        /* Table Styling */
        .table {
            margin-bottom: 0 !important;
        }

        .table thead th {
            background-color: #1e293b !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            font-size: 12px !important;
            letter-spacing: 0.5px;
            border: none !important;
            padding: 1rem 1.5rem !important;
        }

        .table tbody td {
            padding: 1rem 1.5rem !important;
            vertical-align: middle !important;
            color: #475569 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 14px !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* Button Styling */
        .btn-sm {
            padding: 0.5rem 0.75rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
        }

        .btn-primary {
            background-color: #2563eb !important;
            border: none !important;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2) !important;
        }

        .btn-primary:hover {
            background-color: #1d4ed8 !important;
            transform: translateY(-1px);
        }

        .btn-warning {
            background-color: #f59e0b !important;
            border: none !important;
            color: #ffffff !important;
        }

        .btn-danger {
            background-color: #ef4444 !important;
            border: none !important;
        }

        /* Modal Styling */
        .modal-content {
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }

        .modal-header {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.5rem !important;
        }

        .modal-title {
            font-weight: 700 !important;
            color: #1e293b !important;
        }

        .modal-footer {
            border-top: 1px solid #f1f5f9 !important;
            padding: 1.5rem !important;
        }

        .form-control-sm {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0.6rem 0.75rem !important;
            height: auto !important;
        }

        .form-control-sm:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        label {
            font-weight: 600 !important;
            color: #64748b !important;
            font-size: 13px !important;
            margin-bottom: 0.5rem !important;
        }
    </style>
@endpush

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="color: #1e293b; letter-spacing: -0.5px;">Manage Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h3 class="card-title"><i class="ph-duotone ph-list-bullets mr-2"></i> Category List</h3>
                            <div class="card-tools ml-auto">
                                <button class="btn btn-primary btn-sm" id="btn_add">
                                    <i class="ph-bold ph-plus-circle mr-1"></i> Add New Category
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="example1" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50" class="text-center">No</th>
                                            <th>Category Name</th>
                                            <th>Description</th>
                                            <th width="120" class="text-center">Action</th>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title1">Add Category</h4>
                    <h4 class="modal-title" id="title2">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ph-bold ph-x"></i>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div id="alert"></div>
                    <div class="form-group mb-3">
                        <label>Category Name</label>
                        <input type="hidden" id="id">
                        <input type="text" id="nama" class="form-control form-control-sm"
                            placeholder="Enter category name..." required>
                    </div>

                    <div class="form-group mb-0">
                        <label>Description</label>
                        <textarea id="description" class="form-control form-control-sm" rows="3"
                            placeholder="Add a description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary btn-sm Update">Update Changes</button>
                        <button type="button" class="btn btn-primary btn-sm Save">Save Category</button>
                    </div>
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

    <script>
        $(document).ready(function () {
            list();
        });

        function list() {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('category.list') }}"
                },
                columns: [
                    {
                        data: null,
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'id',
                        className: 'text-center',
                        render: function (data) {
                            return `
                                        <div class="btn-group">
                                            <button id="btn_edit" title="Edit" data-id="${data}" class="btn btn-warning btn-sm">
                                                <i class="ph-bold ph-pencil-simple"></i>
                                            </button>
                                            <button id="btn_delete" title="Delete" data-id="${data}" class="btn btn-danger btn-sm ml-2">
                                                <i class="ph-bold ph-trash"></i>
                                            </button>
                                        </div>`;
                        }
                    }
                ],
                oLanguage: {
                    sProcessing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
                }
            });
        }

        $(document).on("click", "#btn_add", function () {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $(".Update").hide();
            $("#title2").hide();
            $(".Save").show();
            $("#title1").show();
            clear();
        });

        $(document).on("click", "#btn_edit", function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('category.edit')}}",
                data: { id: id, _token: '{{csrf_token()}}' },
                success: function (result) {
                    if (result.success) {
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $(".Save").hide();
                        $("#title1").hide();
                        $(".Update").show();
                        $("#title2").show();

                        $('#id').val(result.id);
                        $('#nama').val(result.name);
                        $('#description').val(result.description);
                    } else {
                        Swal.fire({ icon: 'warning', title: 'Oops...', text: result.msg });
                    }
                }
            });
        });

        $(document).on("click", ".close, .btn-secondary", function () {
            $('#myModal2').modal('hide');
            clear();
            $("#alert").html('');
        });

        function clear() {
            $("#id").val('');
            $("#nama").val('');
            $("#description").val('');
        }

        $(document).on("click", ".Save", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('category.store')}}",
                    data: {
                        nama: $('#nama').val(),
                        description: $('#description').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            Swal.fire({ icon: 'success', title: 'Success', text: result.msg, timer: 1500, showConfirmButton: false });
                            $('#myModal2').modal('hide');
                            list();
                        } else {
                            $("#alert").html('<div class="alert alert-danger alert-dismissible fade show"><i class="ph-bold ph-warning-circle mr-2"></i>' + result.msg + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('category.update')}}",
                    data: {
                        id: $('#id').val(),
                        nama: $('#nama').val(),
                        description: $('#description').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            Swal.fire({ icon: 'success', title: 'Updated!', text: result.msg, timer: 1500, showConfirmButton: false });
                            $('#myModal2').modal('hide');
                            list();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: result.msg });
                        }
                    }
                });
            }
        });

        function validasi() {
            if ($('#nama').val() == '') {
                $("#alert").html('<div class="alert alert-warning alert-dismissible fade show"><i class="ph-bold ph-warning-circle mr-2"></i>Category name is required!<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                return false;
            }
            return true;
        }

        $(document).on("click", "#btn_delete", function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Delete Category?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('category.destroy')}}",
                        data: { id: id, _token: '{{csrf_token()}}' },
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({ icon: 'success', title: 'Deleted!', text: result.msg, timer: 1500, showConfirmButton: false });
                                list();
                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: result.msg });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush