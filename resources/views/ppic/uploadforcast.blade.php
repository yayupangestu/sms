@extends('layouts.app')

@section('content')
    <style>
        /* ===== Container & Section ===== */
        section.content {
            background-color: #f5f6f7;
            /* abu-abu muda netral */
            padding: 15px;
        }

        .container-fluid {
            background-color: transparent;
        }

        /* ===== Card ===== */
        .card {
            border-radius: 8px;
            border: none;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* ===== Card Header ===== */
        .card-header {
            background-color: #fff !important;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 15px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .card-title i {
            color: #5c6bc0;
            /* Biru SAP-style */
            margin-right: 8px;
        }

        /* ===== Table ===== */
        /* ===== Full Table Grid Style (SAP-like) ===== */
        table.table {
            border-collapse: collapse;
            /* menyatukan border jadi grid */
            width: 100%;
            background-color: #fff;
            font-size: 13px;
            /* kecil tapi tetap terbaca */
            line-height: 1.4;
            border: 1px solid #ccc;
            /* border luar tabel */
        }

        /* Header */
        table.table thead {
            background-color: #f1f3f4;
            /* abu muda header */
        }

        table.table thead th {
            border: 1px solid #ccc;
            /* garis grid */
            padding: 6px 8px;
            /* kecilkan padding */
            text-align: center;
            font-weight: 600;
            color: #295b8c;
            white-space: nowrap;
        }

        /* Body */
        table.table tbody td {
            border: 1px solid #ccc;
            /* garis grid */
            padding: 5px 8px;
            /* kecilkan padding */
            vertical-align: middle;
            color: #333;
        }

        /* Hover effect */
        table.table tbody tr:hover {
            background-color: #e6f0ff;
            /* highlight ringan */
        }

        /* Responsive text kecil */
        @media (max-width: 768px) {
            table.table {
                font-size: 12px;
            }
        }

        /* ===== Buttons ===== */
        .btn {
            border-radius: 6px;
            font-size: 13px;
            padding: 5px 10px;
        }

        /* ===== Form Controls ===== */
        .form-control {
            font-size: 13px;
            height: 34px;
        }

        input[type="file"] {
            padding: 3px;
            font-size: 13px;
        }

        #example1 th {
            font-weight: 600;
            color: #295b8c;
            border-bottom: 2px solid #dee2e6;
        }

        #example1 td {
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        #example1 tbody tr:hover {
            background-color: #82a8cf;
            cursor: pointer;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
        }

        .btn-sm {
            border-radius: 6px;
        }


        /* modal */
        /* Container untuk mencegah modal memanjang ke bawah */
.table-container {
    max-height: 500px;
    overflow-y: auto;  /* scroll ke bawah */
    overflow-x: hidden; /* tidak perlu scroll samping */
    border: 1px solid #dee2e6;
    border-radius: 6px;
}

/* Header tetap */
.table-container thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 10;
    border-bottom: 2px solid #d4d4d4;
}

/* Rapi seperti ERP */
.table td, .table th {
    vertical-align: middle;
    white-space: nowrap;   /* tampilan ERP, tidak wrap */
}

.modal-header h4 {
    font-weight: 600;
    letter-spacing: .5px;
}

.modal-content {
    border-radius: 10px;
    box-shadow: 0px 4px 20px rgba(0,0,0,0.15);
}

.summary-wrapper {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 10px;
        white-space: nowrap;
    }

    .small-summary-box {
        min-width: 160px;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        border: 1px solid #dcdcdc;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: inline-block;
    }

    .small-summary-box .summary-title {
        font-size: 13px;
        font-weight: bold;
        color: #333;
        margin-bottom: 4px;
        text-transform: uppercase;
    }

    .small-summary-box .summary-value {
        font-size: 18px;
        font-weight: bold;
        color: #000;
        padding: 6px 0;
        background: #ffffff;
        border-radius: 6px;
        border: 1px solid #d0d0d0;
    }


    .header-btn-group .btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 500;
    padding: 6px 12px;
}

.header-btn-group {
    gap: 8px; /* jarak antar tombol */
}

.header-btn-group i {
    font-size: 14px;
}


    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Line uploadforcast</h1>
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
                    <div class="card shadow-sm border-0">
                        <div class="card-header"
                            style="background: linear-gradient(90deg, #f8f9fa, #e9ecef); border-bottom: 2px solid #dee2e6;">
                            <h3 class="card-title mb-0" style="font-weight: 600; color: #495057;">
                                <i class="fas fa-border-none me-2"></i>
                                Data Line uploadforcast Data
                            </h3>
                            <div
                                class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center mt-2 mt-md-0">
                                <form id="importForm" action="{{ route('uploadforcast.importDp') }}" method="POST"
                                    enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                                    @csrf
                                    <input type="file" id="fileInput" name="file"
                                        class="form-control form-control-sm me-2" style="width: auto; border-radius: 6px;"
                                        required>
                                    <button id="importButton" class="btn btn-outline-primary btn-sm" type="submit"
                                        disabled>
                                        <i class="fas fa-upload"></i> Import
                                    </button>
                                </form>
                                <!-- Tombol untuk membuka modal -->
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#myModal">                        
                                    <i class="fas fa-file-export"></i> Export
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table id="example1" class="table table-hover table-striped align-middle mb-0">
                                <thead style="background-color: #f1f3f5;">
                                    <tr>
                                        <th width="50" class="text-center">No</th>
                                        <th class="text-center">FORCAST PERIODE</th>
                                        <th width="80" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan di-load di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content shadow-sm border-0 rounded-3">
    
                <!-- Header -->
                <div class="modal-header bg-secondary text-white py-2 rounded-top">
                    <h6 class="modal-title fw-bold">Export Data</h6>
    
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
    
                <!-- Body -->
                <div class="modal-body text-center p-3">
                    <p class="mb-3 text-muted small">Pilih jenis download yang Anda inginkan:</p>
    
                    <a href="{{ route('uploadforcastformat.export') }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                        <i class="fas fa-download"></i> Download Format
                    </a>
    
                    <a href="{{ route('uploadforcastdata.export') }}" class="btn btn-outline-primary btn-sm w-100 mb-3">
                        <i class="fas fa-download"></i> Download Data
                    </a>
    
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
    
            </div>
        </div>
    </div>
    
   


    
    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
    
                <div class="modal-header bg-primary text-white" style="background:#cccccd!important;">
                    <h4 class="modal-title" id="judulModal2" style="color: #000000">
                        LIST ITEM DELIVERY TAHUN
                    </h4>
                
                    <div class="header-btn-group d-flex align-items-center gap-2 mb-3">

                        <!-- Import File -->
                        <button class="btn btn-secondary btn-sm d-flex align-items-center" id="btnImportFile">
                            <i class="fas fa-file-import mr-1"></i> Import File
                        </button>
                    
                        <!-- Excel -->
                        {{-- <button  href="{{ route('uploadforcastformat2.export3') }}" type="button" class="btn btn-success btn-sm d-flex align-items-center" onclick="exportExcel()">
                            <i class="fa fa-file-excel mr-1"></i> Format Upload
                        </button> --}}

                        <a href="{{ route('uploadforcastformat2.export3') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                            <i class="fas fa-download"></i> Download Format
                        </a>
                    
                        <!-- PDF -->
                        <button type="button" class="btn btn-danger btn-sm d-flex align-items-center" onclick="exportPDF()">
                            <i class="fa fa-file-pdf mr-1"></i> PDF
                        </button>
                    
                        {{-- <!-- Refresh -->
                        <button type="button" class="btn btn-secondary btn-sm d-flex align-items-center" onclick="refreshDetail()">
                            <i class="fa fa-sync mr-1"></i> Refresh
                        </button> --}}
                    
                        <!-- Close -->
                        <button type="button" class="btn btn-light btn-sm d-flex align-items-center ml-auto" data-dismiss="modal">
                            Close
                        </button>
                    
                    </div>
                    
                </div>
                
    
                <div class="modal-body">
    
                    <!-- 🔥 SUMMARY BOX STYLE ERP (Kecil) -->
                    <div class="summary-wrapper">

                        <div class="small-summary-box">
                            <div class="summary-title">ADM PLANT 1</div>
                            <div id="sumAdm1" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">ADM PLANT 4</div>
                            <div id="sumAdm4" class="summary-value">0</div>
                        </div>

                        <div class="small-summary-box">
                            <div class="summary-title">ADM PLANT 5</div>
                            <div id="sumAdm5" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">TMMIN</div>
                            <div id="sumTmmin" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">GAYA MOTOR</div>
                            <div id="sumGayaMotor" class="summary-value">0</div>
                        </div>
                    
                        <!-- Tambahan -->
                        <div class="small-summary-box">
                            <div class="summary-title">FTI</div>
                            <div id="sumFti" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">HMMI</div>
                            <div id="sumHmmi" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">HPM</div>
                            <div id="sumHpm" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">IPPI</div>
                            <div id="sumIppi" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">MAJ</div>
                            <div id="sumMaj" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">MES</div>
                            <div id="sumMes" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">MKM</div>
                            <div id="sumMkm" class="summary-value">0</div>
                        </div>
                    
                        <div class="small-summary-box">
                            <div class="summary-title">PINDAD</div>
                            <div id="sumPindad" class="summary-value">0</div>
                        </div>
                    
                    </div>
                    
                    
                    
                    <!-- END SUMMARY BOX -->
    
                    <div class="table-container">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Job No</th>
                                    <th>Unique No</th>
                                    <th>Part Name</th>
                                    <th>Part No</th>
                                    <th>Qty/Kanban</th>
                                    <th>Customer</th>
                                    <th>January</th>
                                    <th>January/Month</th>
                                    <th>February</th>
                                    <th>February/Month</th>
                                    <th>March</th>
                                    <th>March/Month</th>
                                    <th>April</th>
                                    <th>April/Month</th>
                                    <th>May</th>
                                    <th>May/Month</th>
                                    <th>June</th>
                                    <th>June/Month</th>
                                    <th>July</th>
                                    <th>July/Month</th>
                                    <th>August</th>
                                    <th>August/Month</th>
                                    <th>September</th>
                                    <th>September/Month</th>
                                    <th>October</th>
                                    <th>October/Month</th>
                                    <th>November</th>
                                    <th>November/Month</th>
                                    <th>December</th>
                                    <th>December/Month</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>
    
    
    <!-- MODAL IMPORT FILE -->
