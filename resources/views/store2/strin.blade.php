@extends('layouts.app')

@section('content')

    <style>
        .date-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .date-filter input {
            flex: 1;
            width: 150px;
            /* Menetapkan lebar khusus */
            max-width: 150px;
            /* Menetapkan lebar maksimum */
        }

        .swal2-popup.swal2-toast.colored-toast {
            background-color: #a5dc86 !important;
            color: white;
            /* Optionally, you can change text color as well */
        }



        .swal2-toast-custom-success {
            background-color: green !important;
            color: white;
            /* Optionally, you can change text color as well */
        }


        .swal2-toast {
            background-color: #f69595 !important;
            /* Warna kuning */
            color: #ffffff !important;
            /* Warna teks */
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">List Item IN Store Room 2</h1>
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
                            <h3 class="card-title">List Item IN ASI-2 </h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="date-filter">
                                <h5>Start:</h5><input type="date" id="start_date" class="form-control"
                                    placeholder="Start Date">
                                <h5>End:</h5><input type="date" id="end_date" class="form-control" placeholder="End Date">
                                <button class="btn btn-success btn-sm" id="btn_export"><i class="fa fa-file-excel"></i>
                                    Export Excel</button>
                            </div>
                            <table id="example1" class="table table-hover table-striped">
                                <thead class="table" style="background-color: rgb(245, 238, 163)">
                                    <tr>
                                        <th width="50">No</th>
                                        <th><b>DATE</b> </th>
                                        <th><b>CATEGORY</b></th>
                                        <th width="80"><b>ACTION</b></th>
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
                <div class="modal-header" style="background-color: rgb(255, 243, 118)">
                    <h4 class="modal-title" id="title1"><b>Add Item IN ASI-2</b></h4>
                    <h4 class="modal-title" id="title2"><b>Edit Item IN ASI-2</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: rgb(238, 233, 182)">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-2 col-form-label">Date :</label>
                        <div class="col-sm-3">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-7"></div>
                        <label class="col-sm-2 col-form-label">Category :</label>
                        <div class="col-sm-3 mb-1">
                            <select style="width: 100%;" id="category_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($str_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-7"></div>
                        <label class="col-sm-2 col-form-label">Item :</label>
                        <div class="col-sm-10 mb-1">
                            <select style="width: 100%;" id="item_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($master_list_strs as $barang) ()
                                    <option value="{{ $barang->id }}">{{ $barang->name}} / {{ $barang->category}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Suplaier :</label>
                        <div class="col-sm-10 mb-1">
                            <select style="width: 100%;" id="suplai_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($str_suplaiers as $suplai)
                                    <option value="{{ $suplai->id }}">{{ $suplai->name_suplai }} / {{$suplai->pt}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10 mb-1">
                            <input type="text" id="keterangan" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-2 col-form-label">Qty IN :</label>
                        <div class="col-sm-2">
                            <input type="text" id="qty_in" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-2 col-form-label">Satuan :</label>
                        <div class="col-sm-2 mb-1">
                            <select style="width: 100%;" id="satuan" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($str_uoms as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->name}} </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-sm-7">
                            <button type="button" class="btn btn-primary btn-sm Save">Insert</button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <table id="example2" class="table table-hover">

                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Category</th>
                                    <th>Suplaier</th>
                                    <th widht="90">Item</th>
                                    <th>IN</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
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

        // $(document).ready(function(){
        //     $('#item_id').select2();
        // });

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
                    url: "{{ route('strin2.list') }}"
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
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'mix_id',
                    name: 'mix_id',
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

        function listdetail() {
            var table = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 5,
                ajax: {
                    url: "{{ route('strin2.listdetail') }}",
                    data: {
                        date_plan: date_plan.value,
                        category_id: category_id.value,
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
                    data: 'category_id',
                    name: 'category_id'
                },
                {
                    data: 'suplai_id',
                    name: 'suplai_id'
                },
                {
                    data: 'item_id',
                    name: 'item_id'
                },
                {
                    data: 'qty_in',
                    name: 'qty_in'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function (data) {
                        return '<a href="#" id="btn_delete_line" title="Delete" data-id="' + data + '" class="btn btn-danger btn-sm ml-1">' +
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
            $("#title2").hide();
            $("#title1").show();
            clear();
        });

        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idcategory = id.substr(10);
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#date_plan').val(date_plan);
            $('#category_id').val(idcategory).trigger('change');
            listdetail();
        });

        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
            list();
        });

        function clear() {
            $("#id").val('');
            $("#date_plan").val('');
            $('#category_id').val('');
            $('#item_id').val('');
            $('#suplai_id').val('').trigger('change');
            $("#qty_in").val('');
            $('#satuan').val('');
            $('#keterangan').val('');
            // $('#material_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('strin2.store')}}",
                    data: {
                        date_plan: date_plan.value,
                        category_id: category_id.value,
                        item_id: item_id.value,
                        suplai_id: suplai_id.value,
                        qty_in: qty_in.value,
                        satuan: satuan.value,
                        keterangan: keterangan.value,
                        // material_id: material_id.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + result.msg + '</div>');
                            listdetail();
                            $('#item_id').val('').trigger('change');
                            $("#suplai_id").val('');
                            $("#qty_in").val('');
                            $("#satuan").val('');
                            $("#keterangan").val('');
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

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $(document).on("click", "#btn_export", function () {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            if (startDate && endDate) {
                window.location.href = "{{ route('strin2.export') }}?start_date=" + startDate + "&end_date=" + endDate;
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'Incomplete Date Range',
                    text: 'Please select a date range before exporting.'
                });
            }
        });

        function validasi() {
            $("#alert").show();
            if (date_plan.value != '' && category_id.value != '' && suplai_id.value != '' && item_id.value != '' && satuan.value != '' && qty_in.value != '') {
                return true;
            } else {
                $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>All Column Cannot be Empty.</div>');


                setTimeout(() => { $("#alert").hide(); }, 2000);
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
                        url: "{{route('strin2.destroyline')}}",
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
            var idcategory = id.substr(10);
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
                        url: "{{route('strin2.destroy')}}",
                        data: { date_plan: date_plan, idcategory: idcategory, _token: '{{csrf_token()}}' },
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