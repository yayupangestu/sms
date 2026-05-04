@extends('layouts.app')

@section('content')
    <style>
        .custom-dashboard {
            background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            min-height: 85vh;
            /* Memastikan full tinggi viewport */
            display: flex;
            flex-direction: column;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .container {
            display: flex;
            gap: 7px;
            /* flex-wrap: wrap; Allows cards to wrap to the next line if there are too many to fit */
        }

        .card {
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 5px;
            padding: 5px;
            width: calc(25% - 10px);
            text-align: center;
            width: 150%;
            /* Ubah persentase ini sesuai dengan kebutuhan lebar */
            margin-bottom: 40px;
            /* Tambahkan jarak antar card jika diinginkan */
        }

        .card i {
            font-size: 90px;
            margin-bottom: 10px;
        }

        .card:hover {
            transform: translateY(-9px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.4);
        }

        .card .number {
            font-size: 30px;
            margin-bottom: 5px;
            color: #ffffff;
        }

        .card .label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .brand-image {
            width: 60%;
            height: auto;
            object-fit: contain;
            display: block;
            /* Centers the image */
            margin: 0 auto;
            /* Centers the image */
        }


        @keyframes blinkBlue {
            0% {
                background-color: #ff0000;
            }

            50% {
                background-color: #ff000099;
            }

            /* Biru lebih terang */
            100% {
                background-color: #ff0000;
            }
        }

        @keyframes blinkRed {
            0% {
                background-color: #1eff00;
            }

            50% {
                background-color: #1eff0078;
            }

            /* Merah lebih terang */
            100% {
                background-color: #1eff00;
            }
        }

        @keyframes moveStripes {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 40px 0;
            }
        }

        .progress-bar {
            height: 20px;
            background-color: #000000;
            border-radius: 5px;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
            /* Supaya animasi tidak keluar */
        }

        .progress-bar .available {
            height: 100%;
            background-color: #1eff00;
            border-radius: 5px 0 0 5px;
            transition: background-color 0.3s ease-in-out;
        }

        /* Efek kedip untuk warna biru */
        .progress-bar .available.blink-blue {
            animation: blinkBlue 1s infinite;
        }

        /* Efek kedip untuk warna merah */
        .progress-bar .available.blink-red {
            animation: blinkRed 1s infinite;
        }

        /* Tambahkan efek stripes hanya untuk warna kuning */
        .progress-bar .available.striped {
            background: repeating-linear-gradient(45deg,
                    #f6ab167d,
                    #f6ab167d 10px,
                    #ffff00 10px,
                    #ffff00 30px);
            background-size: 40px 40px;
            animation: moveStripes 1s linear infinite;
        }




        .status {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            color: #ffffff
        }

        /* TABEL */
        .partner-card {
            padding: 15px;
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .auto-scroll-container {
            overflow-x: auto;
            /* Memungkinkan scroll horizontal */
            white-space: nowrap;
            /* Hindari teks terpotong */
        }

        table {
            width: 100%;
            /* Pastikan tabel menggunakan 100% lebar kartu */
            border-collapse: collapse;
        }

        @media (max-width: 768px) {

            td,
            th {
                font-size: 14px;
                /* Ukuran teks lebih kecil untuk layar kecil */
            }
        }

        @media (max-width: 576px) {

            td,
            th {
                font-size: 12px;
                /* Ukuran teks untuk perangkat kecil */
            }
        }


        .partner-table th,
        .partner-table td {
            /* padding: 8px; */
            /* text-align: left; */
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            /* Slightly visible border */
        }

        .partner-table thead {
            position: sticky;
            top: 0;
            background: linear-gradient(to bottom left, #003366 0%, #006699 100%);
            z-index: 1;
            /* Ensure the header stays on top */
        }

        .partner-table tbody tr:nth-child(even) {
            background-color: rgba(226, 226, 226, 0.1);
            /* Light background for alternate rows */
        }


        .partner-table tbody {
            /* display: block; */
            max-height: 1200px;
            /* Ensures only the body scrolls */
            overflow-y: auto;
            position: relative;
            animation: scroll-vertical 30s linear infinite;
        }

        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #d9e2f3;
        }

        .highlight {
            background-color: #d9e2f3;
        }

        .green-highlight {
            background-color: #c6efce;
        }

        .bold {
            font-weight: bold;
        }

        .yellow-status {
            background-color: rgb(222, 255, 58);
            color: rgb(0, 0, 0);
            /* untuk teks agar terlihat kontras */
        }

        .green-status {
            background-color: rgb(125, 251, 125);
            color: rgb(0, 0, 0);
            /* untuk teks agar terlihat kontras */
        }

        custom-dashboard {
            background-color: #f0f4f8;
            /* Light background for the dashboard */
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .dashboard-title {
            font-size: 26px;
            font-weight: bold;
            color: #333;
        }

        .metric-card3 {
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 20px;
            padding: 30px 20px;
            color: #000000;
            box-shadow: 0 6px 15px rgba(58, 142, 214, 0.3);
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-left: 10px;
            /* Adjust as needed */
            display: inline-block;
            /* Keeps the badge in line with text */
        }

        .btn-blue {
            background-color: blue;
            border-color: blue;
        }

        .btn-green {
            background-color: green;
            border-color: green;
        }

        #icon-alert {
            font-size: 1.5rem;
        }

        .auto-scroll-container {
            max-height: 400px;
            /* Sesuaikan tinggi maksimal agar hanya menampilkan 10 baris */
            overflow-y: auto;
            /* Scroll secara vertikal jika lebih dari 10 baris */
            overflow-x: auto;
            /* Scroll horizontal jika tabel terlalu lebar */
            white-space: nowrap;
            /* Hindari teks terpotong */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        .dot {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
    }
    .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
}
.dot-red {
    background-color: red;
}
.dot-yellow {
    background-color: yellow;
}
.white-bold {
    font-weight: bold;
    color: white;
}
#transit-table-body td {
    color: white !important;
}

.bg-warning {
    background-color: #fff3cd4e !important;
}
.bg-danger {
    background-color: #f8d7da !important;
}
.text-dark {
    color: #212529 !important;
}
.text-white {
    color: #040404 !important;
}



    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <div style="background-color: #003366; color:#ffffff"class="content-header">
        <div class="container-fluid">
            <div style="background: linear-gradient(to bottom, #003366 25%, #000000 78%);"
                class="row mb-4 align-items-center">
                <div class="col-md-6" style="position: relative;">
                    <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                        <img src="dist/img/adw3.png" class="brand-image2" style="width: 200px; height: auto;">
                    </div>
                    <strong>
                        <h3 style="color: white; display: inline;">Dashboard OUTGOING RM</h3>
                    </strong>
                </div>
                <div class="col-md-6 text-right">
                    <div
                        style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom, #003366 25%, #006699 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                        <strong>
                            <h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="dateTime" class="text-right">
                            </h3>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board starts here -->
    <section class="custom-dashboard">
        <div class="container-fluid h-50">
            <div class="row">
                <div class="col-md-6">
                    <div class="container">
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE A1')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png" class="brand-image img-fluid"
                                alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE A1')">
                                <P style="color: #ffffff; font-size:16px">LINE A1</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE A2')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png" class="brand-image img-fluid"
                                alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE A2')">
                                <P style="color: #ffffff; font-size:16px">LINE A2</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE A3')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png" class="brand-image img-fluid"
                                alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE A3')">
                                <P style="color: #ffffff; font-size:16px">LINE A3</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE B1')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png" class="brand-image img-fluid"
                                alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE B1')">
                                <P style="color: #ffffff; font-size:16px">LINE B1</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE B2')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png" class="brand-image img-fluid"
                                alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE B2')">
                                <P style="color: #ffffff; font-size:16px">LINE B2</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE B3')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png" class="brand-image img-fluid"
                                alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE B3')">
                                <P style="color: #ffffff; font-size:16px">LINE B3</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE C1')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png"
                                class="brand-image img-fluid" alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE C1')">
                                <P style="color: #ffffff; font-size:16px">LINE C1</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE C2')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png"
                                class="brand-image img-fluid" alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('LINE C2')">
                                <P style="color: #ffffff; font-size:16px">LINE C2</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer"
                            onclick="showIncomingMaterials('LINE TRANSFERS')">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png"
                                class="brand-image img-fluid" alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('TRANSFERS')">
                                <P style="color: #ffffff; font-size:16px">3000T</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png"
                                class="brand-image img-fluid" alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('KOMATSU')">
                                <P style="color: #ffffff; font-size:14px">KOMATSU</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png"
                                class="brand-image img-fluid" alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('AMINO')">
                                <P style="color: #ffffff; font-size:16px">AMINO</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="card" class="info-box" style="cursor: pointer">
                            <img style="color: #ffffff" src="dist/img/press-machine (7).png"
                                class="brand-image img-fluid" alt="press-machine (7) Image">
                            <br>
                            <div class="metric-card" onclick="showIncomingMaterials('FUKUI')">
                                <P style="color: #ffffff; font-size:16px">FUKUI</P>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                    
                        <label style="color: #f9f9f9" class="col-sm-1 col-form-label">Date :</label>
                    
                        <div class="col-sm-2">
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>
                    
                        <div class="col-sm-5 d-flex align-items-center gap-2">
                            <!-- Tombol Search -->
                            <button type="button" class="btn btn-primary d-flex align-items-center" id="btn_search">
                                <i class="fa fa-search me-1"></i> Search
                            </button>
                    
                            {{-- <!-- Icon Alert -->
                            <span id="icon-alert" class="ms-2 mt-1" style="display: none; color: red;">
                                <i class="fa fa-exclamation-circle fa-lg"></i>
                            </span> --}}
                    
                            <!-- Icon Loading (fa-sync) -->
                           <!-- Icon Loading (Font Awesome Sync) -->
<div id="loading-spinner" class="ms-3 mt-1" style="display: none;">
    <i class="fas fa-sync-alt fa-spin text-white fa-2x" style="opacity: 0.8;"></i>
</div>

                        </div>
                    </div>
                    

                    <!-- New Table -->
                    <h4 class="text-center"
                        style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color:#ffffff;   background: #003366;">
                        Tabel Detail LINE</h4>
                    <div class="container md-6">
                        <div class="table-responsive">
                            <div id="incomingMaterialsView"
                                style="display: none; background-color: #f9f9f9; padding: 10px; border: 1px solid #ccc;">
                                <!-- Konten tabel akan diisi melalui JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="partner-card">
                        {{-- <h5 class="text-center text-white">TRANSAKSI PERMINTAAN MATERIAL PRODUKSI</h5> --}}

                        <div class="chart-container" style="display: none; position: relative; height:400px; width:100%">
                            <canvas id="materialChart"></canvas>
                        </div>

                        <!-- Tabel-tabel sejajar (bersampingan) -->

                        <div class="bg-white p-2 mb-3 rounded shadow-sm">
                            <h5 class="text-center text-white m-0" style="letter-spacing: 1px;">INFORMASI MATERIAL AREA TRANSIT</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card shadow-sm border-0 mb-4">
                                    <div class="card-header text-white text-center" style="background-color: #c3d0dd;">
                                        <h5 class="mb-0" style="color:white bold; letter-spacing: 1px;">Material Transit</h5>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover table-bordered text-center align-middle">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>uniqNo</th>
                                                            <th>Part NO</th>
                                                            <th>QTY RH/LH</th>
                                                            <th>Qty/Pallet</th>
                                                            <th>Tanggal Keluar</th>
                                                            <th>Area Transit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="transit-table-body"></tbody>
                                                </table>

                                                <div class="pagination-controls text-center mt-2">
                                                    <button id="prevPage" class="btn btn-sm btn-secondary">Previous</button>
                                                    <span id="pageInfo" class="mx-2"></span>
                                                    <button id="nextPage" class="btn btn-sm btn-secondary">Next</button>
                                                </div>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>

                        </div>
                    </div>
                </div>


            </div>

        </div>
        </div>


    </section>
@endsection

@push('scripts')
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> <!-- Add plugin -->
    <script></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split("T")[0]; // Format YYYY-MM-DD
            document.getElementById("date_plan").value = today;
        });

        var ctx = document.getElementById("materialChart").getContext("2d");
var materialChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: [],
        datasets: [
            {
    label: "Qty Plan - Shift 1",
    data: [],
    backgroundColor: '#2a6993', // Biru
    stack: 'qty_plan'
},
{
    label: "Qty Plan - Shift 2",
    data: [],
    backgroundColor: '#3c97d3',  // Medium Blue - lebih gelap, tetap smooth
    stack: 'qty_plan'
},
{
    label: "Qty Plan - Shift 3",
    data: [],
    backgroundColor: '#6CA0DC',  // Light Steel Blue - biru muda, lembut
    stack: 'qty_plan'
},


            // Qty Out per Shift
            {
                label: "Qty Out - Shift 1",
                data: [],
                backgroundColor: '#059932',
                stack: 'qty_out'
            },
            {
                label: "Qty Out - Shift 2",
                data: [],
                backgroundColor: '#07cc43',
                stack: 'qty_out'
            },
            {
                label: "Qty Out - Shift 3",
                data: [],
                backgroundColor: '#09ff54',
                stack: 'qty_out'
            },
            {
                label: "Qty Sisa Material",
                data: [],
                backgroundColor: 'rgba(255, 249, 71, 0.62)',
                borderColor: 'rgba(255, 247, 0, 1)',
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                stacked: true,
                ticks: {
                    color: 'white',
                    font: {
                        size: 20
                    }
                },
                grid: {
                    color: 'rgba(255, 255, 255, 1)',
                    drawBorder: true,
                    drawOnChartArea: true,
                    drawTicks: false
                }
            },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: {
                        size: 20
                    }
                },
                grid: {
                    color: 'rgba(255, 255, 255, 1)',
                    drawBorder: true,
                    drawOnChartArea: true,
                    drawTicks: false
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: 'white',
                    font: {
                        size: 16
                    }
                }
            },
            tooltip: {
                titleFont: { size: 14 },
                bodyFont: { size: 14 },
                bodyColor: 'white',
                titleColor: 'white',
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                callbacks: {
                    label: function(tooltipItem) {
                        let datasetIndex = tooltipItem.datasetIndex;
                        let index = tooltipItem.dataIndex;
                        let value = tooltipItem.raw || 0;
                        let label = tooltipItem.dataset.label || "";

                        if (label.includes("Qty Plan -")) {
                            return `${label}: ${value}`;
                        } else if (label === "Qty Sisa Material") {
                            return [`${label}: ${value}`, ...partNoSisaData[index].split("\n")];
                        } else if (label === "Qty Out Material") {
                            return [`${label}: ${value}`, ...partNoQtyOutMaterialData[index].split("\n")];
                        }
                        return `${label}: ${value}`;
                    }
                }
            },
            datalabels: {
                color: 'white',
                anchor: 'end',
                align: 'top',
                offset: -30,
                font: {
                    size: 20,
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value > 0 ? value : '';
                }
            }

        }
    },
    plugins: [ChartDataLabels]
});

