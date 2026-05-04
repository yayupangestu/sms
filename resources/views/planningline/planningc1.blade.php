@extends('layouts.app')

@section('content')
    <style>
        .centered-text {
            text-align: center;
        }


        tr:nth-child(even) {
            background-color:
                #efefeff8;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Planning Line C1</h1>
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
                        <div class="card-header" style="background-color: rgb(97, 255, 113)">
                            <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">List Planning
                                    Line C1</b></h3>
                            <div class="card-tools">
                                <button class="btn btn-success btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-striped">
                                <thead class="table" style="background-color: #c0bcbcf8">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Date</th>
                                        <th>Line</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(97, 255, 113)">
                    <h4 class="modal-title" id="title1">Tambah Planning Line C1</h4>
                    <h4 class="modal-title" id="title2">Edit Planning Line C1</h4>
                    <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-2 col-form-label">Date :</label>
                        <div class="col-sm-3">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-7"></div>
                        <label class="col-sm-2 col-form-label">JOB NO :</label>
                        <div class="col-sm-3 mb-1">
                            <select style="width: 100%;" id="job_no" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($TagLabelWelding as $part)
                                    <option value="{{ $part->id }}">{{ $part->job_no }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-7"></div>
                        <label class="col-sm-2 col-form-label">Product :</label>
                        <div class="col-sm-10 mb-1">
                            <select style="width: 100%;" id="product_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                            </select>
                        </div>

                        {{-- <label class="col-sm-2 col-form-label">Material :</label>
                        <div class="col-sm-10 mb-1">
                            <select style="width: 100%;" id="material_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->spek }} </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <label class="col-sm-2 col-form-label">Qty Plan :</label>
                        <div class="col-sm-3">
                            <input type="text" id="qty_plan" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-7">
                            <button type="button" class="btn btn-success btn-sm Save">Insert</button>
                            <button type="button" class="btn btn-warning btn-sm Update">Edit</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <table id="example2" class="table table-hover">
                        <thead>
                            <tr cl\>
                                <th width="50">No</th>
                                <th>Job No</th>
                                <th>Part NO</th>
                                <th>Model</th>
                                <th>Qty</th>
                                <th>Material</th>
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
                    url: "{{ route('mpsplanning.list') }}"
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
                    data: 'date_plan',
                    name: 'date_plan'
                },
                {
                    data: 'mix_id',
                    name: 'mix_id',
                    render: function (data) {
                        return '<a href="#" id="btn_edit" title="Edit" data-id="' + data + '" class="btn btn-info btn-sm">' +
                            '<i class="fas fa-search"></i>' +
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
                    url: "{{ route('mpsplanning.listdetail') }}",
                    data: {
                        date_plan: date_plan.value,
                        job_no: job_no.value,
                    }
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
                    data: 'job_no',
                    name: 'job_no'
                },
                {
                    data: 'part_name',
                    name: 'part_name'
                },
                {
                    data: 'model_id',
                    name: 'model_id'
                },
                {
                    data: 'qty_plan',
                    name: 'qty_plan'
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function (data) {
                        return '<a href="#" id="btn_delete_line" title="Delete" data-id="' + data + '" class="btn btn-danger btn-sm ml-1">' +
                            '<i class="far fa-trash-alt"></i>' +
                            '</a>' +
                            '<a href="#" id="btn_edit_line" title="Edit" data-id="' + data + '" class="btn btn-warning btn-sm ml-1">' +
                            '<i class="fas fa-pencil-alt"></i>' +
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
            $("#title2").hide();
            $(".Update").hide();
            $("#title1").show();
            clear();
        });

        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idline = id.substr(10);
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#date_plan').val(date_plan);
            $('#job_no').val(idline).trigger('change');
            listdetail();
        });

        $(document).on("click", "#btn_edit_line", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('mpsplanning.edit')}}",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.success) {
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#product_id').val(result.product_id).trigger('change');
                        $('#qty_plan').val(result.qty_plan).trigger('change');
                        // $('#description').val(result.description);
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
            list();
        });

        function clear() {
            $("#id").val('');
            $("#date_plan").val('');
            $('#job_no').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $("#qty_plan").val('');
            // $('#material_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('mpsplanning.store')}}",
                    data: {
                        date_plan: date_plan.value,
                        job_no: job_no.value,
                        product_id: product_id.value,
                        qty_plan: qty_plan.value,
                        // material_id: material_id.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + result.msg + '</div>');
                            listdetail();
                            $('#product_id').val('').trigger('change');
                            $("#qty_plan").val('');
                            // $('#material_id').val('').trigger('change');
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
                    url: "{{route('mpsplanning.update')}}",
                    data: {
                        id: id.value,
                        product_id: product_id.value,
                        qty_plan: qty_plan.value,
                        // description: description.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            SweetAlert.fire({
                                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });

                            listdetail();
                            $('#product_id').val('').trigger('change');
                            $("#qty_plan").val('');
                            // $('#material_id').val('').trigger('change');
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

        function validasi() {
            $("#alert").show();
            if (date_plan.value != '' && job_no.value != '' && product_id.value != '' && qty_plan.value != '') {
                return true;
            } else {
                $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
                setTimeout(() => { $("#alert").hide(); }, 1500);
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
                        url: "{{route('mpsplanning.destroyline')}}",
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
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idline = id.substr(10);
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
                        url: "{{route('mpsplanning.destroy')}}",
                        data: { date_plan: date_plan, idline: idline, _token: '{{csrf_token()}}' },
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