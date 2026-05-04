@extends('layouts.app')

@section('content')
    <style>
        #incomingTable.table-hover tbody tr:hover {
            background: linear-gradient(to top, #818181a8 17%, #ffffff 99%);
            color: #000000;
            /* Warna teks saat hover (opsional) */
        }

        #insertedData:empty::before {
            content: none;
        }

        .dashboard-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .card {
        background: linear-gradient(145deg, #add7f5, #f3f4f6);
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        padding: 25px;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        font-size: 18px;
        font-weight: 600;
        color: #444;
        margin-bottom: 6px;
    }

    .card h3 {
        font-size: 26px;
        font-weight: 700;
        color: #111;
        margin-top: 0;
    }

    .card-icon {
        position: absolute;
        top: 18px;
        right: 22px;
        font-size: 48px;
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    /* === Tema Warna Netral dengan Aksen === */
    .bg-blue {
        border-left: 4px solid #3b82f6;
    }

    .bg-green {
        border-left: 4px solid #22c55e;
    }

    .bg-red {
        border-left: 4px solid #ef4444;
    }

    .bg-yellow {
        border-left: 4px solid #eab308;
    }

    /* === Warna Ikon Sesuai Status === */
    .bg-blue .card-icon i {
        color: #3b82f6;
    }

    .bg-green .card-icon i {
        color: #22c55e;
    }

    .bg-red .card-icon i {
        color: #ef4444;
    }

    .bg-yellow .card-icon i {
        color: #eab308;
    }

    /* === Hover efek ikon === */
    .card:hover .card-icon i {
        opacity: 0.8;
        transform: scale(1.15);
    }

    .card .inner {
        z-index: 2;
        position: relative;
    }

        /* === Container Styling === */
        .carousel-container {
            position: relative;
            background: linear-gradient(145deg, #add7f5, #f3f4f6);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .carousel-content {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 0;
        }

        .carousel-content::-webkit-scrollbar {
            height: 6px;
        }

        .carousel-content::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(240, 240, 240, 0.8);
            border: none;
            font-size: 24px;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-button:hover {
            background: #e0e0e0;
        }

        .carousel-button.left {
            left: 10px;
        }

        .carousel-button.right {
            right: 10px;
        }

        /* === Card Item === */
        .summary-item {
            background: #f7f7f7;
            border-radius: 12px;
            padding: 20px;
            min-width: 260px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
        }

        .summary-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .summary-item h5 {
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 15px;
        }

        .status-box {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .status-box-item {
            flex: 1;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .status-box-item:hover {
            transform: scale(1.05);
        }

        /* === Status Colors === */
        .safe {
            background: linear-gradient(135deg, #d7fbe8, #b2f7d2);
        }

        .critical {
            background: linear-gradient(135deg, #ffe0b2, #ffc371);
        }

        .ta {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }

        /* === Export Button === */
        .export-btn {
            background: #28a745;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 20px;
            transition: 0.3s;
        }

        .export-btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .table-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 15px;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        #incomingTable {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            color: #2c3e50;
        }

        #incomingTable thead {
            background: linear-gradient(to right, #004e92, #000428);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #incomingTable th,
        #incomingTable td {
            padding: 10px 12px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0;
        }

        #incomingTable tbody tr {
            background-color: #ffffff;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        #incomingTable tbody tr:nth-child(even) {
            background-color: #f8f9fb;
        }

        #incomingTable tbody tr:hover {
            background-color: #eef4fb;
            transform: scale(1.01);
            cursor: pointer;
        }

        /* Header shadow and soft border */
        .table-container thead th:first-child {
            border-top-left-radius: 12px;
        }

        .table-container thead th:last-child {
            border-top-right-radius: 12px;
        }

        /* Scrollbar customization for smooth UI */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #888;
        }

        #incomingTable thead th {
        font-size: 16px;          /* Ukuran huruf header */
        font-weight: bold;        /* Tebalkan huruf */
        text-transform: uppercase;/* Huruf besar semua (opsional) */
        background-color: #2b6cb0;/* Warna latar header */
        color: white;             /* Warna teks */
        text-align: center;       /* Tengah */
        border: 1px solid #ddd;   /* Tambah grid */
        padding: 10px;            /* Spasi antar teks */
    }

    #incomingTable td {
        font-size: 14px;          /* Ukuran huruf isi tabel */
        border: 1px solid #ddd;   /* Grid antar sel */
        text-align: center;
        vertical-align: middle;
        padding: 8px;
    }

    #incomingTable {
        border-collapse: collapse;
        width: 100%;
    }

    
    </style>

    <div class="container-fluid py-4 custom-dashboard">
        <!-- Top Header -->
        <div style= "background: linear-gradient(to top right, #1a2640 0%, #006699 44%); color: #ffffff "
            class="row mb-4 align-items-center">
            <div class="col-md-6" style="position: relative;">
                <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                    <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                </div>
                <h3 style="color: rgb(255, 255, 255); display: inline;">Tabel Stok Part OUTHOUSE</h3>
            </div>
            <div class="col-md-6 text-right">
                <div
                    style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: ; border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                    <strong>
                        <h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="clock" class="text-right"></h3>
                    </strong>
                </div>
            </div>
        </div>

        <div class="dashboard-container">
            <!-- TOTAL PART -->
            <div class="card bg-blue" id="total_part">
                <div class="card-icon"><i class="ph-fill ph-chart-donut"></i></div>
                <div class="inner">
                    @php
                        $row = DB::table('tabel_stok_sbcs')
                            ->where('home_line', 'OUTHOUSE')
                            ->select(DB::raw('count(id) as jml'))
                            ->first();
                    @endphp
                    <h2>TOTAL PART OUTHOUSE</h2>
                    <h3>{{ $row->jml }} Item</h3>
                </div>
            </div>
            

            <!-- SAFE PART -->
            <div class="card bg-green" id="safe_data">
                <div class="card-icon"><i class="ph-fill ph-shield-check"></i></div>
                <div class="inner">
                    @php
                        $row = DB::table('tabel_stok_sbcs')
                            ->where('home_line', 'OUTHOUSE')
                            ->where(function ($query) {
                                $query
                                    ->whereColumn('qty_act_ls', '>', 'qty_min')
                                    ->orWhereColumn('qty_act_ls', '=', 'qty_min');
                            })
                            ->count();
                    @endphp
                    <h2>TOTAL SAFE PART</h2>
                    <h3>{{ $row }} Item</h3>
                </div>
            </div>

            <!-- CRITICAL PART -->
            <div class="card bg-red">
                <div class="card-icon"><i class="ph-fill ph-warning"></i></div>
                <div class="inner">
                    @php
                        $row = DB::table('tabel_stok_sbcs')
                            ->where('home_line', 'OUTHOUSE')
                            ->where(function ($query) {
                                $query->whereColumn('qty_act_ls', '<', 'qty_min');
                            })
                            ->where('qty_act_ls', '!=', 0)
                            ->count();
                    @endphp
                    <h2>TOTAL CRITICAL PART</h2>
                    <h3>{{ $row }} Item</h3>
                </div>
            </div>

            <!-- TA PART -->
            <div class="card bg-yellow">
                <div class="card-icon"><i class="ph-duotone ph-warning"></i></div>
                <div class="inner">
                    @php
                        $row = DB::table('tabel_stok_sbcs')
                            ->where('home_line', 'OUTHOUSE')
                            ->where(function ($query) {
                                $query->whereNull('qty_act_ls')->orWhere('qty_act_ls', '=', 0);
                            })
                            ->count();
                    @endphp
                    <h2>TOTAL PART TA</h2>
                    <h3>{{ $row }} Item</h3>
                </div>
            </div>
        </div>

        <!-- Metrics Row -->
        <div class="row mb-4" id="material-section">
            <div class="carousel-container">
                <button class="carousel-button left" onclick="slideLeft()">‹</button>
                <div class="carousel-content">
                    <div class="col-ms-3">
                        <div class="summary-item">
                            <h5 style="font-weight: bold; color: rgb(0, 0, 0);">TCF-2</h5>
                            <div class="change">
                                <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                    <div id = "totalTcf2">
                                        <strong>
                                            <p id="totalTcf2" class="status-box-item openText status-text"
                                                style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%); padding: 10px; color: black; text-align: center;">
                                                TOTAL PART <br>
                                                @php
                                                    $row = DB::table('tabel_stok_sbcs')
                                                        ->where('supplier', 'TCF-2')
                                                        ->select(DB::raw('count(part_no) as jml'))
                                                        ->first();
                                                @endphp
                                                <span style="font-size: 20px; font-weight: bold;">{{ $row->jml }}</span>
                                            </p>
                                        </strong>
                                    </div>
                                    <strong>
                                        <p id="safeTcf2" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%); padding: 10px; color: black; text-align: center;">
                                            Total Safe <br>
                                            @php
                                                // Menghitung jumlah item yang memenuhi kondisi qty_act_ls >= qty_min
                                                $row = DB::table('tabel_stok_sbcs')
                                                    ->where('supplier', 'TCF-2')
                                                    ->whereColumn('qty_act_ls', '>=', 'qty_min')
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                        </p>
                                    </strong>

                                    <strong>
                                        <p id="criticalTcf2" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%); padding: 10px; color: black; text-align: center;">
                                            Total Critical <br>
                                            @php
                                                // Menghitung jumlah item dengan tabel_stok_sbcs < qty_min dan qty_min >= 0
                                                $row = DB::table('tabel_stok_sbcs')
                                                    ->where('supplier', 'TCF-2')
                                                    ->where('qty_min', '>=', 0) // Pastikan qty_min tidak negatif
                                                    ->whereColumn('qty_act_ls', '<', 'qty_min') // qty_act_ls lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                        </p>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">GEHO</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <div id = "totalGeho">
                                    <strong>
                                        <p id="totalGeho" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%); padding: 10px; color: black; text-align: center;">
                                            TOTAL PART <br>
                                            @php
                                                $row = DB::table('tabel_stok_sbcs')
                                                    ->where('supplier', 'GEHO')
                                                    ->select(DB::raw('count(part_no) as jml'))
                                                    ->first();
                                            @endphp
                                            <span style="font-size: 20px; font-weight: bold;">{{ $row->jml }}</span>
                                        </p>
                                    </strong>
                                </div>
                                <strong>
                                    <p id="safeGeho" class="status-box-item openText status-text"
                                        style="font-size: 13px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%); padding: 10px; color: black; text-align: center;">
                                        Total Safe <br>
                                        @php
                                            // Menghitung jumlah item yang memenuhi kondisi qty_act_ls >= qty_min
                                            $row = DB::table('tabel_stok_sbcs')
                                                ->where('supplier', 'GEHO')
                                                ->whereColumn('qty_act_ls', '>=', 'qty_min')
                                                ->count();
                                        @endphp
                                        <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                    </p>
                                </strong>

                                <strong>
                                    <p id="criticalGeho" class="status-box-item openText status-text"
                                        style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%); padding: 10px; color: black; text-align: center;">
                                        Total Critical <br>
                                        @php
                                            // Menghitung jumlah item dengan tabel_stok_sbcs < qty_min dan qty_min >= 0
                                            $row = DB::table('tabel_stok_sbcs')
                                                ->where('supplier', 'GEHO')
                                                ->where('qty_min', '>=', 0) // Pastikan qty_min tidak negatif
                                                ->whereColumn('qty_act_ls', '<', 'qty_min') // qty_act_ls lebih kecil dari qty_min
                                                ->count();
                                        @endphp
                                        <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                    </p>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SWT</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <div id = "totalSwt">
                                    <strong>
                                        <p id="totalSwt" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%); padding: 10px; color: black; text-align: center;">
                                            TOTAL PART <br>
                                            @php
                                                $row = DB::table('tabel_stok_sbcs')
                                                    ->where('supplier', 'SWT')
                                                    ->select(DB::raw('count(part_no) as jml'))
                                                    ->first();
                                            @endphp
                                            <span style="font-size: 20px; font-weight: bold;">{{ $row->jml }}</span>
                                        </p>
                                    </strong>
                                </div>
                                <strong>
                                    <p id="safeSwt" class="status-box-item openText status-text"
                                        style="font-size: 13px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%); padding: 10px; color: black; text-align: center;">
                                        Total Safe <br>
                                        @php
                                            // Menghitung jumlah item yang memenuhi kondisi qty_act_ls >= qty_min
                                            $row = DB::table('tabel_stok_sbcs')
                                                ->where('supplier', 'SWT')
                                                ->whereColumn('qty_act_ls', '>=', 'qty_min')
                                                ->count();
                                        @endphp
                                        <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                    </p>
                                </strong>

                                <strong>
                                    <p id="criticalSwt" class="status-box-item openText status-text"
                                        style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%); padding: 10px; color: black; text-align: center;">
                                        Total Critical <br>
                                        @php
                                            // Menghitung jumlah item dengan tabel_stok_sbcs < qty_min dan qty_min >= 0
                                            $row = DB::table('tabel_stok_sbcs')
                                                ->where('supplier', 'SWT')
                                                ->where('qty_min', '>=', 0) // Pastikan qty_min tidak negatif
                                                ->whereColumn('qty_act_ls', '<', 'qty_min') // qty_act_ls lebih kecil dari qty_min
                                                ->count();
                                        @endphp
                                        <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                    </p>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">CGSM</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <div id = "totalSwt">
                                    <strong>
                                        <p id="totalSwt" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%); padding: 10px; color: black; text-align: center;">
                                            TOTAL PART <br>
                                            @php
                                                $row = DB::table('tabel_stok_sbcs')
                                                    ->where('supplier', 'CGSM')
                                                    ->select(DB::raw('count(part_no) as jml'))
                                                    ->first();
                                            @endphp
                                            <span style="font-size: 20px; font-weight: bold;">{{ $row->jml }}</span>
                                        </p>
                                    </strong>
                                </div>
                                <strong>
                                    <p id="safeSwt" class="status-box-item openText status-text"
                                        style="font-size: 13px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%); padding: 10px; color: black; text-align: center;">
                                        Total Safe <br>
                                        @php
                                            // Menghitung jumlah item yang memenuhi kondisi qty_act_ls >= qty_min
                                            $row = DB::table('tabel_stok_sbcs')
                                                ->where('supplier', 'CGSM')
                                                ->whereColumn('qty_act_ls', '>=', 'qty_min')
                                                ->count();
                                        @endphp
                                        <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                    </p>
                                </strong>

                                <strong>
                                    <p id="criticalSwt" class="status-box-item openText status-text"
                                        style="font-size: 13px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%); padding: 10px; color: black; text-align: center;">
                                        Total Critical <br>
                                        @php
                                            // Menghitung jumlah item dengan tabel_stok_sbcs < qty_min dan qty_min >= 0
                                            $row = DB::table('tabel_stok_sbcs')
                                                ->where('supplier', 'CGSM')
                                                ->where('qty_min', '>=', 0) // Pastikan qty_min tidak negatif
                                                ->whereColumn('qty_act_ls', '<', 'qty_min') // qty_act_ls lebih kecil dari qty_min
                                                ->count();
                                        @endphp
                                        <span style="font-size: 20px; font-weight: bold;">{{ $row }}</span>
                                    </p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SUPPLIER</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">SAFE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">CRTICAL</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">TA</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SUPPLIER</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">SAFE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">CRTICAL</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">TA</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SUPPLIER</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">SAFE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">CRTICAL</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">TA</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SUPPLIER</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">SAFE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">CRTICAL</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">TA</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SUPPLIER</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">SAFE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">CRTICAL</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">TA</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <h5 style="font-weight: bold; color: rgb(0, 0, 0);">SUPPLIER</h5>
                        <div class="change">
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">SAFE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">CRTICAL</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">TA</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-button right" onclick="slideRight()">›</button>
            </div>
            <button type="button" class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 shadow-sm"
                style="border-radius: 8px; font-weight: 600; font-size: 16px;" data-toggle="modal"
                data-target="#exportModal">
                <i class="fas fa-file-excel"></i> Export ke Excel
            </button>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table id="incomingTable" class="table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 200px;">PART NAME</th>
                            <th style="width: 120px;">PART NO</th>
                            <th style="width: 80px;">JOB NO</th>
                            <th style="width: 120px;">MODEL</th>
                            <th style="width: 120px;">QTY MINIMAL</th>
                            <th style="width: 120px;">DESTINATION</th>
                            {{-- <th style="width: 100px;">Category</th> --}}
                            <th style="width: 120px;">QTY ACTUAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data tabel akan diisi di sini -->
                    </tbody>
                </table>
            </div>
        </div>



    </div>



    <!-- Export Filter Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff"
                    class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Stok Part OUTHOUSE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="exportForm" action="{{ route('exportLineStore2.export') }}" method="POST">
                        @csrf <!-- CSRF Token -->
                        <div class="form-group">
                            <label for="filterLine">Select Filter</label>
                            <select id="filterLine" name="filter" class="form-control">
                                <option value="">-Pilih-</option>
                                <option value="ALL">ALL</option>
                                <option value="critical">CRITICAL</option>
                                <option value="safe">SAFE</option>
                                <option value="ta">TA</option>
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
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        function updateClock() {
            const clockElement = document.getElementById("clock");
            const now = new Date();

            // Get time
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Get day of the week, month, and date
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];

            const dayName = days[now.getDay()];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();

            // Format: Day, Month Date, Year HH:MM:SS
            clockElement.innerText = `${dayName},  ${date} ${monthName} ${year}, ${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000); // Memperbarui jam setiap detik
        updateClock(); // Menampilkan jam langsung saat halaman dimua

        function formatDate(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }


        //  BARIS UNTUK CARD ATAS
        document.addEventListener("DOMContentLoaded", function() {
            let total_part = document.getElementById("total_part");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (total_part) {
                total_part.addEventListener("click", function() {
                    fetchTotalPart();
                });
            } else {
                console.error("Error: Element with ID 'total_part' not found!");
            }
         });

         function fetchTotalPart() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 20,
                    ajax: "{{ route('getTotalPart') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let safe_data = document.getElementById("safe_data");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (safe_data) {
                safe_data.addEventListener("click", function() {
                    fetchSafePart();
                });
            } else {
                console.error("Error: Element with ID 'safe_data' not found!");
            }
         });

         function fetchSafePart() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 20,
                    ajax: "{{ route('getSafePart') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let critical_data = document.getElementById("critical_data");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (critical_data) {
                critical_data.addEventListener("click", function() {
                    fetchCriticalPart();
                });
            } else {
                console.error("Error: Element with ID 'critical_data' not found!");
            }
        });

        function fetchCriticalPart() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 25,
                    ajax: "{{ route('getCrticalPart') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-"
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-"
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-"
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-"
                        },
                        {
                            data: "home_line",
                            name: "home_line",
                            defaultContent: "-"
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-"
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let data_ta = document.getElementById("data_ta");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (data_ta) {
                data_ta.addEventListener("click", function() {
                    fetchTaPart();
                });
            } else {
                console.error("Error: Element with ID 'data_ta' not found!");
            }
        });

        function fetchTaPart() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 25,
                    ajax: "{{ route('getTaPart') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-"
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-"
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-"
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-"
                        },
                        {
                            data: "home_line",
                            name: "home_line",
                            defaultContent: "-"
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-"
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        // CARD BAGIAN SUPPLIER TCF
        document.addEventListener("DOMContentLoaded", function() {
            let totalTcf2 = document.getElementById("totalTcf2");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (totalTcf2) {
                totalTcf2.addEventListener("click", function() {
                    fetchTcf2Data();
                });
            } else {
                console.error("Error: Element with ID 'totalTcf2' not found!");
            }
         });

         function fetchTcf2Data() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getTcf2Data') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let safeTcf2 = document.getElementById("safeTcf2");
            let tableContainer = $(".table-container"); // Ambil elemen tabel

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            // Pastikan elemen ditemukan sebelum menambahkan event listener
            if (safeTcf2) {
                safeTcf2.addEventListener("click", function() {
                    fetchTcf2Data2();
                });
            } else {
                console.error("Error: Element with ID 'safeTcf2' not found!");
            }
         });

         function fetchTcf2Data2() {
            let tableContainer = $(".table-container");

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Efek slow fade-out sebelum memuat data baru
            tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getTcf2Data2') }}", // Ambil data dari controller
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
, // Memindahkan kolom search ke kanan
                    initComplete: function() {
                        // Efek slow fade-in setelah data selesai dimuat
                        tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let criticalTcf2 = document.getElementById("criticalTcf2");
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            // Pastikan elemen ditemukan sebelum menambahkan event listener
            if (criticalTcf2) {
                criticalTcf2.addEventListener("click", function() {
                    fetchTcf2Data3();
                });
            } else {
                console.error("Error: Element with ID 'criticalTcf2' not found!");
            }
         });

         function fetchTcf2Data3() {
            let tableContainer = $(".table-container");

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Efek slow fade-out sebelum memuat data baru
            tableContainer.fadeOut(500, function() { // 500ms fade-out sebelum refresh

                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getTcf2Data3') }}", // Ambil data dari controller
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
, // Memindahkan kolom search ke kanan
                    initComplete: function() {
                        // Efek slow fade-in setelah data selesai dimuat
                        tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih halus
                    }
                });
            });
        }

         // CARD BAGIAN SUPPLIER GEHO
        document.addEventListener("DOMContentLoaded", function() {
            let totalGeho = document.getElementById("totalGeho");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (totalGeho) {
                totalGeho.addEventListener("click", function() {
                    fetchGehoData();
                });
            } else {
                console.error("Error: Element with ID 'totalGeho' not found!");
            }
          });

         function fetchGehoData() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getGehoData') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let safeGeho = document.getElementById("safeGeho");
            let tableContainer = $(".table-container"); // Ambil elemen tabel

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            // Pastikan elemen ditemukan sebelum menambahkan event listener
            if (safeGeho) {
                safeGeho.addEventListener("click", function() {
                    fetchGehoData2();
                });
            } else {
                console.error("Error: Element with ID 'safeGeho' not found!");
            }
         });

         function fetchGehoData2() {
            let tableContainer = $(".table-container");

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Efek slow fade-out sebelum memuat data baru
            tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getGehoData2') }}", // Ambil data dari controller
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
, // Memindahkan kolom search ke kanan
                    initComplete: function() {
                        // Efek slow fade-in setelah data selesai dimuat
                        tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let criticalGeho = document.getElementById("criticalGeho");
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            // Pastikan elemen ditemukan sebelum menambahkan event listener
            if (criticalGeho) {
                criticalGeho.addEventListener("click", function() {
                    fetchGehoData3();
                });
            } else {
                console.error("Error: Element with ID 'criticalGeho' not found!");
            }
         });

         function fetchGehoData3() {
            let tableContainer = $(".table-container");

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Efek slow fade-out sebelum memuat data baru
            tableContainer.fadeOut(500, function() { // 500ms fade-out sebelum refresh

                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getGehoData3') }}", // Ambil data dari controller
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
, // Memindahkan kolom search ke kanan
                    initComplete: function() {
                        // Efek slow fade-in setelah data selesai dimuat
                        tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih halus
                    }
                });
            });
        }

         // CARD BAGIAN SUPPLIER SWT
         document.addEventListener("DOMContentLoaded", function() {
            let totalSwt = document.getElementById("totalSwt");
            let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            if (totalSwt) {
                totalSwt.addEventListener("click", function() {
                    fetchSwtData();
                });
            } else {
                console.error("Error: Element with ID 'totalSwt' not found!");
            }
          });

         function fetchSwtData() {
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Sembunyikan tabel sebelum di-refresh
            tableContainer.fadeOut(200, function() {
                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getSwtData') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
,
                    initComplete: function() {
                        // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                        tableContainer.fadeIn(400);
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let safeSwt = document.getElementById("safeSwt");
            let tableContainer = $(".table-container"); // Ambil elemen tabel

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            // Pastikan elemen ditemukan sebelum menambahkan event listener
            if (safeSwt) {
                safeSwt.addEventListener("click", function() {
                    fetchSwtData2();
                });
            } else {
                console.error("Error: Element with ID 'safeSwt' not found!");
            }
         });

         function fetchSwtData2() {
            let tableContainer = $(".table-container");

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Efek slow fade-out sebelum memuat data baru
            tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getSwtData2') }}", // Ambil data dari controller
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
, // Memindahkan kolom search ke kanan
                    initComplete: function() {
                        // Efek slow fade-in setelah data selesai dimuat
                        tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let criticalSwt = document.getElementById("criticalSwt");
            let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

            // Sembunyikan tabel saat pertama kali dimuat
            tableContainer.hide();

            // Pastikan elemen ditemukan sebelum menambahkan event listener
            if (criticalSwt) {
                criticalSwt.addEventListener("click", function() {
                    fetchSwtData3();
                });
            } else {
                console.error("Error: Element with ID 'criticalSwt' not found!");
            }
         });

         function fetchSwtData3() {
            let tableContainer = $(".table-container");

            // Hapus DataTable lama jika sudah ada
            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            // Efek slow fade-out sebelum memuat data baru
            tableContainer.fadeOut(500, function() { // 500ms fade-out sebelum refresh

                // Inisialisasi ulang DataTable
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: "{{ route('getSwtData3') }}", // Ambil data dari controller
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex"
                        },
                        {
                            data: "part_name",
                            name: "part_name",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "part_no",
                            name: "part_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "job_no",
                            name: "job_no",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "model",
                            name: "model",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_min",
                            name: "qty_min",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "customer",
                            name: "customer",
                            defaultContent: "-",
                            createdCell: function(td) {
                                $(td).css({
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        },
                        {
                            data: "qty_act_ls",
                            name: "qty_act_ls",
                            defaultContent: "-",
                            createdCell: function(td, cellData) {
                                $(td).css({
                                    "background-color": "rgba(39, 191, 245, 0.43)",
                                    "font-size": "20px",
                                    "font-weight": "bold"
                                });
                            }
                        }
                    ],
                  dom: '<"top"f>rt<"bottom"lip><"clear">'
, // Memindahkan kolom search ke kanan
                    initComplete: function() {
                        // Efek slow fade-in setelah data selesai dimuat
                        tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih halus
                    }
                });
            });
        }
    </script>
@endpush
