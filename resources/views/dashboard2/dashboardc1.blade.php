@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            gap: 10px;
            /* Jarak antar kartu */
            flex-wrap: wrap;
            /* Membuat kartu teratur dalam baris baru */
            justify-content: center;
            /* Memusatkan kartu */
        }

        .card {
            width: 150px;
            /* Lebar kartu yang lebih kecil */
            padding: 10px;
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .card img {
            width: 50px;
            /* Ukuran gambar lebih kecil */
            height: auto;
            /* Proporsi gambar tetap */
            margin-bottom: 10px;
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

        .progress-bar {
            height: 5px;
            background-color: #000000;
            border-radius: 5px;
            margin-bottom: 10px;
            position: relative;
        }

        .progress-bar .available {
            height: 100%;
            background-color: #0bd400;
            border-radius: 5px 0 0 5px;
        }

        .progress-bar .service {
            height: 100%;
            background-color: #ff9800;
            border-radius: 0 5px 5px 0;
            position: absolute;
            right: 0;
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
            max-height: 500px;
            /* Batasi tinggi tabel */
            overflow-y: auto;
            /* Tambahkan scroll jika penuh */
        }

        #rm-materials-table table {
            width: 100%;
            border-collapse: collapse;
        }

        #rm-materials-table th,
        #rm-materials-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        #rm-materials-table tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.1);
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

        .custom-toast {
            background-color: #17a2b8 !important;
            /* Warna info (biru) */
            font-size: 18px !important;
            /* Perbesar ukuran teks */
            padding: 15px !important;
            /* Perbesar padding */
            color: white !important;
            /* Warna teks putih */
            border-radius: 10px !important;
            /* Tambahkan border radius */
        }

        /* Pastikan teks dalam ikon juga putih */
        .custom-toast .swal2-title {
            color: white !important;
        }

        .gradient-blue {
            background: linear-gradient(to right, #003366, #00509e);
            /* Gradasi biru */
            color: white;
        }

        /* New Section Styles */
        .dashboard-card {
            background: #ffffff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .dashboard-card-header {
            background: linear-gradient(135deg, #003366, #00509e);
            color: #fff;
            padding: 12px 20px;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .status-normal { background-color: #28a745; box-shadow: 0 0 8px #28a745; }
        .status-trouble { background-color: #dc3545; box-shadow: 0 0 8px #dc3545; }
        .status-maintenance { background-color: #ffc107; box-shadow: 0 0 8px #ffc107; }

        .history-table thead th {
            background: #f8f9fa;
            color: #003366;
            font-weight: 700;
            text-align: center;
            font-size: 1.1rem;
        }
        .history-table tbody td {
            font-size: 1rem;
            vertical-align: middle;
        }
        .progress-wrapper {
            height: 18px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .progress-bar-custom {
            height: 100%;
            text-align: center;
            line-height: 18px;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            transition: width 0.6s ease;
        }
        .progress-red { background-color: #dc3545; }
        .progress-yellow { background-color: #ffc107; color: black !important; }
        .progress-green { background-color: #28a745; }

        /* Maintenance Grouping Styles */
        .part-group-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .part-group-header {
            background: #f1f8ff;
            padding: 10px 15px;
            font-weight: bold;
            color: #003366;
            border-bottom: 2px solid #0056b3;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
        }
        .maintenance-log-item {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }
        .maintenance-log-item:last-child { border-bottom: none; }
        .maintenance-time { font-size: 0.85rem; color: #666; font-weight: normal; }
        .maintenance-problem { color: #d32f2f; font-weight: 600; font-size: 0.95rem; }
        .maintenance-action { color: #2e7d32; font-size: 0.95rem; }

        .gradient-blue {
            background: linear-gradient(to right, #003366, #00509e);
            /* Gradasi biru */
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-row {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes blink-green {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(0, 255, 0, 0.5);
            }

            100% {
                background-color: transparent;
            }
        }

        @keyframes blink-red {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(255, 0, 0, 0.5);
            }

            100% {
                background-color: transparent;
            }
        }

        @keyframes blink-orange {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(255, 111, 0, 0.5);
            }

            100% {
                background-color: transparent;
            }
        }

        .blinking {
            animation: blink-green 1.5s infinite;
        }

        .blinking2 {
            animation: blink-red 1.5s infinite;
        }

        .blinking3 {
            animation: blink-orange 1.5s infinite;
        }


        .table-body tr {
            position: relative;
            transition: transform 0.5s ease-in-out;
        }

        .move-animation {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-badge {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .badge {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .line-btn.active {
            background-color: #fdb50d !important;
            color: rgb(0, 0, 0) !important;
            border-color: #fdb50d !important;
        }

        .selected-line {
            background-color: #fdb50d !important;
            color: #fff !important;
            border-color: #fdb50d !important;
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
                        <h3 style="color: white; display: inline;">Dashboard Informasi Stamping</h3>
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
                        <div class="card info-box" style="cursor: zoom-in;" onclick="showIncomingMaterials('LINE B3')">
                            <img src="dist/img/press-machine (7).png" class="brand-image img-fluid" alt="press-machine (7) Image">
                            <div class="metric-card text-center mt-2">
                                <h4 class="text-white mb-1">LINE B3</h4>
                            </div>
                            <div class="progress-bar my-2">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                            <div class="status-badge text-center mb-2">
                                <span class="badge bg-info clickable-badge text-dark"
                                data-bs-toggle="modal"
                                data-bs-target="#statusModal"
                                data-mesin="LINE B3"
                                style="font-size: 0.85rem; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
                              Status Mesin
                          </span>
                            </div>
                        </div>


                        <div class="card info-box" style="cursor: zoom-in;" onclick="showIncomingMaterials('LINE C1')">
                            <img src="dist/img/press-machine (7).png" class="brand-image img-fluid" alt="press-machine (7) Image">
                            <div class="metric-card text-center mt-2">
                                <h4 class="text-white mb-1">LINE C1</h4>
                            </div>
                            <div class="progress-bar my-2">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                            <div class="status-badge text-center mb-2">
                                <span class="badge bg-info clickable-badge text-dark"
                                data-bs-toggle="modal"
                                data-bs-target="#statusModal"
                                data-mesin="LINE C1"
                                style="font-size: 0.85rem; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
                              Status Mesin
                          </span>
                            </div>
                        </div>

                        <div class="card info-box" style="cursor: zoom-in;" onclick="showIncomingMaterials('LINE C2')">
                            <img src="dist/img/press-machine (7).png" class="brand-image img-fluid" alt="press-machine (7) Image">
                            <div class="metric-card text-center mt-2">
                                <h4 class="text-white mb-1">LINE C2</h4>
                            </div>
                            <div class="progress-bar my-2">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                            <div class="status-badge text-center mb-2">
                                <span class="badge bg-info clickable-badge text-dark"
                                data-bs-toggle="modal"
                                data-bs-target="#statusModal"
                                data-mesin="LINE C2"
                                style="font-size: 0.85rem; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
                              Status Mesin
                          </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <!-- Date Plan -->
                        <label for="date_plan" class="col-sm-2 col-form-label text-white">TANGGAL:</label>
                        <div class="col-sm-2">
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>

                        <!-- Search Button -->
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
                             <button type="button" class="btn btn-light d-flex align-items-center" id="btn_opne_link" onclick="window.open('http://asi.adyawinsa.com:814/', '_blank')">
                                <i class="fas fa-dolly me-2"></i> E-SPB Store Room
                             </button>
                             <button type="button" class="btn btn-success d-flex align-items-center ms-2" id="btn_export_excel" data-bs-toggle="modal" data-bs-target="#exportExcelModal">
                                <i class="fas fa-file-excel me-2"></i> Export Excel
                             </button>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="my-3">

                    <!-- Dropdown & Go Button -->
                    <div class="form-group row align-items-center">
                        <label for="page_selector" class="col-sm-2 col-form-label text-white">BIKIN LABEL:</label>
                        <div class="col-sm-2">
                            <select id="page_selector" class="form-control form-control-sm">
                                <option value="" selected disabled>- Pilih Line -</option>
                                <option value="kanbanstmp">Kanban STMP B3</option>
                                <option value="kanbanstmpc1">Kanban STMP C1</option>
                                <option value="kanbanstmpc2">Kanban STMP C2</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button id="btn_open_page" class="btn btn-dark w-20">
                                <i class="fa fa-external-link"></i> Go
                            </button>
                        </div>


                    </div>


                    <!-- Modal Info RM -->
                    {{-- <div class="modal fade" id="infoRMModal" tabindex="-1" aria-labelledby="infoRMModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl ">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header bg-gray text-white rounded-top-4">
                                    <h5 class="modal-title" id="infoRMModalLabel">
                                        <i class="bi bi-box-seam me-2"></i> Info Material Sisa
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4 bg-light">
                                    <!-- Button untuk memilih LINE -->
                                    <div class="mb-4 d-flex gap-2 flex-wrap">
                                        <button class="btn btn-outline-primary line-btn" data-line-id="LINE B3">
                                            <i class="bi bi-gear-fill me-1"></i> LINE B3
                                        </button>
                                        <button class="btn btn-outline-secondary line-btn" data-line-id="LINE C1">
                                            <i class="bi bi-gear-wide-connected me-1"></i> LINE C1
                                        </button>
                                        <button class="btn btn-outline-warning line-btn text-dark" data-line-id="LINE C2">
                                            <i class="bi bi-tools me-1"></i> LINE C2
                                        </button>
                                    </div>

                                    <!-- Tabel untuk menampilkan data -->
                                    <div class="table-responsive rounded">
                                        <table id='rmTable'
                                            class="table table-hover table-bordered bg-white align-middle">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Line </th>
                                                    <th>Part No</th>
                                                    <th>Spec</th>
                                                    <th>Qty Awal</th>
                                                    <th>Qty Akhir</th>
                                                    <th>Tanggal Scan</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="rm-info-body">
                                                <!-- Data dari AJAX akan ditambahkan di sini -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="modal-footer bg-white rounded-bottom-4">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-1"></i> Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- New Table -->
                    <h4 class="text-center"
                        style="font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color:#ffffff; background: linear-gradient(to bottom, #003366 0%, #006699 100%);">
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
                    <!-- Kotak untuk data planning_line_b3_s -->
                    <div class="partner-card">

                        <div class="table-responsive">
                            <div class="row gy-4">
                                <!-- Kotak untuk data scan_out_rms -->
                    {{-- <div class="partner-card">
                        <b>
                            <h5 style="color: #ffffff;" class="text-center">TRANSAKSI PERMINTAAN MATERIAL PRODUKSI</h5>
                        </b>
                        <div class="table-responsive auto-scroll-container">
                            <div id="rm-materials-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width:10%">Kode Material</th>
                                            <th style="width:25%">Part No</th>
                                            <th style="width:25%">Material</th>
                                            <th style="width:15%">Supplier</th>
                                            <th style="width:15%">Qty Suplai</th>
                                            <th style="width:15%">Sisa Qty</th>
                                            <th style="width:30%">Waktu</th>
                                            <th style="width:20%">Scan Out</th>
                                            <th style="width:20%">Scan Stamping</th>
                                            <th style="width:20%">Jam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="10" class="text-center">Loading...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row mt-4">
                        <!-- Machine Condition Column -->
                        <div class="col-12">
                            <div class="dashboard-card">
                                <div class="dashboard-card-header" style="font-size: 1.2rem; padding: 8px 15px;">
                                    <i class="fas fa-microchip"></i> KONDISI MESIN & PRODUKSI
                                </div>
                                <div class="card-body p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-6 border-end">
                                            <h6 class="text-center mb-2" style="color: #003366; font-weight: 600; font-size: 0.9rem;">Machine Status</h6>
                                            <div style="height: 150px; position: relative;">
                                                <canvas id="machineStatusChart"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-center mb-2" style="color: #003366; font-weight: 600; font-size: 0.9rem;">Prod. Achievement</h6>
                                            <div style="height: 150px; position: relative;">
                                                <canvas id="productionAchievementChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover history-table" style="font-size: 0.85rem;">
                                            <thead>
                                                <tr>
                                                    <th>Machine</th>
                                                    <th>Status</th>
                                                    <th>Load</th>
                                                    <th>Air (Bar)</th>
                                                    <th>Oil (%)</th>
                                                    <th>Update</th>
                                                </tr>
                                            </thead>
                                            <tbody id="machineConditionList">
                                                <tr>
                                                    <td colspan="6" class="text-center py-3">Loading machine data...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dies & Maintenance Column -->
                        <div class="col-12 mt-2">
                            <div class="dashboard-card">
                                <div class="dashboard-card-header" style="font-size: 1.2rem; padding: 8px 15px; display: flex; justify-content: space-between; align-items: center;">
                                    <span><i class="fas fa-history"></i> DIES HISTORY & MAINTENANCE</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <!-- Dies Stroke Progress -->
                                        <div class="col-12 border-bottom">
                                            <div class="p-2 bg-light fw-bold" style="font-size: 0.9rem; border-bottom: 1px solid #dee2e6;">
                                                <i class="fas fa-tasks me-1 text-primary"></i> 1. RUNNING STROKE PROGRESS
                                            </div>
                                            <div class="table-responsive" style="max-height: 150px;">
                                                <table class="table table-sm table-striped mb-0 history-table" style="font-size: 0.85rem; border-collapse: separate; border-spacing: 0 5px;">
                                                    <thead class="sticky-top bg-white">
                                                        <tr>
                                                            <th width="30%">Part No</th>
                                                            <th width="20%">Std</th>
                                                            <th width="20%">Actual</th>
                                                            <th width="30%">Progress</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="diesHistoryList">
                                                        <tr>
                                                            <td colspan="4" class="text-center py-4">
                                                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Maintenance Logs -->
                                        <div class="col-12">
                                            <div class="p-3 bg-light fw-bold" style="font-size: 1.1rem; border-bottom: 2px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; color: #003366;">
                                                <span><i class="fas fa-tools me-2 text-danger"></i> 2. HISTORY MAINTENANCE PER PART NUMBER</span>
                                            </div>
                                            <div id="maintenanceGroupContainer" style="max-height: 500px; overflow-y: auto; padding: 15px; background: #ffffff;">
                                                <!-- Dynamic Part Groups will be injected here -->
                                                <div class="text-center py-4 text-muted">Loading maintenance data...</div>
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


        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Status Information</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <p>Current Status:</p>
                        <span id="modalStatusBadge" class="badge bg-secondary fs-5">Available</span>

                        <!-- Dropdown untuk memilih status -->
                        <div class="dropdown mt-3">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="statusDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Change Status
                            </button>
                            <ul class="dropdown-menu" id="dropdownMenu">
                                <li><a class="dropdown-item status-option" href="#" data-status="MESIN TROUBLE"
                                        data-color="bg-danger">MESIN TROUBLE</a></li>
                                {{-- <li><a class="dropdown-item status-option" href="#" data-status="DIES BERMASALAH"
                                        data-color="bg-warning text-dark">DIES BERMASALAH</a></li> --}}
                                <li><a class="dropdown-item status-option" href="#" data-status="NORMAL"
                                        data-color="bg-success">NORMAL</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="confirmButton">Confirm</button>
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    </div> <!-- ✅ Tambahkan penutup modal-footer -->
                </div>
            </div>
        </div>

        <!-- Export Excel Modal -->
        <div class="modal fade" id="exportExcelModal" tabindex="-1" aria-labelledby="exportExcelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exportExcelModalLabel"><i class="fas fa-file-excel me-2"></i> Export Excel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboardplanning.export') }}" method="GET">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="mesin_export" class="form-label">Machine</label>
                                <select class="form-control" id="mesin_export" name="mesin" required>
                                    <option value="All">All (C1, C2, B3)</option>
                                    <option value="LINE C1">LINE C1</option>
                                    <option value="LINE C2">LINE C2</option>
                                    <option value="LINE B3">LINE B3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="start_date_export" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date_export" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date_export" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date_export" name="end_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script></script>

    <script>





        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split("T")[0]; // Format YYYY-MM-DD
            const datePlanEl = document.getElementById("date_plan");
            if (datePlanEl) datePlanEl.value = today;
            const startDateEl = document.getElementById("start_date_export");
            if (startDateEl) startDateEl.value = today;
            const endDateEl = document.getElementById("end_date_export");
            if (endDateEl) endDateEl.value = today;

            const modalEl = document.getElementById('infoRMModal');
            const modal = modalEl ? new bootstrap.Modal(modalEl) : null;
            const buttons = document.querySelectorAll('.line-btn');
            let dataTable = null;

            buttons.forEach(button => {
                button.addEventListener('click', async function() {
                    const lineId = this.getAttribute('data-line-id');

                    // Tampilkan modal jika ada
                    if (modal) modal.show();

                    // Hapus class aktif dari semua tombol
                    buttons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Hancurkan DataTable sebelum isi ulang
                    if (dataTable) {
                        dataTable.clear().destroy();
                        dataTable = null;
                    }

                    // Kosongkan tbody
                    const tbody = document.getElementById('rm-info-body');
                    tbody.innerHTML =
                        `<tr><td colspan="8" class="text-center">Loading...</td></tr>`;

                    // Ambil data dari server
                    try {
                        const response = await fetch(
                            `{{ route('get.rm.info') }}?line_id=${encodeURIComponent(lineId)}`
                        );

                        if (!response.ok) {
                            tbody.innerHTML =
                                `<tr><td colspan="8" class="text-center text-danger">Gagal memuat data (${response.status})</td></tr>`;
                            return;
                        }

                        const data = await response.json();
                        tbody.innerHTML = '';

                        if (!Array.isArray(data) || data.length === 0) {
                            tbody.innerHTML =
                                `<tr><td colspan="8" class="text-center">No data available in table</td></tr>`;
                            return;
                        }

                        data.forEach(item => {
                            if (item.sts != 2) {
                                const row = `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.line_id}</td>
                                <td>${item.part_no}</td>
                                <td>${item.spec}</td>
                                <td>${item.qty_awal}</td>
                                <td>${item.qty_return}</td>
                                <td>${item.time}</td>
                                <td>
                                    ${
                                        item.sts == 1
                                            ? '<span class="badge bg-primary">Material Ready</span>'
                                            : `<span class="badge bg-success">${item.sts || 'Tersedia'}</span>`
                                    }
                                </td>
                                <td class="text-center">
                                    ${renderButton(item)}
                                </td>
                            </tr>
                        `;
                                tbody.innerHTML += row;
                            }
                        });

                        // Inisialisasi DataTable setelah isi tabel
                        dataTable = $('#rmTable').DataTable({
                            searching: true,
                            pageLength: 20
                        });

                    } catch (error) {
                        console.error('Fetch error:', error);
                        tbody.innerHTML =
                            `<tr><td colspan="8" class="text-center text-danger">Terjadi kesalahan saat mengambil data.</td></tr>`;
                    }
                });
            });

            function renderButton(item) {
                const disabled = item.sts === 1 ? '' : 'disabled';
                return `
            <button class="btn btn-sm btn-success accepted-btn"
                    data-id="${item.id}"
                    ${disabled}
                    style="font-size: 15px; padding: 4px 15px;">
                <i class="fas fa-sign-in-alt" style="font-size: 1.1rem; margin-right: 2px;"></i> Terima
            </button>
        `;
            }
        });



// document.addEventListener("DOMContentLoaded", function () {
//     let currentPage = 1;
//     const rowsPerPage = 5;
//     let allData = [];

//     function renderTablePage(page) {
//     const tbody = document.getElementById("lineB3Body");
//     tbody.innerHTML = "";

//     const start = (page - 1) * rowsPerPage;
//     const end = start + rowsPerPage;
//     const paginatedItems = allData.slice(start, end);

//     paginatedItems.forEach((row, index) => {
//         const no = start + index + 1;

//         // Cek jika sts_proses2 null, maka beri background hijau
//         const isNull = row.sts_proses2 === null;
//         const tr = document.createElement("tr");
//         tr.setAttribute("style", isNull ? "background-color: #d1fae5;" : "");

//         tr.innerHTML = `
//             <td>${no}</td>
//             <td>${row.uniqNo || '-'}</td>
//             <td>${row.part_no || '-'}</td>
//             <td style="background-color:#7db0df"; color:#fffff>${row.qty_out_sheet || '-'}</td>
//             <td>${row.qty_stamping || 0}</td>
//             <td>${row.qty_pallet || 0}</td>
//             <td>${row.created_at ? new Date(row.created_at).toLocaleString() : '-'}</td>
//         `;
//         tbody.appendChild(tr);
//     });

//     document.getElementById("pageInfo1").textContent = `Page ${page} of ${Math.ceil(allData.length / rowsPerPage)}`;
//  }



//     function setupPaginationControls1() {
//         document.getElementById("prevPage1").addEventListener("click", () => {
//             if (currentPage > 1) {
//                 currentPage--;
//                 renderTablePage(currentPage);
//             }
//         });

//         document.getElementById("nextPage1").addEventListener("click", () => {
//             const maxPage = Math.ceil(allData.length / rowsPerPage);
//             if (currentPage < maxPage) {
//                 currentPage++;
//                 renderTablePage(currentPage);
//             }
//         });
//     }

//     fetch("{{ route('lineb3.data') }}")
//     .then(response => response.json())
//     .then(data => {
//         console.log("Data diterima:", data); // DEBUG: cek isi data
//         allData = data;
//         renderTablePage(currentPage);
//         setupPaginationControls1();
//     })
//     .catch(error => {
//         console.error("Gagal ambil data LINE B3:", error);
//     });

// });


  //////


// document.addEventListener("DOMContentLoaded", function () {
//     let currentPage = 1;
//     const rowsPerPage = 5;
//     let allData = [];

//     function renderTablePage(page) {
//     const tbody = document.getElementById("lineC1Body");
//     tbody.innerHTML = "";

//     const start = (page - 1) * rowsPerPage;
//     const end = start + rowsPerPage;
//     const paginatedItems = allData.slice(start, end);

//     paginatedItems.forEach((row, index) => {
//         const no = start + index + 1; // <-- Ini dia
//         const tr = document.createElement("tr");
//         tr.innerHTML = `
//             <td>${no}</td>
//             <td>${row.uniqNo || '-'}</td>
//             <td>${row.part_no || '-'}</td>
//             <td style="background-color:#7db0df"; color:#fffff>${row.qty_out_sheet || '-'}</td>
//             <td>${row.qty_stamping || 0}</td>
//             <td>${row.qty_pallet || 0}</td>
//             <td>${row.created_at ? new Date(row.created_at).toLocaleString() : '-'}</td>
//         `;
//         tbody.appendChild(tr);
//     });

//     document.getElementById("pageInfo2").textContent = `Page ${page} of ${Math.ceil(allData.length / rowsPerPage)}`;
//  }


//     function setupPaginationControls2() {
//         document.getElementById("prevPage2").addEventListener("click", () => {
//             if (currentPage > 1) {
//                 currentPage--;
//                 renderTablePage(currentPage);
//             }
//         });

//         document.getElementById("nextPage2").addEventListener("click", () => {
//             const maxPage = Math.ceil(allData.length / rowsPerPage);
//             if (currentPage < maxPage) {
//                 currentPage++;
//                 renderTablePage(currentPage);
//             }
//         });
//     }

//     fetch("{{ route('linec1.data') }}")
//         .then(response => response.json())
//         .then(data => {
//             allData = data;
//             renderTablePage(currentPage);
//             setupPaginationControls2();
//         })
//         .catch(error => {
//             console.error("Gagal ambil data LINE C1:", error);
//         });
// });


// document.addEventListener("DOMContentLoaded", function () {
//     let currentPage = 1;
//     const rowsPerPage = 5;
//     let allData = [];

//     function renderTablePage(page) {
//     const tbody = document.getElementById("lineC2Body");
//     tbody.innerHTML = "";

//     const start = (page - 1) * rowsPerPage;
//     const end = start + rowsPerPage;
//     const paginatedItems = allData.slice(start, end);

//     paginatedItems.forEach((row, index) => {
//         const no = start + index + 1; // <-- Ini dia
//         const tr = document.createElement("tr");
//         tr.innerHTML = `
//               <td>${no}</td>
//             <td>${row.uniqNo || '-'}</td>
//             <td>${row.part_no || '-'}</td>
//             <td style="background-color:#7db0df"; color:#fffff>${row.qty_out_sheet || '-'}</td>
//             <td>${row.qty_stamping || 0}</td>
//             <td>${row.qty_pallet || 0}</td>
//             <td>${row.created_at ? new Date(row.created_at).toLocaleString() : '-'}</td>
//         `;
//         tbody.appendChild(tr);
//     });

//     document.getElementById("pageInfo3").textContent = `Page ${page} of ${Math.ceil(allData.length / rowsPerPage)}`;
//  }


//     function setupPaginationControls() {
//         document.getElementById("prevPage3").addEventListener("click", () => {
//             if (currentPage > 1) {
//                 currentPage--;
//                 renderTablePage(currentPage);
//             }
//         });

//         document.getElementById("nextPage3").addEventListener("click", () => {
//             const maxPage = Math.ceil(allData.length / rowsPerPage);
//             if (currentPage < maxPage) {
//                 currentPage++;
//                 renderTablePage(currentPage);
//             }
//         });
//     }

//     fetch("{{ route('linec2.data') }}")
//         .then(response => response.json())
//         .then(data => {
//             allData = data;
//             renderTablePage(currentPage);
//             setupPaginationControls();
//         })
//         .catch(error => {
//             console.error("Gagal ambil data LINE C2:", error);
//         });
// });






        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split("T")[0]; // Format YYYY-MM-DD
            document.getElementById("date_plan").value = today;
        });

        $(document).ready(function() {
            $("#btn_open_page").click(function() {
                var selectedPage = $("#page_selector").val(); // Ambil nilai yang dipilih
                if (selectedPage) {
                    window.location.href = selectedPage; // Arahkan ke halaman yang dipilih
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Pilih halaman terlebih dahulu!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'custom-toast' // Tambahkan custom class
                        }
                    });
                }
            });
        });



        // Search button logic consolidated below in $(document).ready block

        // Set the initial state to blue when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const btnSearch = document.getElementById('btn_search');
            if (btnSearch) btnSearch.classList.add('btn-blue');
            const iconAlert = document.getElementById('icon-alert');
            if (iconAlert) iconAlert.style.display = 'none'; // Hide the icon initially
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
            const dateInput = document.getElementById('date_plan');

            // Set current line
            currentLine = line;

            // Display view if hidden
            if (viewElement.style.display === 'none') {
                viewElement.style.display = 'block';
            }

            // Build table shell only if it's empty or for a different line
            const currentTableLine = viewElement.getAttribute('data-line');
            if (!viewElement.innerHTML.trim() || currentTableLine !== line) {
                viewElement.setAttribute('data-line', line);
                viewElement.innerHTML = `
                    <div style="margin-bottom: 20px;">
                        <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #c6efce;">TABEL SHIFT 1 - <span class="line-header">${line}</span></h3>
                        <div class="table-responsive-wrapper" style="overflow-x: auto;">
                            <table border="1" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part No</th>
                                        <th>Job No</th>
                                        <th>Model</th>
                                        <th>Qty Plan</th>
                                        <th>Material Out</th>
                                        <th>In Stamping</th>
                                        <th>Actual Produksi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody id="incomingMaterialsTableBody1"></tbody>
                            </table>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #d9e2f3;">TABEL SHIFT 2 - <span class="line-header">${line}</span></h3>
                        <div class="table-responsive-wrapper" style="overflow-x: auto;">
                            <table border="1" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part No</th>
                                        <th>Job No</th>
                                        <th>Model</th>
                                        <th>Qty Plan</th>
                                        <th>Material Out</th>
                                        <th>In Stamping</th>
                                        <th>Actual Produksi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody id="incomingMaterialsTableBody2"></tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #ffe599;">TABEL SHIFT 3 - <span class="line-header">${line}</span></h3>
                        <div class="table-responsive-wrapper" style="overflow-x: auto;">
                            <table border="1" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part No</th>
                                        <th>Job No</th>
                                        <th>Model</th>
                                        <th>Qty Plan</th>
                                        <th>Material Out</th>
                                        <th>In Stamping</th>
                                        <th>Actual Produksi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody id="incomingMaterialsTableBody3"></tbody>
                            </table>
                        </div>
                    </div>
                `;
            } else {
                // Update line headers only
                viewElement.querySelectorAll('.line-header').forEach(h => h.textContent = line);
            }

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

                fetch(`{{ route('dashboardplanning.getIncomingMaterials') }}?mesin=${encodeURIComponent(line)}&date_plan=${selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        if (currentLine !== line) return;

                        console.log('Data fetched for', line, ':', data);
                        const filteredData = data.filter(item => item.date_plan === selectedDate);
                        updateTableContent(filteredData);

                        const loadingSpinner = document.getElementById('loading-spinner');
                        if (loadingSpinner) loadingSpinner.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        const loadingSpinner = document.getElementById('loading-spinner');
                        if (loadingSpinner) loadingSpinner.style.display = 'none';
                    });
            };

            const updateTableContent = (data) => {
                const shift1Data = data.filter(item => item.shift === "1");
                const shift2Data = data.filter(item => item.shift === "2");
                const shift3Data = data.filter(item => item.shift === "3");

                populateTableRows('incomingMaterialsTableBody1', shift1Data);
                populateTableRows('incomingMaterialsTableBody2', shift2Data);
                populateTableRows('incomingMaterialsTableBody3', shift3Data);
            };
            const populateTableRows = (tableBodyId, shiftData) => {
                const tableBody = document.getElementById(tableBodyId);
                if (!tableBody) return;

                // Sort shiftData by position
                shiftData.sort((a, b) => parseInt(a.position || 0) - parseInt(b.position || 0));

                let rowsHtml = '';
                if (shiftData.length > 0) {
                    shiftData.forEach((item, index) => {
                        const statusBadge2 = item.status_proses === 1 ?
                            '<span style="background-color: #1E90FF; color: #ffffff; padding: 3px 9px; border-radius: 5px;">Ready Transit</span>' :
                            item.status_proses === 2 ?
                            '<span style="background-color: #ffc100; color: #000000; padding: 3px 10px; border-radius: 10px;">Proses</span>' :
                            item.status_proses === 6 ?
                            '<span style="background-color: #D20103; color: #000000; padding: 3px 10px; border-radius: 10px;">RMTA</span>' :
                            item.status_proses === 3 ?
                            '<span style="background-color: #32cd32; color: #ffffff; padding: 3px 10px; border-radius: 10px;">Finish</span>' :
                            item.status_proses === 4 ?
                            '<span style="background-color: #87cefa; color: #000000; padding: 3px 9px; border-radius: 5px;">On Proses</span>' :
                            item.status_proses === 5 ?
                            '<span style="background-color: #ebe55b; color: #000000; padding: 3px 9px; border-radius: 5px;">Cancel Proses</span>' :
                            item.status_proses === 7 ?
                            '<span style="background-color: #54f6ff; color: #000000; padding: 3px 9px; border-radius: 5px;">IN Proses</span>' :
                            `<span style="background-color: #cffbf9; color: #000000; padding: 3px 9px; border-radius: 5px;">${item.status || 'Prepare'}</span>`;

                        const isApproveDisabled = item.status_proses === null ||
                            [1, 3, 4, 5].includes(item.status_proses);

                        const approveButtonStyle = item.status_proses === 3 ?
                            'background-color: #32cd32; color: white; font-weight: bold;' :
                            '';

                        const isActionDisabled = item.status_proses === 3;

                        rowsHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.part_no2 || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.model_id || '-'}</td>
                            <td>${item.qty_plan || 0}</td>
                            <td>${item.qty_out_material || 0}</td>
                            <td style='background-color:#96fb95'>${item.qty_in_material || 0}</td>
                            <td style='background-color:#96fb95'>${item.actual_production || '-'}</td>
                            <td>${statusBadge2}</td>
                            <td>
                                <button class="btn btn-sm btn-primary approve-production-btn"
                                        data-id="${item.id}"
                                        style="${approveButtonStyle}"
                                        ${isApproveDisabled ? 'disabled' : ''}>
                                    Approve
                                </button>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning cancel-proses-btn"
                                    data-part-no="${item.part_no}"
                                    data-date-plan="${item.date_plan}"
                                    data-shift="${item.shift}"
                                    data-qty-out-material="${item.qty_out_material}"
                                    ${isActionDisabled ? 'disabled' : ''}>
                                    ACTION
                                </button>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-info remark-proses-btn"
                                    data-part-no2="${item.part_no2}"
                                    data-date-plan="${item.date_plan}"
                                    data-shift="${item.shift}"
                                    data-qty-out-material="${item.qty_out_material}">
                                    REMARK
                                </button>
                            </td>
                        </tr>
                    `;
                    });
                } else {
                    rowsHtml = '<tr><td colspan="12">No data available.</td></tr>';
                }
                tableBody.innerHTML = rowsHtml;
            };

            fetchAndDisplayData();

            if (autoUpdateTimer) clearInterval(autoUpdateTimer);
            autoUpdateTimer = setInterval(fetchAndDisplayData, 5000);
        }



        document.addEventListener('click', function(event) {
    if (event.target.classList.contains('approve-production-btn')) {
        const id = event.target.getAttribute('data-id');

        $.ajax({
            url: '{{ route("dashboardplanning.getActualProduction", ":id") }}'.replace(':id', id),
            method: 'GET',
            success: function(response) {
                const actualProduction = response.actual_production ?? 0;
                const qtyPlan = response.qty_plan ?? 0;
                const isDisabled = actualProduction > 0;

                Swal.fire({
                    title: 'Selesaikan Produksi',
                    html: `
                        <p>Masukkan jumlah produksi aktual:</p>
                        <input type="number" id="qty_actual_input" class="swal2-input" placeholder="Qty Actual"
                            ${isDisabled ? `disabled value="${actualProduction}"` : ''}>
                        <p style="margin-top:8px; font-size:14px;">Plan Qty: <b>${qtyPlan}</b></p>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve!',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const input = document.getElementById('qty_actual_input');
                        const qty = parseInt(input.value);

                        if (input.disabled) return actualProduction;

                        if (!qty || isNaN(qty) || qty <= 0) {
                            Swal.showValidationMessage('Masukkan Qty Actual yang valid!');
                            return false;
                        }
                        return qty;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const actualQty = parseInt(result.value);

                        // ✅ Jika actualQty < qty_plan → tampilkan dropdown remark
                        if (actualQty < qtyPlan) {
                            Swal.fire({
                                title: 'Qty Actual lebih kecil dari Plan',
                                html: `
                                    <p>Pilih alasan (remark):</p>
                                    <select id="remarkOption" class="swal2-input">
                                        <option value="Akhir Shift">Akhir Shift</option>
                                        <option value="Dandory">Dandory</option>
                                        <option value="Trouble Robot">Trouble Robot</option>
                                        <option value="Barcode WIP T/A">Barcode WIP T/A</option>
                                        <option value="Actual R/M">Actual R/M</option>
                                        <option value="Henkaten M/P">Henkaten M/P</option>
                                        <option value="Barcode T/M Scan">Barcode T/M Scan</option>
                                        <option value="Part Di Gerinda">Part Di Gerinda</option>
                                    </select>
                                `,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Kirim',
                                cancelButtonText: 'Batal',
                                preConfirm: () => {
                                    const remark = document.getElementById('remarkOption').value;
                                    if (!remark) {
                                        Swal.showValidationMessage('Pilih salah satu remark!');
                                        return false;
                                    }
                                    return remark;
                                }
                            }).then((remarkResult) => {
                                if (remarkResult.isConfirmed) {
                                    const remarkValue = remarkResult.value;

                                    // 🔥 Kirim data ke backend
                                    $.ajax({
                                        url: '{{ route('planninglineb3.approveProduction') }}',
                                        method: 'POST',
                                        data: {
                                            id: id,
                                            actual_production: actualQty,
                                            description: remarkValue, // kirim remark
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(data) {
                                            Swal.fire({
                                                title: data.success ? 'Berhasil!' : 'Gagal!',
                                                text: data.message,
                                                icon: data.success ? 'success' : 'error',
                                                confirmButtonText: 'OK'
                                            });
                                        },
                                        error: function() {
                                            Swal.fire('Error!', 'Gagal mengirim data ke server.', 'error');
                                        }
                                    });
                                }
                            });

                        } else {
                            // ✅ Jika qty actual >= plan, langsung kirim tanpa remark
                            $.ajax({
                                url: '{{ route('planninglineb3.approveProduction') }}',
                                method: 'POST',
                                data: {
                                    id: id,
                                    actual_production: actualQty,
                                    description: null, // tidak ada remark
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: data.success ? 'Berhasil!' : 'Gagal!',
                                        text: data.message,
                                        icon: data.success ? 'success' : 'error',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                error: function() {
                                    Swal.fire('Error!', 'Gagal mengirim data ke server.', 'error');
                                }
                            });
                        }
                    }
                });
            },
            error: function() {
                Swal.fire('Error!', 'Gagal mengambil data produksi.', 'error');
            }
        });
    }
});


  // Event listener untuk tombol "Cancel Porses"
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("cancel-proses-btn")) {
                const partNo = event.target.getAttribute("data-part-no");
                const datePlan = event.target.getAttribute("data-date-plan");
                const shift = event.target.getAttribute("data-shift");
                const qtyOutMaterial = parseFloat(event.target.getAttribute("data-qty-out-material"));

                if (!partNo || !datePlan || !shift) {
                    Swal.fire('Data tidak lengkap', 'Pastikan part_no, date_plan, dan shift tersedia.', 'warning');
                    return;
                }

                const disableProsesKembali = isNaN(qtyOutMaterial) || qtyOutMaterial <= 0;
                const isQtyOutMaterialNull = isNaN(qtyOutMaterial); // null if NaN

                Swal.fire({
                    title: 'Pilih Aksi',
                    html: `
                        <select id="cancelOption" class="swal2-input">
                            <option value="5">Cancel Produksi</option>
                            <option value="2" ${disableProsesKembali ? 'disabled' : ''}>Proses Kembali</option>
                            <option value="manual" ${!isQtyOutMaterialNull ? 'disabled' : ''}>Proses Manual</option>
                        </select>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        return document.getElementById('cancelOption').value;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const selected = result.value;
                        let status = parseInt(selected);
                        let status_proses = parseInt(selected);
                        let qtyOutMaterialUpdate = null;

                        // Jika pilih "Proses Manual"
                        if (selected === "manual") {
                            status = 2;
                            status_proses = 2;
                            qtyOutMaterialUpdate = 1;
                        }

                        Swal.showLoading();

                        $.ajax({
                            url: '{{ route('planninglineb3.cancelProduction') }}',
                            method: 'POST',
                            data: {
                                part_no: partNo,
                                date_plan: datePlan,
                                shift: shift,
                                status: status,
                                status_proses: status_proses,
                                qty_out_material: qtyOutMaterialUpdate,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', 'Status Proses Telah Berubah',
                                    'success');
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error',
                                    'Terjadi kesalahan saat mengirim permintaan.', 'error');
                            }
                        });
                    }
                });
            }
        });

        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remark-proses-btn")) {
                const partNo2 = event.target.getAttribute("data-part-no2");
                const datePlan = event.target.getAttribute("data-date-plan");
                const shift = event.target.getAttribute("data-shift");

                if (!partNo2 || !datePlan || !shift) {
                    Swal.fire('Data tidak lengkap', 'Pastikan part_no, date_plan, dan shift tersedia.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Pilih Remark',
                    html: `
                <select id="remarkOption" class="swal2-input">
                    <option value="Lanjutan">Lanjutan</option>
                    <option value="Repair Dies">Repair Dies</option>
                    <option value="Troubel Mesin">Troubel Mesin</option>
                     <option value="Lanjutan&Repair dies">Lanjutan&Repair dies</option>
                     <option value="BARCODE T/A">BARCODE T/A</option>
                     <option value="RM T/A">RM T/A</option>
                     <option value="ACTUAL RM">ACTUAL RM</option>
                     <option value="AKHIR SHIFT">AKHIR SHIFT</option>
                     <option value="DIES BONGKAR">DIES BONGKAR</option>
                     <option value="WIP PROSES">WIP PROSES</option>
                     <option value="PROSES 2X">PROSES 2X</option>
                    <option value="Jumsih">Jumsih</option>
                </select>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        return document.getElementById('remarkOption').value;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const remarkValue = result.value;

                        Swal.showLoading();

                        $.ajax({
                            url: '{{ route('planninglineb3.updateRemark') }}',
                            method: 'POST',
                            data: {
                                part_no2: partNo2,
                                date_plan: datePlan,
                                shift: shift,
                                description: remarkValue,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success');
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error',
                                    'Terjadi kesalahan saat mengirim data remark.', 'error');
                            }
                        });
                    }
                });
            }
        });





        let machineStatusChart = null;
        let productionAchievementChart = null;

        function reloadMachineCondition() {
            const date = $("#date_plan").val();
            $.ajax({
                url: "{{ route('dashboardplanning.getMachineCondition') }}",
                type: "GET",
                data: { date: date },
                success: function(data) {
                    // Update table
                    let tableHtml = "";
                    let runningCount = 0;
                    let troubleCount = 0;
                    let idleCount = 0;

                    for (const line in data) {
                        const item = data[line];
                        tableHtml += `
                            <tr>
                                <td class="fw-bold">${line}</td>
                                <td><span class="status-indicator ${item.status_class}"></span> ${item.status}</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar ${item.actual >= item.plan && item.plan > 0 ? 'bg-success' : 'bg-warning'}" role="progressbar" style="width: ${item.load > 100 ? 100 : item.load}%;"></div>
                                    </div>
                                    <small class="text-muted">${item.load}% (${item.actual}/${item.plan})</small>
                                </td>
                                <td class="text-center fw-bold ${item.air_pressure < 5.0 && item.air_pressure > 0 ? 'text-danger' : 'text-primary'}">
                                    <i class="fas fa-wind me-1"></i> ${item.air_pressure || '0.0'}
                                </td>
                                <td class="text-center fw-bold ${item.oil_level < 20 ? 'text-danger' : 'text-success'}">
                                    <i class="fas fa-oil-can me-1"></i> ${item.oil_level || '0'}%
                                </td>
                                <td class="text-muted small">Just now</td>
                            </tr>
                        `;
                        if (item.status === 'Running') runningCount++;
                        else if (item.status === 'Trouble') troubleCount++;
                        else idleCount++;
                    }
                    $("#machineConditionList").html(tableHtml);

                    // Update Charts
                    initMachineCharts(runningCount, troubleCount, idleCount, data);
                }
            });
        }

        function initMachineCharts(running, trouble, idle, prodData) {
            // Machine Status Chart (Doughnut)
            const ctxStatus = document.getElementById('machineStatusChart');
            if (!ctxStatus) return;

            if (machineStatusChart) {
                machineStatusChart.destroy();
            }

            machineStatusChart = new Chart(ctxStatus.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Running', 'Trouble', 'Idle'],
                    datasets: [{
                        data: [running, trouble, idle],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 10 }
                        }
                    },
                    cutout: '70%'
                }
            });

            // Production Achievement Chart (Bar)
            const ctxProd = document.getElementById('productionAchievementChart');
            if (!ctxProd) return;

            if (productionAchievementChart) {
                productionAchievementChart.destroy();
            }

            if (!prodData) return;

            const labels = Object.keys(prodData);
            const planData = labels.map(l => prodData[l].plan);
            const actualData = labels.map(l => prodData[l].actual);

            productionAchievementChart = new Chart(ctxProd.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Plan', data: planData, backgroundColor: '#003366' },
                        { label: 'Actual', data: actualData, backgroundColor: '#00c3ff' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    scales: {
                        x: { beginAtZero: true }
                    }
                }
            });
        }

        function reloadDiesHistory() {
            const date = $("#date_plan").val();
            $.ajax({
                url: "{{ route('dashboardplanning.getDiesHistory') }}",
                type: "GET",
                data: { date: date },
                success: function(data) {
                    let html = "";
                    if (data.length === 0) {
                        html = '<tr><td colspan="4" class="text-center py-3 text-muted">Tidak ada data dies history untuk tanggal ini.</td></tr>';
                    } else {
                        data.forEach(item => {
                            let progressClass = "progress-red";
                            if (item.progress >= 100) progressClass = "progress-green";
                            else if (item.progress >= 50) progressClass = "progress-yellow";

                            html += `
                                <tr>
                                    <td><strong class="text-primary">${item.part_no}</strong><br><small class="text-muted">${item.job_no || '-'}</small></td>
                                    <td class="text-center">${parseInt(item.std_stroke).toLocaleString()}</td>
                                    <td class="text-center">${parseInt(item.actual_stroke).toLocaleString()}</td>
                                    <td>
                                        <div class="progress-wrapper">
                                            <div class="progress-bar-custom ${progressClass}" style="width: ${item.progress > 100 ? 100 : item.progress}%">${item.progress}%</div>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    $("#diesHistoryList").html(html);
                }
            });
        }

        function reloadMaintenanceHistory() {
            const date = $("#date_plan").val();
            $.ajax({
                url: "{{ route('dashboardplanning.getMaintenanceHistory') }}",
                type: "GET",
                data: { date: date },
                dataType: "json",
                success: function(data) {
                    let container = $("#maintenanceGroupContainer");
                    if (data.length === 0) {
                        container.html('<div class="text-center py-5 text-muted bg-light border rounded" style="font-size: 1.1rem;">Belum ada riwayat perbaikan untuk part yang sedang running hari ini.</div>');
                        return;
                    }

                    const groupedData = data.reduce((acc, item) => {
                        if (!acc[item.part_no]) acc[item.part_no] = [];
                        acc[item.part_no].push(item);
                        return acc;
                    }, {});

                    let html = "";
                    for (const partNo in groupedData) {
                        html += `
                            <div class="part-maintenance-block mb-4 shadow-sm" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; width: 100%;">
                                <div class="p-3" style="background: linear-gradient(to right, #003366, #00509d); color: #fff; font-size: 1.1rem;">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <i class="fas fa-microchip me-2"></i> PART NO: <strong style="font-size: 1.2rem; letter-spacing: 1px;">${partNo}</strong>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="badge bg-danger p-2 px-3" style="font-size: 0.9rem; border-radius: 20px;">${groupedData[partNo].length} Records</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" style="width: 100% !important;">
                                    <table class="table table-bordered mb-0" style="width: 100% !important; table-layout: fixed;">
                                        <thead>
                                            <tr style="background: #f1f8ff; color: #003366; text-align: center; font-size: 0.9rem;">
                                                <th width="30%" style="padding: 10px;">Problem (Masalah)</th>
                                                <th width="35%" style="padding: 10px;">Action (Tindakan)</th>
                                                <th width="15%" style="padding: 10px;">Date Action</th>
                                                <th width="20%" style="padding: 10px;">Repair Time</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 0.9rem;">
                        `;

                        groupedData[partNo].forEach(item => {
                            let planDate = item.date_plan ? new Date(item.date_plan).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-';
                            let startTime = item.dt_start ? new Date(item.dt_start).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) : '-';
                            let finishTime = item.dt_finish ? new Date(item.dt_finish).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) : '-';

                            html += `
                                <tr>
                                    <td class="p-2" style="vertical-align: top; border-right: 1px solid #eee;">
                                        <div class="text-danger fw-bold" style="line-height: 1.4;">
                                            <i class="fas fa-exclamation-triangle me-1"></i> ${item.problem ?? '-'}
                                        </div>
                                    </td>
                                    <td class="p-2" style="vertical-align: top; border-right: 1px solid #eee;">
                                        <div class="p-2" style="background: #f0fff4; border: 1px solid #c6f6d5; border-radius: 4px; color: #2e7d32; line-height: 1.4; font-size: 0.85rem;">
                                            <i class="fas fa-wrench me-1"></i> ${item.tindakan ?? '-'}
                                        </div>
                                    </td>
                                    <td class="p-2 text-center align-middle fw-bold text-dark" style="font-size: 0.85rem; border-right: 1px solid #eee;">${planDate}</td>
                                    <td class="p-2 text-center align-middle bg-light" style="font-size: 0.85rem;">
                                        <div class="fw-bold text-primary mb-1">${startTime} - ${finishTime}</div>
                                        <div class="badge bg-info text-dark shadow-sm py-1 px-2" style="border-radius: 10px; font-size: 0.7rem;">Area: ${item.line_id}</div>
                                    </td>
                                </tr>
                            `;
                        });
                        html += `</tbody></table></div></div>`;
                    }
                    container.html(html);
                }
            });
        }

        $(document).ready(function() {
            // Initial loads
            reloadMachineCondition();
            reloadDiesHistory();
            reloadMaintenanceHistory();

            // Auto-refresh intervals (every 2 minutes)
            setInterval(reloadMachineCondition, 120000);
            setInterval(reloadDiesHistory, 120000);
            setInterval(reloadMaintenanceHistory, 120000);

            $("#btn_search").click(function() {
                const btnSearch = document.getElementById('btn_search');
                const iconAlert = document.getElementById('icon-alert');
                const loadingSpinner = document.getElementById('loading-spinner');

                if (loadingSpinner) loadingSpinner.style.display = 'block';

                // Ganti warna tombol
                if (btnSearch.classList.contains('btn-blue')) {
                    btnSearch.classList.remove('btn-blue');
                    btnSearch.classList.add('btn-green');
                    if (iconAlert) iconAlert.style.display = 'inline';
                } else {
                    btnSearch.classList.remove('btn-green');
                    btnSearch.classList.add('btn-blue');
                    if (iconAlert) iconAlert.style.display = 'none';
                }

                reloadMachineCondition();
                reloadDiesHistory();
                reloadMaintenanceHistory();

                if (currentLine) {
                    showIncomingMaterials(currentLine);
                }
            });

            // Add interactivity to "Status Mesin" badges
            $(document).on('click', '.clickable-badge', function() {
                const mesin = $(this).data('mesin');
                if (mesin) {
                    showIncomingMaterials(mesin);

                    // Optional: Smooth scroll to the table section
                    const tableSection = document.getElementById('incomingMaterialsView');
                    if (tableSection) {
                        tableSection.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });

        // Event listener untuk tombol "Approve Production"
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('approve-production-btn')) {
                const id = event.target.getAttribute('data-id');

                $.ajax({
                    url: '{{ route("dashboardplanning.getActualProduction", ":id") }}'.replace(':id', id),
                    method: 'GET',
                    success: function(response) {
                        const actualProduction = response.actual_production ?? 0;
                        const qtyPlan = response.qty_plan ?? 0;
                        const isDisabled = actualProduction > 0;

                        Swal.fire({
                            title: 'Selesaikan Produksi',
                            html: `
                                <p>Masukkan jumlah produksi aktual:</p>
                                <input type="number" id="qty_actual_input" class="swal2-input" placeholder="Qty Actual"
                                    ${isDisabled ? `disabled value="${actualProduction}"` : ''}>
                                <p style="margin-top:8px; font-size:14px;">Plan Qty: <b>${qtyPlan}</b></p>
                            `,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Approve!',
                            cancelButtonText: 'Batal',
                            preConfirm: () => {
                                const input = document.getElementById('qty_actual_input');
                                const qty = parseInt(input.value);

                                if (input.disabled) return actualProduction;

                                if (!qty || isNaN(qty) || qty <= 0) {
                                    Swal.showValidationMessage('Masukkan Qty Actual yang valid!');
                                    return false;
                                }
                                return qty;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const actualQty = parseInt(result.value);

                                // ✅ Jika actualQty < qty_plan → tampilkan dropdown remark
                                if (actualQty < qtyPlan) {
                                    Swal.fire({
                                        title: 'Qty Actual lebih kecil dari Plan',
                                        html: `
                                            <p>Pilih alasan (remark):</p>
                                            <select id="remarkOption" class="swal2-input">
                                                <option value="Lanjutan">Lanjutan</option>
                                                <option value="Repair Dies">Repair Dies</option>
                                                <option value="Troubel Mesin">Troubel Mesin</option>
                                                <option value="Actual WIP">Actual WIP</option>
                                                <option value="RM TA">RM TA</option>
                                                <option value="ACTUAL RM">ACTUAL RM</option>
                                                <option value="AKHIR SHIFT">AKHIR SHIFT</option>
                                                <option value="Tunggu WIP">Tunggu WIP</option>
                                                <option value="PROSES 2X">PROSES 2X</option>
                                                <option value="Barcode RM TA">Barcode RM TA</option>
                                            </select>
                                        `,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Kirim',
                                        cancelButtonText: 'Batal',
                                        preConfirm: () => {
                                            const remark = document.getElementById('remarkOption').value;
                                            if (!remark) {
                                                Swal.showValidationMessage('Pilih salah satu remark!');
                                                return false;
                                            }
                                            return remark;
                                        }
                                    }).then((remarkResult) => {
                                        if (remarkResult.isConfirmed) {
                                            const remarkValue = remarkResult.value;

                                            // 🔥 Kirim data ke backend
                                            $.ajax({
                                                url: '{{ route('dashboardplanning.approveProduction') }}',
                                                method: 'POST',
                                                data: {
                                                    id: id,
                                                    actual_production: actualQty,
                                                    description: remarkValue, // kirim remark
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(data) {
                                                    Swal.fire({
                                                        title: data.success ? 'Berhasil!' : 'Gagal!',
                                                        text: data.message,
                                                        icon: data.success ? 'success' : 'error',
                                                        confirmButtonText: 'OK'
                                                    });
                                                },
                                                error: function() {
                                                    Swal.fire('Error!', 'Gagal mengirim data ke server.', 'error');
                                                }
                                            });
                                        }
                                    });

                                } else {
                                    // ✅ Jika qty actual >= plan, langsung kirim tanpa remark
                                    $.ajax({
                                        url: '{{ route('dashboardplanning.approveProduction') }}',
                                        method: 'POST',
                                        data: {
                                            id: id,
                                            actual_production: actualQty,
                                            description: null, // tidak ada remark
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(data) {
                                            Swal.fire({
                                                title: data.success ? 'Berhasil!' : 'Gagal!',
                                                text: data.message,
                                                icon: data.success ? 'success' : 'error',
                                                confirmButtonText: 'OK'
                                            });
                                        },
                                        error: function() {
                                            Swal.fire('Error!', 'Gagal mengirim data ke server.', 'error');
                                        }
                                    });
                                }
                            }
                        });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal mengambil data produksi.', 'error');
                    }
                });
            }
        });





    </script>
@endpush








