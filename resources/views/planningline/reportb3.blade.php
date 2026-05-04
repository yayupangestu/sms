@extends('layouts.app')

@section('content')
<style>
/* Animasi fade-in */
.fade-in {
    opacity: 0;
    transform: translateY(10px);
    animation: fadeInAnimation 0.5s ease-in-out forwards;
}

@keyframes fadeInAnimation {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Warna Header */
.bg-yellow {
    background: #FFC107; /* Warna kuning yang lebih profesional */
    color: #333;
    font-weight: bold;
    text-transform: uppercase;
}

.bg-secondary {
    background: #6C757D; /* Warna abu-abu yang lebih lembut */
    color: #FFF;
    font-weight: bold;
    text-transform: uppercase;
}

/* Teks kategori shift */
.text-success {
    color: #28a745;
    font-weight: bold;
}

.text-primary {
    color: #6C757D;
    font-weight: bold;
}

/* Tampilan Tabel Lebih Modern */
.table {
    border-collapse: separate;
    border-spacing: 0 10px;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
}

.table th {
    padding: 14px;
    text-align: center;
    font-weight: bold;
    background-color: #343A40;
    color: white;
    border-radius: 10px 10px 0 0;
}

.table td {
    padding: 12px;
    text-align: center;
    background-color: #f8f9fa;
    border-bottom: 2px solid #ddd;
    transition: all 0.3s ease-in-out;
}

/* Efek Hover */
.table tbody tr:hover {
    background-color: #FFF8E1; /* Warna hover lebih soft */
    transform: scale(1.01);
    transition: all 0.2s ease-in-out;
}

/* Responsif */
.table-responsive {
    overflow-x: auto;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}


</style>
<div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0" style="font-family: 'Times New Roman', Times, serif">Report Laporan Harian Kerja LINE B3</h1>
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
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title" style="font-family: 'Times New Roman', Times, serif">
                            <i class="fa fa-file-alt"></i> Laporan Harian Kerja LINE B3
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label">Date:</label>
                                    <div class="col-sm-3">
                                        <input type="date" id="date_plan" class="form-control form-control-sm" required>
                                    </div>

                                    <label class="col-sm-1 col-form-label">Line:</label>
                                    <div class="col-sm-3">
                                        <select id="line_stmp" class="form-control form-control-sm select2" required>
                                            <option value="" selected>- pilih -</option>
                                            <option value="LINE B3">LINE B3</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-primary btn-sm" id="btn_search">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tables-container">
                            <!-- Tabel akan muncul di sini setelah data di-filter -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
    $("#example1").hide();
});

$(document).on("click", "#btn_search", function () {
    if($("#date_plan").val() != '' && $("#line_stmp").val() != ''){
        $("#example1").show();
        list();
    }else{
        $("#example1").hide();
    }
});

function list() {
    let shift1HTML = '';
    let shift2HTML = '';
    let no1 = 1;
    let no2 = 1;

    $.ajax({
        type: 'GET',
        url: "{{route('reportb3.list')}}",
        data: {
            date_plan: $("#date_plan").val(),
            line_stmp: $("#line_stmp").val()
        },
        success: function(result) {
            $("#tables-container").empty(); // Kosongkan sebelum diisi ulang

            $.each(result.data, function(key, value) {
                let rowHTML = `<tr class="fade-in">
                    <td>${value.shift == 'SHIFT 1' ? no1++ : no2++}</td>
                       <td>${value.line_stmp ?? '-'}</td>
                    <td>${value.date_plan ?? '-'}</td>
                    <td>${value.job_no ?? '-'}</td>
                    <td>${value.part_no ?? '-'}</td>
                    <td>${value.part_name ?? '-'}</td>
                    <td>${value.model ?? '-'}</td>
                    <td>${value.qty_ok !== null ? value.qty_ok : '-'}</td>
                    <td>${value.qty_ng !== null ? value.qty_ng : '-'}</td>
                    <td>${value.time_start ?? '-'}</td>
                    <td>${value.time_end ?? '-'}</td>
                    <td>${value.shift ?? '-'}</td>
                    <td>${value.createdby ?? '-'}</td>
                    <td>${value.keterangan ?? '-'}</td>
                </tr>`;

                if (value.shift === 'SHIFT 1') {
                    shift1HTML += rowHTML;
                } else if (value.shift === 'SHIFT 2') {
                    shift2HTML += rowHTML;
                }

            });

            if (shift1HTML !== '') {
    $("#tables-container").append(`
        <h4 class="mt-4 text-black">Shift 1</h4>
        <div class="table-responsive fade-in">
            <table class="table table-bordered">
                <thead class="bg-yellow text-white">
                     <tr>
                        <th>No</th>
                        <th>Line</th>
                        <th>Tanggal</th>
                        <th>Job NO</th>
                        <th>Part No</th>
                        <th>Part Name</th>
                        <th>Model</th>
                        <th>QTY Actual</th>
                        <th>QTY NG</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Shift</th>
                        <th>Leader Shift</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>${shift1HTML}</tbody>
            </table>
        </div>
    `);
}

if (shift2HTML !== '') {
    $("#tables-container").append(`
        <h4 class="mt-4 text-black">Shift 2</h4>
        <div class="table-responsive fade-in">
            <table class="table table-bordered">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Job NO</th>
                        <th>Part No</th>
                        <th>Part Name</th>
                        <th>Model</th>
                        <th>QTY Actual</th>
                        <th>QTY NG</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Shift</th>
                        <th>Leader Shift</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>${shift2HTML}</tbody>
            </table>
        </div>
    `);
}

        }
    });
}

$(document).ready(function() {
    $("#btn_search").click(function() {
        list();
    });
});
</script>
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