function updateQtyPlan() {
    $.ajax({
        url: "{{ route('dashboardmps.getQtyPlan') }}",
        type: "GET",
        dataType: "json",
        success: function(response) {
            $(".progress-bar .available")
                .css("background-color", "#000000")
                .removeClass("striped blink-blue blink-red");

            let mesinLabels = [];

            // PLAN
            let qtyPlanShift1Data = [];
            let qtyPlanShift2Data = [];
            let qtyPlanShift3Data = [];

            // OUT
            let qtyOutShift1Data = [];
            let qtyOutShift2Data = [];
            let qtyOutShift3Data = [];

            // SISA
            let qtySisaMaterialData = [];

            let partNoQtyOutMaterialData = [];
            let partNoSisaData = [];

            response.forEach(function(item) {
                let mesin = item.mesin ? item.mesin.trim().toUpperCase() : "";
                mesinLabels.push(mesin);

                // PLAN
                let qtyShift1 = parseInt(item.qty_plan_shift_1) || 0;
                let qtyShift2 = parseInt(item.qty_plan_shift_2) || 0;
                let qtyShift3 = parseInt(item.qty_plan_shift_3) || 0;

                // OUT
                let outShift1 = parseInt(item.qty_out_shift_1) || 0;
                let outShift2 = parseInt(item.qty_out_shift_2) || 0;
                let outShift3 = parseInt(item.qty_out_shift_3) || 0;

                // SISA
                let qtySisa = parseInt(item.totalSisaMaterial) || 0;

                // Push ke array masing-masing
                qtyPlanShift1Data.push(qtyShift1);
                qtyPlanShift2Data.push(qtyShift2);
                qtyPlanShift3Data.push(qtyShift3);

                qtyOutShift1Data.push(outShift1);
                qtyOutShift2Data.push(outShift2);
                qtyOutShift3Data.push(outShift3);

                qtySisaMaterialData.push(qtySisa);

                // Tooltip part_no Qty OUT
                let partNoQtyOut = item.partNoQtyOutMaterial ? item.partNoQtyOutMaterial.split(", ") : [];
                let partNoQtyOutFormatted = partNoQtyOut.map(pair => {
                    let [partNo, qty] = pair.split(":");
                    return `• ${partNo}\n  Qty : ${qty}`;
                }).join("\n");
                partNoQtyOutMaterialData.push(partNoQtyOutFormatted);

                // Tooltip part_no Qty SISA
                let partNoSisa = item.partNoSisaQty ? item.partNoSisaQty.split(", ") : [];
                let partNoSisaFormatted = partNoSisa.map(pair => {
                    let [partNo, qty] = pair.split(":");
                    return `• ${partNo}\n  Qty : ${qty}`;
                }).join("\n");
                partNoSisaData.push(partNoSisaFormatted);

                // Progress bar logic
                let totalPlan = qtyShift1 + qtyShift2 + qtyShift3;
                let totalOut = outShift1 + outShift2 + outShift3;

                let progressBar = $(".metric-card").filter(function() {
                    return $(this).text().trim().toUpperCase() === mesin;
                }).closest('.card').find('.progress-bar .available');

                if (totalOut === 0) {
                    progressBar.css("background-color", "#e23737").addClass("blink-blue");
                } else if (totalOut > totalPlan) {
                    progressBar.css("background-color", "#1eff00").addClass("blink-red").removeClass("blink-blue striped");
                } else if (totalPlan === totalOut) {
                    progressBar.css("background-color", "#1eff00").removeClass("blink-blue blink-red striped");
                } else {
                    progressBar.css("background-color", "#ffff00").addClass("striped").removeClass("blink-blue blink-red");
                }
            });

            // Update Chart.js data
            materialChart.data.labels = mesinLabels;

            // Dataset order harus sesuai index
            materialChart.data.datasets[0].data = qtyPlanShift1Data;
            materialChart.data.datasets[1].data = qtyPlanShift2Data;
            materialChart.data.datasets[2].data = qtyPlanShift3Data;
            materialChart.data.datasets[3].data = qtyOutShift1Data;
            materialChart.data.datasets[4].data = qtyOutShift2Data;
            materialChart.data.datasets[5].data = qtyOutShift3Data;
            materialChart.data.datasets[6].data = qtySisaMaterialData;

            // Tooltip logic
            materialChart.options.plugins.tooltip.callbacks = {
                label: function(tooltipItem) {
                    let index = tooltipItem.dataIndex;
                    let label = tooltipItem.dataset.label;
                    let value = tooltipItem.raw || 0;
                    let result = [`${label}: ${value}`];

                    if (label.includes("Qty Out")) {
                        result.push(...(partNoQtyOutMaterialData[index]?.split("\n") || []));
                    } else if (label === "Qty Sisa Material") {
                        result.push(...(partNoSisaData[index]?.split("\n") || []));
                    }

                    return result;
                }
            };

            materialChart.update();
        },
        error: function() {
            console.error("Gagal mengambil data.");
        }
    });
}


        // Panggil updateQtyPlan saat halaman dimuat dan setiap 30 detik
        $(document).ready(function() {
            updateQtyPlan();
            setInterval(updateQtyPlan, 30000);
        });

        $(document).ready(function() {
            updateQtyPlan(); // Jalankan saat halaman pertama kali dimuat
            setInterval(updateQtyPlan, 5000); // Update setiap 5 detik
        });



        document.getElementById('btn_search').addEventListener('click', function () {
    const btnSearch = document.getElementById('btn_search');
    const iconAlert = document.getElementById('icon-alert');
    const loadingSpinner = document.getElementById('loading-spinner');

    // Tampilkan spinner
    loadingSpinner.style.display = 'block';

    // Ganti warna tombol
    if (btnSearch.classList.contains('btn-blue')) {
        btnSearch.classList.remove('btn-blue');
        btnSearch.classList.add('btn-green');
        iconAlert.style.display = 'inline';
    } else {
        btnSearch.classList.remove('btn-green');
        btnSearch.classList.add('btn-blue');
        iconAlert.style.display = 'none';
    }

    // Jalankan fungsi fetch data
    // showIncomingMaterials(currentLine || ''); // pastikan ada default line kalau belum dipilih
});



        // Set the initial state to blue when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const btnSearch = document.getElementById('btn_search');
            btnSearch.classList.add('btn-blue');
            const iconAlert = document.getElementById('icon-alert');
            iconAlert.style.display = 'none'; // Hide the icon initially
        });



        function updateDateTime() {
            const now = new Date();

            // Hari dalam bahasa Indonesia
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const dayName = days[now.getDay()];

            // Format jam, menit, dan detik
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const time = `${hours}:${minutes}:${seconds}`;

            // Format tanggal
            const day = now.getDate().toString().padStart(2, '0');
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const year = now.getFullYear();
            const date = `${day}-${month}-${year}`;

            // Gabungkan hari, tanggal, dan waktu
            const dateTimeString = `${dayName}, ${date} ${time}`;

            document.getElementById("dateTime").textContent = dateTimeString;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();



        let autoUpdateTimer = null; // Timer untuk auto-update
        let currentLine = null; // Menyimpan LINE yang aktif
        function showIncomingMaterials(line) {
            const viewElement = document.getElementById('incomingMaterialsView');
            const dateInput = document.getElementById('date_plan'); // Date input element
            const btnSearch = document.getElementById('btn_search');

            // Display view if hidden
            if (viewElement.style.display === 'none') {
                viewElement.style.display = 'block';
            }

            const generatePlanItemRow = (data) => {
                return `
            <tr>
                <td colspan="2" class="highlight bold">PLAN ITEM</td>
                <td class="green-highlight bold">${data.length || 0}</td>
                <td class="green-highlight bold">${data.filter(item => item.part_no).length}</td>
                <td class="green-highlight bold">${data.filter(item => item.job_no).length}</td>
                <td class="green-highlight bold">${data.filter(item => item.model_id).length}</td>
                <td class="green-highlight bold">${data.filter(item => item.name_material).length}</td>
                <td class="green-highlight bold">${data.reduce((sum, item) => sum + (item.qty_plan || 0), 0)}</td>
                <td class="green-highlight bold">${data.reduce((sum, item) => sum + (item.qty_out_material || 0), 0)}</td>
                 <td class="green-highlight bold">${data.reduce((sum, item) => sum + (item.qty_out_blank || 0), 0)}</td>
                <td class="green-highlight bold">${data.reduce((sum, item) => sum + (item.qty_in_material || 0), 0)}</td>
                <td class="green-highlight bold">${data.filter(item => item.actual_production).length}</td>
                <td class="green-highlight bold">${data.filter(item => item.status).length}</td>
                <td class="green-highlight bold">${data.filter(item => item.status2).length}</td>
                <td class="green-highlight bold">${data.filter(item => item.status_proses).length}</td>
            </tr>
        `;
            };

            const fetchAndDisplayData = () => {
                const selectedDate = dateInput.value;
                if (!selectedDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ada Tanggal Yang dipilih',
                        text: 'Mohon Masukkan Tanggal Terlebih Dahulu.',
                        confirmButtonText: 'OK',
                    });
                    return;
                }

                currentLine = line; // Set LINE yang aktif
                fetch(`{{ route('dashboardrm.getIncomingMaterials') }}?mesin=${line}&date_plan=${selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
    if (currentLine !== line) return;

    console.log('Data fetched:', data);

    const filteredData = data.filter(item => item.date_plan === selectedDate);
    
    // Update tampilan tabel
    updateTable(filteredData, line);

    // ✅ Sembunyikan spinner setelah semua data tampil
    const loadingSpinner = document.getElementById('loading-spinner');
    loadingSpinner.style.display = 'none';
})

.catch(error => {
    console.error('Error fetching data:', error);
    viewElement.innerHTML = '<div>Data Tidak ditemukan.</div>';

    const loadingSpinner = document.getElementById('loading-spinner');
    loadingSpinner.style.display = 'none';
});

            };

            const updateTable = (data, line) => {
                viewElement.innerHTML = `
            <div style="margin-bottom: 20px;">
                <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #c6efce;">TABEL SHIFT 1</h3>
                <div style="overflow-x: auto;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th colspan="16">${line}</th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Part No</th>
                                <th>Model</th>
                                <th>BQ</th>
                                <th>Qty Plan</th>
                                <th style="width: 80px;">Material Out</th>
                                 <th style="width: 80px;">Blank Out</th>
                                <th style="width: 80px;">Stamping IN</th>
                                <th style="width: 80px;">Actual Produksi</th>
                                <th>Status Order</th>
                                <th>Qty Transit</th>

                            </tr>
                        </thead>
                        <tbody id="incomingMaterialsTableBody1"></tbody>
                    </table>
                </div>
            </div>
            <div>
                <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #d9e2f3;">TABEL SHIFT 2</h3>
                <div style="overflow-x: auto;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                       <thead>
                            <tr>
                                <th colspan="14">${line}</th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Part No</th>
                                <th>Model</th>
                                 <th>BQ</th>
                                <th>Qty Plan</th>
                                <th style="width: 80px;">Material Out</th>
                                <th style="width: 80px;">Blank Out</th>
                                <th style="width: 80px;">Stamping IN</th>
                                <th style="width: 80px;" >Actual Produksi</th>
                                <th>Status Order</th>
                                <th>Qty Transit</th>

                            </tr>
                        </thead>
                        <tbody id="incomingMaterialsTableBody2"></tbody>
                    </table>
                </div>
            </div>
            <div>
                <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #ffe599;">TABEL SHIFT 3</h3>
                <div style="overflow-x: auto;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                       <thead>
                            <tr>
                                <th colspan="14">${line}</th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Part No</th>
                                <th>Model</th>
                                 <th>BQ</th>
                                <th>Qty Plan</th>
                               <th style="width: 80px;">Material Out</th>
                                <th style="width: 80px;">Blank Out</th>
                                <th style="width: 80px;">Stamping IN</th>
                                <th style="width: 80px;">Actual Produksi</th>
                                <th>Status Order</th>
                                 <th>Qty Transit</th>

                            </tr>
                        </thead>
                        <tbody id="incomingMaterialsTableBody3"></tbody>
                    </table>
                </div>
            </div>
        `;

                const populateTable = (tableBodyId, shiftData, shiftName) => {
                    const tableBody = document.getElementById(tableBodyId);

                    // Ambil elemen saat ini untuk membandingkan posisi lama dan baru
                    const existingRows = Array.from(tableBody.children);
                    const rowMap = new Map();

                    existingRows.forEach(row => {
                        const id = row.getAttribute("data-id");
                        if (id) {
                            rowMap.set(id, row);
                        }
                    });

                    // Kosongkan tabel sebelum mengisi ulang
        // Kosongkan tabel sebelum mengisi ulang
tableBody.innerHTML = '';

// Urutkan shiftData berdasarkan position secara numerik
shiftData.sort((a, b) => parseInt(a.position) - parseInt(b.position));
if (shiftData.length > 0) {
    shiftData.forEach((item, index) => {

        let transitBadge = '';

        if ((item.sts_proses === null || item.sts_proses === 'null') && item.sts_proses2 === '3') {
            transitBadge = '<span style="background-color: #ffa500; color: #fff; padding: 3px 10px; border-radius: 10px; margin-left: 5px;">TRANSIT</span>';
        }

        const statusBadge =
    item.status === '4'
        ? '<span style="background-color: #62ABDB; color: #fff; padding: 3px 9px; border-radius: 10px;">Blank Proses</span>'
        : item.qty_out_material == null && (item.status_proses === null || item.status_proses === '')
        ? '<span style="background-color: #32CD32; color: #fff; padding: 3px 9px; border-radius: 10px;">Prepare</span>'
        : item.qty_out_material == null
        ? '<span style="background-color: #1E90FF; color: #ffffff; padding: 3px 10px; border-radius: 10px;">Ready Transit</span>'
        : item.status === '1'
        ? '<span style="background-color: #1E90FF; color: #ffffff; padding: 3px 10px; border-radius: 10px;">Ready</span>'
        : item.status === '2'
        ? '<span style="background-color: #ffc100; color: #000000; padding: 3px 10px; border-radius: 10px;">Received</span>'
        : item.status === '3'
        ? '<span style="background-color: #2a72f9; color: #ffffff; padding: 3px 10px; border-radius: 10px;">Close</span>'
        : item.status === '5'
        ? '<span style="background-color: #C70039; color: #ffffff; padding: 3px 10px; border-radius: 10px;">DIES TROUBLE</span>'
        : item.status === '6'
        ? '<span style="background-color: #D20103; color: #000000; padding: 3px 10px; border-radius: 10px;">RMTA</span>'
        : `<span style="background-color: #32CD32; color: #fff; padding: 3px 9px; border-radius: 10px;">${item.status_proses}</span>`;




        const combinedBadge = statusBadge + transitBadge;

        // ✅ Diperbarui: Kosongkan qtyStampingDisplay saat status 2 atau 3
        let qtyStampingDisplay = (item.status == 2 || item.status == 3) ? '' : (item.qty_stamping || '-');

        const isButtonDisabled = item.status_proses === '1' || item.status_proses === '2' || item.status_proses === '3' || item.status_proses === undefined;
        const buttonStyle = item.status_proses === '3' ? 'background-color: #32cd32; color: white; font-weight: bold;' : '';

        tableBody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.part_no2 || '-'}</td>
                <td>${item.model_id || '-'}</td>
                   <td style='background-color:#efff79'>${item.spec_bq || '-'}</td>
                <td>${item.qty_plan || 0}</td>
                <td>${item.qty_out_material || 0}</td>
                <td style='background-color:#8ac0e4'>${item.qty_out_blank || 0}</td>
                <td style='background-color:#f8ff99'>${item.qty_in_material || 0}</td>
                <td style='background-color:#96fb95'>${item.actual_production || '-'}</td>
                <td>${combinedBadge}</td>
                <td style='background-color:#ffe493'>${qtyStampingDisplay}</td>
            </tr>
        `;
    });
}
 else {
                        tableBody.innerHTML = '<tr><td colspan="12">No data available.</td></tr>';
                    }
                };
                const shift1Data = data.filter(item => item.shift === "1");
                const shift2Data = data.filter(item => item.shift === "2");
                const shift3Data = data.filter(item => item.shift === "3");

                populateTable('incomingMaterialsTableBody1', shift1Data, 'Shift 1');
                populateTable('incomingMaterialsTableBody2', shift2Data, 'Shift 2');
                populateTable('incomingMaterialsTableBody3', shift3Data, 'Shift 3');
            };

            btnSearch.onclick = fetchAndDisplayData; // Bind tombol pencarian

            // **Menghentikan interval sebelumnya sebelum memulai yang baru**
            if (autoUpdateTimer) clearInterval(autoUpdateTimer);

            autoUpdateTimer = setInterval(fetchAndDisplayData, 5000); // Auto-update setiap 5 detik
        }

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('approve-production-btn')) {
                const id = event.target.getAttribute('data-id');

                // SweetAlert2 untuk konfirmasi
                Swal.fire({
                    title: 'Apakah RM TA',
                    // text: "RM TA",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, RM TA'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirimkan permintaan dengan $.ajax()
                        $.ajax({
                            url: '{{ route('dashboardmps.materialTa') }}', // Route yang diinginkan
                            method: 'POST',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}' // Pastikan token CSRF disertakan
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success'
                                    });
                                    // Reload data di tabel
                                    location
                                        .reload(); // Bisa diganti dengan metode reload tabel lainnya jika tidak ingin reload halaman
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error'
                                });
                                console.error('Error:', error);
                            }
                        });
                    }
                });
            }
        });



        let previousData = {}; // Simpan data sebelumnya


        let currentPage = 1;
