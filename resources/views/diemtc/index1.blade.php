@extends('layouts.app')

@section('content')
    <style>
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .scrollable-columns {
            flex: 1 1 auto;
            overflow-x: auto;
            overflow-y: hidden;
            max-width: 100%;
            display: block;
        }

        .fixed-columns {
            flex: 0 0 auto;
            width: 650px;
        }


        /* Kolom kanan bisa di-scroll horizontal */
        .scrollable-columns {
            flex: 1 1 auto;
            overflow-x: auto;
            overflow-y: hidden;
            max-width: calc(100vw - 700px);
            white-space: nowrap;
            border-left: 2px solid #ddd;
        }

        /* Supaya tabel di kanan tidak melampaui batas */
        .scrollable-columns table {
            table-layout: fixed;
            min-width: 1800px;
            width: max-content;
        }

        /* Efek drag scroll */
        .scrollable-columns::-webkit-scrollbar {
            height: 8px;
        }

        .scrollable-columns::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .scrollable-columns::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

      /* Data vertikal (miring ke atas) */
.vertical-text {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    text-align: center;
    vertical-align: middle;
    height: 220px;
    font-size: 20px;
    white-space: nowrap;
    padding: 4px;
}


        /* Lingkaran merah di tabel kanan */
        .red-circle {
            width: 20px;
            height: 20px;
            background-color: rgb(208, 255, 0);
            border-radius: 80%;
            margin: auto;
        }

        /* Header bulan dan minggu */
        .month-header {
            background-color: #fff9a5 !important;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 10px;
            text-align: center;
            font-size: 13px;
            white-space: nowrap;
        }

        th {
            background-color: #004b8d;
            color: white;
            font-weight: bold;
        }

        .month-header {
            background-color: #e3f2fd;
            font-weight: bold;
            color: #004b8d;
        }

        tr:nth-child(even) td {
            background-color: #f9fafb;
        }

        tr:hover td {
            background-color: #eaf4ff;
        }

        /* Garis pembatas antar bulan */
        thead tr:nth-child(2) th:nth-child(4n),
        tbody td:nth-child(4n) {
            border-right: 3px solid #333;
        }

        /* Tabel isi scrollable */
        .wide-table {
            border-collapse: collapse;
            margin: 10px auto;
            font-family: Arial, sans-serif;
            text-align: center;
            width: 100%;
        }

        .wide-table th.month-header {
            background: #2d89ef;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 16px;
        }

        .wide-table td {
            height: 30px;
            width: 10px;
        }

        /* Hilangkan panah atas/bawah di input number */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Untuk Firefox */
        }

        .help {
            cursor: help;
        }

        .modal {
    pointer-events: none;
}

.modal-dialog {
    pointer-events: all;
}

.card-title{
    font-family: 'Times New Roman', Times, serif;
    font-size: 25px;
    color: white;
}

.total-month-row{
    font-size: 80%;
    background-color: #ddd
}


    </style>



    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">List Dies</h1>
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
                        <form action="{{ route('lkhb3.update') }}" method="POST">
                            @csrf
                            <div class="card-header" style="background-color: #004b8d">
                                <h5 class="card-title">List History Stroke Stamping</h5>
                                <div class="card-tools">

                                    {{-- <button class="btn btn-danger btn-sm" name="button" value="print" type="submit"><i class="fa fa-file-pdf"></i> Export PDF</button> --}}
                                    {{-- <button class="btn btn-success btn-sm" name="button" value="#" type="submit"><i class="fa fa-file-excel"></i> Export XCEL</button> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-12" id="alert"></div>
                                            <label class="col-sm-1 col-form-label">TAHUN:</label>
                                            <div class="col-sm-2">
                                                <select id="date_plan" class="form-control form-control-sm" required>
                                                    <option value="">Pilih Tahun</option>
                                                </select>
                                            </div>

                                            <label class="col-sm-1 col-form-label">Part No :</label>
                                            <div class="col-sm-2 mb-1">
                                                <select style="width: 100%;" id="part_no" class="form-control select2"
                                                    required>
                                                    <option value="" selected>- pilih -</option>
                                                    <option value="all">Tampilkan Semua</option> <!-- ✅ Tambahan -->
                                                    @foreach ($tabel_list_dies as $partNo)
                                                        <option value="{{ $partNo->part_no }}">{{ $partNo->part_no }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-sm-6 d-flex align-items-center">
                                                <button type="button" class="btn btn-primary mr-2" id="btn_search">
                                                    <i class="fa fa-search"></i> Search
                                                </button>

                                                <!-- SPINNER -->
                                                <div id="spinner_load"
                                                    style="display:none; width:24px; height:24px;"
                                                    class="spinner-border text-primary mr-3"
                                                    role="status">
                                                </div>

                                                <!-- LEGEND -->
                                                <div class="d-flex flex-wrap" style="gap: 10px; font-size: 12px; font-weight: bold;">
                                                    <div class="d-flex align-items-center border px-2 py-1 rounded bg-white">
                                                        <span class="d-inline-block bg-success rounded-circle mr-2" style="width: 14px; height: 14px;"></span>
                                                        <span>Waktu Preventive</span>
                                                    </div>
                                                    <div class="d-flex align-items-center border px-2 py-1 rounded bg-white">
                                                        <span class="d-inline-block bg-warning rounded-circle mr-2" style="width: 14px; height: 14px;"></span>
                                                        <span>Next Preventive</span>
                                                    </div>
                                                    <div class="d-flex align-items-center border px-2 py-1 rounded bg-white">
                                                        <span class="d-inline-block bg-info rounded-circle mr-2" style="width: 14px; height: 14px;"></span>
                                                        <span>Total Stroke > 90%</span>
                                                    </div>
                                                    <div class="d-flex align-items-center border px-2 py-1 rounded bg-white">
                                                        <span class="d-inline-block bg-danger rounded-circle mr-2" style="width: 14px; height: 14px;"></span>
                                                        <span>Total Stroke > 100%</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="table-wrapper">
                                        <div class="fixed-columns">
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead class="table" style="background-color:rgb(255, 249, 134)">
                                                    </thead>
                                                    <tbody id="tb_detail" class="vertical-data"></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="scrollable-columns">
                                            <div class="scroll-container">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr class="month-row"></tr>
                                                        <tr class="value-row"></tr>
                                                        <tr class="week-row"></tr>
                                                    </thead>
                                                    <tbody class="wide-table"></tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MODAL DETAIL -->
    <div class="modal fade" id="weekModal" tabindex="-1"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content shadow-lg border-0 rounded-3"
             style="background: #f8f9fa;"> <!-- Abu muda -->

            <div class="modal-header" style="background: #e9ecef;"> <!-- Abu lebih gelap -->
                <h5 class="modal-title fw-bold text-secondary">Detail Minggu</h5>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                  </button>
            </div>

            <div class="modal-body" id="modalContent" style="background: #ffffff;"> <!-- Putih -->
                <!-- Konten akan masuk lewat JS -->
            </div>

        </div>
    </div>
</div>

    <!-- Modal for LKH Details -->
    <div class="modal fade" id="lkhDetailModal" tabindex="-1" aria-labelledby="lkhDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="lkhDetailModalLabel">Detail LKH Dies MTC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Job No:</strong> <span id="modalJobNo"></span> |
                        <strong>Part No:</strong> <span id="modalPartNo"></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="lkhDetailTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Category</th>
                                    <th>Problem</th>
                                    <th>Perbaikan</th>
                                    <th>DT Total</th>
                                    <th>Start</th>
                                    <th>Finish</th>
                                    <th>PIC</th>
                                </tr>
                            </thead>
                            <tbody id="lkhDetailTableBody">
                                <tr>
                                    <td colspan="7" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                  </button>
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
        const select = document.getElementById('date_plan');
        const currentYear = new Date().getFullYear();
        for (let y = 2000; y <= 2100; y++) {
            const option = document.createElement('option');
            option.value = y;
            option.textContent = y;
            if (y === currentYear) option.selected = true;
            select.appendChild(option);
        }

        $("#example1").hide();

$(document).on("click", "#btn_search", function () {
    const partNo = $('#part_no').val();
    const year   = $('#date_plan').val();

    if (partNo !== '') {
        $("#example1").show();
        loadList(partNo, year);
    } else {
        $("#example1").hide();
    }
});
function loadList(partNoValue, yearValue) {

$("#spinner_load").show();

$.ajax({
    type: 'GET',
    url: "{{ route('tabelprev.list') }}",
    data: {
        part_no: partNoValue,
        year: yearValue
    },
    success: function (result) {

        $("#spinner_load").hide();
        $(".dynamic-block").remove();

        if (!result.data || result.data.length === 0) {
            $(".table-wrapper").append(`
                <div class="dynamic-block text-center text-muted mt-2">
                    Tidak ada data ditemukan
                </div>
            `);
            return;
        }

        /* ================= MAP PRODUKSI ================= */
        let productionMap = {};
        if (result.production && Array.isArray(result.production)) {
            result.production.forEach(p => {
                let key = `${p.part_no}-${p.month}-${p.week}`;
                productionMap[key] = parseInt(p.total) || 0;
            });
        }

        /* ================= GROUP DATA ================= */
        let groupedData = {};
        result.data.forEach(item => {
            if (!groupedData[item.part_no]) groupedData[item.part_no] = [];
            groupedData[item.part_no].push(item);
        });

        Object.keys(groupedData).forEach(partNoKey => {

            const partData = groupedData[partNoKey];
            const jobNo = partData[0].job_no;
            const forecastRow = result.forecast?.[jobNo] || null;

            /* ================= MAP FORECAST ================= */
            let forecastMap = {};
            if (forecastRow) {
                forecastMap = {
                    1: +forecastRow.jan || 0,
                    2: +forecastRow.feb || 0,
                    3: +forecastRow.mar || 0,
                    4: +forecastRow.apr || 0,
                    5: +forecastRow.may || 0,
                    6: +forecastRow.jun || 0,
                    7: +forecastRow.jul || 0,
                    8: +forecastRow.aug || 0,
                    9: +forecastRow.sep || 0,
                    10: +forecastRow.oct || 0,
                    11: +forecastRow.nov || 0,
                    12: +forecastRow.dec || 0
                };
            }

            /* ================= PREVENTIVE ================= */
            let greenIndices = new Set();
            if (partData[0].date_plan_prev_list) {
                let dates = partData[0].date_plan_prev_list.split(',');
                dates.forEach(dateStr => {
                    let d = new Date(dateStr);
                    if (d.getFullYear() == yearValue) {
                        let m = d.getMonth() + 1;
                        let w = Math.floor((d.getDate() - 1) / 7) + 1;
                        if (w > 4) w = 4;
                        greenIndices.add(((m - 1) * 4) + w);
                    }
                });
            }

            /* ================= HITUNG BIRU ================= */
            let stdStroke = parseInt(partData[0].std_stroke) || 0;
            let limit90 = stdStroke * 0.9;

            let akumulasi = 0;
            let biruIndex = null;
            let idx = 0;

            for (let m = 1; m <= 12; m++) {
                for (let w = 1; w <= 4; w++) {
                    idx++;
                    akumulasi += productionMap[`${partNoKey}-${m}-${w}`] || 0;
                    if (akumulasi >= limit90 && biruIndex === null) {
                        biruIndex = idx;
                    }
                }
            }

            /* ================= HITUNG KUNING (FORECAST / JADWAL PREVENTIVE) ================= */
            let yellowIndices = new Set();
            let forecastRunning = 0;
            let currentCycle = 1;

            if (stdStroke > 0) {
               for (let m = 1; m <= 12; m++) {
                   let fVal = forecastMap[m] || 0;
                   if (fVal <= 0) continue;

                   // Cek apakah dalam bulan ini melewati satu atau lebih target (90% dari kelipatan stdStroke)
                   while (true) {
                       let targetThreshold = (currentCycle * stdStroke) * 0.9;

                       if (forecastRunning + fVal >= targetThreshold) {
                           let valNeeded = targetThreshold - forecastRunning;
                           // Jika valNeeded < 0, berarti sudah lewat dari bulan sebelumnya (seharusnya tidak terjadi jika logic benar)
                           if (valNeeded < 0) valNeeded = 0;

                           let ratio = valNeeded / fVal;
                           let w = Math.ceil(ratio * 4);
                           if (w < 1) w = 1;
                           if (w > 4) w = 4;

                           yellowIndices.add(((m - 1) * 4) + w);
                           currentCycle++;
                       } else {
                           break;
                       }
                   }
                   forecastRunning += fVal;
               }
            }

            /* ================= BLOCK ================= */
            let block = $(`
                <div
                    class="dynamic-block mt-4 border rounded shadow-sm p-2"
                    data-partno="${partNoKey}"
                    data-blueindex="${biruIndex}">
                    <div class="d-flex">
                        <div class="fixed-columns me-2">
                            <table class="table table-bordered table-striped mb-0">
                                <thead style="background:#fff986">
                                    <tr class="text-center">
                                        <th>LINE</th>
                                        <th>JOB NO</th>
                                        <th>PART NO</th>
                                        <th>MODEL</th>
                                        <th>CUSTOMER</th>
                                        <th>STD</th>
                                        <th>JML</th>
                                        <th>PROSES</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="scrollable-columns">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr class="month-row"></tr>
                                    <tr class="total-month-row"></tr>
                                    <tr class="week-row"></tr>
                                </thead>
                                <tbody class="wide-table"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `);

            /* ================= BODY ================= */
            const tbody = block.find(".wide-table");

            /* ================= TABEL KIRI ================= */
            let left = '';
            partData.forEach(v => {
                left += `
                    <tr>
                        <td class="vertical-text">${v.line_id ?? '-'}</td>
                        <td class="vertical-text">${v.job_no ?? '-'}</td>
                        <td class="vertical-text">${v.part_no}</td>
                        <td class="vertical-text">${v.model_id ?? '-'}</td>
                        <td class="vertical-text">${v.customer ?? '-'}</td>
                        <td class="vertical-text">${v.std_stroke ?? 0}</td>
                        <td class="vertical-text">${v.jml_stroke ?? 0}</td>
                        <td class="vertical-text">${v.proses ?? '-'}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-info btn-history" data-job="${v.job_no}" data-part="${v.part_no}">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </td>
                    </tr>`;
            });
            block.find(".fixed-columns tbody").html(left);

            /* ================= HEADER ================= */
            const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

            months.forEach(m => {
                block.find(".month-row").append(`
                    <th colspan="4" class="text-center">${m}-${String(yearValue).slice(-2)}</th>
                `);
            });

            months.forEach((m, i) => {
                let total = 0;
                for (let w = 1; w <= 4; w++) {
                    total += productionMap[`${partNoKey}-${i + 1}-${w}`] || 0;
                }
                block.find(".total-month-row").append(`
                    <th colspan="4" class="p-0">
                        <div class="d-flex fw-bold text-center">
                            <div style="width:50%;background:#0dcaf0;color:#000000">${total}</div>
                            <div style="width:50%;background:#ffc107;color:#000000">${forecastMap[i + 1] || 0}</div>
                        </div>
                    </th>
                `);
            });

            months.forEach((m, mi) => {
                ["I","II","III","IV"].forEach((w, wi) => {
                    block.find(".week-row").append(`
                        <th class="text-center week-header"
                            style="cursor:pointer"
                            data-month="${mi + 1}"
                            data-week="${wi + 1}">
                            ${w}
                        </th>
                    `);
                });
            });

            /* ================= BODY ROW ================= */
            const numRows = parseInt(partData[0].proses) || 1;

            for (let r = 1; r <= numRows; r++) {
                let row = $('<tr>');
                let running = 0, prevRunning = 0, cell = 0;

                for (let m = 1; m <= 12; m++) {
                    for (let w = 1; w <= 4; w++) {
                        cell++;
                        let val = productionMap[`${partNoKey}-${m}-${w}`] || 0;
                        prevRunning = running;
                        running += val;

                        let cls = '';
                        if (greenIndices.has(cell)) cls = 'bg-success text-black fw-bold';
                        else if (running >= stdStroke && prevRunning < stdStroke) cls = 'bg-danger text-black fw-bold';
                        else if (cell === biruIndex) cls = 'bg-info text-black fw-bold';
                        else if (yellowIndices.has(cell)) cls = 'bg-warning text-dark fw-bold';

                        row.append(`<td class="text-center ${cls}">${val}</td>`);
                    }
                }
                tbody.append(row);
            }

            $(".table-wrapper").append(block);
        });
    },
    error: function () {
        $("#spinner_load").hide();
    }
});
}


        $(document).on("click", ".week-header", function() {

            const month = $(this).data("month");
            const week = $(this).data("week");

            const block = $(this).closest(".dynamic-block");
            const partNo = block.data("partno");

            // Ambil biruIndex dari block
            const blueIndex = parseInt(block.data("blueindex"));

            // Hitung index absolute
            const clickedIndex = ((month - 1) * 4) + week;

            // Tentukan apakah week ini adalah week biru
            let tpmButton = "";
            if (clickedIndex === blueIndex) {
                tpmButton = `
                    <button class="btn btn-info w-50 mt-3 fw-bold" id="btnTPM">
                        LAKUKAN TPM PREVENTIVE
                    </button>
                `;
            }

            // Render modal awal
            $("#modalContent").html(`
              <div class="text-center mb-4">
    <h4 class="fw-bold mb-3 text-primary">Detail Produksi Mingguan</h4>

    <div class="d-flex justify-content-center align-items-center gap-5 mb-3">

        <div class="px-3 py-2 border rounded shadow-sm bg-light">
            <small class="text-muted d-block">Part No</small>
            <span class="fw-bold fs-5 text-dark">${partNo}</span>
        </div>

        <div class="px-3 py-2 border rounded shadow-sm bg-light">
            <small class="text-muted d-block">Month</small>
            <span class="fw-bold fs-5 text-dark">${month}</span>
        </div>

        <div class="px-3 py-2 border rounded shadow-sm bg-light">
            <small class="text-muted d-block">Week</small>
            <span class="fw-bold fs-5 text-dark">${week}</span>
        </div>

    </div>

    ${tpmButton}
</div>

            `);

            $("#weekModal").modal("show");

            // Ambil tahun dari dropdown
            const year = $('#date_plan').val();

            // === AJAX ===
            $.ajax({
                url: "{{ route('week.detail') }}",
                type: "GET",
                data: {
                    part_no: partNo,
                    month: month,
                    week: week,
                    year: year // Filter berdasarkan tahun
                },
                success: function(res) {

                    if (!res.data || res.data.length === 0) {
                        $("#modalContent").append(`
                            <p class="text-center text-muted">Tidak ada data.</p>
                        `);
                        return;
                    }

                    let html = `
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>Line</th>
                                        <th>Job No</th>
                                        <th>Model</th>
                                        <th>Qty Plan</th>
                                        <th>Qty Act</th>
                                        <th>Tgl Produksi</th>
                                        <th>Status</th>
                                        <th>Shift</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    res.data.forEach(item => {
                        html += `
                            <tr>
                                <td>${item.mesin ?? '-'}</td>
                                <td>${item.job_no ?? '-'}</td>
                                <td>${item.model_id ?? '-'}</td>
                                <td>${item.qty_plan ?? '0'}</td>
                                <td>${item.actual_production ?? '-'}</td>
                                <td>${item.date_plan ?? '-'}</td>
                                <td>${item.status_proses2 == 3
                                    ? '<span class="badge bg-success">FINISH</span>'
                                    : (item.status_proses2 ?? '-')}
                                </td>
                                <td>${item.shift}</td>
                                <td>${item.description ?? '-'}</td>
                            </tr>
                        `;
                    });

                    html += `</tbody></table></div>`;

                    $("#modalContent").append(html);
                }
            });

        });

        // Handler for Detail button click
        $(document).on('click', '.btn-history', function(e) {
            e.preventDefault();
            const jobNo = $(this).data('job');
            const partNo = $(this).data('part');

            $('#modalJobNo').text(jobNo);
            $('#modalPartNo').text(partNo);
            $('#lkhDetailTableBody').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');

            // Show modal
            $('#lkhDetailModal').modal('show');

            // Fetch data from server
            $.ajax({
                url: "{{ route('diemtc.lkh.history') }}",
                method: 'GET',
                data: { job_no: jobNo, part_no: partNo },
                success: function(response) {
                    let rows = '';
                    if (response.success && response.data && response.data.length > 0) {
                        response.data.forEach((item, index) => {
                            const statusBadge = item.status == 'CLOSE' ? 'success' : 'warning';
                            rows += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.tanggal      || '-'}</td>
                                    <td>${item.category     || '-'}</td>
                                    <td>${item.problem      || '-'}</td>
                                    <td>${item.perbaikan    || '-'}</td>
                                    <td>${item.dt_total     || 0}</td>
                                    <td>${item.dt_start     || 0}</td>
                                    <td>${item.dt_finish    || 0}</td>
                                    <td><span class="badge bg-${statusBadge}">${item.pic || '-'}</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = '<tr><td colspan="7" class="text-center">No data found</td></tr>';
                    }
                    $('#lkhDetailTableBody').html(rows);
                },
                error: function() {
                    $('#lkhDetailTableBody').html('<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>');
                }
            });
        });
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
