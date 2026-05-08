@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-navy: #1a2640;
            --accent-blue: #006699;
            --safe-green: #28a745;
            --critical-red: #dc3545;
            --info-cyan: #00e1ff;
            --bg-light: #f0f7ff;
            /* Professional Smooth Blue */
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            --glass-bg: rgba(255, 255, 255, 0.85);
        }

        body {
            background: linear-gradient(135deg, #f0f7ff 0%, #e1e9f5 100%);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        .custom-dashboard {
            padding: 20px;
        }

        /* Header Styling */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--accent-blue) 100%);
            color: #ffffff;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo-container {
            background: #ffffff;
            padding: 8px 15px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }

        #clock {
            font-size: 18px;
            font-weight: 500;
            opacity: 0.9;
        }

        /* Summary Cards */
        .info-box {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 15px 20px;
            margin-bottom: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
            height: 100%;
            cursor: pointer;
        }

        .info-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--accent-blue);
        }

        .info-box.safe::before {
            background: var(--safe-green);
        }

        .info-box.critical::before {
            background: var(--critical-red);
        }

        .info-box.repair {
            background: #2d3436;
            color: #fff;
        }

        .info-box.repair::before {
            background: var(--info-cyan);
        }

        .info-box .icon-wrapper {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.2;
            font-size: 40px;
            transition: all 0.3s ease;
        }

        .info-box:hover .icon-wrapper {
            opacity: 0.5;
            transform: scale(1.1);
        }

        .info-box .label {
            font-size: 14px;
            font-weight: 600;
            color: #636e72;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        .info-box.repair .label {
            color: #b2bec3;
        }

        .info-box .value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-navy);
            margin: 0;
        }

        .info-box.repair .value {
            color: #fff;
        }

        .info-box .unit {
            font-size: 14px;
            font-weight: 500;
            color: #b2bec3;
        }

        /* Carousel & Model Cards */
        .carousel-container {
            position: relative;
            padding: 0 40px;
            margin-bottom: 30px;
        }

        .carousel-content {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px 5px;
        }

        .carousel-content::-webkit-scrollbar {
            display: none;
        }

        .summary-item {
            background: #ffffff;
            border-radius: 20px;
            padding: 15px;
            min-width: 280px;
            box-shadow: var(--card-shadow);
            border: 1px solid #f1f2f6;
        }

        .summary-item h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-navy);
            margin-bottom: 15px;
            text-align: center;
            border-bottom: 2px solid #f1f2f6;
            padding-bottom: 10px;
        }

        .status-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .status-pill {
            text-align: center;
            padding: 10px 5px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .status-pill:hover {
            filter: brightness(0.95);
        }

        .status-pill.total {
            background: rgba(93, 189, 255, 0.15);
            color: #0984e3;
        }

        .status-pill.safe {
            background: rgba(0, 184, 148, 0.15);
            color: #00b894;
        }

        .status-pill.critical {
            background: rgba(214, 48, 49, 0.15);
            color: #d63031;
        }

        .status-pill .pill-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .status-pill .pill-value {
            font-size: 18px;
            font-weight: 800;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: #fff;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: var(--primary-navy);
            font-size: 24px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .carousel-button:hover {
            background: var(--primary-navy);
            color: #fff;
        }

        .carousel-button.left {
            left: 0;
        }

        .carousel-button.right {
            right: 0;
        }

        /* Table Styling */
        .table-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 15px 20px;
            box-shadow: var(--card-shadow);
            margin-top: 20px;
        }

        #incomingTable {
            border: none;
            border-collapse: separate;
            border-spacing: 0 6px;
        }

        #incomingTable thead th {
            background: var(--primary-navy);
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        #incomingTable thead th:first-child {
            border-radius: 12px 0 0 12px;
        }

        #incomingTable thead th:last-child {
            border-radius: 0 12px 12px 0;
        }

        #incomingTable tbody tr {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        #incomingTable tbody tr:hover {
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background-color: #f8f9fa !important;
        }

        #incomingTable td {
            vertical-align: middle;
            border: none;
            padding: 8px 15px;
            color: #2d3436;
            font-weight: 500;
            font-size: 13px;
        }

        .btn-detail {
            background: var(--accent-blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 4px 12px;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-detail:hover {
            background: var(--primary-navy);
            transform: translateY(-2px);
        }

        /* DataTables overrides */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 10px;
            border: 1px solid #dfe6e9;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 8px;
            border: 1px solid #dfe6e9;
            padding: 5px 10px;
        }

        /* Modal Modernization */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--accent-blue) 100%);
            color: #fff;
            padding: 15px 25px;
            border: none;
        }

        .modal-title {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .modal-body {
            background-color: #f8fbff;
        }

        .modal-table-header {
            background: #f1f4f9;
            color: var(--primary-navy);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
        }

        .modal-table td {
            font-size: 12px;
            padding: 10px 8px;
            vertical-align: middle;
        }

        .badge-qty {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.2);
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .badge-ng {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .badge-repair {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.2);
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
        }

        /* Ensure DataTable controls are visible in modal */
        #detailModalTable_wrapper .dataTables_length,
        #detailModalTable_wrapper .dataTables_filter,
        #detailModalTable_wrapper .dataTables_info,
        #detailModalTable_wrapper .dataTables_paginate {
            padding: 10px;
            font-size: 12px;
        }

        #detailModalTable_wrapper .pagination {
            margin: 0;
            justify-content: flex-end;
        }
    </style>

    <div class="container-fluid py-4 custom-dashboard">
        <!-- Top Header -->
        <header class="dashboard-header">
            <div class="d-flex align-items-center">
                <div class="header-logo-container">
                    <img src="dist/img/adw3.png" alt="Logo" style="height: 45px; width: auto;">
                </div>
                <h3 class="header-title">Incoming Part Dashboard</h3>
            </div>
            <div id="clock"></div>
        </header>


        <div class="container-fluid">
            <div class="row">
                <!-- Total Part Card -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div id="total_part" class="info-box">
                        <div class="icon-wrapper">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="inner">
                            @php
                                $row = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->select(DB::raw('count(id) as jml'))
                                    ->first();
                            @endphp
                            <span class="label">Total Part Inhouse</span>
                            <h3 class="value">{{ $row->jml }} <span class="unit">Items</span></h3>
                        </div>
                    </div>
                </div>

                <!-- Safe Part Card -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div id="safe_data" class="info-box safe">
                        <div class="icon-wrapper">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="inner">
                            @php
                                $row = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->where(function ($query) {
                                        $query->whereColumn('qty_actual', '>', 'qty_min')
                                            ->orWhereColumn('qty_actual', '=', 'qty_min');
                                    })
                                    ->count();
                            @endphp
                            <span class="label">Safe Inhouse</span>
                            <h3 class="value">{{ $row }} <span class="unit">Items</span></h3>
                        </div>
                    </div>
                </div>

                <!-- Critical Part Card -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div id="critical_data" class="info-box critical">
                        <div class="icon-wrapper">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="inner">
                            @php
                                $row = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->whereColumn('qty_actual', '<', 'qty_min')
                                    ->where('qty_actual', '!=', 0)
                                    ->count();
                            @endphp
                            <span class="label">Critical Inhouse</span>
                            <h3 class="value">{{ $row }} <span class="unit">Items</span></h3>
                        </div>
                    </div>
                </div>

                <!-- TA Part Card -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div id="data_ta" class="info-box critical">
                        <div class="icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="inner">
                            @php
                                $row = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->where(function ($query) {
                                        $query->whereNull('qty_actual')
                                            ->orWhere('qty_actual', '=', 0);
                                    })
                                    ->count();
                            @endphp
                            <span class="label">TA Inhouse (Zero)</span>
                            <h3 class="value">{{ $row }} <span class="unit">Items</span></h3>
                        </div>
                    </div>
                </div>

                <!-- Repair Card -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div id="data_repair" class="info-box repair">
                        <div class="icon-wrapper">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="inner">
                            @php
                                $status = DB::table('scan_out_stmps')->value('status');
                                $row = 0;
                                if ($status == 1) {
                                    $row = DB::table('scan_out_stmps')
                                        ->where('status', '!=', 1)
                                        ->where('status_2', 2)
                                        ->count();
                                }
                            @endphp
                            <span class="label">Total Repair</span>
                            <h3 class="value">{{ $row }} <span class="unit">Items</span></h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Metrics Row (Model Summary Carousel) -->
        <div class="carousel-container" id="material-section">
            <button class="carousel-button left" onclick="slideLeft()"><i class="fas fa-chevron-left"></i></button>
            <div class="carousel-content">
                @php
                    $modelGroups = [
                        ['label' => 'Model D12 & D14', 'models' => ['D14N', 'D14N/D12L'], 'id_prefix' => 'D12'],
                        ['label' => 'Model D26A//D55L/D03B/D74A', 'models' => ['D26A', 'D26A/D55L/D03B', 'D55L/D26A/D74A'], 'id_prefix' => 'D26'],
                        ['label' => 'Model D40/D40L/D40G/D72', 'models' => ['D40G', 'D40L', 'D40G/DCWA', 'D40G/D40L/D72A', 'D40G/D40L'], 'id_prefix' => 'D40'],
                        ['label' => 'Model D30', 'models' => ['D30D', 'D30'], 'id_prefix' => 'D30'],
                        ['label' => 'Model D03', 'models' => ['D03B UNB', 'D03B UPB', 'D55L/D26A/D74A/D03B UPB', 'D26A/D55L/D03B'], 'id_prefix' => 'D03'],
                        ['label' => 'Model KS', 'models' => ['KS'], 'id_prefix' => 'KS']
                    ];
                @endphp

                @foreach($modelGroups as $group)
                    <div class="summary-item">
                        <h3>{{ $group['label'] }}</h3>
                        <div class="status-box">
                            @php
                                $total = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->whereIn('model', $group['models'])
                                    ->count();

                                $safe = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->whereIn('model', $group['models'])
                                    ->whereColumn('qty_actual', '>=', 'qty_min')
                                    ->count();

                                $critical = DB::table('line_store_stoks')
                                    ->where('home_line', 'INHOUSE')
                                    ->whereIn('model', $group['models'])
                                    ->whereColumn('qty_actual', '<', 'qty_min')
                                    ->count();
                            @endphp
                            <div class="status-pill total" id="total{{ $group['id_prefix'] }}">
                                <span class="pill-label">Total</span>
                                <span class="pill-value">{{ $total }}</span>
                            </div>
                            <div class="status-pill safe" id="safe{{ $group['id_prefix'] }}">
                                <span class="pill-label">Safe</span>
                                <span class="pill-value">{{ $safe }}</span>
                            </div>
                            <div class="status-pill critical" id="critical{{ $group['id_prefix'] }}">
                                <span class="pill-label">Critical</span>
                                <span class="pill-value">{{ $critical }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-button right" onclick="slideRight()"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- Export Button -->
        <div class="d-flex justify-content-start mb-4">
            <button type="button" class="btn btn-success btn-lg shadow-sm" style="border-radius: 12px; font-weight: 600;"
                data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-file-excel mr-2"></i> Export ke Excel
            </button>
        </div>


        <div class="table-container table-striped">
            <div style="background-color: #f2f3f5d7; color:black" class="table-responsive">
                <table id="incomingTable" class="table table-hover table-bordered" style="table-layout: fixed;">
                    <thead style="background: linear-gradient(to top right, #1a2640 0%, #006699 44%); color: #ffffff">
                        <tr>
                            <th style="width: 10px; text-align:center">NO</th>
                            <th style="width: 50px; text-align:center">Supplier</th>
                            <th style="width: 50px; text-align:center">Job No</th>
                            {{-- <th style="width: 50px; text-align:center">Part No(G5)</th> --}}
                            <th style="width: 50px; text-align:center">Part No</th>
                            <th style="width: 100px; text-align:center">Part Name</th>
                            <th style="width: 100px; text-align:center">Model</th>
                            <th style="width: 50px; text-align:center">Category</th>
                            <th style="width: 50px; text-align:center">Qty Minimal</th>
                            <th style="width: 50px; text-align:center">Qty Actual</th>
                            <th style="width: 50px; text-align:center">Detail</th>
                        </tr>
                    </thead>

                    <tbody style="text-align: center">
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
                    <h5 class="modal-title" id="exportModalLabel">Export Data Stok Part INHOUSE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="exportForm" action="{{ route('exportLineStore.export') }}" method="POST">
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


    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Data Scan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table id="detailModalTable" class="table table-hover table-bordered align-middle mb-0 modal-table">
                            <thead class="modal-table-header">
                                <tr>
                                    <th>#</th>
                                    <th>Uniq No</th>
                                    <th>Job No</th>
                                    <th>Part No</th>
                                    <th>Model</th>
                                    <th>Qty</th>
                                    <th>NG Stmp</th>
                                    <th>NG Rep</th>
                                    <th>Date</th>
                                    <th>Material</th>
                                    <th>User</th>
                                    <th>Scan Time</th>
                                    <th>Status</th>
                                    <th>In LS</th>
                                    <th>Process</th>
                                    <th>Out</th>
                                    <th>Track</th>
                                </tr>
                            </thead>
                            <tbody id="detailModalBody" class="text-center">
                                <!-- Content loaded via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <!-- Detail Out Modal -->
    <div class="modal fade" id="detailOutModal" tabindex="-1" aria-labelledby="detailOutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailOutModalLabel">Detail Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="detailOutModalTable" class="table table-striped table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Uniq No</th>
                                    <th>Job No</th>
                                    <th>Part No</th>
                                    <th>Model</th>
                                    <th>Qty</th>
                                    <th>Additional Qty</th>
                                    <th>Time Out</th>
                                </tr>
                            </thead>
                            <tbody id="detailOutModalBody">
                                <tr>
                                    <td colspan="8" class="text-center">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom, #006600 0%, #00cc99 100%); color:#ffffff;">
                    <h5 class="modal-title" id="trackModalLabel">Tracking Planner</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="trackModalTable" class="table table-bordered table-sm align-middle">
                            <thead class="bg-light text-center">
                                <tr class="table-bordered">
                                    <th class="border">No</th>
                                    <th class="border">Tanggal</th>
                                    <th class="border">Part No</th>
                                    <th class="border">Model</th>
                                    <th class="border">Mesin</th>
                                    <th class="border">Qty Plan</th>
                                    <th class="border">Spek</th>
                                    <th class="border">Dibuat</th>
                                    <th class="border">Jam</th>
                                </tr>
                            </thead>
                            <tbody id="trackModalBody">
                                <tr>
                                    <td colspan="9" class="text-center">No tracking data available.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
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

    <script>
        // Real-time Clock
        function updateClock() {
            const clockElement = document.getElementById("clock");
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const dayName = days[now.getDay()];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();
            const time = now.toLocaleTimeString('id-ID');

            clockElement.innerText = `${dayName}, ${date} ${monthName} ${year} | ${time}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Carousel Logic
        function slideLeft() {
            document.querySelector('.carousel-content').scrollBy({ left: -300, behavior: 'smooth' });
        }
        function slideRight() {
            document.querySelector('.carousel-content').scrollBy({ left: 300, behavior: 'smooth' });
        }

        // Reusable DataTable Loader
        function loadTable(url, highlightColor = 'rgba(0, 102, 153, 0.1)') {
            const tableContainer = $(".table-container");

            if ($.fn.DataTable.isDataTable("#incomingTable")) {
                $("#incomingTable").DataTable().destroy();
            }

            tableContainer.fadeOut(300, function () {
                $("#incomingTable").DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: true,
                    pageLength: 10,
                    ajax: url,
                    columns: [
                        { data: "DT_RowIndex", name: "DT_RowIndex", className: "text-center", width: "40px" },
                        { data: "customer", name: "customer", defaultContent: "-", className: "text-center" },
                        { data: "job_no", name: "job_no", defaultContent: "-", className: "text-center" },
                        { data: "part_no2", name: "part_no2", defaultContent: "-", className: "text-center font-weight-bold" },
                        { data: "part_name", name: "part_name", defaultContent: "-" },
                        { data: "model", name: "model", defaultContent: "-", className: "text-center" },
                        { data: "home_line", name: "home_line", defaultContent: "-", className: "text-center" },
                        { data: "qty_min", name: "qty_min", defaultContent: "-", className: "text-center" },
                        {
                            data: "qty_actual",
                            name: "qty_actual",
                            defaultContent: "-",
                            className: "text-center",
                            createdCell: function (td) {
                                $(td).css("background-color", highlightColor);
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: "text-center",
                            render: function (data, type, row) {
                                return `<button class="btn-detail detail-btn" data-part="${row.part_no2}" data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                    ],
                    dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                    initComplete: function () {
                        tableContainer.fadeIn(400);
                        if (tableContainer.offset()) {
                            $('html, body').animate({
                                scrollTop: tableContainer.offset().top - 100
                            }, 500);
                        }
                    }
                });
            });
        }

        // Event Listeners for Summary Cards
        $(document).ready(function () {
            $('#total_part').click(() => loadTable("{{ route('getTotalPartInhouse') }}", 'rgba(0, 168, 255, 0.2)'));
            $('#safe_data').click(() => loadTable("{{ route('getSafePartInhouse') }}", 'rgba(0, 184, 148, 0.2)'));
            $('#critical_data').click(() => loadTable("{{ route('getCrticalPartInhouse') }}", 'rgba(214, 48, 49, 0.2)'));
            $('#data_ta').click(() => loadTable("{{ route('getTaPartInhouse') }}", 'rgba(214, 48, 49, 0.2)'));
            $('#data_repair').click(() => loadTable("{{ route('getTotalPartInhouse') }}", 'rgba(0, 225, 255, 0.2)'));

            // Event Listeners for Model Summary Pills
            const modelRoutes = {
                'D12': { total: "{{ route('getModelD12') }}", safe: "{{ route('get2ModelD12') }}", critical: "{{ route('get3ModelD12') }}" },
                'D26': { total: "{{ route('getModelD26') }}", safe: "{{ route('get2ModelD26') }}", critical: "{{ route('get3ModelD26') }}" },
                'D40': { total: "{{ route('getModelD40') }}", safe: "{{ route('get2ModelD40') }}", critical: "{{ route('get3ModelD40') }}" },
                'D30': { total: "{{ route('getModelD30') }}", safe: "{{ route('get2ModelD30') }}", critical: "{{ route('get3ModelD30') }}" },
                'D03': { total: "{{ route('getModelD03') }}", safe: "{{ route('get2ModelD03') }}", critical: "{{ route('get3ModelD03') }}" },
                'KS': { total: "{{ route('getModelKS') }}", safe: "{{ route('get2ModelKS') }}", critical: "{{ route('get3ModelKS') }}" }
            };

            Object.keys(modelRoutes).forEach(key => {
                $(`#total${key}`).click(() => loadTable(modelRoutes[key].total, 'rgba(0, 168, 255, 0.15)'));
                $(`#safe${key}`).click(() => loadTable(modelRoutes[key].safe, 'rgba(0, 184, 148, 0.15)'));
                $(`#critical${key}`).click(() => loadTable(modelRoutes[key].critical, 'rgba(214, 48, 49, 0.15)'));
            });

            // Initial load
            loadTable("{{ route('getTotalPartInhouse') }}");
        });

        // Detail Modal Logic
        $(document).on('click', '.detail-btn', function () {
            const partNo2 = $(this).data('part');
            const jobNo = $(this).data('job');

            $('#detailModalLabel').text(`Detail for ${partNo2} - ${jobNo}`);
            $('#detailModalBody').html('<tr><td colspan="17" class="text-center">Loading data...</td></tr>');

            $.ajax({
                url: '{{ route('getScanOutStmps') }}',
                method: 'GET',
                data: { part_no2: partNo2 },
                success: function (response) {

                    // Destroy dulu kalau sudah ada DataTable
                    if ($.fn.DataTable.isDataTable('#detailModalTable')) {
                        $('#detailModalTable').DataTable().clear().destroy();
                    }

                    if (response.data.length > 0) {

                        let detailHtml = '';
                        response.data.forEach((item, index) => {
                            detailHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.uniqNo}</td>
                                    <td>${item.job_no}</td>
                                    <td>${item.part_no2}</td>
                                    <td>${item.model}</td>
                                    <td><span class="badge-qty">${item.qty_act}</span></td>
                                    <td><span class="badge-ng">${item.qty_ng}</span></td>
                                    <td><span class="badge-repair">${item.ng_repair || '0'}</span></td>
                                    <td>${item.date_plan}</td>
                                    <td>${item.kode_material}</td>
                                    <td>${item.createdby || '-'}</td>
                                    <td>${item.date_scan || '-'}</td>
                                    <td>${getStatusBadge(item.status)}</td>
                                    <td>${item.scan_in_ls || '-'}</td>
                                    <td>${getStatus2Badge(item.status_2)}</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-info detail-row-btn"
                                            data-part="${item.part_no2}" data-uniq="${item.uniqNo}">
                                            Out
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-success detail-row-btn2"
                                            data-part="${item.part_no2}" data-dateplan="${item.date_plan}">
                                            Track
                                        </button>
                                    </td>
                                </tr>`;
                        });

                        $('#detailModalBody').html(detailHtml);

                        // Init ulang DataTable
                        $('#detailModalTable').DataTable({
                            paging: true,
                            pageLength: 10,
                            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                            pagingType: "simple_numbers", // ada Prev Next + angka
                            searching: true,
                            ordering: true,
                            info: true,
                            autoWidth: false,
                            responsive: true,

                            // Sort by date_plan DESC (column index 8)
                            order: [[8, "desc"]],

                            dom: '<"row px-3 py-2"<"col-sm-6"l><"col-sm-6"f>>' +
                                '<"row"<"col-sm-12"tr>>' +
                                '<"row px-3 py-2"<"col-sm-5"i><"col-sm-7"p>>',

                            language: {
                                search: "Cari:",
                                lengthMenu: "Show _MENU_",
                                info: "Showing _START_ to _END_ of _TOTAL_",
                                paginate: {
                                    next: "Next",
                                    previous: "Prev"
                                }
                            },
                            "drawCallback": function (settings) {
                                var api = this.api();
                                var rows = api.rows({ page: 'current' }).nodes();
                                var last = null;

                                api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                                    cell.innerHTML = i + 1;
                                });
                            }
                        });

                    } else {
                        $('#detailModalBody').html('<tr><td colspan="17" class="text-center">No data found.</td></tr>');
                    }
                }
            });

            $('#detailModal').modal('show');
        });
        function getStatusBadge(status) {
            if (status === 3) return '<span class="text-success font-weight-bold">Received</span>';
            if (status === 2) return '<span class="text-danger font-weight-bold">Repair</span>';
            if (status === 1) return '<span class="text-primary font-weight-bold">Transit</span>';
            return '<span>-</span>';
        }

        function getStatus2Badge(status2) {
            if (status2 === 2) return '<span class="text-danger font-weight-bold">Repair</span>';
            if (status2 === 1) return '<span class="text-success font-weight-bold">Stamping</span>';
            return `<span>${status2 || '-'}</span>`;
        }

        // Row Detail Out Modal
        $(document).on('click', '.detail-row-btn', function () {
            const partNo = $(this).data('part');
            const uniqNo = $(this).data('uniq');
            $('#detailOutModalLabel').text(`Detail Out: ${partNo}`);
            $('#detailOutModalBody').html('<tr><td colspan="8">Loading...</td></tr>');

            $.ajax({
                url: '{{ route('getScanPartBps') }}',
                method: 'GET',
                data: { part_no2: partNo, uniqNo: uniqNo },
                success: function (response) {
                    if (response.data.length > 0) {
                        let html = '';
                        response.data.forEach((item, index) => {
                            html += `<tr><td>${index + 1}</td><td>${item.uniqNo}</td><td>${item.job_no}</td><td>${item.part_no2}</td><td>${item.model}</td><td>${item.qty}</td><td><span class="badge badge-danger">${item.additional_qty}</span></td><td>${item.date_scan}</td></tr>`;
                        });

                        if ($.fn.DataTable.isDataTable('#detailOutModalTable')) {
                            $('#detailOutModalTable').DataTable().destroy();
                        }
                        $('#detailOutModalBody').html(html);
                        $('#detailOutModalTable').DataTable({
                            "paging": true,
                            "pageLength": 5,
                            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                            "searching": false,
                            "info": true,
                            "order": [],
                            "dom": 'rtip',
                            "drawCallback": function (settings) {
                                var api = this.api();
                                api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                                    cell.innerHTML = i + 1;
                                });
                            }
                        });
                    } else {
                        if ($.fn.DataTable.isDataTable('#detailOutModalTable')) {
                            $('#detailOutModalTable').DataTable().destroy();
                        }
                        $('#detailOutModalBody').html('<tr><td colspan="8">No data found.</td></tr>');
                    }
                }
            });
            $('#detailOutModal').modal('show');
        });

        // Track Modal Logic
        $(document).on('click', '.detail-row-btn2', function () {
            const partNo = $(this).data('part');
            const datePlan = $(this).data('dateplan');
            $('#trackModalLabel').text(`Tracking: ${partNo} (${datePlan})`);
            $('#trackModalBody').html('<tr><td colspan="9">Loading...</td></tr>');

            $.ajax({
                url: '{{ route('getPlanningLineB3') }}',
                method: 'GET',
                data: { part_no2: partNo, date_plan: datePlan },
                success: function (response) {
                    if (response.data.length > 0) {
                        let html = '';
                        response.data.forEach((item, index) => {
                            html += `<tr><td>${index + 1}</td><td>${item.date_plan || '-'}</td><td>${item.part_no2 || '-'}</td><td>${item.model_id || '-'}</td><td>${item.mesin || '-'}</td><td>${item.qty_plan || '-'}</td><td>${item.rm_spek || '-'}</td><td>${item.createdby || '-'}</td><td>${item.created_at || '-'}</td></tr>`;
                        });

                        if ($.fn.DataTable.isDataTable('#trackModalTable')) {
                            $('#trackModalTable').DataTable().destroy();
                        }
                        $('#trackModalBody').html(html);
                        $('#trackModalTable').DataTable({
                            "paging": true,
                            "pageLength": 5,
                            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
                            "searching": false,
                            "info": true,
                            "order": [],
                            "dom": 'rtip',
                            "drawCallback": function (settings) {
                                var api = this.api();
                                api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                                    cell.innerHTML = i + 1;
                                });
                            }
                        });
                    } else {
                        if ($.fn.DataTable.isDataTable('#trackModalTable')) {
                            $('#trackModalTable').DataTable().destroy();
                        }
                        $('#trackModalBody').html('<tr><td colspan="9">No tracking data found.</td></tr>');
                    }
                }
            });
            $('#trackModal').modal('show');
        });
    </script>
@endpush