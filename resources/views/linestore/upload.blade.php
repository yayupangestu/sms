@extends('layouts.app')

@section('content')
    <style>
        .table-responsive {
            overflow-x: auto;
            /* Memungkinkan scroll horizontal */
        }

        .table th,
        .table td {
            white-space: nowrap;
            /* Mencegah teks dibungkus untuk kolom tertentu */
        }

        /* Tambahan untuk kolom-kolom yang sangat lebar */
        .table td {
            padding: 8px;
            /* Mengatur padding untuk sel */
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                font-size: 12px;
                /* Mengurangi ukuran font pada perangkat kecil */
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

        .toolbar {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .toolbar select,
        .toolbar button {
            margin: 0 5px;
            padding: 5px;
            border: 1px solid #ddd;
            background: #fff;
            cursor: pointer;
        }

        .toolbar button {
            background: none;
            border: none;
            font-size: 16px;
        }

        .toolbar button:hover {
            background: #f0f0f0;
        }

        .toolbar .separator {
            border-left: 1px solid #ddd;
            height: 20px;
            margin: 0 5px;
        }

        .toolbar .more-options {
            margin-left: auto;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Upload PO Line Store</h1>
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
                        <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">PO LIST</b></h3>
                        <div class="card-tools">
                            <form id="importForm" action="{{ route('importDnLs') }}" method="POST"
                                enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf
                                <input type="file" id="fileInput" name="file" class="form-control me-2"
                                    style="width: auto;" required>
                                <button id="importButton" class="btn btn-success" type="submit" disabled>Import DN</button>
                            </form>
                            <!-- Tombol untuk Export -->
                            {{-- <form action="{{ route('exportDn') }}" method="POST" class="d-inline-block">
                        @csrf
                        <div class="d-flex align-items-center">
                            <select name="year" class="form-control me-2" required>
                                <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                                <!-- Menambahkan opsi tahun sebelumnya atau lebih banyak tahun jika diperlukan -->
                                <option value="{{ now()->subYear()->year }}">{{ now()->subYear()->year }}</option>
                            </select>
                            <select name="month" class="form-control me-2" required>
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
                            <button type="submit" class="btn btn-primary" id="exportButton">Export DN</button>
                        </div>
                    </form> --}}

                        </div>

                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-hover table-striped">
                            <thead class="table" style="background-color: #c0bcbcf8">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Supplier</th>
                                    <th>Nomor DN</th>
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
                <div class="modal-header" style="background-color: #245a7e; color:white">
                    <h4 class="modal-title" id="title1">LIST ITEM DN</h4>
                    <h4 class="modal-title" id="title2">LIST ITEM DN</h4>
                    <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="form-group row">
                       
                    </div> --}}
                </div>
                
                <div class="table-responsive">
                    <table id="example2" class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">No</th>
                                <th>NO DN</th>
                                <th>Job No</th>
                                <th>Part No</th>
                                <th>Order Qty</th>
                                <th>Supplier</th>
                                <th>Balance Order</th>
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


    <div class="modal fade" id="myModal3">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #245a7e; color:white;">
                    <h4 class="modal-title" id="title1">Create Label Part No</h4>
                    <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-12" id="alert"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="id" class="col-form-label">No DN:</label>
                                <input type="text" id="id" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="no_dn2" class="col-form-label">No DN:</label>
                                <input type="text" id="no_dn2" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="supplier" class="col-form-label">Supplier:</label>
                                <input type="text" id="supplier" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="part_no" class="col-form-label">Part No:</label>
                                <input type="text" id="part_no" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="qty_act" class="col-form-label">Qty:</label>
                                <input type="text" id="qty_act" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-success btn-sm Save">
                                    <i class="fas fa-plus-circle"></i> Insert
                                </button>
                                <button type="button" class="btn btn-warning btn-sm Update">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <button id="btn_generate_all" class="btn btn-primary">Generate Selected QR Codes</button>

                        <table id="example3" class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAll"> {{-- checkbox untuk select semua --}}
                                    </th>
                                    <th>No DN</th>
                                    <th>Part No</th>
                                    <th>Supplier</th>
                                    <th>Qty</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <!-- Table rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
        <input type="hidden" id="no_dn">
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
                    pageLength: 5,
                    ajax: {
                        url: "{{ route('linestoreupload.list') }}"
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
                            data: 'supplier',
                            name: 'supplier',
                        },
                        {
                            data: 'no_dn',
                            name: 'no_dn',
                        },
                        {
                            data: 'no_dn',
                            name: 'no_dn',
                            render: function(data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="' + data +
                                    '" class="btn btn-info btn-sm">' +
                                    '<i class="fas fa-search"></i>' +
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
                        url: "{{ route('linestoreupload.listdetail') }}",
                        data: {
                            no_dn: no_dn.value,
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
                            data: 'no_dn',
                            name: 'no_dn'
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
                            data: 'order_part',
                            name: 'order_part'
                        },
                        {
                            data: 'balance_order',
                            name: 'balance_order'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
                        },
                        {
                            data: 'part_no',
                            name: 'part_no',
                            render: function(data, type, row) {
                                return `
            <a href="#" 
               id="btn_delete_line" 
               title="Delete" 
               data-id="${row.id}" 
               class="btn btn-danger btn-sm ml-1">
                <i class="far fa-trash-alt"></i>
            </a>
            <a href="#" 
               id="btn_edit_line" 
               title="Edit" 
               class="btn btn-primary btn-sm ml-1"
               data-id="${row.id}"
               data-part_no="${row.part_no}"
               data-no_dn="${row.no_dn}"
               data-supplier="${row.supplier}">
                <i class="fas fa-pencil-alt"></i>
            </a>
        `;
                            }
                        }

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
                        sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                    }
                });
            }

            $(document).on('click', '#selectAll', function () {
    $('.dataCheckbox').prop('checked', this.checked);
});



