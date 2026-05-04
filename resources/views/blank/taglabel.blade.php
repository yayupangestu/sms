@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
    </style>
    <div style="background-color: #003366; color:#ffffff"class="content-header">
        <div class="container-fluid">
            <div style="background: linear-gradient(to bottom, #003366 25%, #000000 78%);"
                class="row mb-4 align-items-center">
                <div class="col-md-6" style="position: relative;">
                    <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                        <img src="dist/img/adw3.png" class="brand-image2" style="width: 200px; height: auto;">
                    </div>
                    <strong>
                        <h3 style="color: white; display: inline;">Dashboard Informasi BLANK</h3>
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
    <section class="custom-dashboard">
        <div class="row">
            <!-- Kiri: Card Mesin -->
            <div class="col-md-6">
                <div class="row justify-content-center text-center">
                    <div class="col-auto mb-3 mx-2">
                        <div class="card" style="width: 140px; cursor: pointer;" onclick="showIncomingMaterials('KOMATSU')">
                            <img src="dist/img/press-machine (7).png" class="brand-image img-fluid" alt="KOMATSU">
                            <div class="metric-card">
                                <h4 style="color: white;">KOMATSU</h4>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto mb-3 mx-2">
                        <div class="card" style="width: 140px; cursor: pointer;" onclick="showIncomingMaterials('FUKUI')">
                            <img src="dist/img/press-machine (7).png" class="brand-image img-fluid" alt="FUKUI">
                            <div class="metric-card">
                                <h4 style="color: white;">FUKUI</h4>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto mb-3 mx-2">
                        <div class="card" style="width: 140px; cursor: pointer;" onclick="showIncomingMaterials('AMINO')">
                            <img src="dist/img/press-machine (7).png" class="brand-image img-fluid" alt="AMINO">
                            <div class="metric-card">
                                <h4 style="color: white;">AMINO</h4>
                            </div>
                            <div class="progress-bar">
                                <div class="available" style="width: 100%;"></div>
                            </div>
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
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-primary" id="btn_search">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <span id="icon-alert" class="ms-2 text-danger" style="display: none;">
                            <i class="fa fa-exclamation-circle"></i>
                        </span>
                    </div>
                </div>


                <!-- Divider -->
                <hr class="my-3">
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



            <!-- Kanan: Tabel QR Code -->
            <div class="col-md-6">
                <div class="partner-card h-40">
                    <div class="bg-gradient-gray p-3 rounded-top shadow-sm mb-3"
                        style="background: linear-gradient(to right, #0062E6, #33AEFF);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-white fw-bold mb-0" style="letter-spacing: 1px;">
                                <i class="fa fa-clipboard-list me-2"></i>INFORMASI STOK BLANK
                            </h4>
                            <a href="dashboardblank" style="margin-left: 20px;">
                                <button class="btn btn-info">
                                    <i class="fa fas fa-arrow-left"></i> Dashboard Detail Stok
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Tambahan 4 kotak isi penuh tinggi -->
                    <div class="container h-80">
                        @php

                    $totalPart = DB::table('tabel_stok_blanks')
                        ->where('home_line', 'ASI-1')
                        ->count();


                        $totalSafe = DB::table('tabel_stok_blanks')
                            ->where('home_line', 'ASI-1')
                            ->whereColumn('qty_kanban', '>', 'qty_min')
                            ->count();

                        $totalCritical = DB::table('tabel_stok_blanks')
                                    ->whereColumn('qty_kanban', '<', 'qty_min')
                                    ->where('qty_kanban', '>', 0) // Hanya yang positif
                                    ->where('home_line', 'ASI-1')
                                    // ->where('keterangan', '!=', 2)  // Kecuali yang keterangan = 2
                                    ->count();

                                    $totalTa = DB::table('tabel_stok_blanks')
                                        ->where('home_line', 'ASI-1')
                                        ->where(function ($query) {
                                            $query->whereNull('qty_kanban')
                                                ->orWhere('qty_kanban', 0);
                                        })
                                        ->count();

                                        $totalSafe2 = DB::table('tabel_stok_blanks')
                            ->where('home_line', 'ASI-1')
                            ->whereColumn('qty_kanban', '>', 'qty_min')
                            ->count();

                        $totalCritical2 = DB::table('tabel_stok_blanks')
                                    ->whereColumn('qty_kanban', '<', 'qty_min')
                                    ->where('qty_kanban', '>', 0) // Hanya yang positif
                                    ->where('home_line', 'ASI-1')
                                    // ->where('keterangan', '!=', 2)  // Kecuali yang keterangan = 2
                                    ->count();

                                    $totalTa2 = DB::table('tabel_stok_blanks')
                                        ->where('home_line', 'ASI-1')
                                        ->where(function ($query) {
                                            $query->whereNull('qty_kanban')
                                                ->orWhere('qty_kanban', 0);
                                        })
                                        ->count();

                    @endphp
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="p-4 bg-light border rounded shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                    <h5 class="fw-bold text-primary mb-2">Total Item</h5>
                                    <span class="display-4 fw-semibold text-dark" id="totalItem">{{ $totalPart }} </span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-4 bg-light border rounded shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                    <h5 class="fw-bold text-success mb-2">PART SAFE</h5>
                                    <span class="display-4 fw-semibold text-dark" id="qtyZero">{{ $totalSafe }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-4 bg-light border rounded shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                    <h5 class="fw-bold text-danger mb-2">PART CRITICAL</h5>
                                    <span class="display-4 fw-semibold text-dark" id="qtyNull">{{ $totalCritical }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="p-4 bg-light border rounded shadow-sm text-center h-100 d-flex flex-column justify-content-center">
                                    <h5 class="fw-bold text-danger mb-2">PART TA</h5>
                                    <span class="display-4 fw-semibold text-dark" id="qtyTotalKanban">{{ $totalTa2 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="partner-card h-80">
                    <div class="bg-gradient-gray p-3 rounded-top shadow-sm mb-3"
                        style="background: linear-gradient(to right, #0062E6, #33AEFF);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-white fw-bold mb-0" style="letter-spacing: 1px;">
                                <i class="fa fa-clipboard-list me-2"></i> TABEL PEMBUATAN LABEL QR-CODE
                            </h4>
                            <div class="card-tools">
                                <button class="btn btn-sm btn-outline-light" id="btn_add">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead style="background-color: #e9ecef; color: #495057;">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Date</th>
                                    <th>Line</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data rows go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%); color:aliceblue">
                    <h4 class="modal-title" id="title1">Tambah Label</h4>
                    <h4 class="modal-title" id="title2">Edit Label</h4>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-primary btn-sm" id="btn_submit">Save</button>
                        {{-- <button class="btn btn-default btn-sm" id="btn_cancel">Cancel</button> --}}
                        <button type="button" class="close; btn btn-secondary" data-dismiss="modal"
                            aria-label="Close">Close</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-1 col-form-label">Date :</label>
                        <div class="col-sm-3">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="date" id="plan_date" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-8"></div>
                        <label class="col-sm-1 col-form-label">Line :</label>
                        <div class="col-sm-3 mb-1">
                            <select style="width: 100%;" id="line_id" class="form-control form-control-sm" required>
                                <option value="" selected>- pilih -</option>
                                <option value="FUKUI">FUKUI</option>
                                <option value="KOMATSU">KOMATSU</option>
                                <option value="AMINO">AMINO</option>
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Kode Material:</label>
                        <div class="col-sm-4">
                            <select id="kode_material" class="form-control form-control-sm" required>
                                <option value="">Pilih Kode Material</option>
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <input type="text" id="qty_blank" class="form-control form-control-sm" readonly>
                        </div>


                        {{-- <div class="col-sm-1"></div> --}}
                        {{-- <label class="col-sm-1 col-form-label">Item:</label>
                        <div class="col-sm-6 mb-2">
                            <select style="width: 100%;" id="product_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($tabel_stok_blanks as $part)
                                    <option value="{{ $part->id }}" data-part_name="{{ $part->part_name }}"
                                        data-job_no="{{ $part->job_no }}" data-part_no="{{ $part->part_no }}"
                                        data-model="{{ $part->model }}">
                                     {{ $part->job_no }} / {{ $part->part_no }} / {{ $part->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <label class="col-sm-1 col-form-label">Item:</label>
                        <div class="col-sm-6 mb-2">
                            <select style="width: 100%;" id="product_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($tabel_stok_blanks as $part)
                                    <option value="{{ $part->id }}" data-part_name="{{ $part->part_name }}"
                                        data-job_no="{{ $part->job_no }}" data-part_no2="{{ $part->part_no2 }}"
                                        data-part_no="{{ $part->part_no }}" data-model_id="{{ $part->model_id }}">
                                        | {{ $part->part_no }} | {{ $part->job_no}} | {{ $part->model_id }} | {{ $part->part_no2 }} (
                                        {{ $part->createdby }} )
                                    </option>
                                @endforeach
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

                        <label class="col-sm-1 col-form-label">Actual:</label>
                        <div class="col-sm-2 mb-1">
                            <input type="text" id="qty_act" class="form-control form-control-sm" required disabled>
                        </div>

                        <label class="col-sm-1 col-form-label">NG:</label>
                        <div class="col-sm-1 mb-1">
                            <input type="text" id="qty_ng" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-7">
                            <button type="button" class="btn btn-success btn-sm Save">Insert</button>
                            <button type="button" class="btn btn-info btn-sm SumQty">Jumlahkan Qty</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-sm text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Part Name</th>
                                    <th>Job No</th>
                                    <th>Part No</th>
                                    <th>Model</th>
                                    <th>Spec</th>
                                    <th>Actual</th>
                                    <th>NG</th>
                                    <th>Kode Material</th>
                                    <th>Status Scan</th>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="qtyModal" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%); color:white"
                    class="modal-header">
                    <h5 class="modal-title" id="sumQtyModalLabel">Jumlahkan Quantity Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label for="km_part" class="form-label fw-bold">Part No</label>
                            <select class="form-control form-control-sm" id="km_part"></select>
                        </div>
                    </div>
                    <form id="sumQtyForm">
                        <div class="mb-2">
                            <label for="uniqNo1" class="form-label">Kode Material 1</label>
                            <select class="form-control form-control-sm" id="uniqNo1" name="uniqNo1" required></select>
                        </div>
                        <div class="mb-2">
                            <label for="uniqNo2" class="form-label">Kode Material 2</label>
                            <select class="form-control form-control-sm" id="uniqNo2" name="uniqNo2" required></select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 btn-sm">Jumlahkan</button>
                    </form>
                    <div id="totalQtyResult" class="mt-3" style="display:none;">
                        <div class="alert alert-success d-flex align-items-center p-2" role="alert">
                            <i class="bi bi-check-circle me-2" style="font-size: 1.2rem;"></i>
                            <strong>Total Quantity:</strong> <span id="totalQty"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <input type="hidden" id="job_no" name="job_no">
    <input type="hidden" id="part_no" name="part_no">
    <input type="hidden" id="part_no2" name="part_no2">
    <input type="hidden" id="model_id" name="model_id">
    <input type="hidden" id="part_name" name="part_name">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            list();
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

        //DROPDOWN KODE MATERIAL YANG AKAN DI PROSES
        document.getElementById("kode_material").addEventListener("change", function() {
            var qtyAct = document.getElementById("qty_act");
            if (this.value) {
                qtyAct.removeAttribute("disabled"); // Aktifkan input jika ada pilihan
            } else {
                qtyAct.setAttribute("disabled", "true"); // Nonaktifkan kembali jika kosong
            }
        });


        $(document).ready(function() {
            let originalOptions = $('#product_id option').clone(); // Simpan opsi awal

            // Saat product dipilih
            $('#product_id').on('change', function() {
                let selectedOption = $(this).find(':selected');
                let partNo = selectedOption.data('part_no');

                if (partNo) {
                    $.ajax({
                        url: "{{ route('taglabelblank.getKodeMaterial') }}",
                        type: 'GET',
                        data: {
                            part_no: partNo
                        },
                        success: function(response) {
                            let kodeMaterialDropdown = $('#kode_material');
                            kodeMaterialDropdown.empty().append(
                                '<option value="">Pilih Kode Material</option>');

                            if (response.length === 0) {
                                kodeMaterialDropdown.append(
                                    '<option disabled>Tidak ada stok tersedia</option>');
                                return;
                            }

                            response.forEach(item => {
                                if (item.qty_blank > 0) {
                                    kodeMaterialDropdown.append(`
                                <option value="${item.uniqno}" data-part_no="${item.part_no}">
                                    ${item.uniqno} - ${item.spec} - ${item.part_no} (Stok: ${item.qty_blank})
                                </option>
                            `);
                                }
                            });
                        },
                        error: function() {
                            alert('Gagal mengambil data kode material.');
                        }
                    });
                } else {
                    $('#kode_material').empty().append('<option value="">Pilih Kode Material</option>');
                }
            });

            // Saat kode_material dipilih, sinkronkan ke product_id jika perlu
            $('#kode_material').change(function() {
                let selectedPartNo = $('#kode_material option:selected').data('part_no');

                if (selectedPartNo) {
                    $('#product_id option').each(function() {
                        if ($(this).data('part_no') == selectedPartNo) {
                            $('#product_id').val($(this).val()).trigger('change.select2');
                        }
                    });
                }
            });

            // Inisialisasi Select2
            $('#product_id').select2();
        });



        $(document).ready(function() {
            function updateQtyBlank() {
                let selectUniqNo = $('#kode_material').val();

                if (selectUniqNo) {
                    $.ajax({
                        url: "{{ route('taglabelblank.getQtyBlank') }}",
                        type: 'GET',
                        data: {
                            uniqno: selectUniqNo
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#qty_blank').val(response.qty_blank);
                            }
                        }
                    });
                }
            }

            // Jalankan update setiap 1 detik
            setInterval(updateQtyBlank, 1000);

            // Update saat dropdown kode_material berubah
            $('#kode_material').change(function() {
                updateQtyBlank();
            });
        });

        //BATASNYA




        $(document).ready(function () {
    // Tampilkan modal saat tombol "SumQty" diklik
    document.querySelector('.SumQty').addEventListener('click', () => {
        const modal = new bootstrap.Modal(document.getElementById('qtyModal'));
        modal.show();

        // Ambil data Part No saat modal dibuka
        $.get("{{ route('taglabelblank.getPartNos') }}", function (data) {
            if (data.length > 0) {
                let options = '<option value="">Pilih Part No</option>';
                data.forEach(item => {
                    options += `<option value="${item.part_no}">${item.part_no}</option>`;
                });
                $('#km_part').html(options);
            } else {
                $('#km_part').html('<option value="">Data tidak ditemukan</option>');
            }
        }).fail(function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengambil data Part No!',
            });
        });
    });

    // Ketika Part No dipilih
   // Saat Part No dipilih
$('#km_part').on('change', function () {
    const partNo = $(this).val();
    if (partNo) {
        $.ajax({
            url: "{{ route('taglabelblank.getMaterialCodes') }}",
            type: "GET",
            data: { part_no: partNo },
            success: function (response) {
                if (response.length > 0) {
                    let options = '<option value="">Pilih Kode Material</option>';
                    response.forEach(item => {
                        options += `<option value="${item.part_no}" data-qty="${item.qty_blank}" data-uniq="${item.uniqNo}">
                            ${item.part_no} - ${item.qty_blank} - ${item.uniqNo}
                        </option>`;
                    });
                    $('#uniqNo1').html(options);
                    $('#uniqNo2').html(options);
                } else {
                    $('#uniqNo1, #uniqNo2').html('<option value="">Tidak ada data</option>');
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal mengambil kode material!',
                });
            }
        });
    } else {
        $('#uniqNo1, #uniqNo2').html('<option value="">Silakan pilih Part No terlebih dahulu</option>');
    }
});

// ===== Filter uniqNo2 berdasarkan pilihan uniqNo1 =====
$('#uniqNo1').on('change', function () {
    const selectedUniq1 = $(this).find(':selected').data('uniq');

    $('#uniqNo2 option').each(function () {
        const uniq2 = $(this).data('uniq');
        if (uniq2 === selectedUniq1) {
            $(this).hide();   // sembunyikan yang sama
        } else {
            $(this).show();   // tampilkan lainnya
        }
    });

    // reset pilihan uniqNo2 kalau sebelumnya pilih yang sama
    if ($('#uniqNo2').find(':selected').data('uniq') === selectedUniq1) {
        $('#uniqNo2').val('');
    }
});


$('#sumQtyForm').on('submit', function (e) {
    e.preventDefault();

    // Ambil selected option dari kedua select box
    const selected1 = $('#uniqNo1 option:selected');
    const selected2 = $('#uniqNo2 option:selected');

    const qty1 = parseFloat(selected1.data('qty')) || 0; // qty_blank pada Kode Material 1
    const qty2 = parseFloat(selected2.data('qty')) || 0; // qty_blank pada Kode Material 2
    const total = qty1 + qty2;

    // Tampilkan hasil ke user
    Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: `Qty baru untuk Material 2: ${qty1} + ${qty2} = ${total}`,
    });

    // Ambil uniqNo dari selected options
    const uniqNo1 = selected1.data('uniq'); // Ambil uniqNo untuk Kode Material 1
    const uniqNo2 = selected2.data('uniq'); // Ambil uniqNo untuk Kode Material 2

    // Kirim update ke server via AJAX untuk mengurangi qty_blank pada Kode Material 1 (mengurangi nilai awal qty1)
    $.ajax({
        url: "{{ route('taglabelblank.updateQtyBlank') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            uniq_no: uniqNo1,  // Kirim uniqNo untuk Kode Material 1
            qty_blank: qty1 - qty1  // Kurangi qty_blank pada Kode Material 1 dengan nilai awalnya
        },
        success: function (res) {
            console.log(res);
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal mengurangi qty_blank untuk Kode Material 1!'
            });
        }
    });

    // Kirim update ke server via AJAX untuk menambah qty_blank pada Kode Material 2 (menambahkan total)
    $.ajax({
        url: "{{ route('taglabelblank.updateQtyBlank') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            uniq_no: uniqNo2,  // Kirim uniqNo untuk Kode Material 2
            qty_blank: total  // Tambah qty_blank pada Kode Material 2 dengan total penjumlahan
        },
        success: function (res) {
            console.log(res);
            // Optional: reload select, modal, dll
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal mengupdate qty_blank pada Kode Material 2!'
            });
        }
    });
});

});










        $('#product_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var job_no = selectedOption.data('job_no');
            var part_no = selectedOption.data('part_no');
            var part_no2 = selectedOption.data('part_no2');
            var model_id = selectedOption.data('model_id');
            var part_name = selectedOption.data('part_name');

            // Assign the values to hidden inputs or directly to an AJAX request payload
            $('#job_no').val(job_no);
            $('#part_no').val(part_no);
            $('#part_no2').val(part_no2);
            $('#model_id').val(model_id);
            $('#part_name').val(part_name);
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
                order: [
                    [1, 'desc']
                ], // Urutkan berdasarkan kolom ke-1 (`date_plan`) dari yang terbaru
                ajax: {
                    url: "{{ route('taglabelblank.list') }}"
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
                        data: 'plan_date',
                        name: 'plan_date'
                    },
                    {
                        data: 'line_id',
                        name: 'line_id'
                    },
                    {
                        data: 'mix_id',
                        name: 'mix_id',
                        render: function(data) {
                            return '<a href="#" id="btn_edit" title="Edit" data-id="' + data +
                                '" class="btn btn-info btn-sm">' +
                                '<i class="fas fa-search"></i>' +
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
                    url: "{{ route('taglabelblank.listdetail') }}",
                    data: {
                        plan_date: plan_date.value,
                        line_id: line_id.value,
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
                        data: 'part_name',
                        name: 'part_name'
                    },
                    {
                        data: 'job_no',
                        name: 'job_no'
                    },
                    {
                        data: 'part_no2',
                        name: 'part_no2'
                    },
                    {
                        data: 'model_id',
                        name: 'model_id'
                    },
                    {
                        data: 'spec',
                        name: 'spec'
                    },
                    {
                        data: 'qty_act',
                        name: 'qty_act'
                    },
                    {
                        data: 'qty_ng',
                        name: 'qty_ng'
                    },
                    {
                        data: 'uniqNo',
                        name: 'uniqNo'
                    },
                    {
                        data: 'sts_scan',
                        name: 'sts_scan',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="badge badge-success">Sudah Scan</span>';
                            } else {
                                return '<span class="badge badge-warning">Belum Scan</span>';
                            }
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row) {
                            let disableClass = row.sts_scan == 1 ? 'disabled-link' : '';
                            let disableStyle = row.sts_scan == 1 ? 'pointer-events: none; opacity: 0.5;' :
                                '';

                            return '<a href="#" id="btn_delete_line" title="Delete" data-id="' + data +
                                '" class="btn btn-danger btn-sm ml-1 ' + disableClass + '" style="' +
                                disableStyle + '">' +
                                '<i class="far fa-trash-alt"></i>' +
                                '</a>' +
                                '<a href="#" id="btn_pdf" title="Generate" data-id="' + data +
                                '" class="btn btn-info btn-sm ml-1">' +
                                '<i class="fas fa-qrcode"></i>' +
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


        $(document).on("click", "#btn_add", function() {
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $("#title2").hide();
            $(".Update").hide();
            $("#title1").show();
            clear();

            // Set tanggal hari ini secara otomatis
            let today = new Date().toISOString().split('T')[0];
            $("#plan_date").val(today);
        });


        $(document).on("click", "#btn_edit", function() {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var plan_date = id.substr(0, 10);
            var idline = id.substr(10);
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('#plan_date').val(plan_date);
            $('#line_id').val(idline).trigger('change');
            listdetail();
        });

        $(document).on("click", "#btn_edit_line", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('planninglineb3.edit') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                        $('#id').val(result.id);
                        $('#product_id').val(result.product_id);
                        $('#qty_act').val(result.qty_act);
                        $('#time_start').val(result.time_start).trigger('change');
                        $('#time_end').val(result.time_end).trigger('change');
                        // $('#description').val(result.description);
                    } else {
                        SweetAlert.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });

        $(document).on("click", ".close", function() {
            clear();
            $("#alert").html('');
            list();
        });

        function clear() {
            $("#id").val('');
            $("#plan_date").val('');
            $('#line_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $("#qty_act").val('');
            $("#qty_ng").val('');
            // $('#material_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function() {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('taglabelblank.store') }}",
                    data: {
                        plan_date: plan_date.value,
                        line_id: line_id.value,
                        product_id: product_id.value,
                        qty_act: qty_act.value,
                        job_no: job_no.value,
                        part_name: part_name.value,
                        part_no: part_no.value,
                        part_no2: part_no2.value,
                        model_id: model_id.value,
                        qty_ng: qty_ng.value,
                        kode_material: kode_material.value,
                        qty_blank: qty_blank.value,
                        // spec: spec.value,
                        // material_id: material_id.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#alert").html(
                                '<div class="alert alert-success"><i class="fa fa-check"></i> ' +
                                result.msg + '</div>');
                            listdetail();
                            $('#product_id').val('').trigger('change');
                            $("#qty_act").val('');
                            $("#qty_ng").val('');
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

        $(document).on("click", ".Update", function() {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('taglabelblank.update') }}",
                    data: {
                        id: id.value,
                        plan_date: plan_date.value,
                        line_id: line_id.value,
                        product_id: product_id.value,
                        qty_act: qty_act.value,
                        job_no: job_no.value,
                        part_name: part_name.value,
                        part_no: part_no.value,
                        part_no2: part_no2.value,
                        model_id: model_id.value,
                        qty_ng: qty_ng.value,
                        // spec: spec.value,
                        kode_material: kode_material.value,
                        qty_blank: qty_blank.value,
                        // description: description.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            SweetAlert.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            listdetail();
                            $('#product_id').val('').trigger('change');
                            $('#qty_act').val('').trigger('change');
                            // $('#material_id').val('').trigger('change');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 150);
                        } else {
                            SweetAlert.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    }
                });
            }
        });

        $(document).on('click', '#btn_pdf', function(e) {
            e.preventDefault();

            // Ambil data-id dari tombol yang diklik
            var id = $(this).data('id');

            // Bangun URL untuk mencetak PDF
            var printUrl = "{{ route('taglabelblank.cetak', ':id') }}".replace(':id', id);

            // Coba buka di tab baru
            var newWindow = window.open(printUrl, '_blank');

            // Fallback: jika tab baru diblokir oleh browser, buka di jendela saat ini
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                window.location.href = printUrl;
            }
        });


        function validasi() {
            $("#alert").show();
            if (plan_date.value != '' && line_id.value != '' && product_id.value != '' && qty_act.value != '' && qty_ng.value != '') {
                return true;
            } else {
                $("#alert").html(
                    '<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
                setTimeout(() => {
                    $("#alert").hide();
                }, 1500);
            }
        }

        $(document).on("click", "#btn_delete_line", function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('taglabelblank.destroyline') }}",
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
                            listdetail();
                        }
                    });
                }
            })
        });

        $(document).on("click", "#btn_delete", function() {
            var id = $(this).data('id');
            var plan_date = id.substr(0, 10);
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
                        url: "{{ route('taglabelblank.destroy') }}",
                        data: {
                            plan_date: plan_date,
                            idline: idline,
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

        $(document).on("click", "#btn_submit", function() {
            updt_submit();
            location.reload(); // Refresh halaman setelah berhasil
        });

        function updt_submit() {
            $("#alert").html('');
            $("#alert").show();
            $.ajax({
                type: 'POST',
                url: "{{ route('taglabelblank.submit') }}",
                data: {
                    plan_date: plan_date.value,
                    line_id: line_id.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#modal_header').modal('hide');
                        SweetAlert.fire({
                            icon: 'success',
                            title: 'Success',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        list();
                    } else {
                        $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                            result.msg + '</div>');
                        setTimeout(() => {
                            $("#alert").hide();
                        }, 1500);
                    }
                }
            });
        }

        ///////////////// Ini Batas dashboar kanan

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
                            `{{ route('get_rm_blank') }}?line_id=${encodeURIComponent(lineId)}`
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


        document.getElementById('btn_search').addEventListener('click', function() {
            const btnSearch = document.getElementById('btn_search');
            const iconAlert = document.getElementById('icon-alert');

            // Toggle class to green on click
            if (btnSearch.classList.contains('btn-blue')) {
                btnSearch.classList.remove('btn-blue');
                btnSearch.classList.add('btn-green');
                iconAlert.style.display = 'inline'; // Show the icon
            } else {
                btnSearch.classList.remove('btn-green');
                btnSearch.classList.add('btn-blue');
                iconAlert.style.display = 'none'; // Hide the icon
            }
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
                        if (currentLine !== line) return; // Cegah update jika LINE berubah

                        console.log('Data fetched:', data);

                        // Filter data berdasarkan tanggal
                        const filteredData = data.filter(item => item.date_plan === selectedDate);

                        // **Update tabel dengan data baru**
                        updateTable(filteredData, line);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        viewElement.innerHTML = '<div>Error fetching data. Please try again later.</div>';
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
                                <th>In BLANK</th>
                                <th>Actual Produksi</th>
                                <th>Status Order</th>
                                <th>Action</th>
                                <th>Action</th>
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
                                <th>In BLANK</th>
                                <th>Actual Produksi</th>
                                <th>Status Order</th>
                                <th>Action</th>
                                <th>Action</th>
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
                                <th>In BLANK</th>
                                <th>Actual Produksi</th>
                                <th>Status Order</th>
                                <th>Action</th>
                                <th>Action</th>
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
                                item.status_proses === 4;

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
                                        Approve Production
                                    </button>
                                    <td>
                                  <button
                                        class="btn btn-sm btn-warning cancel-proses-btn"
                                        data-part-no="${item.part_no}"
                                        data-date-plan="${item.date_plan}"
                                        data-shift="${item.shift}"
                                        data-mesin="${item.mesin}"
                                        data-qty-out-material="${item.qty_out_material}"
                                        ${buttonAksi ? 'disabled' : ''}>
                                        AKSI
                                    </button>

                        </td>
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
                    url: '{{ route("dashboardplanningblank.getActualProduction", ":id") }}'.replace(':id', id),
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
                            url: '{{ route('dashboardplanningblank.approveProduction') }}',
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
                                }).then(() => {
                                    if (data.success) location.reload();
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
        const mesin = event.target.getAttribute("data-mesin");
        const qtyOutMaterial = parseFloat(event.target.getAttribute("data-qty-out-material"));

        if (!partNo || !datePlan || !shift || !mesin) {
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
                    // status_proses2 = 2;
                    qtyOutMaterialUpdate = 1;
                }

                Swal.showLoading();

                $.ajax({
                    url: '{{ route('dashboardplanningblank.cancelProduction') }}',
                    method: 'POST',
                    data: {
                        part_no: partNo,
                        date_plan: datePlan,
                        shift: shift,
                        mesin: mesin,
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


        function fetchLatestMaterials() {
            const tableBody = document.querySelector('#rm-materials-table table tbody');

            fetch('{{ route('dashboardrm.getLatestRmReturnMaterials') }}')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="10" class="text-center">No data available</td></tr>`;
                    } else {
                        data.forEach(material => {
                            const row = `
                        <tr>
                            <td style="font-size: 20px; color:white">${material.uniqNo ?? '-'}</td>
                            <td style="font-size: 20px; color:white">${material.part_no ?? '-'}</td>
                            <td style="font-size: 20px; color:white">${material.spec ?? '-'}</td>
                            <td style="font-size: 20px; color:white">${material.supplier ?? '-'}</td>
                            <td style="font-size: 20px; color:#07ed77">${material.qty_out_sheet ?? '-'}</td>
                            <td style="font-size: 20px; color:#f3ff0e">${material.qty_sisa ?? '-'}</td>
                            <td style="font-size: 20px; color:white">${new Intl.DateTimeFormat('id-ID', { timeStyle: 'short' }).format(new Date(material.created_at))}</td>
                            <td style="font-size: 20px; color:white">${material.createdby ?? '-'}</td>
                            <td style="font-size: 20px; background-color:#e1ff0054; color:white">${material.scan_stmp_user ?? '-'}</td>
                            <td style="font-size: 20px; background-color:#e1ff0054; color:white">${material.scan_stmp_time ?? '-'}</td>
                        </tr>`;
                            tableBody.innerHTML += row;
                        });
                    }
                })
                .catch(error => console.error('Error fetching material data:', error));
        }

        // Panggil fungsi pertama kali
        fetchLatestPlanningData();
        fetchLatestMaterials();




        document.addEventListener("DOMContentLoaded", function() {
            // Event listener untuk badge di luar modal
            document.querySelector(".clickable-badge").addEventListener("click", function() {
                var myModal = new bootstrap.Modal(document.getElementById('statusModal'));
                myModal.show();
            });

            // Event delegation untuk menangani event klik pada dropdown-item
            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("status-option")) {
                    event.preventDefault(); // Mencegah navigasi ulang

                    var statusText = event.target.getAttribute("data-status");
                    var statusColor = event.target.getAttribute("data-color");

                    var modalStatusBadge = document.getElementById("modalStatusBadge");
                    modalStatusBadge.textContent = statusText;
                    modalStatusBadge.className = "badge fs-5 " + statusColor;
                }
            });

            // Event listener untuk tombol Confirm
            document.getElementById("confirmButton").addEventListener("click", function() {
                var selectedStatus = document.getElementById("modalStatusBadge").textContent;
                var statusValue = null;

                // Menentukan nilai status berdasarkan teks yang dipilih
                if (selectedStatus === "MESIN TROUBLE") {
                    statusValue = 5;
                } else if (selectedStatus === "NORMAL") {
                    statusValue = 2;
                }

                // Jika ada status yang sesuai, lakukan AJAX request
                if (statusValue !== null) {
                    $.ajax({
                        url: '{{ route('dashboardplanning.updateStatusProses') }}', // Sesuaikan dengan route yang ada
                        method: 'POST',
                        data: {
                            mesin: "LINE B3",
                            new_status: statusValue,
                            _token: '{{ csrf_token() }}' // Pastikan token CSRF disertakan
                        },
                        success: function(response) {
                            if (response.success) {
                                alert("Status berhasil diperbarui!");
                            } else {
                                alert("Gagal memperbarui status: " + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan, coba lagi.");
                        }
                    });
                } else {
                    alert("Status confirmed: " + selectedStatus);
                }
            });

            // Cek apakah modal terbuka sebelum menjalankan setInterval
            function isModalOpen() {
                return document.getElementById("statusModal").classList.contains("show");
            }

            // Interval untuk fetch data, tetapi tidak berjalan jika modal terbuka
            setInterval(function() {
                if (!isModalOpen()) {
                    fetchLatestPlanningData();
                    fetchLatestMaterials();
                }
            }, 5000);
        });


    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush





