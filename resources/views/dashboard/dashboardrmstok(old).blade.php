@extends('layouts.app')

@section('content')
    <style>
        .custom-dashboard {
            background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .metric-card {
            /* background: linear-gradient(to bottom, #11ed2e 5%, #6699ff 96%); */
            border-radius: 15px;
            padding: 30px 20px;
            color: #fff;
            box-shadow: 0 6px 15px rgba(58, 142, 214, 0.3);
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-left: 10px;
            /* Adjust as needed */
            display: inline-block;
            /* Keeps the badge in line with text */
        }

        .metric-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(58, 142, 214, 0.4);
        }

        .metric-card h5 {
            font-size: 18px;
            font-weight: 500;
            color: #f0f4f8;
            /* Lighter text color for better contrast */
            margin-bottom: 10px;
        }

        .metric-card h2 {
            font-size: 40px;
            font-weight: bold;
            color: #fff;
            margin: 0;
        }

        #incomingTable.table-hover tbody tr:hover {
            background: linear-gradient(to bottom right, #ffffff 18%, #669999 77%);
            color: #000000;
            /* Warna teks saat hover (opsional) */
        }

        .small-box {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .small-box:hover {
            transform: scale(2.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            /* Membuat elemen pindah ke bawah jika ruang habis */
            justify-content: center;
            /* Memposisikan elemen agar tetap di tengah */
            gap: 10px;
            /* Jarak antar elemen */
            padding: 10px;
        }

        .small-box {
            background: #ffffff;
            width: 300px;
            height: 150px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .small-box:hover {
            transform: scale(1.05);
            /* Animasi saat hover */
        }

        @media (max-width: 768px) {
            .small-box {
                width: 100%;
                /* Membuat elemen memenuhi lebar layar pada layar kecil */
                height: auto;
            }
        }

        @media (max-width: 480px) {
            .container {
                flex-direction: column;
                /* Jika layar sangat kecil, buat semua elemen berbaris vertikal */
                align-items: center;
            }
        }

        .carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            max-width: 100%;
        }

        .carousel-content {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-behavior: smooth;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 10px;
            z-index: 10;
        }

        .carousel-button.left {
            left: 0;
        }

        .carousel-button.right {
            right: 0;
        }

        .savings-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .savings-content {
            flex-grow: 1;
        }

        /* CARD ATAS */
        /* General Card Styling */
        /* Info Box Styling */
        .info-box {
            /* background: linear-gradient(to bottom, #3b6289 0%, #002850 100%); */
            background: #3d465f;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            padding: 25px;
            position: relative;
            color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Content Styling */
        .info-content {
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .info-title {
            font-size: 30px;
            font-weight: 500;
            margin: 0;
            color: #ffffff;
            opacity: 0.9;
        }

        .info-value {
            font-size: 28px;
            font-weight: bold;
            margin: 8px 0;
            color: #ffffff;
        }

        .icon2 {
            position: absolute;
            top: 60px;
            right: 15px;
            font-size: 70px;
            color: rgba(255, 255, 255, 0.584);
        }

        /* Icon Styling */
        .info-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 80px;
            color: rgba(255, 255, 255, 0.584);
        }

        /* Change Text Styling */
        .info-change {
            font-size: 14px;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .info-change i {
            margin-right: 5px;
        }

        /* Color for positive and negative changes */
        .text-success {
            color: #4caf50;
        }

        .text-danger {
            color: #f44336;
        }


        .monthly-budget-card .chart {
            height: 150px;
            margin-top: 20px;
        }

        .chart {
            position: relative;
            height: 250px;
            /* Adjust the height as needed */
            margin-top: 15px;
        }

        .monthly-budget-card h5 {
            font-size: 18px;
            font-weight: 500;
            color: #f0f4f8;
            margin-bottom: 15px;
        }

        /* TABEL */
        .partner-card {
            background-color: #2a4b7c;
            /* Adjust color as needed */
            color: white;
            padding: 16px;
            border-radius: 8px;
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
            max-height: 400px;
            /* Ensures only the body scrolls */
            overflow-y: auto;
            position: relative;

        }


        .dataTables_filter {
            float: right;
            /* Memindahkan pencarian ke kanan */
            margin-top: 10px;
            /* Memberikan sedikit ruang di atas */
        }

        .dataTables_filter input {
            width: 200px;
            /* Menentukan lebar input pencarian */
        }

        .bg-success {
            background-color: #28a745;
            /* Warna hijau */
            color: white;
            /* Teks putih untuk kontras */
        }

        .bg-warning {
            background-color: #ffc107;
            /* Warna kuning */
            color: black;
            /* Teks hitam untuk kontras */
        }

        /* Memperbesar ukuran font pada badge */
        .badge {
            font-size: 0.9rem;
            /* Mengubah ukuran font */
            padding: 0.5em;
            /* Memberi padding agar lebih besar */
        }

        /* Efek blur pada latar belakang modal */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        /* Kontainer modal */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            border: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Header modal */
        .modal-header {
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px;
        }

        /* Tombol close */
        .modal-header .close {
            color: white;
            opacity: 0.8;
            transition: 0.3s;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        /* Body modal */
        .modal-body {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }

        /* Animasi fade-in */
        @keyframes fadeIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <div class="container-fluid py-4 custom-dashboard">
        <div class="content-header">
            <div class="container-fluid">
                <div style="background: linear-gradient(to bottom, #003366 25%, #000000 78%);"
                    class="row mb-4 align-items-center">
                    <div class="col-md-6" style="position: relative;">
                        <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                            <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                        </div>
                        <strong>
                            <h3 style="color: white; display: inline;">Dashboard Informasi STOK Material</h3>
                        </strong>
                    </div>
                    <div class="col-md-6 text-right">
                        <div
                            style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom, #003366 25%, #006699 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                            <strong>
                                <h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="dateTime"
                                    class="text-right"></h3>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>


            <div id="cardCarousel" class="carousel slide" data-bs-ride="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center text-center d-flex flex-wrap">
                            <!-- Card 1 -->
                            <div class="col-lg-3 col-md-5 mb-3 d-flex">
                                @php
                                    // Ambil semua id dari RM Stok dengan category INHOUSE jadi string dipisah koma
                                    $allIds = DB::table('rm_stoks')
                                        ->where('category_id', 'INHOUSE')
                                        ->pluck('id')
                                        ->implode(',');

                                    // Hitung jumlah id, dengan syarat category_id = INHOUSE dan keterangan != 2
                                    $row = DB::table('rm_stoks')
                                        ->where('category_id', 'INHOUSE')
                                        // ->where('keterangan', '!=', 2)
                                        ->select(DB::raw('count(id) as jml'))
                                        ->first();
                                @endphp

                                <div class="info-box h-100 w-100" onclick="showIncomingMaterials1('{{ $allIds }}')">
                                    <div class="inner">
                                        <strong>
                                            <p style="font-size: 20px; color:#ffffff">TOTAL MATERIAL</p>
                                        </strong>
                                        <strong>
                                            <h3>({{ $row->jml }}) Item Material</h3>
                                        </strong>
                                    </div>
                                    <span class="info-icon" style="color:#0ac2ff"><i class="ph-duotone ph-gauge"></i></span>
                                </div>
                            </div>


                            <!-- Card 2 -->
                            <div class="col-lg-3 col-md-5 mb-3 d-flex">
                                <div class="info-box h-100 w-100" onclick="showIncomingMaterials2('safe_data')">
                                    <div class="inner">
                                        @php
                                            $row = DB::table('rm_stoks')
                                                ->where('category_id', 'INHOUSE')
                                                ->whereColumn('actual_sheet', '>=', 'minimal')
                                                // ->where('keterangan', '!=', 2) // disembunyikan dulu
                                                ->count();
                                        @endphp

                                        <strong>
                                            <p style="font-size: 20px; color:#ffffff">TOTAL SAFE</p>
                                        </strong>
                                        <strong>
                                            <h3>({{ $row }}) Item Material</h3>
                                        </strong>
                                    </div>
                                    <span class="info-icon" style="color:#07ed77">
                                        <i class="ph-duotone ph-chart-bar"></i>
                                    </span>
                                </div>
                            </div>


                            <!-- Card 3 -->
                            <div class="col-lg-3 col-md-5 mb-3 d-flex">
                                <div class="info-box h-100 w-100" onclick="showIncomingMaterials3('critical_data')">
                                    <div class="inner">
                                        @php
                                        $row = DB::table('rm_stoks')
                                            ->whereColumn('actual_sheet', '<', 'minimal')
                                            ->where('actual_sheet', '>', 0) // Hanya yang positif
                                            ->where('category_id', 'INHOUSE')
                                            // ->where('keterangan', '!=', 2)  // Kecuali yang keterangan = 2
                                            ->count();
                                    @endphp

                                        <strong>
                                            <p style="font-size: 20px; color:#ffffff">TOTAL MATERIAL CRITICAL</p>
                                        </strong>
                                        <strong>
                                            <h3>({{ $row }}) Item Material</h3>
                                        </strong>
                                    </div>
                                    <span class="info-icon" style="color:#e1ed079d"><i
                                            class="ph-duotone ph-chart-line-down"></i></span>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-5 mb-3 d-flex">
                                <div class="info-box h-100 w-100" onclick="showIncomingMaterials4('data_ta')">
                                    <div class="inner">
                                        {{-- @php
                                        $row = DB::table('rm_stoks')
                                            ->where(function ($query) {
                                                $query->whereNull('actual_sheet')
                                                      ->orWhere('actual_sheet', '=', 0) & ('minimal', '!=', 0) ;
                                                    //   ->orWhere('minimal', '!=', 0);
                                            })
                                            ->where(function ($query) {
                                                $query->whereNull('keterangan')
                                                      ->orWhere('keterangan', '=', 1);
                                            })
                                            ->count();
                                        @endphp --}}
                                        @php
                                            $row = DB::table('rm_stoks')
                                                ->where('category_id', 'INHOUSE')
                                                ->where(function ($query) {
                                                    $query
                                                        ->where(function ($q) {
                                                            $q->whereNull('actual_sheet')
                                                            ->orWhere('actual_sheet', '=', 0);
                                                        })
                                                        ->where('minimal', '!=', 0);
                                                })
                                                // ->where(function ($query) {
                                                //     $query->whereNull('keterangan')->orWhere('keterangan', '=', 1);
                                                // })
                                                ->count();
                                        @endphp
                                        <strong>
                                            <p style="font-size: 20px; color:#ffffff">TOTAL MATERIAL TA</p>
                                        </strong>
                                        <strong>
                                            <h3>({{ $row }}) Item Material</h3>
                                        </strong>
                                    </div>
                                    <span class="info-icon" style="color:#ed0707"><i
                                            class="ph-duotone ph-warning"></i></span>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="carousel-item">
                        <div class="row justify-content-center text-center d-flex flex-wrap">
                        <!-- Card 4 -->


                        <!-- Card 5 (Tambahan) -->
                        <div class="col-lg-3 col-md-5 mb-3 d-flex">
                                <div class="info-box h-100 w-100" onclick="showIncomingMaterials5('run_out')">
                                    <div class="inner">
                                        @php
                                            $row = DB::table('rm_stoks')->where('keterangan', 2)->count();
                                        @endphp
                                        <strong>
                                            <p style="font-size: 20px; color:#ffffff">MATERIAL RUNOUT</p>
                                        </strong>
                                        <strong>
                                            <h3>({{ $row }}) Item Material</h3>
                                        </strong>
                                    </div>
                                    <span class="info-icon" style="color:#ffcc00"><i class="ph-duotone ph-clipboard"></i></span>
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
        </div>




        <section class="content">
            {{-- <div class="container-fluid py-4 custom-dashboard"> --}}
            <!-- Top Header -->

            <!-- Metrics Row -->
            <div class="row mb-4">
                <div class="carousel-container">
                    <button class="carousel-button left" onclick="slideLeft()">‹</button>
                    <div class="carousel-content">

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D12L';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D12L')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D12L</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D14N/D12L';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D14N/D12L')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D14N/D12L</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D14N';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D14N')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D14N</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D26A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D26A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D26A</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D26A/D55L/D03B';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D26A/D55L/D03B')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D26A/D55L/D03B</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D55L/D26A/D74A/D03B UPB';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D55L/D26A/D74A/D03B UPB')">
                                    <strong><i>
                                            <h3
                                                style="font-size: 20px; color:rgb(255, 255, 255); word-wrap: break-word; white-space: normal;">
                                                Model D55L/D26A/D74A/D03B UPB
                                            </h3>

                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    {{-- <span class="text-warning">More Info</span> --}}
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D03B UNB';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D03B UNB')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D03B UNB</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D03B UPB';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D03B UPB')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D03B UPB</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D40G';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D40G')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D40G</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D40L';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D40L')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D40L</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D40G/D40L';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D40G/D40L')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D40G/D40L</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D40L/D72A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D40L/D72A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D40L/D72A</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D40G/DCWA';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D40G/DCWA')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D40G/DCWA</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D40G/D40L/D72A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D40G/D40L/D72A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D40GLD40L/D72A</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D55L';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D55L')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D55L</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D55L/D74A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D55L/D74A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D55L/D74A</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D74A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D74A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D74A</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TG (1W 3W)/D72A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TG (1W 3W)/D72A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TG (1W 32)/D72A
                                            </h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D74A';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D74A')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D74A</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D88N';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D88N')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D88N</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D80N';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D80N')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D80N</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D97D';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D97D')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D97D</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'D21N/D97D';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('D21N/D97D')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model D21N/D97D</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'T86';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('T86')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model T86</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TD';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TD')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TD</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'FTD17D';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('FTD17D')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model FTD17D</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TG (1W 3W)';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TG (1W 3W)')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TG (1W 3W)</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>


                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TG (1W)';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TG (1W)')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TG (1W)</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TG (3W)';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TG (3W)')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TG (3W)</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TG EXP';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TG EXP')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TG EXP</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'TG4';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('TG4')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model TG4</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'FM';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('FM')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model FM</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'FT SL22MY';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('FT SL22MY')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model FT SL22MY</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'FTD17D';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('FTD17D')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model FTD17D</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'DATE SL22MY';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('DATE SL22MY')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model DATE SL22MY</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'JAZZ, HRV';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('JAZZ, HRV')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model JAZZ, HRV</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'KS';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('KS')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model KS</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'SL';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('SL')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model SL</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'SU2ID';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $allZeroOrNull = $data->every(function ($val) {
                                        return is_null($val) || $val == 0;
                                    });

                                    $starColor = $allZeroOrNull ? 'red' : 'lime'; // jika semua null/0 -> merah, jika ada yang > 0 -> hijau
                                    $row = $data->count();
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('SU2ID')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model SU2ID</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-2">
                            <div style="background-color: #3d465f; position: relative;" class="small-box card-shadow p-3">

                                @php
                                    $modelName = 'SU2ID FT';
                                    $data = DB::table('rm_stoks')->where('model_id', $modelName)->pluck('actual_sheet'); // Ambil semua nilai actual_sheet

                                    $total = $data->count();
                                    $countMoreThanZero = $data
                                        ->filter(function ($val) {
                                            return $val > 0;
                                        })
                                        ->count();

                                    if ($countMoreThanZero == 0) {
                                        $starColor = 'red'; // semua null/0
                                    } elseif ($countMoreThanZero < $total) {
                                        $starColor = 'yellow'; // sebagian lebih dari 0
                                    } else {
                                        $starColor = 'lime'; // semua lebih dari 0
                                    }

                                    $row = $total;
                                @endphp

                                <!-- Simbol * di pojok kanan atas -->
                                <div
                                    style="position: absolute; top: 8px; right: 8px; color: {{ $starColor }}; font-size: 30px;">
                                    !
                                </div>

                                <div class="inner" onclick="showIncomingMaterials('SU2ID FT')">
                                    <strong><i>
                                            <h3 style="font-size: 20px; color:rgb(255, 255, 255)">Model SU2ID FT</h3>
                                        </i></strong>
                                    <strong><i>
                                            <p style="font-size: 20px; color:white">( {{ $row }} ) Items</p>
                                        </i></strong>
                                    <span class="text-warning">More Info</span>
                                </div>

                                <div style="color:#fff713" class='icon2'>
                                    <i class="ph-bold ph-equalizer"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button class="carousel-button right" onclick="slideRight()">›</button>
                </div>
            </div>

            <div class="row">
                <!-- Tabel Transaksi Material Incoming -->
                <div class="col-md-4">
                    <div class="partner-card">
                        <a href="#" data-toggle="modal" data-target="#exportModal2"
                            class="btn btn-success btn-sm">
                            <i class="fa fas fa-file-excel"></i> Export Excel
                        </a>
                        <hr>
                        <h5 style="color: white">Transaksi Material Incoming</h5>
                        <div class="table-responsive auto-scroll-container2" style="max-height: 350px; overflow-y: auto;">
                            <table class="partner-table table">
                                <thead>
                                    <tr>
                                        <!-- Your headers here -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dn_inputs as $item)
                                        <tr>
                                            <td>{{ $item->part_no }}</td>
                                            <td>{{ $item->spec }}</td>
                                            {{-- <td>{{ $item->detail_t }}</td> --}}
                                            <td style="color: #07ed77;">{{ $item->actual }} Sheet</td>
                                            {{-- <td style="color: #07ed77;">{{ $item->kg_sheet }} Kg</td> --}}
                                            <td>{{ $item->supplier }}</td>
                                            <td>{{ $item->update_time }}</td>
                                            <td>{{ $item->createdby }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Tabel Transaksi Material Out -->
                <div class="col-md-4">
                    <div class="partner-card">
                        <a href="#" data-toggle="modal" data-target="#exportModal3"
                            class="btn btn-success btn-sm">
                            <i class="fa fas fa-file-excel"></i> Export Excel
                        </a>
                        <hr>
                        <h5 style="color: white">Transaksi Material Out Inhouse</h5>
                        <div class="table-responsive auto-scroll-container2" style="max-height: 350px; overflow-y: auto;">
                            <table class="partner-table table">
                                <thead>
                                    <tr>
                                        <!-- Your headers here -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scan_out_rms as $item)
                                        <tr>
                                            <td>{{ $item->uniqNo }}</td>
                                            <td>{{ $item->part_no }}</td>
                                            <td>{{ $item->spec }}</td>
                                            <td>{{ $item->supplier }}</td>
                                            <td style="color: #fff700;">{{ $item->qty_out_sheet }} Sheet</td>
                                            {{-- <td style="color: #fff700;">{{ $item->qty_out_kg }} Kg</td> --}}
                                            <td>{{ $item->createdby }}</td>
                                            <td>{{ $item->update_time }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div  style="background-color: #1a264065" class="partner-card">
                        <a href="#" data-toggle="modal" data-target="#exportModal3"
                            class="btn btn-success btn-sm">
                            <i class="fa fas fa-file-excel"></i> Export Excel
                        </a>
                        <hr>
                        <h5  style="color: white">Transaksi Material Out Subcont</h5>
                        <div class="table-responsive auto-scroll-container2" style="max-height: 350px; overflow-y: auto;">
                            <table class="partner-table table">
                                <thead>
                                    <tr>
                                        <!-- Your headers here -->
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($scan_out_subconts as $item)
                                        <tr>
                                            <td>{{ $item->uniqNo }}</td>
                                            <td>{{ $item->part_no }}</td>
                                            <td>{{ $item->spec }}</td>
                                            <td>{{ $item->supplier }}</td>
                                            <td style="color: #fff700;">{{ $item->qty_out_sheet }} Sheet</td>
                                            <td style="color: #fff700;">{{ $item->qty_out_kg }} Kg</td>
                                            <td>{{ $item->createdby }}</td>
                                            <td>{{ $item->update_time }}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            <div style=" background: #1a2640;" id="material-section" class="modal-body">
                <div style="background: linear-gradient(to top right, #1a2640 0%, #006699 44%); color: #ffffff"
                    class="form-group row">
                    <div class="col-12" id="alert"></div>
                    <div class="col-sm-7">

                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <a href="rmstok"> <button class="btn btn-info"><i style="color: #07ed77; size:50px"
                                    class="ph ph-upload"></i>Import Data Stok</button></a>
                    </div>
                    <div class="col-sm-5 text-right">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search..."
                            style="display: inline-block; width: auto;">
                        <button id="searchButton" class="btn btn-secondary"
                            style="display: inline-block;">Search</button>
                    </div>
                </div>
            </div>
            <div style="background-color: #363e55; color:white" class="table-responsive">
                <table id="incomingTable" class="table table-hover table-bordered" style="table-layout: fixed;">
                    <thead style= "background: linear-gradient(to top right, #1a2640 0%, #006699 44%); color: #ffffff">
                        <tr>
                            <th style="width: 10px; text-align:center">N0</th>
                            <th style="width: 100px; text-align:center">Part Name</th>
                            <th style="width: 50px; text-align:center">Part No(G5)</th>
                            <th style="width: 50px; text-align:center">Part No</th>
                            <th style="width: 50px; text-align:center">Job No</th>
                            <th style="width: 70px; text-align:center">Model</th>
                            <th style="width: 70px; text-align:center">Spec</th>
                            <th style="width: 10px; text-align:center">T</th>
                            <th style="width: 10px; text-align:center">W</th>
                            <th style="width: 40px; text-align:center">L</th>
                            <th style="width: 50px; text-align:center">Supplier</th>
                            <th style="width: 40px; text-align:center">Minimal</th>
                            <th style="width: 40px; text-align:center">Actual Sheet</th>
                            <th style="width: 30px; text-align:center">No Rak</th>
                            <th style="width: 40px; text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        <!-- Data tabel akan diisi di sini -->
                    </tbody>
                </table>
            </div>
    </div>
    </div>
    </div>

    <!-- Export Filter Material -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff"
                    class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Stok Material NPC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="exportForm" action="{{ route('dashboardrmstok.export') }}" method="POST">
                        @csrf <!-- CSRF Token -->

                        <div class="form-group">
                            <label for="filterLine">Select Filter</label>
                            <select id="filterLine" name="supplierFilter" class="form-control">
                                <option value="">-Pilih-</option>
                                <option value="ALL">ALL</option>
                                <option value="critical">CRITICAL</option>
                                <option value="safe">SAFE</option>
                                <option value="ta">TA</option>
                                <option value="runout">RANOUT</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="exportForm" class="btn btn-primary" id="exportBtn">Export</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Export Incoming Excel -->
    <div class="modal fade" id="exportModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff"
                    class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export Material Incoming by Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('dashboardrmstok.export2') }}">
                        @csrf
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-success">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Export Outgoing Excel -->
    <div class="modal fade" id="exportModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff"
                    class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export Material Outgoing by Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('dashboardrmstok.export3') }}">
                        @csrf
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-success">Export Outgoing</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div style="background-color: #003366; color:white" class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Part Details</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <div class="modal-body">
                    <!-- Details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal2" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail PO</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="modalTableContainer">
                        <!-- Data dari JS akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    {{-- <script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script> --}}
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#exportModal').on('show.bs.modal', function(event) {
            // You can add additional logic here if needed when the modal is about to be shown
        });

        $(document).on('click', '#exportBtn', function (e) {
    e.preventDefault();

    let filter = $('#supplierFilter').val(); // Ambil nilai filter jika ada

    // Tampilkan SweetAlert loading
    Swal.fire({
        title: 'Mengekspor Data...',
        html: `<img src="{{ asset('dist/img/Hourglass.gif') }}" width="50"><br>Mohon tunggu, sedang diproses...`,
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Buat form POST dinamis jika tidak ada form sebelumnya
    let form = $('#exportForm');
    form.append($('<input>', {
        type: 'hidden',
        name: 'supplierFilter',
        value: filter
    }));

    // Submit form
    form.submit();

    // Tutup loading setelah beberapa detik (estimasikan waktu untuk export)
    setTimeout(() => {
        Swal.close();
    }, 3000); // bisa sesuaikan waktu sesuai dengan ukuran data
});


        document.getElementById("searchInput").addEventListener("keyup", function() {
            let searchTerm = this.value.toLowerCase();
            let tableRows = document.querySelectorAll("#incomingTable tbody tr");

            tableRows.forEach(row => {
                let cells = row.getElementsByTagName("td");
                let rowContainsSearchTerm = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                        rowContainsSearchTerm = true;
                        break;
                    }
                }

                row.style.display = rowContainsSearchTerm ? "" : "none";
            });
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

        // Update date and time every second
        setInterval(updateDateTime, 1000);

        // Initial call to display date and time immediately on page load
        updateDateTime();


        function slideRight() {
            const carousel = document.querySelector('.carousel-content');
            carousel.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        }

        function showIncomingMaterials(values) {
            document.getElementById('material-section').scrollIntoView({
                behavior: 'smooth'
            });
            const models = values.split(',');
            $('#incomingTable tbody').empty();
            let counter = 1;
            models.forEach(function(model_id) {
                console.log("Processing model: " + model_id);
                $.ajax({
                    url: "{{ route('dashboardrmstok.detail') }}", // Route untuk mengambil data
                    method: 'GET',
                    data: {
                        model_id: model_id
                    }, // Kirim model sebagai parameter
                    success: function(response) {
                        let tableBody = '';

                        // Iterasi setiap item dari response
                        response.forEach(function(item) {
                            tableBody += `
                          <tr>
                            <td>${counter}</td> <!-- Kolom urutan -->
                            <td>${item.part_name || '-'}</td>
                            <td >${item.part_no || '-'}</td>
                            <td>${item.part_no2 || '-'}</td>
                           <td style="max-width: 150px; word-break: break-word; overflow-wrap: break-word; white-space: normal;">
                            ${item.job_no || '-'}
                            </td>
                            <td>${item.model_id || '-'}</td>
                            <td>${item.spek || '-'}</td>
                            <td>${item.spek_t || '-'}</td>
                            <td>${item.spek_w || '-'}</td>
                            <td>${item.spek_l || '-'}</td>
                            <td>${item.supplier || '-'}</td>
                            <td>${item.minimal || '-'}</td>
                            <td style="background-color:#48cf; color:#ffffff">${item.actual_sheet || '-'}</td>
                             <td style="background-color:#48cf; color:#ffffff">${item.no_rak || '-'} Kg</td>
                             <td><button class="btn btn-info btn-sm" onclick="showDetails('${item.part_no}')">Detail</button></td>
                          </tr>`;
                            counter++; // Increment urutan setiap kali item ditambahkan
                        });

                        // Tambahkan data ke dalam tabel
                        $('#incomingTable tbody').append(tableBody);
                    },
                    error: function(error) {
                        console.error('Error fetching data', error);
                    }
                });
            });

            // Setelah semua request selesai, tampilkan modal
            $('#incomingModal').modal('show');
        }

        // #48cf

        function showIncomingMaterials1(values) {
            document.getElementById('material-section').scrollIntoView({
                behavior: 'smooth'
            });
            const ids = values.split(',');
            $('#incomingTable tbody').empty();
            let counter = 1;
            ids.forEach(function(id) {
                console.log("Processing ID: " + id);
                $.ajax({
                    url: "{{ route('dashboardrmstok.detail2') }}",
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let tableBody = '';
                        response.forEach(function(item) {
                            tableBody += `
                      <tr>
                        <td>${counter}</td>
                        <td>${item.part_name || '-'}</td>
                        <td>${item.part_no || '-'}</td>
                        <td>${item.job_no || '-'}</td>
                        <td>${item.model_id || '-'}</td>
                        <td>${item.category_id || '-'}</td>
                        <td>${item.spek || '-'}</td>
                        <td>${item.spek_t || '-'}</td>
                        <td>${item.spek_w || '-'}</td>
                        <td>${item.spek_l || '-'}</td>
                        <td>${item.supplier || '-'}</td>
                        <td>${item.minimal || '-'}</td>
                        <td style="background-color:#48cf; color:#ffffff">${item.actual_sheet || '-'}</td>
                        <td style="background-color:#48cf; color:#ffffff">${item.actual_kg || '-'} Kg</td>
                        <td style="background-color:#708090; color:#ffffff">${item.no_rak || '-'}</td>
                      </tr>`;
                            counter++;
                        });
                        $('#incomingTable tbody').append(tableBody);
                    },
                    error: function(error) {
                        console.error('Error fetching data', error);
                    }
                });
            });

            $('#incomingModal').modal('show');
        }


        function showIncomingMaterials2(condition) {
            document.getElementById('material-section').scrollIntoView({
                behavior: 'smooth'
            });
            $('#incomingTable tbody').empty();

            if (condition === 'safe_data') {
                // Make an AJAX request to get data where `actual_sheet` > `minimal + 300`
                $.ajax({
                    url: "{{ route('dashboardrmstok.getSafeData') }}",
                    method: 'GET',
                    success: function(response) {
                        console.log(response); // Log the response to check its structure
                        let tableBody = '';
                        let counter = 1;
                        response.data.forEach(function(item) { // Access response.data
                            tableBody += `
                        <tr>
                          <td>${counter}</td>
                          <td>${item.part_name || '-'}</td>
                          <td>${item.part_no || '-'}</td>
                          <td>${item.part_no2 || '-'}</td>
                          <td>${item.job_no || '-'}</td>
                          <td>${item.model_id || '-'}</td>
                          <td>${item.spek || '-'}</td>
                          <td>${item.spek_t || '-'}</td>
                          <td>${item.spek_w || '-'}</td>
                          <td>${item.spek_l || '-'}</td>
                          <td>${item.supplier || '-'}</td>
                          <td>${item.minimal || '-'}</td>
                          <td style="background-color:#008080; color:#ffffff">${item.actual_sheet || '-'}</td>
                          <td style="background-color:#708090; color:#ffffff">${item.no_rak || '-'}</td>
                          <td><button class="btn btn-info btn-sm" onclick="showDetails('${item.part_no}')">Detail</button></td>
                        </tr>`;
                            counter++;
                        });
                        $('#incomingTable tbody').append(tableBody);
                        $('#incomingModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data', error);
                    }
                });
            } else {
                console.log("Unknown condition: " + condition);
            }
        }

      function showDetails(partNo) {
            $.ajax({
                url: "{{ route('dashboardrmstok.getPartDetails') }}",
                method: 'GET',
                data: {
                    part_no: partNo
                },
                success: function(response) {
                    console.log(response);

                    let countBox = `
                        <div class="row text-center mb-3">
                            <div class="col-md-4">
                                <div class="p-3 text-white rounded status-box active" data-status="Material READY" style="cursor:pointer; background-color:#146c43;">
                                    Material READY: <strong>${response.count_null}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 text-white rounded status-box" data-status="Material OUT" style="cursor:pointer; background-color:#b36a00;">
                                    Material OUT: <strong>${response.count_1}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 text-white rounded status-box" data-status="Material OUT Subcont" style="cursor:pointer; background-color:#00749c;">
                                    Material OUT Subcont: <strong>${response.count_2}</strong>
                                </div>
                            </div>
                        </div>`;


                    function renderTable(data, statusFilter) {
                        let filteredData = data.filter(item => item.status === statusFilter);

                        let html = `
                    <div class="table-responsive">
                        <table id="partDetailsTable" class="table table-bordered">
                            <thead style="background-color: #003366; color:white">
                                <tr class="text-center">
                                    <th>No</th>
                                      <th style="width:180px">Unique No</th>
                                    <th style="width:180px">Part No</th>
                                    <th>Supplier</th>
                                    <th>Spec</th>
                                    <th style="width:120px">Sheet In</th>
                                    <th>Kg In</th>
                                    <th style="width:150px">Tanggal In</th>
                                    <th style="width:120px">Scan In</th>
                                    <th style="width:150px">Tanggal Out</th>
                                    <th style="width:150px">Scan Out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        if (filteredData.length > 0) {
                            filteredData.forEach((item, index) => {
                                let statusClass = '';
                                if (item.status === 'Material READY') {
                                    statusClass = 'badge-success';
                                } else if (item.status === 'Material OUT') {
                                    statusClass = 'badge-warning';
                                } else if (item.status === 'Material OUT Subcont') {
                                    statusClass = 'badge-info';
                                } else {
                                    statusClass = 'badge-secondary';
                                }
                             html += `
                            <tr class="text-center">
                                <td>${index + 1}</td>
                                  <td>${item.uniqNo || '-'}</td>
                                <td>${item.part_no || '-'}</td>
                                <td>${item.supplier || '-'}</td>
                                <td>${item.spec || '-'}</td>
                                <td>${item.qty_in || '-'}</td>
                                <td>${item.qty_kg || '-'}</td>
                                <td style="background-color:#8affa7">${item.created_at || '-'}</td>
                                <td>${item.createdby || '-'}</td>
                                <td style="background-color:#f9ffa2">${item.time_out || '-'}</td>
                                <td>${item.out_user || '-'}</td>
                                <td><span class="badge ${statusClass}">${item.status}</span></td>
                                  <td class="text-center">
                                    <a href="#" id="btn_pdf" title="Generate" data-uniq="${item.uniqNo}" class="btn btn-info btn-sm">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                </td>

                            </tr>`;
                            });
                        } else {
                            html += `
                        <tr class="text-center">
                            <td colspan="13">No data found for "${statusFilter}".</td>
                        </tr>`;
                        }

                        html += `</tbody></table></div>`;
                        return html;
                    }

                    const initialStatus = 'Material READY';
                    let fullHTML = countBox + renderTable(response.data, initialStatus);

                    $('#detailModal .modal-body').html(fullHTML);

                    $('#partDetailsTable').DataTable({
                        searching: true,
                        pageLength: 5,
                        lengthChange: false,
                        autoWidth: true,
                        destroy: true,
                        columnDefs: [{
                            targets: '_all',
                            className: 'text-center'
                        }]
                    });

                    $('#detailModal').modal('show');

                    // Box click listener
                    $(document).off('click', '.status-box').on('click', '.status-box', function() {
                        $('.status-box').removeClass('active'); // Remove active from all
                        $(this).addClass('active'); // Highlight selected box

                        const selectedStatus = $(this).data('status');
                        const updatedHTML = countBox + renderTable(response.data, selectedStatus);
                        $('#detailModal .modal-body').html(updatedHTML);

                        $('#partDetailsTable').DataTable({
                            searching: true,
                            pageLength: 5,
                            lengthChange: false,
                            autoWidth: true,
                            destroy: true,
                            columnDefs: [{
                                targets: '_all',
                                className: 'text-center'
                            }]
                        });
                    });
                },
                error: function(error) {
                    console.error('Error fetching details', error);
                    $('#detailModal .modal-body').html(
                        `<div class="alert alert-danger">Failed to load data.</div>`);
                    $('#detailModal').modal('show');
                }
            });
        }

        $(document).on('click', '#btn_pdf', function(e) {
            e.preventDefault();

            // Ambil uniq_no dari tombol yang diklik
            var uniqNo = $(this).data('uniq');

            // Bangun URL untuk cetak PDF berdasarkan uniq_no
            var printUrl = "{{ route('dashboardrmstok.cetak', ':uniqNo') }}".replace(':uniqNo', uniqNo);

            // Coba buka di tab baru
            var newWindow = window.open(printUrl, '_blank');

            // Fallback
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                window.location.href = printUrl;
            }
        });


        function showIncomingMaterials3(condition, id) {
            document.getElementById('material-section').scrollIntoView({
                behavior: 'smooth'
            });
            $('#incomingTable tbody').empty();

            if (condition === 'critical_data') {
                // Make an AJAX request to get data where `actual_sheet` < `minimal`
                $.ajax({
                    url: "{{ route('dashboardrmstok.getCritcalData') }}", // Adjust route to fetch 'critical' data
                    method: 'GET',
                    data: {
                        id: id
                    }, // Kirim ID sebagai parameter
                    success: function(response) {
                        let tableBody = '';
                        let counter = 1;

                        response.forEach(function(item) {
                            tableBody += `
                        <tr>
                            <td>${counter}</td> <!-- Kolom urutan -->
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.part_no2 || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.model_id || '-'}</td>
                            <td>${item.spek || '-'}</td>
                            <td>${item.spek_t || '-'}</td>
                            <td>${item.spek_w || '-'}</td>
                            <td>${item.spek_l || '-'}</td>
                            <td>${item.supplier || '-'}</td>
                            <td>${item.minimal || '-'}</td>
                            <td style="background-color:#FF4500; color:#ffffff">${item.actual_sheet || '-'}</td>
                            <td style="background-color:#708090; color:#ffffff">${item.no_rak || '-'}</td>
                            <td><button class="btn btn-info btn-sm" onclick="showDetails('${item.part_no}')">Detail</button></td>
                        </tr>`;
                            counter++; // Increment urutan setiap kali item ditambahkan
                        });
                        // Add the data to the table body
                        $('#incomingTable tbody').append(tableBody);
                        $('#incomingModal').modal('show'); // Show modal with data
                    },
                    error: function(error) {
                        console.error('Error fetching data', error);
                    }
                });
            } else {
                console.log("Unknown condition: " + condition);
            }
        }

        function showIncomingMaterials4(condition, id) {
            document.getElementById('material-section').scrollIntoView({
                behavior: 'smooth'
            });
            $('#incomingTable tbody').empty();

            if (condition === 'data_ta') {
                $.ajax({
                    url: "{{ route('dashboardrmstok.getPartTa') }}",
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let tableBody = '';
                        let counter = 1;

                        response.forEach(function(item) {
                            tableBody += `
                        <tr>
                            <td>${counter}</td>
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.part_no2 || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.model_id || '-'}</td>
                            <td>${item.spek || '-'}</td>
                            <td>${item.spek_t || '-'}</td>
                            <td>${item.spek_w || '-'}</td>
                            <td>${item.spek_l || '-'}</td>
                            <td>${item.supplier || '-'}</td>
                            <td>${item.minimal || '-'}</td>
                            <td style="background-color:#D20103; color:#ffffff">${item.actual_sheet || '-'}</td>
                            <td style="background-color: #708090; color:#ffffff">${item.no_rak || '-'}</td>
                            <td>
                                <button class="btn btn-warning btn-lg px-2 py-1" onclick="showDetails2('${item.part_no}')">${item.doc_po_count}</button>
                            </td>
                        </tr>`;
                            counter++; // Increment urutan setiap kali item ditambahkan
                        });
                        // Add the data to the table body
                        $('#incomingTable tbody').append(tableBody);
                        $('#incomingModal').modal('show'); // Show modal with data
                    },
                    error: function(error) {
                        console.error('Error fetching data', error);
                    }
                });
            } else {
                console.log("Unknown condition: " + condition);
            }
        }


        function showIncomingMaterials5(condition, id) {
            document.getElementById('material-section').scrollIntoView({
                behavior: 'smooth'
            });
            $('#incomingTable tbody').empty();

            if (condition === 'run_out') {
                $.ajax({
                    url: "{{ route('dashboardrmstok.getRunOut') }}",
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        let tableBody = '';
                        let counter = 1;

                        response.forEach(function(item) {
                            tableBody += `
                        <tr>
                            <td>${counter}</td>
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.part_no2 || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.model_id || '-'}</td>
                            <td>${item.spek || '-'}</td>
                            <td>${item.spek_t || '-'}</td>
                            <td>${item.spek_w || '-'}</td>
                            <td>${item.spek_l || '-'}</td>
                            <td>${item.supplier || '-'}</td>
                            <td>${item.minimal || '-'}</td>
                            <td style="background-color:#D20103; color:#ffffff">${item.actual_sheet || '-'}</td>
                            <td style="background-color: #708090; color:#ffffff">${item.no_rak || '-'}</td>
                            <td></td>
                        </tr>`;
                            counter++;
                        });

                        $('#incomingTable tbody').append(tableBody);
                        $('#incomingModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data', error);
                    }
                });
            } else {
                console.log("Unknown condition: " + condition);
            }
        }



        function showDetails2(partNo) {
                       $.ajax({
                url: "{{ route('dashboardrmstok.getDocPo') }}",
                method: "GET",
                data: {
                    part_no: partNo
                },
                success: function(response) {
                    if (response.length > 0) {
                        let countNull = response.filter(item => item.status === null).length;
                        let countClose = response.filter(item => item.status === 'Close').length;

                        let allData = response;

                        // HTML awal dengan box count
                        let modalContent = `
                <div class="row text-center mb-3">
                   <div class="col-md-6">
    <div class="p-3 rounded text-white filter-status" data-filter="open" style="background-color: #2c7a9b; cursor:pointer; font-size: 1.3rem;">
        Status OPEN: <strong id="count-open">${countNull}</strong>
    </div>
</div>
<div class="col-md-6">
    <div class="p-3 rounded text-white filter-status" data-filter="close" style="background-color: #2d6a4f; cursor:pointer; font-size: 1.3rem;">
        Status CLOSE: <strong id="count-close">${countClose}</strong>
    </div>
</div>

                </div>
                <div class="table-responsive">
                    <table id="poTable" class="table table-bordered w-100"></table>
                </div>`;

                        // Tampilkan konten ke modal
                        $('#detailModal2 .modal-body').html(modalContent);
                        $('#detailModal2').modal('show');

                        // Render DataTable berdasarkan filter
                        function renderTable(filteredData) {
                            let tableBody = '';
                            filteredData.forEach(item => {
                                tableBody += `
                            <tr class="text-center">
                                <td>${item.part_no}</td>
                                <td>${item.doc_po || '-'}</td>
                                <td style="background-color: #edff00">${item.order_sheet || '-'}</td>
                                <td style="background-color: #8affae">${item.actual_sheet || '-'}</td>
                                <td>${item.balance_sheet || '-'}</td>
                                <td>${item.supplier || '-'}</td>
                                <td style="background-color: #457f57; color: #fff">${item.delivery || '-'}</td>
                                <td>${item.status || '-'}</td>
                            </tr>`;
                            });

                            const tableHTML = `
                        <thead style="background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff">
                            <tr class="text-center">
                                <th>Part No</th>
                                <th>Doc PO</th>
                                <th>Qty Order</th>
                                <th>Qty Datang</th>
                                <th>Balance</th>
                                <th>Supplier</th>
                                <th>Tanggal PO</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>${tableBody}</tbody>`;

                            // Ganti isi tabel
                            $('#poTable').html(tableHTML);

                            // Re-init DataTables
                            $('#poTable').DataTable({
                                destroy: true,
                                searching: true,
                                pageLength: 10,
                                lengthChange: false,
                                ordering: false
                            });
                        }

                        // Tampilkan awal (status null)
                        renderTable(allData.filter(item => item.status === null));

                        // Event interaktif
                        $(document).off('click', '.filter-status').on('click', '.filter-status', function() {
                            const filter = $(this).data('filter');
                            if (filter === 'open') {
                                renderTable(allData.filter(item => item.status === null));
                            } else if (filter === 'close') {
                                renderTable(allData.filter(item => item.status === 'Close'));
                            }
                        });


                    } else {
                        alert("Data tidak ditemukan untuk Part No: " + partNo);
                    }
                },
                error: function(error) {
                    console.error("Error fetching data", error);
                }
            });
        }




        function updateDnInputs() {
            fetch('{{ route('dnInputs.update') }}')
                .then(response => response.json())
                .then(data => {
                    let tbody = document.querySelector('.table-responsive.auto-scroll-container2 tbody');
                    tbody.innerHTML = ''; // Clear the table content before adding new data

                    data.forEach(item => {
                        let row = `
                    <tr>
                        <td>${item.part_no}</td>
                        <td>${item.spec}</td>
                        <td>${item.spec_t}</td>
                        <td style="color: #07ed77;">${item.actual}</td>
                        <td style="color: #07ed77;">${item.kg_sheet}</td>
                        <td>${item.supplier}</td>
                        <td>${item.update_time}</td>
                        <td>${item.createdby}</td>
                    </tr>
                `;
                        tbody.innerHTML += row; // Add the new row to the table
                    });
                })
                .catch(error => console.error('Error:', error));
        }


        function updateScanOutRms() {
            fetch('{{ route('scanOutRms.update2') }}')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Periksa struktur data yang diterima

                    let tbody = document.querySelector('.table-responsive.auto-scroll-container tbody');

                    // Cek apakah elemen tbody ditemukan
                    if (!tbody) {
                        console.error(
                            "Element <tbody> tidak ditemukan. Pastikan selector sudah benar dan elemen sudah tersedia di DOM."
                            );
                        return; // Hentikan eksekusi jika tbody tidak ditemukan
                    }

                    // Ambil semua uniqNo yang sudah ada di tabel
                    let existingUniqNos = Array.from(tbody.querySelectorAll('tr')).map(row => row.cells[0].innerText);

                    data.forEach(item => {
                        // Jika uniqNo sudah ada, tidak menambahkan baris baru
                        if (!existingUniqNos.includes(item.uniqNo)) {
                            let row = `
                        <tr>
                            <td>${item.uniqNo}</td>
                            <td>${item.part_no}</td>
                            <td>${item.spec}</td>
                            <td>${item.supplier}</td>
                            <td style="color: #fff700;">${item.qty_out_sheet} Sheet</td>
                            <td style="color: #fff700;">${item.qty_out_kg} Kg</td>
                            <td>${item.createdby}</td>
                            <td>${item.update_time}</td>
                        </tr>
                    `;
                            tbody.insertAdjacentHTML('beforeend', row);
                            existingUniqNos.push(item.uniqNo);
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function updateScanOutSubcont() {
            fetch('{{ route('scanOutSubcont.update3') }}')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Periksa struktur data yang diterima

                    let tbody = document.querySelector('.table-responsive.auto-scroll-container tbody');

                    // Cek apakah elemen tbody ditemukan
                    if (!tbody) {
                        console.error(
                            "Element <tbody> tidak ditemukan. Pastikan selector sudah benar dan elemen sudah tersedia di DOM."
                            );
                        return; // Hentikan eksekusi jika tbody tidak ditemukan
                    }

                    // Ambil semua uniqNo yang sudah ada di tabel
                    let existingUniqNos = Array.from(tbody.querySelectorAll('tr')).map(row => row.cells[0].innerText);

                    data.forEach(item => {
                        // Jika uniqNo sudah ada, tidak menambahkan baris baru
                        if (!existingUniqNos.includes(item.uniqNo)) {
                            let row = `
                        <tr>
                            <td>${item.uniqNo}</td>
                            <td>${item.part_no}</td>
                            <td>${item.spec}</td>
                            <td>${item.supplier}</td>
                            <td style="color: #fff700;">${item.qty_out_sheet} Sheet</td>
                            <td style="color: #fff700;">${item.qty_out_kg} Kg</td>
                            <td>${item.createdby}</td>
                            <td>${item.update_time}</td>
                        </tr>
                    `;
                            tbody.insertAdjacentHTML('beforeend', row);
                            existingUniqNos.push(item.uniqNo);
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }





        // Jalankan pembaruan setiap 5 detik (5000 ms)
        setInterval(updateDnInputs, 5000);
        setInterval(updateScanOutRms, 5000);
        setInterval(updateScanOutSubcont, 5000);
    </script>
@endpush