$(document).on('click', '#btn_generate_all', function(e) {
    e.preventDefault();

    const selectedIds = [];
    $('.dataCheckbox:checked').each(function() {
        selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Pilih setidaknya satu data untuk generate QR Code!',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    $.ajax({
        url: "{{ route('linestoreupload.generateMultipleQrCodes') }}",
        method: 'POST',
        xhrFields: {
            responseType: 'blob' // penting agar file binary (PDF) bisa diproses
        },
        data: {
            ids: selectedIds,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            const blob = new Blob([response], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'qrcodes_' + new Date().toISOString().slice(0, 10) + '.pdf';
            link.click();
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat memproses data.',
                showConfirmButton: true
            });
        }
    });
});


            function listdetail2() {
    var table = $('#example3').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: false,
        searching: true,
        bLengthChange: true,
        destroy: true,
        pageLength: 10,
        ajax: {
            url: "{{ route('linestoreupload.listdetail2') }}",
            data: {
                no_dn: $('#no_dn2').val(),
                part_no: $('#part_no').val()
            }
        },
        columns: [
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return `<input type="checkbox" class="dataCheckbox" value="${data}">`;
                }
            },
            { data: 'no_dn', name: 'no_dn' },
            { data: 'part_no', name: 'part_no' },
            { data: 'supplier', name: 'supplier' },
            { data: 'qty_act', name: 'qty_act' },
            {
    data: 'id',
    name: 'id',
    render: function(data, type, row) {
        return `
            <a href="#" id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-sm ml-1">
                <i class="far fa-trash-alt"></i>
            </a>
            <a href="#" id="btn_edit_line" title="Edit" class="btn btn-primary btn-sm ml-1"
                data-id="${row.id}"
                data-part_no="${row.part_no}"
                data-no_dn="${row.no_dn}"
                data-supplier="${row.supplier}"
                data-qty="${row.qty_act}">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <a href="#" id="genrate_qrcode" title="qrcode" data-id="${data}" class="btn btn-info btn-sm ml-1">
                <i class="far fa-qrcode"></i>
            </a>
        `;
    }
}

        ],
        columnDefs: [
            { targets: [0], orderable: false }
        ],
        responsive: true,
        fixedColumns: true,
        oLanguage: {
            sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
        }
    });
}




            $('#saveChanges').on('click', function() {
                let dataToSend = [];

                $('.actual-sheet').each(function() {
                    let orderPart = $(this).val();
                    let id = $(this).data('id');

                    dataToSend.push({
                        id: id,
                        order_part: orderPart
                    });
                });

                // Send the data to the server via AJAX
                $.ajax({
                    url: "{{ route('linestoreupload.update') }}", // Your update route here
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}", // Include CSRF token for security
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


            $(document).on("click", "#btn_edit", function() {
                $("#title1").hide();
                $("#title2").show();
                var id = $(this).data('id');
                var no_dn = id;

                $('#myModal2').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                $('#no_dn').val(no_dn);

                listdetail();
            });

            $(document).on("click", "#btn_edit_line", function() {
                $("#title1").hide();
                $("#title2").show();

                // Ambil semua data dari atribut data-*
                var id = $(this).data('id');
                var part_no = $(this).data('part_no');
                var no_dn2 = $(this).data('no_dn');
                var supplier = $(this).data('supplier');


                // Tampilkan modal
                $('#myModal3').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });

                // Isi input form
                $('#id').val(id);
                $('#part_no').val(part_no);
                $('#no_dn2').val(no_dn2);
                $('#supplier').val(supplier);


                // Tampilkan detail tabel
                listdetail2(no_dn2, part_no);
            });



            // $(document).on("click", "#btn_edit_line", function() {
            //     $(".Save").show();
            //     $(".Update").show();
            //     $("#title1").hide();
            //     $("#title2").show();
            //     var id = $(this).data('id');
            //     $.ajax({
            //         type: 'GET',
            //         url: "{{ route('linestoreupload.edit') }}",
            //         data: {
            //             id: id,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         success: function(result) {
            //             if (result.success) {
            //                 $('#myModal3').modal({
            //                     backdrop: 'static',
            //                     keyboard: false,
            //                     show: true
            //                 });
            //                 $('#id').val(result.id);
            //                 $('#no_dn2').val(result.no_dn2).trigger('change');
            //                 $('#part_no').val(result.part_no).trigger('change');
            //                 $('#supplier').val(result.supplier).trigger('change');
            //                 $('#qty_act').val(result.qty_cat).trigger('change');
            //             } else {
            //                 SweetAlert.fire({
            //                     icon: 'warning',
            //                     title: 'Warning',
            //                     text: result.msg,
            //                     showConfirmButton: false,
            //                     timer: 1500
            //                 });
            //             }
            //         }
            //     });
            // });


            $(document).on("click", ".Save", function() {
                $("#alert").html('');
                $("#alert").show();
                if (validasi()) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('linestoreupload.store') }}",
                        data: {
                            id: id.value,
                            no_dn: no_dn.value,
                            part_no: part_no.value,
                            // job_no: job_no.value,
                            qty_act: qty_act.value,
                            supplier: supplier.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success) {
                                $("#alert").html(
                                    '<div class="alert alert-success"><i class="fa fa-check"></i> ' +
                                    result.msg + '</div>');
                                listdetail2();
                                $('#qty_act').val('').trigger('change');
                                // $("#qty_plan").val('');
                                // $('#material_id').val('').trigger('change');
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

            function validasi() {
                $("#alert").show();
                if (qty_act.value != '') {
                    return true;
                } else {
                    $("#alert").html(
                        '<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
                    setTimeout(() => {
                        $("#alert").hide();
                    }, 1500);
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
                    url: "{{route('linestoreupload.destroyline')}}",
                    data: {id: id, _token: '{{csrf_token()}}'},
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
                        listdetail2();
                    }
                });
                }
            })
        });

            $(document).on("click", "#btn_delete", function() {
                var id = $(this).data('id');
                var no_dn = id;
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
                            url: "{{ route('linestoreupload.destroy') }}",
                            data: {
                                no_dn: no_dn,
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
        <style>
            .centered-text {
                text-align: center;
            }


            tr:nth-child(even) {
                background-color:
                    #efefeff8;
            }
        </style>
        <!-- DataTables -->
        <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @endpush