<div class="modal fade" id="modalImportFile">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Import Delivery / Bulan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="importForm2" action="{{ route('uploadforcast.importforcast2') }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                    @csrf
                    <input type="file" id="fileInput2" name="file"
                        class="form-control form-control-sm me-2" style="width: auto; border-radius: 6px;"required>
                    <button id="importButton2" class="btn btn-outline-primary btn-sm" type="submit" disabled>
                        <i class="fas fa-upload"></i> Import
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

    
    
<input type="hidden" id="tahun">

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
                    url: "{{ route('uploadforcast.list') }}"
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
                        data: 'tahun',
                        name: 'tahun',
                        className: 'text-center' // ⭐ DITENGAHKAN
                    },
                    {
                        data: 'mix_id',
                        name: 'mix_id',
                        className: 'text-center',
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

$("#myModal2 .modal-title").text("LIST ITEM DELIVERY TAHUN " + tahun.value);

$.ajax({
    url: "{{ route('uploadforcast.listdetail') }}",
    type: "GET",
    data: { tahun: tahun.value },

    success: function(response) {

        // 🔥 UPDATE SUMMARY BOX (TETAP)
        $("#sumAdm1").text((response.sum_adm1 ?? 0).toLocaleString());
        $("#sumAdm4").text((response.sum_adm4 ?? 0).toLocaleString());
        $("#sumAdm5").text((response.sum_adm5 ?? 0).toLocaleString());
        $("#sumTmmin").text((response.sum_tmmin ?? 0).toLocaleString());
        $("#sumGayaMotor").text((response.sum_gayamotor ?? 0).toLocaleString());

        $("#sumFti").text((response.sum_fti ?? 0).toLocaleString());
        $("#sumHmmi").text((response.sum_hmmi ?? 0).toLocaleString());
        $("#sumHpm").text((response.sum_hpm ?? 0).toLocaleString());
        $("#sumIppi").text((response.sum_ippi ?? 0).toLocaleString());
        $("#sumMaj").text((response.sum_maj ?? 0).toLocaleString());
        $("#sumMes").text((response.sum_mes ?? 0).toLocaleString());
        $("#sumMkm").text((response.sum_mkm ?? 0).toLocaleString());
        $("#sumPindad").text((response.sum_pindad ?? 0).toLocaleString());


        // 🔥 LOAD DATATABLE (TETAP)
        $('#example2').DataTable({
            processing: true,
            serverSide: false,
            autoWidth: false,
            scrollX: true,
            destroy: true,
            pageLength: 15,
            data: response.data.data,
            columns: [
                { data: null, render: (d, t, r, m) => m.row + 1 },
                { data: 'job_no' },
                { data: 'uniqNo' },
                { data: 'part_name' },
                { data: 'part_no' },
                { data: 'qty_kanban' },
                { data: 'customer' },

                { data: 'jan' }, { data: 'jan_month' },
                { data: 'feb' }, { data: 'feb_month' },
                { data: 'mar' }, { data: 'mar_month' },
                { data: 'apr' }, { data: 'apr_month' },
                { data: 'may' }, { data: 'may_month' },
                { data: 'jun' }, { data: 'jun_month' },
                { data: 'jul' }, { data: 'jul_month' },
                { data: 'aug' }, { data: 'aug_month' },
                { data: 'sep' }, { data: 'sep_month' },
                { data: 'oct' }, { data: 'oct_month' },
                { data: 'nov' }, { data: 'nov_month' },
                { data: 'dec' }, { data: 'dec_month' },

                {
                    data: 'id',
                    render: function (data) {
                        return `
                            <button class="btn btn-sm btn-primary" onclick="editData(${data})">
                                <i class="fa fa-edit"></i>
                            </button>`;
                    }
                }
            ],

            // ⭐️ PEWARNAAN HANYA TAMBAHAN – SCRIPT LAMA TETAP
            createdRow: function(row, data) {

                function warna(idx1, idx2, valMain, valMonth) {
                    if (valMonth === null) return;  // bulan_month null → tidak kasih warna

                    let td1 = $('td', row).eq(idx1);
                    let td2 = $('td', row).eq(idx2);

                    if (valMain == valMonth) {
                        td1.css("background", "#cfe8ff");
                        td2.css("background", "#cfe8ff");
                    } else {
                        td1.css("background", "#fff3b0");
                        td2.css("background", "#fff3b0");
                    }
                }

                // Index kolom sesuai DataTable
                warna(7, 8, data.jan, data.jan_month);
                warna(9, 10, data.feb, data.feb_month);
                warna(11, 12, data.mar, data.mar_month);
                warna(13, 14, data.apr, data.apr_month);
                warna(15, 16, data.may, data.may_month);
                warna(17, 18, data.jun, data.jun_month);
                warna(19, 20, data.jul, data.jul_month);
                warna(21, 22, data.aug, data.aug_month);
                warna(23, 24, data.sep, data.sep_month);
                warna(25, 26, data.oct, data.oct_month);
                warna(27, 28, data.nov, data.nov_month);
                warna(29, 30, data.dec, data.dec_month);
            }

        });

    }
});
}





        
        
        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var tahun = id;

            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#tahun').val(tahun);
            // $("#judulModal2").text("LIST ITEM DELIVERY TAHUN " + tahun.value);


            listdetail();
        });
