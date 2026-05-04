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

                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="my-3">

                    <!-- Dropdown & Go Button -->
                    <div class="form-group row align-items-center">
                        <label for="page_selector" class="col-sm-2 col-form-label text-white">LINE:</label>
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
                        <div class="bg-gradient-gray p-3 rounded-top text-center shadow-sm mb-3"
                            style="background: linear-gradient(to right, #0062E6, #33AEFF);">
                            <h4 class="text-white fw-bold mb-0" style="letter-spacing: 1px;">
                                <i class="fa fa-clipboard-list me-2"></i> MATERIAL TRANSIT
                            </h4>
                        </div>


                        <div class="table-responsive">
                            <div class="row gy-4">

                                <!-- LINE B3 -->
                                <div class="col-md-6">
                                    <div class="p-2 bg-gray text-white rounded-top shadow-sm mb-0 d-flex justify-content-center align-items-center">
                                        <i class="fa fa-cogs me-2"></i>
                                        <h5 class="mb-0 fw-bold">LINE B3</h5>
                                    </div>

                                    <!-- Tambahkan wrapper table-responsive di sini -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm text-white gradient-blue">
                                            <thead class="gradient-blue">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Unique No</th>
                                                    <th>Part No</th>
                                                    <th style="background-color: #17a2b8; color:white">Qty Awal</th>
                                                    <th>Qty RH/LH</th>
                                                    <th>Qty Pallet</th>
                                                    <th>Tanggal</th>

                                                </tr>
                                            </thead>
                                            <tbody id="lineB3Body">
                                                <!-- Diisi dengan AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="paginationControls1" class="mt-2 text-center">
                                        <button id="prevPage1" class="btn btn-sm btn-light me-2">Previous</button>
                                        <span id="pageInfo1" class="text-white">Page 1</span>
                                        <button id="nextPage1" class="btn btn-sm btn-light ms-2">Next</button>
                                    </div>
                                </div>


                                <!-- LINE C1 -->
                                <div class="col-md-6">
                                    <div class="p-2 bg-gray text-white rounded-top shadow-sm mb-0 d-flex justify-content-center align-items-center">
                                        <i class="fa fa-cogs me-2"></i>
                                        <h5 class="mb-0 fw-bold">LINE C1</h5>
                                    </div>

                                    <!-- Tambahkan wrapper table-responsive di sini -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm text-white gradient-blue">
                                            <thead class="gradient-blue">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Unique No</th>
                                                    <th>Part No</th>
                                                    <th style="background-color: #17a2b8; color:white">Qty Awal</th>
                                                    <th>Qty RH/LH</th>
                                                    <th>Qty Pallet</th>
                                                    <th>Tanggal</th>

                                                </tr>
                                            </thead>
                                            <tbody id="lineC1Body">
                                                <!-- Diisi dengan AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="paginationControls2" class="mt-2 text-center">
                                        <button id="prevPage2" class="btn btn-sm btn-light me-2">Previous</button>
                                        <span id="pageInfo2" class="text-white">Page 1</span>
                                        <button id="nextPage2" class="btn btn-sm btn-light ms-2">Next</button>
                                    </div>
                                </div>


                                <!-- LINE C2 -->
                                <div class="col-md-6">
                                    <div class="p-2 bg-gray text-white rounded-top shadow-sm mb-0 d-flex justify-content-center align-items-center">
                                        <i class="fa fa-cogs me-2"></i>
                                        <h5 class="mb-0 fw-bold">LINE C2</h5>
                                    </div>

                                    <!-- Tambahkan wrapper table-responsive di sini -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm text-white gradient-blue">
                                            <thead class="gradient-blue">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Unique No</th>
                                                    <th>Part No</th>
                                                    <th style="background-color: #17a2b8; color:white">Qty Awal</th>
                                                    <th>Qty RH/LH</th>
                                                    <th>Qty Pallet</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lineC2Body">
                                                <!-- Diisi dengan AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="paginationControls3" class="mt-2 text-center">
                                        <button id="prevPage3" class="btn btn-sm btn-light me-2">Previous</button>
                                        <span id="pageInfo3" class="text-white">Page 1</span>
                                        <button id="nextPage3" class="btn btn-sm btn-light ms-2">Next</button>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>


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
            const modal = new bootstrap.Modal(document.getElementById('infoRMModal'));
            const buttons = document.querySelectorAll('.line-btn');
            let dataTable = null;

            buttons.forEach(button => {
                button.addEventListener('click', async function() {
                    const lineId = this.getAttribute('data-line-id');

                    // Tampilkan modal
                    modal.show();

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



        document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    const rowsPerPage = 5;
    let allData = [];

    function renderTablePage(page) {
    const tbody = document.getElementById("lineB3Body");
    tbody.innerHTML = "";

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = allData.slice(start, end);

    paginatedItems.forEach((row, index) => {
        const no = start + index + 1;

        // Cek jika sts_proses2 null, maka beri background hijau
        const isNull = row.sts_proses2 === null;
        const tr = document.createElement("tr");
        tr.setAttribute("style", isNull ? "background-color: #d1fae5;" : "");

        tr.innerHTML = `
            <td>${no}</td>
            <td>${row.uniqNo || '-'}</td>
            <td>${row.part_no || '-'}</td>
            <td style="background-color:#7db0df"; color:#fffff>${row.qty_out_sheet || '-'}</td>
            <td>${row.qty_stamping || 0}</td>
            <td>${row.qty_pallet || 0}</td>
            <td>${row.created_at ? new Date(row.created_at).toLocaleString() : '-'}</td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById("pageInfo1").textContent = `Page ${page} of ${Math.ceil(allData.length / rowsPerPage)}`;
}



    function setupPaginationControls1() {
        document.getElementById("prevPage1").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                renderTablePage(currentPage);
            }
        });

        document.getElementById("nextPage1").addEventListener("click", () => {
            const maxPage = Math.ceil(allData.length / rowsPerPage);
            if (currentPage < maxPage) {
                currentPage++;
                renderTablePage(currentPage);
            }
        });
    }

    fetch("{{ route('lineb3.data') }}")
    .then(response => response.json())
    .then(data => {
        console.log("Data diterima:", data); // DEBUG: cek isi data
        allData = data;
        renderTablePage(currentPage);
        setupPaginationControls1();
    })
    .catch(error => {
        console.error("Gagal ambil data LINE B3:", error);
    });

});


  //////


     document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    const rowsPerPage = 5;
    let allData = [];

    function renderTablePage(page) {
    const tbody = document.getElementById("lineC1Body");
    tbody.innerHTML = "";

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = allData.slice(start, end);

    paginatedItems.forEach((row, index) => {
        const no = start + index + 1; // <-- Ini dia
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${no}</td>
            <td>${row.uniqNo || '-'}</td>
            <td>${row.part_no || '-'}</td>
            <td style="background-color:#7db0df"; color:#fffff>${row.qty_out_sheet || '-'}</td>
            <td>${row.qty_stamping || 0}</td>
            <td>${row.qty_pallet || 0}</td>
            <td>${row.created_at ? new Date(row.created_at).toLocaleString() : '-'}</td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById("pageInfo2").textContent = `Page ${page} of ${Math.ceil(allData.length / rowsPerPage)}`;
}


    function setupPaginationControls2() {
        document.getElementById("prevPage2").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                renderTablePage(currentPage);
            }
        });

        document.getElementById("nextPage2").addEventListener("click", () => {
            const maxPage = Math.ceil(allData.length / rowsPerPage);
            if (currentPage < maxPage) {
                currentPage++;
                renderTablePage(currentPage);
            }
        });
    }

    fetch("{{ route('linec1.data') }}")
        .then(response => response.json())
        .then(data => {
            allData = data;
            renderTablePage(currentPage);
            setupPaginationControls2();
        })
        .catch(error => {
            console.error("Gagal ambil data LINE C1:", error);
        });
});


document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    const rowsPerPage = 5;
    let allData = [];

    function renderTablePage(page) {
    const tbody = document.getElementById("lineC2Body");
    tbody.innerHTML = "";

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = allData.slice(start, end);

    paginatedItems.forEach((row, index) => {
        const no = start + index + 1; // <-- Ini dia
        const tr = document.createElement("tr");
        tr.innerHTML = `
              <td>${no}</td>
            <td>${row.uniqNo || '-'}</td>
            <td>${row.part_no || '-'}</td>
            <td style="background-color:#7db0df"; color:#fffff>${row.qty_out_sheet || '-'}</td>
            <td>${row.qty_stamping || 0}</td>
            <td>${row.qty_pallet || 0}</td>
            <td>${row.created_at ? new Date(row.created_at).toLocaleString() : '-'}</td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById("pageInfo3").textContent = `Page ${page} of ${Math.ceil(allData.length / rowsPerPage)}`;
}


    function setupPaginationControls() {
        document.getElementById("prevPage3").addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                renderTablePage(currentPage);
            }
        });

        document.getElementById("nextPage3").addEventListener("click", () => {
            const maxPage = Math.ceil(allData.length / rowsPerPage);
            if (currentPage < maxPage) {
                currentPage++;
                renderTablePage(currentPage);
            }
        });
    }

    fetch("{{ route('linec2.data') }}")
        .then(response => response.json())
        .then(data => {
            allData = data;
            renderTablePage(currentPage);
            setupPaginationControls();
        })
        .catch(error => {
            console.error("Gagal ambil data LINE C2:", error);
        });
});






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
                                <th colspan="13">${line}</th>
                            </tr>
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
            <div>
                <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #d9e2f3;">TABEL SHIFT 2</h3>
                <div style="overflow-x: auto;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th colspan="13">${line}</th>
                            </tr>
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
                <h3 class="text-center" style="font-family:'Times New Roman', Times, serif; background-color: #ffe599;">TABEL SHIFT 3</h3>
                <div style="overflow-x: auto;">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th colspan="13">${line}</th>
                            </tr>
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
                    tableBody.innerHTML = '';

                    // Urutkan shiftData berdasarkan position secara numerik
                    shiftData.sort((a, b) => parseInt(a.position) - parseInt(b.position));

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


                            const isButtonDisabled = item.status_proses === null ||
                                item.status_proses === 1 ||
                                item.status_proses === 3 ||
                                item.status_proses === 4 ||
                                item.status_proses === 5;

                            const buttonStyle = item.status_proses === 3 ?
                                'background-color: #32cd32; color: white; font-weight: bold;' :
                                '';

                            const buttonAksi = item.status_proses === 3


                            tableBody.innerHTML += `
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
                                            style="${buttonStyle}"
                                            ${isButtonDisabled ? 'disabled' : ''}>
                                        Approve
                                    </button>
                                    <td>
                                  <button
                                        class="btn btn-sm btn-warning cancel-proses-btn"
                                        data-part-no="${item.part_no}"
                                        data-date-plan="${item.date_plan}"
                                        data-shift="${item.shift}"
                                        data-qty-out-material="${item.qty_out_material}"
                                        ${buttonAksi ? 'disabled' : ''}>
                                        ACTION
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
                        tableBody.innerHTML = '<tr><td colspan="14">No data available.</td></tr>';
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



        // Event listener untuk tombol "Approve Production"
        document.addEventListener('click', function(event) {
                if (event.target.classList.contains('approve-production-btn')) {
                    const id = event.target.getAttribute('data-id');

                    // Ambil data dari backend (pastikan route-nya tersedia)
                    $.ajax({
                        url: '{{ route("planninglineb3.getActualProduction", ":id") }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const actualProduction = response.actual_production ?? 0;
                            const isDisabled = actualProduction > 0;

                            Swal.fire({
                                title: 'Selesaikan Produksi',
                                html: `
                                    <p>Masukkan jumlah produksi aktual:</p>
                                    <input type="number" id="qty_actual_input" class="swal2-input" placeholder="Qty Actual"
                                        ${isDisabled ? `disabled value="${actualProduction}"` : ''}>
                                `,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Approve!',
                                cancelButtonText: 'Batal',
                                preConfirm: () => {
                                    const input = document.getElementById('qty_actual_input');
                                    const qty = input.value;

                                    if (input.disabled) {
                                        return actualProduction;
                                    }

                                    if (!qty || isNaN(qty) || qty <= 0) {
                                        Swal.showValidationMessage('Masukkan Qty Actual yang valid!');
                                        return false;
                                    }

                                    return qty;
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const actualQty = result.value;

                                    $.ajax({
                                        url: '{{ route('planninglineb3.approveProduction') }}',
                                        method: 'POST',
                                        data: {
                                            id: id,
                                            actual_production: actualQty,
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

                                        error: function(err) {
                                            Swal.fire('Error!', 'Gagal mengirim data ke server.', 'error');
                                        }
                                    });
                                }
                            });
                        },
                        error: function(err) {
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
                                Swal.fire('Berhasil!', 'Status Proses Telah Berubah', 'success');
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Terjadi kesalahan saat mengirim permintaan.', 'error');
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
                    <option value="Actual WIP">Actual WIP</option>
                     <option value="RM TA">RM TA</option>
                      <option value="Tunggu WIP">Tunggu WIP</option>
                       <option value="Barcode RM TA">Barcode RM TA</option>
                        <option value="Distaker ERROR">Distaker ERROR</option>
                         <option value="Crane Mati">Crane Mati</option>
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
                        Swal.fire('Error', 'Terjadi kesalahan saat mengirim data remark.', 'error');
                    }
                });
            }
        });
    }
});





    </script>
@endpush