const rowsPerPage = 20;
let transitData = [];

function displayPage(page) {
    const tableBody = document.querySelector('#transit-table-body');
    tableBody.innerHTML = '';

    // Urutkan data: sts_proses == 2 lebih dulu, lalu sts_proses == 1, lalu lainnya
    transitData.sort((a, b) => {
        const getPriority = (item) => {
            if (item.sts == 1 && item.sts_proses == 2) return 1;
            if (item.sts == 1 && item.sts_proses == 1) return 2;
            return 3;
        };
        return getPriority(a) - getPriority(b);
    });

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = transitData.slice(start, end);

    if (paginatedItems.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>`;
    } else {
        paginatedItems.forEach((item, index) => {
            // Tentukan warna dot (opsional, bisa tetap dipakai)
            let dotColor = '';
            if (item.sts == 1 && item.sts_proses == 2) {
                dotColor = 'dot-yellow';
            } else if (item.sts == 1 && item.sts_proses == 1) {
                dotColor = 'dot-red';
            }

            // Tentukan background kuning jika part_no mengandung "/"
            let rowClass = '';
            if (item.part_no.includes('/')) {
                rowClass = 'bg-warning text-dark'; // kuning
            }

            const row = `
                <tr class="${rowClass}">
                    <td class="d-flex justify-content-center align-items-center">
                        <span class="dot ${dotColor}"></span>
                        <span class="white-bold">${start + index + 1}</span>
                    </td>
                    <td>${item.uniqNo}</td>
                    <td>${item.part_no}</td>
                    <td>${item.qty_stamping}</td>
                    <td>${item.qty_pallet}</td>
                    <td>${item.updated_at}</td>
                    <td>${item.mesin}</td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    // Update pagination info
    document.getElementById('pageInfo').innerText =
        `Page ${currentPage} of ${Math.ceil(transitData.length / rowsPerPage)}`;
}




fetch('{{ route('dashboardmps.getTransitData') }}')
    .then(response => response.json())
    .then(data => {
        const currentTotalPages = Math.ceil(transitData.length / rowsPerPage);
        transitData = data;

        // Jika currentPage masih valid setelah update data
        const maxPage = Math.ceil(transitData.length / rowsPerPage);
        if (currentPage > maxPage) {
            currentPage = 1;
        }

        displayPage(currentPage);
    });



document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        displayPage(currentPage);
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    if (currentPage < Math.ceil(transitData.length / rowsPerPage)) {
        currentPage++;
        displayPage(currentPage);
    }
});



fetchTransitData();
setInterval(fetchTransitData, 500); // Update setiap 30 detik
    </script>
@endpush