// Tampilkan modal import saat tombol diklik
document.getElementById('btnImportFile').addEventListener('click', function () {
    $('#modalImportFile').modal('show');
});


        
        
        
                // $(document).on("click", "#btn_add", function () {
                //     $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                //     $(".Update").hide();
                //     $("#title2").hide();
                //     $(".Save").show();
                //     $("#title1").show();
                // });





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
                    url: "{{ route('uploadforcast.store') }}",
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
                    url: "{{ route('uploadforcast.update') }}",
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
                        url: "{{ route('uploadforcast.destroy') }}",
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
                url: "{{ route('uploadforcast.importDp') }}", // Replace with your route name
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



        const fileInput2 = document.getElementById('fileInput2');
        const importButton2 = document.getElementById('importButton2');
        // Menonaktifkan tombol jika tidak ada file yang dipilih
        fileInput2.addEventListener('change', function() {
            if (fileInput2.files.length > 0) {
                importButton2.disabled = false; // Aktifkan tombol jika ada file yang dipilih
            } else {
                importButton2.disabled = true; // Nonaktifkan tombol jika tidak ada file
            }
        });

        document.getElementById('importForm2').addEventListener('submit', function(event) {
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

        function importData2() {
            let formData = new FormData();
            formData.append('file', document.getElementById('fileInput2').files[0]);

            $.ajax({
                url: "{{ route('uploadforcast.importforcast2') }}", // Replace with your route name
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
        
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
