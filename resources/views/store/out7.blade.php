@extends('layouts.app')

@section('content')


    <style>
        /* style css tabe */
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
            background-color: #245a7e;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        .table tbody tr {
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #728da392;
        }

        .table tbody td {
            text-align: center;
            border-color: #e3dfdf;
        }

        .btn-info {
            background-color: #245a7e;
            border-color: #245a7e;
        }

        .btn-info:hover {
            background-color: #4a86f75d;
            border-color: #f8f8f8;
        }

        /* end style css tabel */

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

        .status-cell {
            background-color: green;
            border-radius: 15%;
            padding: 10px;
            /* display: inline-block; */
            width: 100px;
            /* height: 30px; */
            /* line-height: 10px; */
            text-align: center;
            color: white;
        }

        .text-center {
            text-align: center
        }

        .status-waiting-leader {
            background-color: rgb(141, 238, 230);
            padding: 2%;
            border-radius: 20%;
            color: rgb(2, 2, 2)
        }

        .status-storeroom {
            background-color: rgb(251, 255, 166);
            padding: 2%;
            border-radius: 20%;
            color: rgb(2, 2, 2)
        }

        .status-approved {
            background-color: rgb(145, 240, 244);
            padding: 2%;
            border-radius: 20%;
            color: rgb(2, 2, 2)
        }

        .status-approved2 {
            background-color: rgb(135, 245, 135);
            padding: 2%;
            border-radius: 20%;
            color: rgb(2, 2, 2)
        }

        .status-approved3 {
            background-color: rgb(44, 255, 202);
            padding: 2%;
            border-radius: 20%;
            color: rgb(0, 0, 0)
        }


        th.status-header {
            background-color: white;
            color: black;
            text-align: center;
        }

        .date-filter {
            display: flex;
            align-items: center;
        }

        .date-filter h5 {
            margin: 0 10px 0 0;
        }

        .form-control2 {
            width: 150px;
            /* Sesuaikan ukuran yang diinginkan */
            margin-right: 10px;
        }

        .btn {
            margin-left: 10px;
        }
    </style>

    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">E-Surat Permintaan Barang LINE BLANK</h1>
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
                    <div class="card" id="CardHead">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-store"></i>
                                E-Surat Permintaan Barang Blank (SPB)

                            </h3>
                            <div class="card-tools">
                                {{-- <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i>
                                    Add</button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="date-filter">
                                <h5>Start:</h5>
                                <input type="date" id="start_date" class="form-control2" placeholder="Start Date">

                                <h5>End:</h5>
                                <input type="date" id="end_date" class="form-control2" placeholder="End Date">

                                <!-- Dropdown Export -->
                                <div class="dropdown">
                                    <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fa fa-file-excel"></i> Export
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item export-option" data-type="history" href="#">Export
                                                History</a></li>
                                        <li><a class="dropdown-item export-option" data-type="data" href="#">Export Data
                                                (Summary)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <br>
                            <table id="tableHeader" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="status-header">No</th>
                                        <th class="status-header">Doc No</th>
                                        <th class="status-header">Date</th>
                                        <th class="status-header">Dept</th>
                                        <th class="status-header">Status</th>
                                        <th class="status-header">Detail</th>
                                        <th class="status-header" width="150">Actions</th>
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('strout7.update') }}" method="POST">
                            @csrf
                            <div class="CardHead">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i style="font-size: 120%" class="fas fa-cart-plus"></i>
                                        SPB Permintaan
                                    </h3>
                                    <div class="card-tools">
                                        <button class="btn btn-info btn-sm" name="button" value="update" type="submit"><i
                                                class="fa fa-plus"></i> Update</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="spb">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="example1" class="table  table-bordered table-striped">
                                                    <thead class="table-info">
                                                        <tr class="text-center">
                                                            <th width="50">No</th>
                                                            <th width="90">Line</th>
                                                            <th width="150">Tanggal</th>
                                                            <th>Waktu</th>
                                                            <th>Item Name</th>
                                                            <th>Qty Return</th>
                                                            <th>Qty Request</th>
                                                            <th>Qty Out</th>
                                                            <th>Description</th>
                                                            <th>Update</th>

                                                            {{-- <th>Recipient</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_detail">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('strout7.update') }}" method="POST">
                            @csrf
                            <div class="CardHead">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i style="font-size: 120%" class="fas fa-cart-plus"></i>
                                        - Report List Pengambilan Barang (SPB)
                                    </h3>
                                    <div class="card-tools">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="spb">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="example1" class="table  table-bordered table-striped">
                                                    <thead class="table-success">
                                                        <tr class="text-center">
                                                            <th class="status-header" width="50">No</th>
                                                            <th class="status-header" width="90">line</th>
                                                            <th class="status-header" width="120">Tanggal</th>
                                                            <th class="status-header">Item Name</th>
                                                            <th class="status-header">Qty Retrun</th>
                                                            <th class="status-header">Qty Request</th>
                                                            <th class="status-header">Qty Out</th>
                                                            <th class="status-header">Description</th>
                                                            <th class="status-header">Qty Out Standing</th>
                                                            <th class="status-header">Update</th>
                                                            {{-- <th>Updated By</th> --}}
                                                            {{-- <th>Recipient</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_detail2">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal HTML -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background-color: #245a7e">
                        <h5 class="modal-title" id="detailsModalLabel">Detail Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered" id="detailTable">
                            <thead>
                                <tr>
                                    <th>Cek</th>
                                    <th>Line</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Dikembalikan</th>
                                    <th>Diminta</th>
                                    <th>Dibuat</th>
                                    <th>Dicek</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data detail akan di-inject di sini oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Oke</button>
                        <input type="hidden" class="btn btn-primary" id="saveChecked"></input>
                    </div>
                </div>
            </div>
        </div>
        </div>



        <div class="modal fade" id="modal_header">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(195, 255, 249)">
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-between">
                            <div class="col-sm-5">
                                <h4 class="modal-title" id="title1"><b>Add Item Out</b></h4>
                                <h4 class="modal-title" id="title2"><b>Edit Item Out</b></h4>
                            </div>
                            <div class="col-sm-6 text-right" style="">
                                <button class="btn btn-primary btn-sm" id="btn_submit">Save</button>
                                <button class="btn btn-default btn-sm" id="btn_cancel">Cancel</button>
                                <button type="button" class="close; btn btn-secondary btn-sm" data-dismiss="modal"
                                    aria-label="Close">Close
                            </div>
                        </div>
                        <hr>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                        <div class="form-group row">
                            <div class="col-12" id="alert"></div>

                            <label for="qty" class="col-sm-2 col-form-label">No SPB :</label>
                            <div class="col-sm-6">
                                <input style="width: 100%" type="text" id="doc_no" class="form-control form-control-sm"
                                    readonly>
                            </div>
                            <div class="col-sm-12"></div>
                            <label for="qty" class="col-sm-2 col-form-label">Date :</label>
                            <div class="col-sm-3 mb-1">
                                <input type="hidden" id="id" class="form-control" required>
                                <input type="date" id="date_plan" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-sm-7"></div>
                            <label class="col-sm-2 col-form-label">Dept :</label>
                            <div class="col-sm-3 mb-1">
                                <select style="width: 100%;" id="line_id" class="form-control select2" required>
                                    <option value="" selected>- pilih -</option>
                                    <option value="FUKUI">FUKUI</option>
                                    <option value="KOMATSU">KOMATSU</option>
                                    <option value="SHIMOMURA">SHIMOMURA</option>
                                    <option value="AMINO">AMINO</option>
                                </select>
                            </div>

                            <div class="col-sm-7"></div>
                            <label class="col-sm-2 col-form-label">Item :</label>
                            <div class="col-sm-7 mb-1">
                                <select style="width: 100%;" id="item_id" class="select2" required>
                                    <option value="" selected>- pilih -</option>
                                    @php
                                        $sorterdBarangs = $master_list_strs->sortBy('name');
                                    @endphp
                                    @foreach ($sorterdBarangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->name}} / {{ $barang->category}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2 mb-1">
                                <input type="text" id="actual_value" class="form-control" readonly>
                            </div>

                            <label class="col-sm-0 col-form-label"></label>
                            <div class="col-sm-0">
                                <input type="hidden" id="qty_standing" class="form-control form-control-sm" required>
                            </div>

                            <label class="col-sm-2 col-form-label">Qty Return :</label>
                            <div class="col-sm-1">
                                <input type="text" id="qty_return" class="form-control form-control-sm" required>
                            </div>

                            <label class="col-sm-2 col-form-label">Qty Request:</label>
                            <div class="col-sm-1">
                                <input type="text" id="qty_request" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-sm-1"></div>
                            <label class="col-sm-1 col-form-label">UoM:</label>
                            <div class="col-sm-2 mb-1">
                                <select style="width: 100%;" id="satuan" class="form-control select2" required>
                                    <option value="" selected>- pilih -</option>
                                    @foreach ($str_uoms as $satuan)
                                        <option value="{{ $satuan->id }}">{{ $satuan->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div>
                            <label class="col-sm-2 col-form-label">Description :</label>
                            <div class="col-sm-10 mb-1">
                                <input type="text" id="keterangan" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-sm-12 mb-2">
                                <button type="button" class="btn btn-primary btn-sm Save">Insert</button>
                                <button type="button" class="btn btn-warning btn-sm Update2">Edit</button>
                            </div>

                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="example2" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="status-header" width="50">No</th>
                                                <th class="status-header">Dept</th>
                                                <th class="status-header">Item Name</th>
                                                <th class="status-header">Qty Return</th>
                                                <th class="status-header">Qty Request</th>
                                                {{-- <th>Item Out</th> --}}
                                                <th class="status-header">UoM</th>
                                                <th class="status-header">Description</th>
                                                <th class="status-header" width="80">Action</th>
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

    <div class="modal fade" id="modal_konfirmasi">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(195, 255, 249)">
                    <h4 class="modal-title"><b>Are you sure you want to cancel the transaction?</b></h4>
                </div>
                <div class="modal-body" style="background-color: rgb(255, 255, 255)">
                    <button class="btn btn-success btn-sm" id="btn_tidak">Yes</button>
                    <button class="btn btn-warning btn-sm" id="btn_ya">No</button>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdeliver.net/npm/bootstrap@5.3.2/dist/js/bootsrtap.bundle.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#item_id').select2();

        });

        document.getElementById('qty_request').addEventListener('input', function () {
            var actualValue = parseFloat(document.getElementById('actual_value').value);
            var qtyRequest = parseFloat(this.value);

            if (!isNaN(actualValue) && !isNaN(qtyRequest)) {
                if (qtyRequest > actualValue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Maaf Anda meminta lebih dari Stok!',
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
                    this.value = null;  // Reset the input value to 0
                }
            }
        });

        $(document).ready(function () {
            $("#example1").show();
            list();
            getDoc();
        });

        $(document).ready(function () {
            var getActualUrl = '{{ route('strout7.getActual') }}'; // Menghasilkan URL route

            $('#item_id').change(function () {
                var itemId = $(this).val(); // Mengambil nilai item_id dari dropdown

                if (itemId) {
                    $.ajax({
                        url: getActualUrl, // Menggunakan URL yang dihasilkan
                        type: 'GET',
                        data: { item_id: itemId },
                        success: function (response) {
                            if (response.success) {
                                $('#actual_value').val(response.data.actual); // Menggunakan .val() untuk input
                            } else {
                                $('#actual_value').val('Data tidak ditemukan.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('AJAX Error:', status, error); // Menampilkan error di konsol
                            $('#actual_value').val('Terjadi kesalahan.');
                        }
                    });
                } else {
                    $('#actual_value').val(''); // Kosongkan data jika tidak ada item yang dipilih
                }
            });
        });

        function getDoc() {
            var d = new Date(),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            $.ajax({
                type: 'GET',
                url: "{{route('strout7.getdoc')}}",
                success: function (result) {
                    $("#id").val('');
                    $("#doc_no").val("SPB/ASI/STAMPING/BLANK/" + year + month + "/" + result.jml);
                    $("#date_plan").val('');
                    $('#line_id').val('');
                    $('#item_id').val('');
                    $("#qty_return").val('');
                    $('#qty_request').val('');
                    $('#satuan').val('');
                    $('#keterangan').val('');
                }
            });
        }

        function list() {
            var table = $('#tableHeader').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('strout7.list') }}",
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'doc_no',
                        name: 'doc_no'
                    },
                    {
                        data: 'date_plan',
                        name: 'date_plan'
                    },
                    {
                        data: 'line_id',
                        name: 'line_id'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (data) {
                            if (data == null || data == '') {
                                return '<span class="status-waiting-leader" style="background-color: yellow;">Waiting Approve Leader</span>';
                            } else if (data == 1) {
                                return '<span class="status-storeroom">Waiting Approve Storeroom</span>';
                            } else if (data == 2) {
                                return '<span class="status-approved">StoreRoom Done (Cek Item)</span>';
                            } else if (data == 3) {
                                return '<span class="status-approved3">Cek Item Complate </span>';
                            } else {
                                return '<span class="status-approved2">Transcation Complate</span>';
                            }
                        }
                    },

                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row) {
                            return '<button class="btn btn-info btn-sm btn-details" data-doc_no="' + row.doc_no + '">Details</button>';
                        }
                    },
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row) {
                            if (row.status == 1) {
                                return '<a href="#" id="btn_search" title="Search" data-id="' + row.doc_no + '" class="btn btn-success btn-sm ml-1">' +
                                    '<i class="fas fa-search"></i>' +
                                    '</a>' +
                                    '<a href="#" title="Aproved StoreRoom" class="btn btn-primary btn-sm ml-1 approve-btn2" data-doc_no="' + row.doc_no + '">' +
                                    '<i class="fas fa-check"></i>' +
                                    '</a>';

                            } else if (row.status == 2) {
                                return '<a href="#" id="btn_search" title="Search" data-id="' + row.doc_no + '" class="btn btn-success btn-sm ml-1">' +
                                    '<i class="fas fa-search"></i>' +
                                    '</a>';
                                // '<a href="#" id="btn_delete" title="Delete" data-id="'+row.doc_no+'" class="btn btn-danger btn-sm ml-1">'+
                                //        '<i class="far fa-trash-alt"></i>'+
                                //    '</a>';
                            } else if (row.status == 3) {
                                return '<a href="#" id="btn_search" title="Search" data-id="' + row.doc_no + '" class="btn btn-success btn-sm ml-1">' +
                                    '<i class="fas fa-search"></i>' +
                                    '</a>';
                            } else if (row.status == 4) {
                                return '<a href="#" id="btn_search" title="Search" data-id="' + row.doc_no + '" class="btn btn-success btn-sm ml-1">' +
                                    '<i class="fas fa-search"></i>' +
                                    '</a>';
                            } else {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="' + row.doc_no + '" class="btn btn-info btn-sm">' +
                                    '<i class="fas fa-list"></i>' +
                                    '</a>' +
                                    '<a href="#" id="btn_search" title="Search" data-id="' + row.doc_no + '" class="btn btn-success btn-sm ml-1">' +
                                    '<i class="fas fa-search"></i>' +
                                    '</a>' +
                                    '<a href="#" title="Aproved Leader" class="btn btn-primary btn-sm ml-1 approve-btn" data-doc_no="' + row.doc_no + '">' +
                                    '<i class="fas fa-check"></i>' +
                                    '</a>';

                            }
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

            // Script untuk menangani klik tombol detail dan memuat modal
            $(document).on("click", ".btn-details", function () {
                var doc_no = $(this).data('doc_no'); // Ambil doc_no dari tombol yang diklik

                // Kirim permintaan AJAX untuk mendapatkan detail berdasarkan doc_no
                $.ajax({
                    type: 'GET',
                    url: "{{ route('strout7.listdetail3') }}", // Route yang mengarah ke listdetail3
                    data: {
                        doc_no: doc_no
                    },
                    success: function (result) {
                        // Panggil fungsi untuk menampilkan data di modal
                        showModalWithDetails(result);
                    },
                    error: function (error) {
                        console.log("Error:", error);
                    }
                });
            });

            // Fungsi untuk menampilkan modal dengan data yang diambil dari backend
            function showModalWithDetails(data) {
                // Bersihkan isi tabel sebelumnya
                let tableBody = document.querySelector("#detailsModal tbody");
                tableBody.innerHTML = '';

                // Loop untuk menambahkan baris ke tabel
                data.forEach(function (item) {
                    // Jika status_checklist bernilai 1, checkbox akan otomatis dicentang
                    let checked = item.status_checklist == 1 ? 'checked' : '';

                    let row = `
                                    <tr>
                                        <td><input type="checkbox" class="item-checkbox" value="${item.id}" ${checked}></td>
                                        <td>${item.line_id ? item.line_id : ''}</td>
                                        <td>${item.date_plan ? item.date_plan : ''}</td>
                                        <td>${item.name ? item.name : ''}</td>
                                        <td>${item.qty_return ? item.qty_return : ''}</td>
                                        <td>${item.qty_request ? item.qty_request : ''}</td>
                                        <td>${item.createdby ? item.createdby : ''}</td>
                                         <td>${item.update_checklist ? item.update_checklist : ''}</td>
                                    </tr>
                                `;

                    // Tambahkan baris ke dalam tabel
                    tableBody.innerHTML += row;
                });

                // Tampilkan modal
                let detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                detailsModal.show();
            }

        }


        // Ketika tombol OK diklik, simpan hasil centang
        document.getElementById("saveChecked").addEventListener("click", function () {
            let checkedItems = [];

            // Ambil semua checkbox yang dicentang
            document.querySelectorAll(".item-checkbox:checked").forEach(function (checkbox) {
                checkedItems.push(checkbox.value);  // Ambil ID dari data yang dicentang
            });

            // Lakukan sesuatu dengan data yang dicentang, misalnya kirim via AJAX
            if (checkedItems.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('strout7.saveChecked') }}",  // Sesuaikan URL
                    data: {
                        items: checkedItems,
                        _token: '{{ csrf_token() }}'  // Pastikan CSRF token disertakan
                    },
                    success: function (response) {
                        // Tampilkan SweetAlert pesan sukses
                        Swal.fire({
                            title: 'Data Berhasil Disimpan!',
                            text: 'Item yang dipilih telah berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Tutup modal setelah SweetAlert ditutup dan refresh halaman
                                $('#detailsModal').modal('hide');
                                location.reload(); // Refresh halaman
                            }
                        });
                    },
                    error: function (error) {
                        // Tampilkan pesan kesalahan jika terjadi error
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                // Tampilkan SweetAlert jika tidak ada item yang dipilih
                Swal.fire({
                    title: 'Tidak Ada Item Dipilih!',
                    text: 'Harap pilih setidaknya satu item sebelum menyimpan.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });

        //tombol aprrove 1//
        $(document).on('click', '.approve-btn', function (e) {
            var $button = $(this);
            var doc_no = $button.data('doc_no');

            Swal.fire({
                title: 'Are You sure?',
                text: "Items cannot be exchanged",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#228B22',
                confirmButtonText: 'Yes, approve items!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('strout7.approve') }}',
                        data: {
                            doc_no: doc_no,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                var row = $('button[data-doc_no="' + doc_no + '"]').closest('tr');
                                var statusCell = row.find('span'); // update this line according to your status cell
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Item has been approved successfully!'
                                });
                                list(); // Refresh or update the table list as needed
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to approve item.'
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        });

        //tombol approve 2//
        $(document).on('click', '.approve-btn2', function (e) {
            var $button = $(this);
            var doc_no = $button.data('doc_no');
            Swal.fire({
                title: 'Are You sure?',
                text: "Is the item as requested?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#228B22',
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('strout7.approve2') }}',
                        data: {
                            doc_no: doc_no,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                var row = $('button[data-doc_no="' + doc_no + '"]').closest('tr');
                                var statusCell = row.find('span'); // update this line according to your status cell
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Item has been approved successfully!'
                                }).then(() => {
                                    window.location.href = '{{ route('kanban.index') }}';
                                });
                            }
                        },
                    });
                }
            });
        });

        //tombol approve3//
        $(document).on('click', '.approve-btn3', function (e) {
            var $button = $(this);
            var doc_no = $button.data('doc_no');
            Swal.fire({
                title: 'Are You sure?',
                text: "The transaction will be completed",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#228B22',
                confirmButtonText: 'Yes, completed transaction!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('strout7.approve3') }}',
                        data: {
                            doc_no: doc_no,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                var row = $('button[data-doc_no="' + doc_no + '"]').closest('tr');
                                var statusCell = row.find('span'); // update this line according to your status cell
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Item has been approved successfully!'
                                });
                                list();
                            }
                        },
                    });
                }
            });
        });

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
                    url: "{{ route('strout7.listdetail') }}",
                    data: {
                        doc_no: doc_no.value,
                        date_plan: date_plan.value,
                        line_id: line_id.value,
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
                    data: 'line_id',
                    name: 'line_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'qty_return',
                    name: 'qty_return'
                },
                {
                    data: 'qty_request',
                    name: 'qty_request'
                },
                // {
                //     data: 'qty_standing',
                //     name: 'qty_standing'
                // },
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

        $(document).on("click", "#btn_search", function () {
            var html = '';
            let no = 1;
            var doc_no = $(this).data('id');
            let idline = 1;
            let qty_out = 1;
            let idket = 1;
            let keterangan = 1;
            $.ajax({
                type: 'GET',
                url: "{{route('strout7.listdetail2')}}",
                data: {
                    doc_no: doc_no,
                },
                success: function (result) {
                    $.each(result.data, function (key, value) {
                        var qty_standing = value.qty_standing;
                        if (qty_standing == null) {
                            qty_standing = ''
                        } else {
                            qty_standing = value.qty_standing;
                        }

                        var qty_return = value.qty_return;
                        if (qty_return == null) {
                            qty_return = ''
                        } else {
                            qty_return = value.qty_return;
                        }

                        var qty_request = value.qty_request;
                        if (qty_request == null) {
                            qty_request = ''
                        } else {
                            qty_request = value.qty_request;
                        }

                        var qty = value.qty_out;
                        if (qty == null) {
                            qty = ''
                        } else {
                            qty = value.qty_out;
                        }

                        var ket = value.w_dibuat;
                        if (ket == null) {
                            ket = ''
                        } else {
                            ket = value.w_dibuat;
                        }

                        var createdby = value.createdby;
                        if (createdby == null) {
                            createdby = ''
                        } else {
                            createdby = value.createdby;
                        }


                        html += '<tr class="text-center">' +
                            '<td>' + no++ + '</td>' +
                            '<td width="80">' + value.line_id + '</td>' +
                            '<td width="80">' + value.date_plan + '</td>' +
                            '<td>' + value.w_dibuat + '</td>' +
                            '<td>' + value.name + '</td>' +
                            '<td>' + qty_return + '</td>' +
                            '<td>' + qty_request + '</td>' +
                            '<td><input type="hidden" name="idline[' + idline++ + ']" value="' + value.id + '"><input type="number" name="qty[' + qty_out++ + ']" value="' + qty + '"></td>' +
                            '<td>' + createdby + '</td>' +
                            '<td>' + qty_standing + '</td>' +
                            '</tr>';
                    })
                    document.getElementById("tb_detail").innerHTML = html;
                }
            });
        });

        $(document).on("click", "#btn_search", function () {
            var html = '';
            let no = 1;
            var doc_no = $(this).data('id');
            let idline = 1;
            let qty_out = 1;
            let idket = 1;
            let keterangan = 1;

            $.ajax({
                type: 'GET',
                url: "{{route('strout7.listdetail2')}}",
                data: {
                    doc_no: doc_no,
                },
                success: function (result) {
                    $.each(result.data, function (key, value) {
                        var line_id = value.line_id || '';
                        var date_plan = value.date_plan || '';
                        var qty_standing = value.qty_standing || '';
                        var qty_request = value.qty_request || '';
                        var qty_return = value.qty_return || '';
                        var w_dibuat = value.w_dibuat || '';
                        var createdby = value.createdby || '';
                        var qty_out = value.qty_out || '';
                        var keterangan = value.keterangan || '';

                        html += '<tr class="text-center">' +
                            '<td>' + no++ + '</td>' +
                            '<td>' + line_id + '</td>' +
                            '<td>' + date_plan + '</td>' +
                            '<td>' + value.name + '</td>' +
                            '<td>' + qty_return + '</td>' +
                            '<td>' + qty_request + '</td>' +
                            '<td>' + qty_out + '</td>' +
                            '<td>' + keterangan + '</td>' +
                            '<td>' + qty_standing + '</td>' +
                            '<td>' + createdby + '</td>' +
                            '</tr>';
                    });

                    // Tampilkan data di dalam tabel
                    document.getElementById("tb_detail2").innerHTML = html;

                    // Scroll ke tabel setelah data di-load
                    document.getElementById("tb_detail2").scrollIntoView({
                        behavior: 'smooth' // guliran halus
                    });
                }
            });
        });

        document.getElementById("tb_detail2").scrollIntoView({
            behavior: 'smooth'
        });


        $(document).on("click", "#btn_add", function () {
            $('#modal_header').modal({ backdrop: 'static', keyboard: false, show: true });
            $("#title2").hide();
            $("#title1").show();
            $('.Update2').hide();
            clear();
            getDoc();
        });

        $(document).on("click", "#btn_edit", function () {
            $('#modal_header').modal({ backdrop: 'static', keyboard: false, show: true });
            $("#title1").hide();
            $("#title2").show();
            $(".Update2").hide();
            var doc_no = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('strout7.edit')}}",
                data: {
                    doc_no: doc_no,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#doc_no').val(doc_no);
                    $('#date_plan').val(result.date_plan);
                    $('#line_id').val(result.idline).trigger('change');
                    listdetail();
                }
            });
        });

        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
            list();
            getDoc();
        });

        $(document).on("click", ".Update2", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('strout7.update2')}}",
                    data: {
                        id: id.value,
                        item_id: item_id.value,
                        qty_request: qty_request.value,
                        qty_return: qty_return.value,
                        satuan: satuan.value,
                        // description: description.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        if (result.success) {
                            SweetAlert.fire({
                                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });

                            listdetail();
                            $('#item_id').val('').trigger('change');
                            $('#qty_request').val('').trigger('change');
                            $('#qty_return').val('').trigger('change');
                            $('#satuan').val('').trigger('change');
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

        $(document).on("click", "#btn_edit_line", function () {
            $("#title1").hide();
            $("#title2").show();
            $(".Update2").show();
            $(".Save").hide();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('strout7.edit2')}}",
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.success) {
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#item_id').val(result.item_id).trigger('change');
                        $('#qty_return').val(result.qty_return).trigger('change');
                        $('#qty_request').val(result.qty_request).trigger('change');
                        $('#satuan').val(result.satuan).trigger('change');
                        // $('#description').val(result.description);
                    } else {
                        SweetAlert.fire({
                            icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 1500
                        });
                    }
                }
            });
        });

        $(document).on("click", ".Save", function () {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('strout7.store')}}",
                    data: {
                        doc_no: doc_no.value,
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                        item_id: item_id.value,
                        qty_standing: qty_standing.value,
                        qty_return: qty_return.value,
                        qty_request: qty_request.value,
                        satuan: satuan.value,
                        keterangan: keterangan.value,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        const Toast = Swal.mixin({
                            icon: 'success',
                            title: 'Yeahh...',
                            text: 'Insert Item Succes...',
                            toast: true,
                            position: 'top-end',
                            iconColor: 'white',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                        });

                        if (result.success) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Yeah..',
                            });
                            listdetail();
                            $('#item_id').val('').trigger('change');
                            $("#qty_standing").val('');
                            $("#qty_return").val('');
                            $("#qty_request").val('');
                            $("#satuan").val('');
                            $("#keterangan").val('');
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: result.msg,
                            });
                        }
                    }
                });
            }
        });

        function clear() {
            $("#id").val('');
            $("#doc_no").val('');
            $("#date_plan").val('');
            $('#line_id').val('');
            $('#item_id').val('');
            $("#qty_standing").val('');
            $('#qty_return').val('');
            $('#satuan').val('');
            $('#qty_request').val('');
            $('#keterangan').val('');
            // $('#material_id').val('').trigger('change');
        }

        function updt_submit() {
            $("#alert").html('');
            $("#alert").show();
            $.ajax({
                type: 'POST',
                url: "{{route('strout7.submit')}}",
                data: {
                    doc_no: doc_no.value,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.success) {
                        $('#modal_header').modal('hide');
                        SweetAlert.fire({
                            icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                        });
                        list();
                    } else {
                        $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + result.msg + '</div>');
                        setTimeout(() => { $("#alert").hide(); }, 1500);
                    }
                }
            });
        }

        $(document).on("click", "#btn_submit", function () {
            updt_submit();
        });

        $(document).on("click", "#btn_cancel", function () {
            $('#modal_konfirmasi').modal({ backdrop: 'static', keyboard: false, show: true });
        });

        $(document).on("click", "#btn_tidak", function () {
            $('#modal_konfirmasi').modal('hide');
            $('#modal_header').modal('hide');
            delete_draft()
        });

        document.getElementById('btn_tidak').addEventListener('click', function () {
            location.reload();
        });

        $(document).on("click", "#btn_ya", function () {
            $('#modal_konfirmasi').modal('hide');
            updt_submit();
        });

        function delete_draft() {
            $.ajax({
                type: 'POST',
                url: "{{route('strout7.delete_draft')}}",
                data: {
                    doc_no: doc_no.value,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    //
                }
            });
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            customClass: {
                container: 'swal2-toast-container'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $(document).on("click", ".export-option", function () {
            let type = $(this).data("type");
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();

            if (!startDate || !endDate) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Incomplete Date Range',
                    text: 'Please select a date range before exporting.'
                });
                return;
            }

            // Export HISTORY
            if (type === "history") {
                window.location.href =
                    "{{ route('strout7.export') }}?start_date=" + startDate + "&end_date=" + endDate;
                return;
            }

            // Export SUMMARY
            if (type === "data") {
                window.location.href =
                    "{{ route('strout7.export.summary') }}?start_date=" + startDate + "&end_date=" + endDate;
                return;
            }
        });

        function validasi() {
            if (date_plan.value != '' && line_id.value != '' && item_id.value != '' && satuan.value != '' && qty_request.value != '') {
                return true;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'All columns cannot be empty!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    customClass: {
                    }
                });
                return false;
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
                        url: "{{route('strout7.destroyline')}}",
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
                            getDoc();
                        }
                    });
                }
            })
        });

        $(document).on("click", "#btn_delete", function () {
            var doc_no = $(this).data('id');
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
                        url: "{{route('strout7.destroy')}}",
                        data: { doc_no: doc_no, _token: '{{csrf_token()}}' },
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
                            getDoc();
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