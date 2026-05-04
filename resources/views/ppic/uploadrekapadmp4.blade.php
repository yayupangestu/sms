@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --background: #f1f5f9;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --green-gradient: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
            background-color: var(--background) !important;
            color: var(--text-main);
        }

        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            background: var(--surface);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 1.25rem 1.5rem !important;
        }

        /* Refined Grid Style for Table */
        #example1 {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #cbd5e1;
        }

        #example1 thead th {
            background-color: #f8fafc !important;
            color: #334155 !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.05em;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
        }

        #example1 tbody td {
            padding: 10px 15px;
            vertical-align: middle;
            border: 1px solid #cbd5e1;
            color: #334155;
            font-size: 13px;
        }

        #example1 tbody tr:hover {
            background-color: #f1f5f9;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border-radius: 8px;
            border: none;
            transition: all 0.2s;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            color: white;
        }
        .btn-outline-custom {
            background: white;
            border: 1px solid var(--border);
            color: var(--text-main);
            border-radius: 8px;
            transition: all 0.2s;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
        }
        .btn-outline-custom:hover {
            background: #f1f5f9;
            border-color: var(--secondary);
        }

        /* Overview Widget Styles */
        .overview-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            background: var(--surface);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        .overview-header {
            padding: 1rem 1.5rem;
            background: var(--green-gradient);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .overview-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem;
        }
        .icon-circle-lg {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .bg-soft-primary { background: #eff6ff; color: #3b82f6; }
        .bg-soft-warning { background: #fffbeb; color: #fbbf24; }
        .bg-soft-success { background: #f0fdf4; color: #22c55e; }

        .stat-content { flex-grow: 1; }
        .stat-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-bottom: 0.125rem; }
        .stat-value { font-size: 1.25rem; font-weight: 800; color: var(--text-main); line-height: 1.2; }

        .chart-legend-container {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 0.75rem 1.25rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .chart-legend-item { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #475569; font-weight: 700; }
        .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

        .border-right-lg { border-right: 1px solid var(--border); }
        @media (max-width: 991.98px) {
            .border-right-lg { border-right: none; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        }

        .activity-list { position: relative; padding-left: 1.5rem; }
        .activity-list::before {
            content: '';
            position: absolute;
            left: 0.35rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
            border-radius: 2px;
        }
        .activity-item { position: relative; margin-bottom: 1.25rem; padding-bottom: 0.5rem; }
        .activity-item::before {
            content: '';
            position: absolute;
            left: -1.45rem;
            top: 0.25rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--primary);
            z-index: 1;
        }
        .activity-label { display: block; font-size: 0.65rem; text-transform: uppercase; font-weight: 700; color: var(--text-muted); margin-bottom: 0.125rem; }
        .activity-name { display: block; font-size: 0.875rem; font-weight: 700; color: var(--text-main); line-height: 1.2; }

        .cycle-box-besi .created-by-tag { color: '#4ade80' !important; }

        /* Widen Detail Modal */
        @media (min-width: 1200px) {
            .modal-widest {
                max-width: 96% !important;
                margin: 1.75rem auto;
            }
        }

        /* Detail Table Refinement */
        #example2 th {
            font-size: 11px !important;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            padding: 10px 8px !important;
            vertical-align: middle !important;
            background: #f8fafc !important;
            color: #475569 !important;
        }
        #example2 td {
            font-size: 12px !important;
            padding: 8px !important;
            vertical-align: middle !important;
        }
        .col-dn { min-width: 150px; }
        .col-del { min-width: 100px; }
        .col-name { min-width: 250px; }
        .col-part { min-width: 120px; }
        .col-cycle { min-width: 90px; text-align: center; } /* Increased slightly */
        .col-action { min-width: 80px; text-align: center; }

        /* --- Tim Prepare Section Ported Styles --- */
        .tim-prepare-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
        }
        .tim-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .tim-header i { font-size: 1.25rem; color: #10b981; }
        .tim-header span { font-weight: 800; font-size: 0.9rem; color: #1e293b; text-transform: uppercase; letter-spacing: 0.025em; }

        .tim-grid {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .tim-pair {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .tim-team-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }
        .tim-member-grid {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .tim-member {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .tim-member:hover {
            border-color: #10b981;
            background: #f0fdf4;
            transform: translateY(-1px);
        }
        .tim-member span {
            font-size: 0.95rem; /* Bigger font as requested */
            font-weight: 800;
            color: #334155;
            display: flex;
            align-items: center;
        }
        .tim-member img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        /* Modal Styling */
        #myModal2 .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }
        #myModal2 .modal-header {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
        }
        .summary-panel {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .summary-stat-group {
            display: flex;
            gap: 20px;
        }
        .summary-stat-box {
            padding: 5px 15px;
            border-left: 3px solid #10b981;
            background: #f8fafc;
            border-radius: 0 6px 6px 0;
        }
        .summary-stat-box.danger {
            border-left-color: #ef4444;
        }
        .stat-box-label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-box-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1.2;
        }

        /* Cycle Reset Styling */
        .btn-reset-cycle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #64748b;
            border: none;
            transition: all 0.2s;
            margin-top: 5px;
        }
        .btn-reset-cycle:hover {
            background: #3b82f6;
            color: #fff;
            transform: translateY(-1px);
        }

        .cycle-th {
            background: #f8fafc !important;
            vertical-align: middle !important;
            padding: 10px 5px !important;
        }
        .cycle-label {
            font-size: 11px;
            font-weight: 700;
            color: #475569;
        }

        /* Row Actions */
        .btn-delete-row {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #fef2f2;
            color: #ef4444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #fee2e2;
            transition: all 0.2s;
        }
        .btn-delete-row:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        /* Dashboard Info Bar */
        .info-bar {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(16, 185, 129, 0.1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-right: 25px;
            font-size: 0.85rem;
            color: #64748b;
        }
        .info-item i {
            margin-right: 8px;
            color: #10b981;
            font-size: 1rem;
        }
        .info-item .info-label {
            font-weight: 700;
            color: #334155;
            margin-right: 5px;
        }
        .live-pulse {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .stat-hint {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-top: 2px;
            font-style: italic;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Rekap Order ADM PLANT 4</h1>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid py-3">

                <!-- Info Bar -->
                <div class="info-bar animated fadeInDown">
                    <div class="info-item">
                        <div class="live-pulse"></div>
                        <span class="info-label">Status:</span> Live Monitoring
                    </div>
                    <div class="info-item">
                        <i class="fas fa-industry"></i>
                        <span class="info-label">Plant:</span> ADM PLANT 4
                    </div>
                    <div class="info-item">
                        <i class="fas fa-microchip"></i>
                        <span class="info-label">System:</span> Smart Monitoring S2
                    </div>
                    <div class="info-item ml-auto mr-0">
                        <i class="fas fa-sync-alt fa-spin-hover"></i>
                        <span class="info-label">Last Sync:</span> <span id="last_sync_time">-</span>
                    </div>
                </div>

                <!-- Works Overview Widget -->
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-12">
                        <div class="overview-card">
                            <div class="overview-header">
                                <h5 class="overview-title">
                                    <i class="fas fa-chart-line"></i>
                                    Works Overview
                                </h5>
                                <div class="d-flex align-items-center">
                                    <label for="cycleArrivalFilter" class="mr-2 mb-0 font-weight-bold text-dark" style="font-size: 0.85rem;">Filter Date:</label>
                                    <div class="input-group input-group-sm" style="width: 180px;">
                                        <input type="date" id="cycleArrivalFilter" class="form-control" style="border-radius: 6px;">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-left-0"><i class="far fa-calendar-alt text-muted"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 border-right-lg">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-primary">
                                                        <i class="fas fa-list-ul"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Total work orders</div>
                                                        <div class="stat-value" id="stats_total">-</div>
                                                        <div class="stat-hint">Total requirement for delivery</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-danger" style="background: #fef2f2; color: #ef4444;">
                                                        <i class="fas fa-times-circle"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Done not scan</div>
                                                        <div id="stats_not_scanned" class="stat-value">-</div>
                                                        <div class="stat-hint">Manual output entries</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-warning">
                                                        <i class="fas fa-clock"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Estimated Kanban</div>
                                                        <div class="stat-value" id="stats_pending">-</div>
                                                        <div class="stat-hint">Remaining items to scan</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-success">
                                                        <i class="fas fa-check-double"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Approved works</div>
                                                        <div class="stat-value" id="stats_approved">-</div>
                                                        <div class="stat-hint">Confirmed scanner logs</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 border-right-lg mt-4 mt-lg-0">
                                        <div class="d-flex align-items-center justify-content-center flex-column">
                                            <div style="position: relative; height: 240px; width: 240px; margin-bottom: 1.5rem;">
                                                <canvas id="worksOverviewChart"></canvas>
                                                <div id="chartCenterText" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; pointer-events: none;">
                                                    <div id="chartPercent" style="font-size: 3rem; font-weight: 800; color: #1e293b; line-height: 1;">0%</div>
                                                    <div style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-top: 4px;">Done</div>
                                                </div>
                                            </div>
                                            <div class="chart-legend-container">
                                                <!-- Legend generated by JS -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 mt-4 mt-lg-0">
                                        <div class="tim-prepare-card">
                                            <div class="tim-header">
                                                <i class="fas fa-users"></i>
                                                <span>Tim Prepare</span>
                                            </div>
                                            <div class="tim-grid">
                                                <div class="tim-pair">
                                                    <div class="tim-member-grid">
                                                        <span class="tim-team-label text-center">PALLET BESI</span>
                                                        <div class="tim-member">
                                                            <span>Iswadi <span id="count_Iswadi" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar">
                                                        </div>
                                                        <div class="tim-member">
                                                            <span>Asep <span id="count_Asep" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar">
                                                        </div>
                                                    </div>
                                                    <div class="tim-member-grid">
                                                        <span class="tim-team-label text-center">PALLET BOX</span>
                                                        <div class="tim-member">
                                                            <span>Abi <span id="count_Abi" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar">
                                                        </div>
                                                        <div class="tim-member">
                                                            <span>Fikri <span id="count_Fikri" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar">
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

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <h5 class="mb-0 font-weight-bold text-dark">
                                        <i class="fas fa-database mr-2 text-primary"></i>
                                       Upload & Database
                                    </h5>

                                    <div class="import-section mt-2 mt-md-0">
                                        <form id="importForm" action="{{ route('importRekapadmp4') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                            @csrf
                                            <div class="import-zone p-1 d-flex align-items-center mr-2" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px;">
                                                <input type="file" id="fileInput" name="file" class="form-control-file form-control-sm border-0 bg-transparent" style="width: 220px;" required>
                                            </div>
                                            <button id="importButton" class="btn btn-primary-custom btn-sm shadow-sm px-3" type="submit" disabled>
                                                <i class="fas fa-cloud-upload-alt mr-1"></i> Import DN
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="50">No</th>
                                                <th>Tanggal DN</th>
                                                <th>Arrival 1</th>
                                                <th>Arrival 2</th>
                                                <th width="80">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Detail -->
        <div class="modal fade" id="myModal2">
            <div class="modal-dialog modal-widest">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header d-flex justify-content-between align-items-center py-3 px-4">
                        <h4 class="modal-title font-weight-bold" id="title1">LIST ITEM DN</h4>
                        <button type="button" class="btn btn-outline-custom btn-sm px-3" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Close
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="summary-panel animated fadeIn">
                            <div class="d-flex align-items-center">
                                <div class="btn-group">
                                    <button id="saveChanges" class="btn btn-primary-custom px-4 shadow-sm">
                                        <i class="fas fa-save mr-2"></i>SAVE CHANGES
                                    </button>
                                    <button id="btn_export_pdf" class="btn btn-outline-danger shadow-sm ml-2">
                                        <i class="fas fa-file-pdf mr-2"></i>REVIEW PDF
                                    </button>
                                </div>
                            </div>

                            <div class="summary-stat-group">
                                <div class="summary-stat-box">
                                    <div class="stat-box-label">Total Items</div>
                                    <div id="summary_total_data" class="stat-box-value">-</div>
                                </div>
                                <div class="summary-stat-box danger">
                                    <div class="stat-box-label">Zero Qty (C1-10)</div>
                                    <div id="summary_zero_qty" class="stat-box-value">-</div>
                                </div>
                            </div>
                        </div>

                        <div id="alert"></div>

                        <div class="table-container">
                            <table id="example2" class="table table-hover table-bordered mb-0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle text-center" width="40">No</th>
                                        <th rowspan="2" class="align-middle col-dn">NO DN</th>
                                        <th rowspan="2" class="align-middle col-del">DEL DATE</th>
                                        <th rowspan="2" class="align-middle col-name">PART NAME</th>
                                        <th rowspan="2" class="align-middle col-part">PART NO</th>
                                        <th rowspan="2" class="align-middle" width="80">JOB NO</th>
                                        <th rowspan="2" class="align-middle text-center" width="70">QTY KANBAN</th>
                                        <th class="text-center col-cycle">Cycle 1</th>
                                        <th class="text-center col-cycle">Cycle 2</th>
                                        <th class="text-center col-cycle">Cycle 3</th>
                                        <th class="text-center col-cycle">Cycle 4</th>
                                        <th class="text-center col-cycle">Cycle 5</th>
                                        <th class="text-center col-cycle">Cycle 6</th>
                                        <th class="text-center col-cycle">Cycle 7</th>
                                        <th class="text-center col-cycle">Cycle 8</th>
                                        <th class="text-center col-cycle">Cycle 9</th>
                                        <th class="text-center col-cycle">Cycle 10</th>
                                        <th rowspan="2" class="align-middle text-center col-action">ACTION</th>
                                    </tr>
                                    <tr>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 1</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="1" title="Reset Cycle 1">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 2</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="2" title="Reset Cycle 2">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 3</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="3" title="Reset Cycle 3">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 4</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="4" title="Reset Cycle 4">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 5</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="5" title="Reset Cycle 5">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 6</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="6" title="Reset Cycle 6">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 7</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="7" title="Reset Cycle 7">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 8</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="8" title="Reset Cycle 8">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 9</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="9" title="Reset Cycle 9">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                                <th class="cycle-th">
                                                    <div class="cycle-label">CYC 10</div>
                                                    <button type="button" class="btn-reset-cycle" data-cycle="10" title="Reset Cycle 10">
                                                        <i class="fas fa-sync-alt fa-xs"></i>
                                                    </button>
                                                </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic Data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Small Modal Reset Cycle -->
        <div class="modal fade" id="cycleDetailModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-danger text-white py-2">
                        <h6 class="modal-title font-weight-bold"><i class="fas fa-sync-alt mr-2"></i>Reset Cycle Qty</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="text-center">
                            <p class="mb-3 font-weight-bold">Reset Qty for Cycle <span id="targetCycleNum"></span></p>
                            <form id="resetCycleForm">
                                <input type="hidden" id="resetCycleInput">
                                <div class="form-group mb-2">
                                    <input type="password" class="form-control text-center" id="resetPassword" placeholder="Password">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control text-center text-uppercase" id="resetConfirm" placeholder="Type 'RESET'">
                                </div>
                                <button type="submit" class="btn btn-danger btn-block font-weight-bold shadow-sm">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>PROCEED RESET
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="created_at">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    </div>

    <!-- Modal PDF Preview (Print View style) -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-xl" style="max-width: 90% !important;">
            <div class="modal-content shadow-lg border-0" style="height: 90vh;">
                <div style="background: #343a40 !important;" class="modal-header text-white py-2 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-file-pdf mr-2"></i>PREVIEW REKAP ORDER PLANT 4</h5>
                    <div>
                        <button id="modalDownloadPdf" class="btn btn-success btn-sm mr-2 shadow-sm"><i class="fas fa-download mr-1"></i>Download PDF</button>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body p-0 bg-secondary position-relative" style="height: calc(100% - 40px);">
                    <iframe id="pdfPreviewFrame" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set default date to today
            var today = new Date().toISOString().split('T')[0];
            $('#cycleArrivalFilter').val(today);

            // --- Works Overview Donut Chart ---
            var ctx = document.getElementById('worksOverviewChart').getContext('2d');
            var worksOverviewChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    legend: { display: false },
                    tooltips: {
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleFontColor: '#1e293b',
                        bodyFontColor: '#475569',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: true,
                        cornerRadius: 8
                    },
                    animation: { animateScale: true, animateRotate: true }
                }
            });

                            function updateChart() {
                                var cycleArrivalDate = $('#cycleArrivalFilter').val();
                                $.ajax({
                                    url: "{{ route('uploadrekapadmp4.getChartData') }}",
                                    method: "GET",
                                    data: { cycle_arrival_date: cycleArrivalDate },
                                    success: function(response) {
                                        if(response.success) {
                                            // Update Chart
                                            worksOverviewChart.data.labels = response.labels;
                                            worksOverviewChart.data.datasets[0].data = response.data;
                                            worksOverviewChart.data.datasets[0].backgroundColor = response.colors;
                                            worksOverviewChart.update();

                                            // Update Center Text
                                            $('#chartPercent').text(response.percentage + '%');

                                            // Update Team Counts
                                            if (response.team_counts) {
                                                Object.keys(response.team_counts).forEach(member => {
                                                    $(`#count_${member}`).text(response.team_counts[member]);
                                                });
                                            }

                                            // Update Stats
                                            $('#stats_total').text(response.total_works || 0);
                                            $('#stats_not_scanned').text(response.not_scanned_count || 0);
                                            $('#stats_pending').text(response.pending_works || 0);
                                            $('#stats_approved').text(response.approved_works || 0);

                                            // Update Legend with Counts
                                            var legendHtml = '';
                                            if (response.labels) {
                                                response.labels.forEach((label, index) => {
                                                    var color = response.colors[index];
                                                    var value = response.data[index] || 0;
                                                    legendHtml += `
                                                        <div class="chart-legend-item">
                                                            <span class="legend-dot" style="background-color: ${color};"></span>
                                                            <span>${label}: <span style="color: #1e293b; margin-left: 2px;">${value}</span></span>
                                                        </div>
                                                    `;
                                                });
                                            }
                                            $('.chart-legend-container').html(legendHtml);

                                            // Update Last Sync Time
                                            let now = new Date();
                                            $('#last_sync_time').text(now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }));
                                        }
                                    }
                                });
                            }

            // Set default date to today for the filter
            if (!$('#cycleArrivalFilter').val()) {
                var today = new Date().toISOString().split('T')[0];
                $('#cycleArrivalFilter').val(today);
            }

            // Initial Load
            updateChart();
            list();

            // Update on filter change
            $('#cycleArrivalFilter').on('change', function() {
                updateChart();
                // list(); // Removed to prevent table reload/flicker on date filter change
            });
        });

        // DataTables & Actions
        function list() {
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                destroy: true,
                pageLength: 10,
                order: [[1, 'desc']],
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: { url: "{{ route('uploadrekapadmp4.list') }}" },
                columns: [
                    {
                        data: null, className: 'text-center',
                        render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
                    },
                    { data: 'del_date', name: 'del_date', className: 'text-center' },
                    { data: 'arrival1', name: 'arrival1', className: 'text-center' },
                    { data: 'arrival2', name: 'arrival2', className: 'text-center' },
                    {
                        data: 'id', name: 'id', className: 'text-center',
                        render: function(data) {
                            return `<div class="btn-group">
                                <a href="#" id="btn_edit" title="Detail" data-id="${data}" class="btn btn-info btn-sm shadow-sm"><i class="fas fa-search"></i></a>
                                <a href="#" id="btn_delete" title="Delete" data-id="${data}" class="btn btn-danger btn-sm ml-1 shadow-sm"><i class="fas fa-trash"></i></a>
                            </div>`;
                        }
                    }
                ],
                oLanguage: { sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading...' }
            });
        }

        function listdetail() {
            var table = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                destroy: true,
                scrollX: true,
                scrollCollapse: true,
                orderCellsTop: true,
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "{{ route('uploadrekapadmp4.listdetail') }}",
                    data: { created_at: $('#created_at').val() }
                },
                columns: [
                    { data: null, className: 'text-center', render: function(d, t, r, m) { return m.row + m.settings._iDisplayStart + 1; } },
                    { data: 'doc_dn', name: 'doc_dn' },
                    { data: 'del_date', name: 'del_date' },
                    { data: 'part_name', name: 'part_name' },
                    { data: 'part_no', name: 'part_no' },
                    { data: 'job_no', name: 'job_no' },
                    { data: 'qty_kanban', name: 'qty_kanban' },
                    {
                        data: 'cycle1',
                        name: 'cycle1',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 1 && row.cycle != '1') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle2',
                        name: 'cycle2',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 2 && row.cycle != '2') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle3',
                        name: 'cycle3',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 3 && row.cycle != '3') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle4',
                        name: 'cycle4',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 4 && row.cycle != '4') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle5',
                        name: 'cycle5',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 5 && row.cycle != '5') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle6',
                        name: 'cycle6',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 6 && row.cycle != '6') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle7',
                        name: 'cycle7',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 7 && row.cycle != '7') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle8',
                        name: 'cycle8',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 8 && row.cycle != '8') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle9',
                        name: 'cycle9',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 9 && row.cycle != '9') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle10',
                        name: 'cycle10',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 10 && row.cycle != '10') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid rgba(0,0,0,0.1);">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'id', name: 'id', className: 'text-center', render: function(data) {
                            return `<button class="btn-delete-row btn_delete_line shadow-sm" data-id="${data}" title="Delete Row">
                                <i class="fas fa-trash-alt"></i>
                            </button>`;
                        }
                    }
                ],
                columnDefs: [{ "targets": [0, 17], "orderable": false }],
                oLanguage: { sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading...' }
            });

            $(window).on('resize', function() { table.columns.adjust(); });
            $('#myModal2').on('shown.bs.modal', function() { table.columns.adjust(); });
        }

        $(document).on("click", "#btn_edit", function() {
            var createdAt = $(this).data('id');
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#created_at').val(createdAt);
            fetchSummary(createdAt);
            listdetail();
        });

        function fetchSummary(createdAt) {
            $.ajax({
                url: "{{ route('uploadrekapadmp4.getSummary') }}",
                method: "GET",
                data: { created_at: createdAt },
                success: function(response) {
                    if(response.success) {
                        $('#summary_total_data').text(response.total_data);
                        $('#summary_zero_qty').text(response.zero_qty_count);
                    }
                }
            });
        }

        $(document).on("click", ".btn-reset-cycle", function(e) {
            e.stopPropagation();
            var cycle = $(this).data('cycle');
            $('#targetCycleNum').text(cycle);
            $('#resetCycleInput').val(cycle);
            $('#resetPassword').val('');
            $('#resetConfirm').val('');
            $('#cycleDetailModal').modal('show');
        });

        $('#resetCycleForm').on('submit', function(e) {
            e.preventDefault();
            var cycle = $('#resetCycleInput').val();
            var password = $('#resetPassword').val();
            var confirm = $('#resetConfirm').val();
            var createdAt = $('#created_at').val();

            if (password !== '572') {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Wrong Password!', timer: 2000, showConfirmButton: false });
                return;
            }
            if (confirm.toUpperCase() !== 'RESET') {
                Swal.fire({ icon: 'warning', title: 'Error', text: 'Type "RESET" to confirm!', timer: 2000, showConfirmButton: false });
                return;
            }

            $.ajax({
                url: "{{ route('uploadrekapadmp4.resetCycle') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", cycle: cycle, created_at: createdAt },
                success: function(res) {
                    $('#cycleDetailModal').modal('hide');
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Success', text: res.msg }).then(() => {
                            fetchSummary(createdAt);
                            listdetail();
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Failed', text: res.msg });
                    }
                }
            });
        });

        $(document).on("click", "#btn_export_pdf", function() {
            var createdAt = $('#created_at').val();
            if (!createdAt) {
                Swal.fire({ icon: 'warning', title: 'Warning', text: 'No record selected!' });
                return;
            }
            var previewUrl = "{{ route('uploadrekapadmp4.exportPdf') }}?created_at=" + encodeURIComponent(createdAt);
            $('#pdfPreviewFrame').attr('src', previewUrl);
            $('#pdfPreviewModal').modal('show');
        });

        $('#modalDownloadPdf').on('click', function() {
            var createdAt = $('#created_at').val();
            var downloadUrl = "{{ route('uploadrekapadmp4.exportPdf') }}?created_at=" + encodeURIComponent(createdAt) + "&download=1";
            window.location.href = downloadUrl;
        });

        $(document).on("click", ".btn_delete_line", function() {
            var id = $(this).data('id');
            var createdAt = $('#created_at').val();
            Swal.fire({
                title: 'Delete Item?',
                text: "This specific record will be permanently removed!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('uploadrekapadmp4.destroyline') }}",
                        data: { id: id, _token: '{{ csrf_token() }}' },
                        success: function(res) {
                            Swal.fire({ icon: res.success ? 'success' : 'error', title: res.success ? 'Deleted!' : 'Error', text: res.msg, timer: 1500 });
                            fetchSummary(createdAt);
                            listdetail();
                        }
                    });
                }
            });
        });

        $(document).on("click", "#btn_delete", function() {
            var createdAt = $(this).data('id');
            Swal.fire({
                title: 'Delete History?',
                text: "All items in this DN will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('uploadrekapadmp4.destroy') }}",
                        data: { created_at: createdAt, _token: '{{ csrf_token() }}' },
                        success: function(res) {
                            Swal.fire({ icon: res.success ? 'success' : 'error', title: res.success ? 'Deleted!' : 'Error', text: res.msg, timer: 1500 });
                            list();
                        }
                    });
                }
            });
        });

        document.getElementById('fileInput').addEventListener('change', function() {
            document.getElementById('importButton').disabled = !this.files.length;
        });

        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Import DN?',
                text: 'Are you sure you want to import this file?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Import'
            }).then((res) => { if (res.isConfirmed) this.submit(); });
        });
    </script>
@endpush

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
