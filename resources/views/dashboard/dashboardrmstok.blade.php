@extends('layouts.app')

@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Orbitron:wght@600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --deep-navy: #0f172a;
            /* Slate 900 */
            --indigo-accent: #312e81;
            /* Indigo 900 */
            --glass-bg: rgba(255, 255, 255, 0.7);
            --accent-cyan: #0ea5e9;
            --emerald-good: #10b981;
            --amber-warn: #f59e0b;
            --crimson-bad: #ef4444;
            --bg-main: #f8fafc;
            --card-white: #ffffff;
            --border-soft: rgba(226, 232, 240, 0.8);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --shadow-premium: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-dashboard {
            background-color: var(--bg-main);
            background-image:
                radial-gradient(at 0% 0%, rgba(14, 165, 233, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(49, 46, 129, 0.05) 0px, transparent 50%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding-bottom: 4rem;
        }

        /* Premium Header */
        .dashboard-header {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: white;
            padding: 0.875rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .logo-container {
            background: white;
            padding: 8px 16px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .logo-container img {
            height: 36px;
            width: auto;
        }

        .dashboard-title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .digital-clock {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #4ade80;
            letter-spacing: 0.05em;
            text-align: right;
            line-height: 1.2;
        }

        /* Stat Cards Refined */
        .info-box {
            background: var(--card-white) !important;
            border: 1px solid var(--border-soft) !important;
            border-radius: 20px !important;
            padding: 1.75rem !important;
            transition: var(--transition-smooth) !important;
            color: var(--text-main) !important;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-premium) !important;
            cursor: pointer;
        }

        .info-box:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
            border-color: var(--accent-cyan) !important;
        }

        .info-label {
            color: var(--text-muted);
            font-size: 0.7rem !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem !important;
        }

        .info-value {
            font-size: 2.25rem !important;
            font-weight: 900 !important;
            color: var(--deep-navy) !important;
            margin: 0 !important;
            font-family: 'Orbitron', sans-serif;
            line-height: 1;
        }

        .info-icon {
            position: absolute;
            right: 0.5rem;
            bottom: 0.5rem;
            font-size: 4.5rem !important;
            opacity: 0.08;
            color: var(--text-muted) !important;
            transition: var(--transition-smooth);
        }

        .info-box:hover .info-icon {
            transform: scale(1.2) rotate(-8deg);
            opacity: 0.15;
            color: var(--accent-cyan) !important;
        }

        /* Status Colors for Info Boxes */
        .info-box[onclick*="showIncomingMaterials2"] .info-value {
            color: var(--emerald-good) !important;
        }

        .info-box[onclick*="showIncomingMaterials3"] .info-value {
            color: var(--amber-warn) !important;
        }

        .info-box[onclick*="showIncomingMaterials4"] .info-value {
            color: var(--crimson-bad) !important;
        }

        .info-box[onclick*="showIncomingMaterials5"] .info-value {
            color: var(--text-muted) !important;
        }

        /* Model Cards Tech Style */
        .model-card {
            background: var(--card-white) !important;
            border: 1px solid var(--border-soft) !important;
            border-radius: 16px !important;
            padding: 1.25rem !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
            min-width: 280px;
            position: relative;
            overflow: hidden;
            transition: var(--transition-smooth) !important;
        }

        .model-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-premium) !important;
            border-color: var(--accent-cyan) !important;
        }

        .status-indicator {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        .carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            padding: 0 80px;
            overflow: hidden;
        }

        .carousel-content {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 20px;
            padding: 24px 0;
            width: 100%;
            scrollbar-width: none;
        }

        .model-item {
            flex: 0 0 auto;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border: 1px solid var(--border-soft);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: var(--deep-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: var(--transition-smooth);
            font-size: 1.75rem;
        }

        .carousel-button:hover {
            background: var(--deep-navy);
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-button.left {
            left: 10px;
        }

        .carousel-button.right {
            right: 10px;
        }

        /* Premium Tables */
        .partner-card {
            background: var(--card-white) !important;
            border-radius: 20px !important;
            box-shadow: var(--shadow-premium) !important;
            border: 1px solid var(--border-soft) !important;
            overflow: hidden;
        }

        .partner-card .card-header {
            background: linear-gradient(135deg, var(--deep-navy) 0%, var(--indigo-accent) 100%) !important;
            padding: 1.25rem 1.75rem !important;
        }

        .partner-table thead th {
            background: #f8fafc !important;
            color: var(--text-muted) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem !important;
            border-bottom: 2px solid #f1f5f9 !important;
        }

        .partner-table td {
            color: var(--text-main) !important;
            padding: 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle !important;
            font-size: 0.9rem;
        }

        /* Main Material Table */
        #incomingTable {
            background: white !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border-radius: 12px;
            overflow: hidden;
        }

        #incomingTable thead th {
            background: var(--deep-navy) !important;
            color: white !important;
            font-weight: 700 !important;
            padding: 1.25rem 1rem !important;
            text-align: center !important;
        }

        .btn-success {
            background: var(--emerald-good) !important;
            border: none !important;
            border-radius: 30px !important;
            padding: 0.5rem 1.25rem !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2) !important;
            transition: var(--transition-smooth) !important;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3) !important;
        }

        .form-control-sm {
            border-radius: 30px !important;
            padding-left: 1.25rem !important;
            border: 1px solid var(--border-soft) !important;
        }

        /* Modal Overrides */
        .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: var(--deep-navy);
            color: white;
            border: none;
        }

        .modal-header .close {
            color: white;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* DataTables UI Styling */
        .dataTables_wrapper .dataTables_filter { margin-bottom: 1.5rem; }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border-soft) !important;
            border-radius: 30px !important;
            padding: 0.5rem 1.25rem !important;
            background: #fff !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
            margin-left: 0.75rem !important;
            width: 250px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border-soft) !important;
            border-radius: 8px !important;
            padding: 0.25rem 0.5rem !important;
            margin: 0 0.5rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            border: 1px solid var(--border-soft) !important;
            background: #fff !important;
            margin-left: 4px !important;
            padding: 0.4rem 0.8rem !important;
            font-weight: 600 !important;
            color: var(--text-main) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--deep-navy) !important;
            color: white !important;
            border-color: var(--deep-navy) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            color: var(--deep-navy) !important;
        }

        /* Enhanced Table Aesthetics */
        .table { width: 100% !important; margin-bottom: 0 !important; }
        .table thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none !important;
            vertical-align: middle !important;
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--deep-navy) !important;
        }
        .table tbody td {
            vertical-align: middle !important;
            border-top: 1px solid #f1f5f9 !important;
            padding: 1rem 0.75rem !important;
            font-size: 0.85rem;
        }
        .table-striped tbody tr:nth-of-type(odd) { background-color: rgba(248, 250, 252, 0.5); }
        .table-hover tbody tr:hover { background-color: #f1f5f9 !important; cursor: default; }

        /* Status Badge Improvements */
        .badge {
            font-weight: 700;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }
        .badge-success { background: rgba(16, 185, 129, 0.1) !important; color: var(--emerald-good) !important; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-warning { background: rgba(245, 158, 11, 0.1) !important; color: var(--amber-warn) !important; border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-info { background: rgba(14, 165, 233, 0.1) !important; color: var(--accent-cyan) !important; border: 1px solid rgba(14, 165, 233, 0.2); }

        /* Modal Table Container */
        .modal-body .table-responsive {
            border-radius: 12px;
            border: 1px solid var(--border-soft);
            background: #fff;
        }

        /* Grid Borders */
        .table-bordered {
            border: 1px solid var(--border-soft) !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid var(--border-soft) !important;
        }
        .table thead th {
            border-bottom: 2px solid var(--border-soft) !important;
        }
    </style>

    <div class="custom-dashboard">
        <header class="dashboard-header">
            <div class="header-brand">
                <div class="logo-container">
                    <img src="dist/img/adw3.png" alt="Logo">
                </div>
                <h1 class="dashboard-title">Dashboard Informasi STOK Material</h1>
            </div>
            <div id="dateTime" class="digital-clock"></div>
        </header>

        <div class="container-fluid py-4">


            <div id="cardCarousel" class="carousel slide" data-bs-ride="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center px-4">
                            <!-- Card 1 -->
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                                <div class="info-box" onclick="showIncomingMaterials1('{{ $allInhouseIds }}')">
                                    <p class="info-label">Total Material</p>
                                    <h3 class="info-value">{{ $totalMaterialCount }}</h3>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge bg-soft-navy text-muted px-2 py-1"
                                            style="font-size: 0.7rem; background: #f1f5f9;">Global Inventory</span>
                                    </div>
                                    <span class="info-icon"><i class="ph-duotone ph-gauge"></i></span>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                                <div class="info-box" onclick="showIncomingMaterials2('safe_data')">
                                    <p class="info-label">Stock Safe</p>
                                    <h3 class="info-value">{{ $totalSafeCount }}</h3>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge px-2 py-1"
                                            style="font-size: 0.7rem; background: rgba(16, 185, 129, 0.1); color: var(--emerald-good);">Healthy
                                            Status</span>
                                    </div>
                                    <span class="info-icon"><i class="ph-duotone ph-chart-bar"></i></span>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                                <div class="info-box" onclick="showIncomingMaterials3('critical_data')">
                                    <p class="info-label">Critical Items</p>
                                    <h3 class="info-value">{{ $totalCriticalCount }}</h3>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge px-2 py-1"
                                            style="font-size: 0.7rem; background: rgba(245, 158, 11, 0.1); color: var(--amber-warn);">Needs
                                            Attention</span>
                                    </div>
                                    <span class="info-icon"><i class="ph-duotone ph-chart-line-down"></i></span>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                                <div class="info-box" onclick="showIncomingMaterials4('data_ta')">
                                    <p class="info-label">TA Runout</p>
                                    <h3 class="info-value">{{ $totalTaCount }}</h3>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge px-2 py-1"
                                            style="font-size: 0.7rem; background: rgba(239, 68, 68, 0.1); color: var(--crimson-bad);">Action
                                            Required</span>
                                    </div>
                                    <span class="info-icon"><i class="ph-duotone ph-warning"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row justify-content-center px-4">
                            <!-- Card 5 -->
                            <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                                <div class="info-box" onclick="showIncomingMaterials5('run_out')">
                                    <p class="info-label">Material Runout</p>
                                    <h3 class="info-value">{{ $totalRunOutCount }}</h3>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="badge px-2 py-1"
                                            style="font-size: 0.7rem; background: rgba(100, 116, 139, 0.1); color: var(--text-muted);">Stock
                                            Empty</span>
                                    </div>
                                    <span class="info-icon text-secondary"><i class="ph-duotone ph-clipboard"></i></span>
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
                <!-- Top Header -->

                <!-- Metrics Row -->
                <div class="row mb-4">
                    <div class="carousel-container">
                        <button class="carousel-button left" onclick="slideLeft()">‹</button>
                        <div class="carousel-content py-2">
                            @foreach($modelStatusData as $m)
                                <div class="model-item">
                                    <div class="model-card" onclick="showIncomingMaterials('{{ $m['model_id'] }}')">
                                        <div class="status-indicator" style="background-color: {{ $m['statusColor'] }};"></div>
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="info-label mb-1">Model Series</p>
                                                <h4 class="mb-0 font-weight-bold"
                                                    style="font-family: 'Orbitron'; font-size: 1.1rem; color: var(--deep-navy);">
                                                    {{ $m['model_id'] ?: 'Unknown' }}</h4>
                                            </div>
                                            <span class="badge rounded-pill"
                                                style="background: #f1f5f9; color: var(--text-muted); font-size: 0.75rem;">{{ $m['count'] }}
                                                Qty</span>
                                        </div>
                                        <div class="mt-3 d-flex align-items-center justify-content-between">
                                            <span
                                                style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Operational
                                                Status</span>
                                            <i class="ph ph-arrow-square-out text-muted" style="font-size: 0.9rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-button right" onclick="slideRight()">›</button>
                    </div>
                </div>




                <div class="row mt-4">
                    <!-- Tabel Transaksi Material Incoming -->
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card partner-card h-100 border-0">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-white mb-0"
                                    style="font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Incoming Materials</h5>
                                <a href="#" data-toggle="modal" data-target="#exportModal2"
                                    class="btn btn-success btn-xs px-3">
                                    <i class="ph ph-file-xls mr-1"></i> Export
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive auto-scroll-container2" style="max-height: 400px;">
                                    <table class="table table-sm table-bordered partner-table mb-0">
                                        <thead class="sticky-top">
                                            <tr class="text-white">
                                                <th class="pl-3">Part No</th>
                                                <th>Spec</th>
                                                <th class="text-center">Actual</th>
                                                <th>Supplier</th>
                                                <th class="pr-3 text-right">Time</th>
                                                <th class="pr-3 text-right">Dibuat</th>
                                            </tr>
                                        </thead>
                                        <tbody class="partner-body">
                                            @foreach ($dn_inputs as $item)
                                                <tr>
                                                    <td class="pl-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                                        {{ $item->part_no }}</td>
                                                    <td class="py-2" style="font-size: 0.8rem; opacity: 0.8;">{{ $item->spec }}
                                                    </td>
                                                    <td class="py-2 text-center"
                                                        style="font-weight: 700; color: var(--emerald-good);">
                                                        {{ $item->actual }}</td>
                                                    <td class="py-2" style="font-size: 0.8rem; opacity: 0.8;">
                                                        {{ $item->supplier }}</td>
                                                    <td class="pr-3 py-2 text-right" style="font-size: 0.75rem; opacity: 0.6;">
                                                        {{ date('H:i', strtotime($item->update_time)) }}</td>
                                                    <td class="py-2 text-center"
                                                        style="font-weight: 700; color: var(--emerald-good);">
                                                        {{ $item->createdby}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Transaksi Material Out Inhouse -->
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card partner-card h-100 border-0">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-white mb-0"
                                    style="font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Outbound (Inhouse)</h5>
                                <a href="#" data-toggle="modal" data-target="#exportModal3" class="btn btn-success btn-xs">
                                    <i class="ph ph-file-xls mr-1"></i> Export
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive auto-scroll-container" style="max-height: 400px;">
                                    <table class="table table-sm table-bordered partner-table mb-0">
                                        <thead class="sticky-top">
                                          <tr class="text-white">
                                                <th class="text-center">Unique No</th>
                                                <th class="pl-3">Part No</th>
                                                <th>Spec</th>
                                                <th class="text-center">Actual</th>
                                                <th>Supplier</th>
                                                <th class="pr-3 text-right">Time</th>
                                                <th class="pr-3 text-right">Dibuat</th>
                                            </tr>
                                        </thead>
                                        <tbody class="partner-body">
                                            @foreach ($scan_out_rms as $item)
                                               <tr>
                                                 <td class="pl-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                                        {{ $item->uniqNo }}</td>
                                                    <td class="pl-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                                        {{ $item->part_no }}</td>
                                                    <td class="py-2" style="font-size: 0.8rem; opacity: 0.8;">{{ $item->spec }}
                                                    </td>
                                                    <td class="py-2 text-center"
                                                        style="font-weight: 700; color: var(--emerald-good);">
                                                        {{ $item->qty_out_sheet }}</td>
                                                    <td class="py-2" style="font-size: 0.8rem; opacity: 0.8;">
                                                        {{ $item->supplier }}</td>
                                                    <td class="pr-3 py-2 text-right" style="font-size: 0.75rem; opacity: 0.6;">
                                                        {{ date('H:i', strtotime($item->update_time)) }}</td>
                                                    <td class="py-2 text-center"
                                                        style="font-weight: 700; color: var(--emerald-good);">
                                                        {{ $item->createdby}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Transaksi Material Out Subcont -->
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card partner-card h-100 border-0">
                            <div class="card-header border-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title text-white mb-0"
                                    style="font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Outbound (Subcont)</h5>
                                <a href="#" data-toggle="modal" data-target="#exportModal3" class="btn btn-success btn-xs">
                                    <i class="ph ph-file-xls mr-1"></i> Export
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive auto-scroll-container2" style="max-height: 400px;">
                                    <table class="table table-sm table-bordered partner-table mb-0">
                                        <thead class="sticky-top">
                                            <tr class="text-white">
                                                <th class="pl-3">Uniq No</th>
                                                <th>Part No</th>
                                                <th class="text-center">Qty</th>
                                                <th class="pr-3 text-right">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-white">
                                            {{-- @foreach ($scan_out_subconts as $item)
                                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                <td class="pl-3 py-2" style="font-size: 0.8rem; opacity: 0.7;">{{
                                                    $item->uniqNo }}</td>
                                                <td class="py-2 font-weight-bold" style="font-size: 0.85rem;">{{
                                                    $item->part_no }}</td>
                                                <td class="py-2 text-center text-warning font-weight-bold">{{
                                                    $item->qty_out_sheet }}</td>
                                                <td class="pr-3 py-2 text-right" style="font-size: 0.75rem; opacity: 0.6;">
                                                    {{ date('H:i', strtotime($item->update_time)) }}</td>
                                            </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>




            <div id="material-section" class="row mt-4 px-3">
                <div class="col-12">
                    <div class="card partner-card border-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <h5 class="mb-0 text-white mr-2"
                                    style="font-size: 1rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                    Material Inventory Status</h5>

                                <button type="button" class="btn btn-success d-flex align-items-center"
                                    data-toggle="modal" data-target="#exportModal">
                                    <i class="ph ph-file-xls mr-2" style="font-size: 1.2rem;"></i> Export
                                </button>

                                <div class="position-relative">
                                    <i class="ph ph-magnifying-glass position-absolute"
                                        style="left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                                    <input type="text" id="searchInput" class="form-control form-control-sm"
                                        placeholder="Search Part Number..."
                                        style="width: 250px; padding-left: 35px; background: rgba(255,255,255,0.9); border: none;">
                                </div>
                            </div>

                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 1000px;">
                                <table id="incomingTable" class="table table-hover table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">No</th>
                                            <th>Part Name</th>
                                            <th>Part No (G5)</th>
                                            <th>Part No</th>
                                            <th>Job No</th>
                                            <th>Model</th>
                                            <th>Spec</th>
                                            <th style="width: 40px;">T</th>
                                            <th style="width: 40px;">W</th>
                                            <th style="width: 60px;">L</th>
                                            <th>Supplier</th>
                                            <th>Min</th>
                                            <th>Actual</th>
                                            <th>Rack</th>
                                            <th style="width: 110px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="vertical-align: middle;">
                                        <!-- Data populated by JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Filter Material -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
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
                <div class="modal-header">
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
                <div class="modal-header">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Part Details</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
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
    {{--
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script> --}}
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let incomingDataTable, partDetailsDataTable, poDataTable;
        $('#exportModal').on('show.bs.modal', function (event) {
            // You can add additional logic here if needed when the modal is about to be shown
        });

        $(document).on('click', '#exportBtn', function (e) {
            e.preventDefault();

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

            // Submit form
            $('#exportForm').submit();

            // Tutup loading setelah beberapa detik (estimasikan waktu untuk export)
            setTimeout(() => {
                Swal.close();
            }, 3000);
        });


        // Document ready initialization
        $(document).ready(function () {
            // Initialize main inventory table
            incomingDataTable = $('#incomingTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                destroy: true,
                pageLength: 20,
                ajax: {
                    url: "{{ route('dashboardrmstok.detail') }}",
                    data: function (d) {
                        d.filter = $('#incomingTable').data('filter') || 'all_inhouse';
                        d.model_id = $('#incomingTable').data('model_id') || '';
                    }
                },
                columns: [
                    { data: 'id', name: 'id', searchable: false, orderable: false, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                    { data: 'part_name', name: 'part_name', defaultContent: '-' },
                    { data: 'part_no', name: 'part_no', defaultContent: '-' },
                    { data: 'part_no2', name: 'part_no2', defaultContent: '-' },
                    {
                        data: 'job_no',
                        name: 'job_no',
                        render: data => `<div style="max-width: 150px; white-space: normal; word-break: break-all;">${data || '-'}</div>`
                    },
                    { data: 'model_id', name: 'model_id', defaultContent: '-' },
                    { data: 'spek', name: 'spek', defaultContent: '-' },
                    { data: 'spek_t', name: 'spek_t', className: 'text-center', render: data => data || '-' },
                    { data: 'spek_w', name: 'spek_w', className: 'text-center', render: data => data || '-' },
                    { data: 'spek_l', name: 'spek_l', className: 'text-center', render: data => data || '-' },
                    { data: 'supplier', name: 'supplier', defaultContent: '-' },
                    { data: 'minimal', name: 'minimal', className: 'text-center', defaultContent: '-' },
                    {
                        data: 'actual_sheet',
                        name: 'actual_sheet',
                        className: 'text-center',
                        render: (data, type, row) => {
                            let colorClass = 'var(--emerald-good)';
                            if (data == 0) colorClass = 'var(--crimson-bad)';
                            else if (data < row.minimal) colorClass = 'var(--amber-warn)';
                            return `<div style="background: ${colorClass}; color: white; padding: 4px 8px; border-radius: 4px; font-weight: 700;">${data || 0}</div>`;
                        }
                    },
                    {
                        data: 'no_rak',
                        name: 'no_rak',
                        className: 'text-center',
                        render: data => `<div style="background: var(--slate-primary); color: white; padding: 4px 8px; border-radius: 4px; font-weight: 700;">${data || '-'}</div>`
                    },
                    { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
                ],
                dom: '<"d-none"f>rt<"d-flex justify-content-between align-items-center p-3"ip>',
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
                }
            });

            // Connect external search input
            $('#searchInput').on('keyup', function () {
                incomingDataTable.search(this.value).draw();
            });
        });


        function updateDateTime() {
            const now = new Date();

            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            const dayName = days[now.getDay()];
            const day = now.getDate().toString().padStart(2, '0');
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const dateString = `${dayName}, ${day} ${monthName} ${year}`;
            const timeString = `${hours}:${minutes}:${seconds}`;

            document.getElementById("dateTime").innerHTML = `
                    <div style="font-size: 0.8rem; font-family: 'Inter'; font-weight: 600; text-align: right; margin-bottom: -4px; color: rgba(255,255,255,0.7);">${dateString}</div>
                    <div>${timeString}</div>
                `;
        }

        // Update date and time every second
        setInterval(updateDateTime, 1000);

        // Initial call to display date and time immediately on page load
        updateDateTime();


        function slideLeft() {
            const carousel = document.querySelector('.carousel-content');
            carousel.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        }

        function slideRight() {
            const carousel = document.querySelector('.carousel-content');
            carousel.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        }

        function showFilteredMaterials(filter, model_id = null) {
            document.getElementById('material-section').scrollIntoView({ behavior: 'smooth' });

            $('#incomingTable').data('filter', filter);
            $('#incomingTable').data('model_id', model_id);

            incomingDataTable.ajax.reload();
        }

        function showIncomingMaterials(values) {
            // Take the first model from values for context, or handle all
            const models = values.split(',');
            showFilteredMaterials(null, models[0]);
        }

        // #48cf

        function showIncomingMaterials1() { showFilteredMaterials('all_inhouse'); }
        function showIncomingMaterials2() { showFilteredMaterials('safe'); }

        function showDetails(partNo) {
            currentPartNo = partNo;
            $('#detailModal').modal('show');
            $('#detailModal .modal-body').html('<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted">Analyzing Material History...</p></div>');

            $.ajax({
                url: "{{ route('dashboardrmstok.getPartDetails') }}",
                data: { part_no: partNo, length: 1 },
                success: function (response) {
                    let countBox = `
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 text-white rounded status-box active shadow-sm d-flex align-items-center justify-content-between"
                                     data-status="" style="cursor:pointer; background: linear-gradient(135deg, #10b981 0%, #059669 100%); transition: var(--transition-smooth);">
                                    <div>
                                        <small class="d-block opacity-75 font-weight-bold">READY</small>
                                        <h3 class="mb-0 font-weight-bold">${response.count_null}</h3>
                                    </div>
                                    <i class="ph-duotone ph-package" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 text-white rounded status-box shadow-sm d-flex align-items-center justify-content-between"
                                     data-status="1" style="cursor:pointer; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); transition: var(--transition-smooth);">
                                    <div>
                                        <small class="d-block opacity-75 font-weight-bold">OUT</small>
                                        <h3 class="mb-0 font-weight-bold">${response.count_1}</h3>
                                    </div>
                                    <i class="ph-duotone ph-truck" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 text-white rounded status-box shadow-sm d-flex align-items-center justify-content-between"
                                     data-status="2" style="cursor:pointer; background: linear-gradient(135deg, #334155 0%, #0f172a 100%); transition: var(--transition-smooth);">
                                    <div>
                                        <small class="d-block opacity-75 font-weight-bold">SUBCONT</small>
                                        <h3 class="mb-0 font-weight-bold">${response.count_2}</h3>
                                    </div>
                                    <i class="ph-duotone ph-factory" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="partDetailsTable" class="table table-hover table-bordered w-100">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Uniq No</th>
                                        <th>Supplier</th>
                                        <th>Spec</th>
                                        <th class="text-center">Sheet</th>
                                        <th class="text-center">Kg</th>
                                        <th class="text-center">Tanggal In</th>
                                        <th>Scan In</th>
                                        <th class="text-center">Tanggal Out</th>
                                        <th>Scan Out</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>`;

                    $('#detailModal .modal-body').html(countBox);

                    partDetailsDataTable = $('#partDetailsTable').DataTable({
                        processing: true,
                        serverSide: true,
                        pageLength: 10,
                        autoWidth: false,
                        destroy: true,
                        ajax: {
                            url: "{{ route('dashboardrmstok.getPartDetails') }}",
                            data: function (d) {
                                d.part_no = currentPartNo;
                                d.status = $('#partDetailsTable').data('status-filter') || '';
                            }
                        },
                        columns: [
                            { data: 'id', name: 'id', className: 'text-center', render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                            { data: 'uniqNo', name: 'uniqNo' },
                            { data: 'supplier', name: 'supplier' },
                            { data: 'spec', name: 'spec' },
                            { data: 'qty_in', name: 'qty_in', className: 'text-center font-weight-bold' },
                            { data: 'qty_kg', name: 'qty_kg', className: 'text-center' },
                            { data: 'created_at', name: 'created_at', className: 'text-center' },
                            { data: 'createdby', name: 'createdby' },
                            { data: 'time_out', name: 'time_out', className: 'text-center', defaultContent: '-' },
                            { data: 'out_user', name: 'out_user', defaultContent: '-' },
                            { data: 'status', name: 'status', className: 'text-center' },
                            { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
                        ]
                    });
                }
            });
        }

        $(document).on('click', '.status-box', function () {
            $('.status-box').removeClass('active').css('opacity', '0.7');
            $(this).addClass('active').css('opacity', '1');
            $('#partDetailsTable').data('status-filter', $(this).data('status'));
            partDetailsDataTable.ajax.reload();
        });


        $(document).on('click', '#btn_pdf', function (e) {
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


        function showIncomingMaterials3() { showFilteredMaterials('critical'); }
        function showIncomingMaterials4() { showFilteredMaterials('ta'); }
        function showIncomingMaterials5() { showFilteredMaterials('runout'); }



        function showDetails2(partNo) {
            currentPartNo = partNo;
            $('#detailModal2').modal('show');
            $('#detailModal2 .modal-body').html('<div class="text-center p-5"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted">Tracking Purchase Orders...</p></div>');

            $.ajax({
                url: "{{ route('dashboardrmstok.getDocPo') }}",
                data: { part_no: partNo, length: 1 },
                success: function (response) {
                    let modalContent = `
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 text-white rounded filter-status active shadow-sm d-flex align-items-center justify-content-between"
                                     data-filter="open" style="cursor:pointer; background: linear-gradient(135deg, #0f172a 0%, #334155 100%); transition: var(--transition-smooth);">
                                    <div>
                                        <small class="d-block opacity-75 font-weight-bold">STATUS</small>
                                        <h3 class="mb-0 font-weight-bold">OPEN: ${response.count_open}</h3>
                                    </div>
                                    <i class="ph-duotone ph-clock-countdown" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 text-white rounded filter-status shadow-sm d-flex align-items-center justify-content-between"
                                     data-filter="close" style="cursor:pointer; background: linear-gradient(135deg, #10b981 0%, #059669 100%); transition: var(--transition-smooth);">
                                    <div>
                                        <small class="d-block opacity-75 font-weight-bold">STATUS</small>
                                        <h3 class="mb-0 font-weight-bold">CLOSE: ${response.count_close}</h3>
                                    </div>
                                    <i class="ph-duotone ph-check-circle" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="poTable" class="table table-hover table-striped table-bordered w-100">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th>Part No</th>
                                        <th>Doc PO</th>
                                        <th class="text-center">Qty Order</th>
                                        <th class="text-center">Qty Datang</th>
                                        <th class="text-center">Balance</th>
                                        <th>Supplier</th>
                                        <th class="text-center">Tanggal PO</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>`;

                    $('#detailModal2 .modal-body').html(modalContent);

                    poDataTable = $('#poTable').DataTable({
                        processing: true,
                        serverSide: true,
                        pageLength: 10,
                        autoWidth: false,
                        destroy: true,
                        ajax: {
                            url: "{{ route('dashboardrmstok.getDocPo') }}",
                            data: function (d) {
                                d.part_no = currentPartNo;
                                d.status = $('#poTable').data('status-filter') || 'open';
                            }
                        },
                        columns: [
                            { data: 'part_no', name: 'part_no' },
                            { data: 'doc_po', name: 'doc_po', defaultContent: '-' },
                            { data: 'order_sheet', name: 'order_sheet', className: 'text-center', render: data => `<div class="badge badge-warning" style="background: #fffbeb !important; color: #92400e !important; border: 1px solid #fef3c7;">${data || 0}</div>` },
                            { data: 'actual_sheet', name: 'actual_sheet', className: 'text-center', render: data => `<div class="badge badge-success" style="background: #ecfdf5 !important; color: #065f46 !important; border: 1px solid #d1fae5;">${data || 0}</div>` },
                            { data: 'balance_sheet', name: 'balance_sheet', className: 'text-center font-weight-bold' },
                            { data: 'supplier', name: 'supplier' },
                            { data: 'delivery', name: 'delivery', className: 'text-center', render: data => `<div class="text-muted small">${data || '-'}</div>` },
                            { data: 'status', name: 'status', className: 'text-center', render: data => data === 'Close' ? '<span class="badge badge-success">CLOSED</span>' : '<span class="badge badge-info">OPEN</span>' }
                        ]
                    });
                }
            });
        }

        $(document).on('click', '.filter-status', function () {
            $('.filter-status').removeClass('active').css('opacity', '0.7');
            $(this).addClass('active').css('opacity', '1');
            $('#poTable').data('status-filter', $(this).data('filter'));
            poDataTable.ajax.reload();
        });




        function updateDnInputs() {
            fetch('{{ route('dnInputs.update') }}')
                .then(response => response.json())
                .then(data => {
                    let tbody = document.querySelector('.table-responsive.auto-scroll-container2 tbody');
                    tbody.innerHTML = ''; // Clear the table content before adding new data

                    data.forEach(item => {
                        let row = `
                        <tr style="vertical-align: middle;">
                            <td><span class="badge bg-light text-dark">${item.uniqNo}</span></td>
                            <td>${item.part_no}</td>
                            <td>${item.spec}</td>
                            <td style="font-weight: 700; color: var(--emerald-good);">${item.actual}</td>
                            <td>${item.supplier}</td>
                            <td style="font-size: 0.8rem;">${item.update_time}</td>
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
                        if (!existingUniqNos.includes(item.uniqNo)) {
                            let row = `
                            <tr style="vertical-align: middle;">
                                <td><span class="badge bg-light text-dark">${item.uniqNo}</span></td>
                                 <td>${item.part_no}</td>
                                <td>${item.spec}</td>
                                <td style="font-weight: 700; color: var(--emerald-good);">${item.qty_out_sheet}</td>
                                <td>${item.supplier}</td>
                                <td style="font-size: 0.8rem;">${item.update_time}</td>
                                <td>${item.createdby}</td>
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
                        if (!existingUniqNos.includes(item.uniqNo)) {
                            let row = `
                            <tr style="vertical-align: middle;">
                                <td><span class="badge bg-light text-dark">${item.uniqNo}</span></td>
                                <td>${item.part_no}</td>
                                <td>${item.spec}</td>
                                <td>${item.supplier}</td>
                                <td style="font-weight: 700; color: var(--accent-cyan);">${item.qty_out_sheet} Sheet</td>
                                <td style="font-weight: 700; color: var(--accent-cyan);">${item.qty_out_kg} Kg</td>
                                <td>${item.createdby}</td>
                                <td style="font-size: 0.8rem;">${item.update_time}</td>
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
        // Consolidated polling every 10 seconds
        setInterval(function () {
            updateDnInputs();
            updateScanOutRms();
            updateScanOutSubcont();
        }, 10000);
    </script>
@endpush
