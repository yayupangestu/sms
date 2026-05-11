@extends('layouts.app')

@section('content')
    <style>
        .centered-text {
            text-align: center;
        }


        tr:nth-child(even) {
            background-color:
                #e6e6e6
        }

        .actual {
            background-color: rgb(0, 255, 64);
        }

        .minimal {
            background-color: yellow;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Stok Items Cuptip ASI-1 </h1>
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
                        <div class="card-header" style="background-color:  rgb(126, 144, 144)">
                            <h3 class="card-title">
                                <i class="fas fa-store"></i>
                                List Stok Items Cuptip
                            </h3>
                            <div class="card-tools">
                                <button class="btn btn-warning btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                                <a href="{{route("stokcuptip.export")}}" class="btn btn-success btn-sm"><i
                                        class="fa 	fas fa-file-excel"></i> Export Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-family: 'Times New Roman', Times, serif">
                    <table id="example1" class="table  table-bordered table-striped; centered-text">
                        <thead class="table" style="background-color:  rgb(126, 144, 144)">
                            <tr>
                                <th width="50">No</th>
                                <th>Items Name</th>
                                <th width="100">Category</th>
                                <th class="minimal" width="100">MinimalStok</th>
                                <th class="actual" width="100">Actual Stok</th>
                                <th class="centered-text" style="text-align: center" width="100">UoM</th>
                                <th width="50">Action</th>
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
                    <h4 class="modal-title" id="title1">Add Items</h4>
                    <h4 class="modal-title" id="title2">Edit Items</h4>
                    <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
                        {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-3 col-form-label">Nama Barang :</label>
                        <div class="col-sm-9 mb-1">
                            <input type="hidden" id="id">
                            <select style="width: 100%;" id="item_id" class="form-control select2" class="text-center"
                                required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($master_list_strs as $barang)
                                    <option style="text-align: center" value="{{ $barang->id }}">{{ $barang->name }}
                                        /{{ $barang->category}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-3 col-form-label">Category :</label>
                        <div class="col-sm-9">
                            <select style="width: 100%;" id="category" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value="CUPTIP">CUPTIP</option>

                            </select>
                        </div>

                        <label class="col-sm-3 col-form-label">Minimal :</label>
                        <div class="col-sm-9">
                            <input type="text" id="minimal" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-3 col-form-label">Actual :</label>
                        <div class="col-sm-9">
                            <input type="text" id="actual" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-3 col-form-label">Satuan :</label>
                        <div class="col-sm-9">
                            <select style="width: 100%;" id="satuan" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($str_uoms as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->name}}</option>
                                @endforeach

                            </select>
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
                    url: "{{ route('stokcuptip.list') }}"
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
                    data: 'item_id',
                    name: 'item_id'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'minimal',
                    name: 'minimal'
                },
                {
                    data: 'actual',
                    name: 'actual'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function (data) {
                        return '<a href="#" id="btn_edit" title="Edit" data-id="' + data + '" class="btn btn-warning btn-sm">' +
                            '<i class="	fas fa-edit"></i>' +
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
                url: "{{route('stokcuptip.edit')}}",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.success) {
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#item_id').val(result.item_id).trigger('change');
                        $('#category').val(result.category).trigger('change');
                        $('#minimal').val(result.minimal).trigger('change');
                        $('#actual').val(result.actual).trigger('change');
                        $('#satuan').val(result.satuan).trigger('change');
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
            $("#item_id").val('');
            $("#category").val('');
            $('#minimal').val('').trigger('change');
            $('#actual').val('').trigger('change');
            $('#satuan').val('').trigger('change');

        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('stokcuptip.store')}}",
                    data: {
                        item_id: item_id.value,
                        category: category.value,
                        minimal: minimal.value,
                        actual: actual.value,
                        satuan: satuan.value,
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
                    url: "{{route('stokcuptip.update')}}",
                    data: {
                        id: id.value,
                        item_id: item_id.value,
                        category: category.value,
                        minimal: minimal.value,
                        actual: actual.value,
                        satuan: satuan.value,
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

        $(document).ready(function () {
            $.ajax({
                url: '/check-stock6',
                type: 'GET',
                success: function (response) {
                    if (response.status === 'error') {
                        var message = response.message + '\n';
                        response.items.forEach(function (item) {
                            message += '& ' + item.name + '\n';
                        });
                        SweetAlert.fire({
                            icon: 'info',
                            title: 'OUT OF STOCK',
                            text: message,
                            // showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });




        function validasi() {
            $("#alert").show();
            if (item_id.value != '' && category.value != '' && minimal.value != '' && actual.value != '' && satuan.value != '') {
                return true;
            } else {
                $("#alert").html('<div class="alert alert-info"><i class="fa fa-info"></i>all column cannot be empty.</div>');
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
                        url: "{{route('stokcuptip.destroy')}}",
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