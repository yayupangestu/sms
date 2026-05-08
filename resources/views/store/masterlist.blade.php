@extends('layouts.app')

<style>
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

    .table th,
    .table td {
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
        background-color: #08b1ff3b;
    }

    .table tbody td {
        text-align: center;
        border-color: #e3dfdf;
    }
</style>

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-family: 'Times New Roman', Times, serif">List Item STORE ROOM</h1>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-family: ">List Data Items </h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                                <a href="{{route("masterliststr.export")}}" class="btn btn-success btn-sm"><i
                                        class="fa 	fas fa-file-excel"></i> Export Excel</a>
                            </div>
                        </div>
                        <div class="card-body" style="font-family: 'Times New Roman', Times, serif">
                            <table id="example1" class="table table-striped  table-bordered" class="text-center">
                                <thead class="table-info">
                                    <tr class="text-center">
                                        <th width="50">No</th>
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Price</th>
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
                    <h4 class="modal-title" id="title1">Add Item</h4>
                    <h4 class="modal-title" id="title2">Edit Item</h4>
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

                        <label class="col-sm-3 col-form-label">Category :</label>
                        <div class="col-sm-9 mb-1">
                            <select style="width: 100%;" id="category" class="form-control select2" required>
                                <option value="" selected>-pilih-</option>
                                @foreach ($str_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-3 col-form-label">Description :</label>
                        <div class="col-sm-9">
                            <input type="text" id="description" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-3 col-form-label">Item Code :</label>
                        <div class="col-sm-9">
                            <select style="width: 100%;" id="item_code" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value=""></option>
                                <option value="STMP">STMP</option>
                                <option value="WELD">WELDING</option>
                                <option value="STMP&WELD&PRD-2">STMP&WELD&PRD-2</option>
                                <option value="OFFICE">OFFICE</option>
                                <option value="PRD-2">PRD-2</option>
                            </select>
                        </div>

                        <label class="col-sm-3 col-form-label">Price :</label>
                        <div class="col-sm-9">
                            <input type="text" id="price" class="form-control form-control-sm" required
                                oninput="formatRupiah(this)">
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

        $(document).ready(function () {
            list();
        });

        function formatRupiah(element) {
            // Mengambil nilai input
            let value = element.value;

            // Menghapus semua karakter non-digit
            value = value.replace(/[^,\d]/g, '');

            // Memisahkan nilai menjadi integer dan pecahan
            let parts = value.split(',');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? ',' + parts[1] : '';

            // Format integer menjadi format Rupiah
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Menggabungkan kembali bagian integer dan decimal
            element.value = integerPart + decimalPart;
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
                pageLength: 20,
                ajax: {
                    url: "{{ route('masterliststr.list') }}"
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
                    data: 'item_code',
                    name: 'item_code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function (data) {
                        return '<a href="#" id="btn_edit" title="Edit" data-id="' + data + '" class="btn btn-warning btn-sm">' +
                            '<i class="fas fa-pencil-alt"></i>' +
                            '</a>' +
                            '<a href="#" id="btn_delete" title="Delete" data-id="' + data + '" class="btn btn-danger btn-sm ml-1">' +
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
                url: "{{route('masterliststr.edit')}}",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.success) {
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#nama').val(result.name);
                        $('#category').val(result.category).trigger('change');
                        $('#item_code').val(result.item_code);
                        $('#description').val(result.description);
                        $('#price').val(result.price);
                    } else {
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

        function clear() {
            $("#id").val('');
            $("#nama").val('');
            $("#category").val('');
            $("#description").val('');
            $("#item_code").val('');
            $("#price").val('');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('masterliststr.store')}}",
                    data: {
                        nama: nama.value,
                        category: category.value,
                        description: description.value,
                        item_code: item_code.value,
                        price: price.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + result.msg + '</div>');
                            list();
                            clear();
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        } else {
                            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + result.msg + '</div>');
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('masterliststr.update')}}",
                    data: {
                        id: id.value,
                        nama: nama.value,
                        category: category.value,
                        description: description.value,
                        item_code: item_code.value,
                        price: price.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            $('#myModal2').modal('hide');
                            SweetAlert.fire({
                                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                            list();
                            clear();
                        } else {
                            SweetAlert.fire({
                                icon: 'error', title: 'Error', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }
                    }
                });
            }
        });

        function validasi() {
            $("#alert").show();
            if (nama.value != '' && category.value != '' && item_code.value != '') {
                return true;
            } else {
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
                        url: "{{route('masterliststr.destroy')}}",
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