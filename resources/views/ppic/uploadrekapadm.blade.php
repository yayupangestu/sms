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
        --background: #f1f5f9; /* Darker slate for better contrast */
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

    .content-wrapper {
        background-color: var(--background) !important;
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

        /* Refined List Dictionary Table - Grid Style */
        #example1 {
            width: 100% !important;
            border-collapse: collapse !important;
            border: 1px solid #e2e8f0 !important;
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
            table-layout: fixed !important; /* Force fixed layout for better alignment */
        }

        #example1 thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 0.05em !important;
            padding: 14px 15px !important;
            border: 1px solid #e2e8f0 !important;
            vertical-align: middle !important;
        }

        #example1 tbody td {
            padding: 12px 15px !important;
            vertical-align: middle !important;
            border: 1px solid #e2e8f0 !important; /* Synchronized with header */
            color: #1e293b !important;
            font-size: 13px !important;
            font-weight: 500 !important;
        }

        #example1 tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* DataTables Control Styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 0.4rem 0.8rem !important;
            font-size: 0.85rem !important;
            color: #1e293b !important;
            outline: none !important;
            transition: all 0.2s ease !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 0.85rem !important;
            color: #64748b !important;
            font-weight: 500 !important;
        }

        .dataTables_wrapper .pagination .page-link {
            border-radius: 6px !important;
            margin: 0 2px !important;
            color: #64748b !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            border: 1px solid #e2e8f0 !important;
        }

        .dataTables_wrapper .pagination .page-item.active .page-link {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
            color: white !important;
        }

        /* Action Buttons Refinement */
        .btn-action {
            width: 34px !important;
            height: 34px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 8px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: none !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        .btn-detail-custom {
            background: #f0f9ff !important;
            color: #0ea5e9 !important;
        }
        .btn-detail-custom:hover {
            background: #0ea5e9 !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }

        .btn-delete-custom {
            background: #fef2f2 !important;
            color: #ef4444 !important;
        }
        .btn-delete-custom:hover {
            background: #ef4444 !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }

        #example2 td {
            font-size: 0.85rem;
            color: #444;
            text-align: center !important;
        }

        #example2 td:nth-child(3) {
            text-align: left !important; /* Part Name */
        }

        /* Button Refinement */
        .btn-custom {
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
        }
        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border-radius: 8px;
            border: none;
            transition: all 0.2s;
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
        }
        .btn-outline-custom:hover {
            background: #f1f5f9;
            border-color: var(--secondary);
        }

        /* Modal Refinement */
        .modal-xl { max-width: 98% !important; }
        .modal-content {
            border-radius: 16px !important;
            border: none;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25) !important;
        }

        #example2 { border-collapse: separate !important; border-spacing: 0 !important; width: 100% !important; }
        #example2 tbody td {
            padding: 12px 10px !important;
            border: 1px solid #f1f5f9 !important;
            font-size: 13px !important;
            vertical-align: middle !important;
            color: var(--text-main) !important;
            font-weight: 500;
        }
        #example2 tbody tr:hover { background-color: #f8fafc !important; }

        .cycle-box {
            padding: 8px 6px;
            border-radius: 8px;
            min-width: 80px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }
        .cycle-val { font-size: 15px; font-weight: 700; margin-bottom: 2px; }
        .cycle-sep { margin: 4px 0; border-top: 1px solid rgba(0,0,0,0.08); }
        .created-by-tag { font-size: 11px; font-weight: 600; display: flex; align-items: center; justify-content: center; }

        .btn-qr-custom {
            background-color: #ffffff;
            color: #64748b;
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .btn-qr-custom:hover {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            transform: translateY(-1px);
        }

        /* Refined Works Overview Styles */
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

        /* Stats Styling Re-aligned */
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
        /* Soft Backgrounds */
        .bg-soft-primary { background: #eff6ff; color: #3b82f6; }
        .bg-soft-warning { background: #fffbeb; color: #fbbf24; }
        .bg-soft-success { background: #f0fdf4; color: #22c55e; }

        .stat-content {
            flex-grow: 1;
        }
        .stat-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            margin-bottom: 0.125rem;
        }
        .stat-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
            margin-bottom: 0.125rem;
        }
        .stat-trend {
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .text-trend-up { color: #10b981; }
        .text-trend-down { color: #f59e0b; }

        /* Chart & Legend Refined */
        .chart-legend-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            padding: 0.5rem;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid var(--border);
        }
        .chart-legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            color: var(--text-main);
            font-weight: 500;
        }
        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        /* Separator Line */
        .border-right-lg {
            border-right: 1px solid var(--border);
        }
        @media (max-width: 991.98px) {
            .border-right-lg { border-right: none; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
        }
        /* Activity List - Professional Timeline */
        .activity-list {
            position: relative;
            padding-left: 1.5rem;
        }
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
        .activity-item {
            position: relative;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
        }
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
        .activity-item.urgent::before { border-color: var(--warning); }
        .activity-item.success::before { border-color: var(--success); }

        .activity-label {
            display: block;
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 0.125rem;
        }
        .activity-name {
            display: block;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }
        .activity-name:hover { color: var(--primary); text-decoration: none; }

        .activity-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Tim Prepare Styling */
        .tim-prepare-container {
            margin-top: 0.5rem;
            padding: 0.6rem 0.8rem;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
        }
        .tim-prepare-header {
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.05em;
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tim-team-label {
            font-size: 0.75rem;
            font-weight: 800;
            color: #64748b;
            margin-bottom: 8px;
            display: block;
            text-align: center;
        }
        .tim-member-grid {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            gap: 10px;
            width: 100%;
        }
        .tim-member {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            flex: 1;
        }
        .tim-member i {
            font-size: 2.2rem;
            color: #94a3b8;
            margin-top: 4px;
        }
        .tim-member span {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1e293b;
            white-space: nowrap;
        }
        .tim-member .badge {
            font-size: 0.85rem;
            padding: 4px 8px;
            border-radius: 6px;
            background: #fff;
            color: #1e293b;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Upload Rekap Order Astra Daihatsu Motor (ADM) KAP-1 & 2</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid py-3">
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
                                    <!-- Stats Column -->
                                    <div class="col-lg-5 border-right-lg">
                                        <div class="row">
                                            <!-- Stats Row 1: Total & Done Not Scan -->
                                            <div class="col-md-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-primary">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Total work orders</div>
                                                        <div id="total_work_orders" class="stat-value">0</div>
                                                        <div class="stat-trend text-trend-up">
                                                            <i class="fas fa-arrow-up"></i> 2.1% higher
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-danger" style="background: #fef2f2; color: #ef4444;">
                                                        <i class="fas fa-times-circle"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Done not scan</div>
                                                        <div id="not_scanned_count" class="stat-value">0</div>
                                                        <div class="stat-trend text-trend-down" style="color: #64748b;">
                                                            <i class="fas fa-info-circle"></i> Not yet scanned
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Estimated Works -->
                                            <div class="col-md-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-warning">
                                                        <i class="fas fa-pause"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Estimated Kanban</div>
                                                        <div id="estimated_kanban" class="stat-value">0</div>
                                                        <div class="stat-trend text-trend-down">
                                                            <i class="fas fa-arrow-down"></i> 1.2% completed
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Approved Works -->
                                            <div class="col-md-6 mb-3">
                                                <div class="stat-item">
                                                    <div class="icon-circle-lg bg-soft-success">
                                                        <i class="fas fa-check-double"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <div class="stat-label">Approved works</div>
                                                        <div id="approved_works_count" class="stat-value">0</div>
                                                        <div class="stat-trend text-trend-up">
                                                            <i class="fas fa-arrow-up"></i> 3.5% approved
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tim Prepare Section Moved Below Stats -->
                                            <div class="col-md-12">
                                                <div class="tim-prepare-container">
                                                    <div class="tim-prepare-header">
                                                        <i class="fas fa-users"></i> TIM PREPARE
                                                    </div>
                                                    <div class="row no-gutters">
                                                        <div class="col-6 pr-2 border-right">
                                                            <span class="tim-team-label">PALLET BESI</span>
                                                            <div class="tim-member-grid">
                                                                <div class="tim-member">
                                                                    <span>Slamet <span id="count_Slamet" class="badge badge-light border ml-1">0</span></span>
                                                                    <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                                </div>
                                                                <div class="tim-member">
                                                                    <span>Priono <span id="count_Priono" class="badge badge-light border ml-1">0</span></span>
                                                                    <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 pl-2">
                                                            <span class="tim-team-label text-center">PALLET BOX</span>
                                                            <div class="tim-member-grid">
                                                                <div class="tim-member">
                                                                    <span>Eman <span id="count_Eman" class="badge badge-light border ml-1">0</span></span>
                                                                    <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                                </div>
                                                                <div class="tim-member">
                                                                    <span>Hilman <span id="count_Hilman123" class="badge badge-light border ml-1">0</span></span>
                                                                    <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chart Column -->
                                    <div class="col-lg-4 border-right-lg mt-4 mt-lg-0">
                                        <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                            <div style="position: relative; height: 240px; width: 240px;">
                                                <canvas id="worksOverviewChart"></canvas>
                                                <div id="chartCenterText" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; pointer-events: none;">
                                                    <div id="chartPercent" style="font-size: 3rem; font-weight: 800; color: #1e293b; line-height: 1;">0%</div>
                                                    <div style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-top: 4px;">Done</div>
                                                </div>
                                            </div>
                                            <div class="ml-sm-4 mt-3 mt-sm-0 chart-legend-container">
                                                <!-- Legend generated by JS -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity List Column -->
                                    <div class="col-lg-3 mt-4 mt-lg-0">
                                        <div class="activity-list">
                                            <h6 class="text-uppercase text-muted font-weight-bold mb-3" style="font-size: 0.7rem; letter-spacing: 0.05em;">Recent Actions</h6>

                                            <div class="activity-item">
                                                <span class="activity-label">1 Days Ago</span>
                                                <a href="#" class="activity-name">Prepare Estimate</a>
                                            </div>

                                            <div class="activity-item">
                                                <span class="activity-label">2 Days Ago</span>
                                                <a href="#" class="activity-name">Review Documentation</a>
                                            </div>

                                            <div class="activity-item urgent">
                                                <span class="activity-label text-warning">Action Needed</span>
                                                <a href="#" class="activity-name">Identify Planner</a>
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
                                       LIST PO ADM
                                    </h5>

                                    <div class="import-section mt-2 mt-md-0">
                                        <form id="importForm" action="{{ route('importRekapadm') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
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
                                <div class="table-container">
                                    <table id="example1" class="table table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="60">No</th>
                                                <th>Tanggal DN</th>
                                                <th>Arrival 1</th>
                                                <th>Arrival 2</th>
                                                <th width="120">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <!-- Data dinamis akan dimuat di sini -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="myModal2">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center py-3 px-4">
                        <h4 class="modal-title" id="title1">LIST ITEM DN</h4>
                        <button type="button" class="btn btn-outline-custom btn-sm px-3" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Close
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-12" id="alert"></div>
                            <div class="col-sm-6 d-flex align-items-center">
                                <input type="hidden" id="created_at" name="created_at">
                                <button id="saveChanges" class="btn btn-primary shadow-sm mr-2">Save Changes</button>
                                <button id="btn_export_pdf" class="btn btn-danger shadow-sm"><i class="fas fa-file-pdf mr-2"></i>Export / Review PDF</button>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-end">
                                <div class="d-flex align-items-center bg-white border rounded px-3 py-1 shadow-sm" style="min-width: 200px;">
                                    <div class="text-center mr-3 pr-3 border-right">
                                        <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Total Data</div>
                                        <div id="summary_total_data" class="h5 mb-0 font-weight-bold text-primary">-</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Cycle 1-9 (Qty 0)</div>
                                        <div id="summary_zero_qty" class="h5 mb-0 font-weight-bold text-danger">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="20">No</th>
                                    <th>NO DN</th>
                                    <th>PART NAME</th>
                                    <th>PART NO</th>
                                    <th>JOB NO</th>
                                    <th>QTY KANBAN</th>
                                    <th>CYCLE DATE</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                    <th>8</th>
                                    <th>9</th>
                                    <th width="50">Action</th>
                                </tr>
                                <tr>
                                    <th colspan="7" class="bg-white border-0" style="background: #fff !important;"></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="1"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="2"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="3"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="4"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="5"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="6"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="7"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="8"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="text-center p-1 bg-white border-0" style="background: #fff !important;"><button class="btn btn-xs btn-primary btn-block btn-cycle-detail" data-cycle="9"><i class="fas fa-info-circle"></i></button></th>
                                    <th class="bg-white border-0" style="background: #fff !important;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data tabel akan diisi di sini -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Small Cycle Detail Modal -->
    <div class="modal fade" id="cycleDetailModal">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title font-weight-bold" style="font-size: 1rem;">Cycle Detail</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-3">
                    <div id="cycleDetailContent" class="text-center">
                        <p class="mb-3 font-weight-bold">Reset Qty Order for Cycle <span id="targetCycleNum"></span></p>
                        <form id="resetCycleForm">
                            <input type="hidden" id="resetCycleInput">
                            <div class="form-group">
                                <input type="password" class="form-control text-center" id="resetPassword" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control text-center" id="resetConfirm" placeholder="Type 'RESET' to overwrite">
                            </div>
                            <button type="submit" class="btn btn-danger btn-block font-weight-bold shadow-sm">
                                <i class="fas fa-exclamation-triangle mr-2"></i>RESET CYCLE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PDF Preview (Print View style) -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-xl" style="max-width: 90% !important;">
            <div class="modal-content shadow-lg border-0" style="height: 90vh;">
                <div style="background: #343a40 !important;" class="modal-header text-white py-2 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-file-pdf mr-2"></i>PREVIEW REKAP ORDER ADM</h5>
                    <div>
                        <button id="modalDownloadPdf" class="btn btn-success btn-sm mr-2 shadow-sm"><i class="fas fa-download mr-1"></i>Download PDF</button>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body p-0 bg-secondary" style="height: calc(100% - 40px);">
                    <iframe id="pdfPreviewFrame" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="created_at">
@endsection

@push('scripts')
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
                    url: "{{ route('uploadrekapadm.getChartData') }}",
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

                            // Update Legend
                            var legendHtml = '';
                            response.labels.forEach((label, index) => {
                                var color = response.colors[index];
                                var value = response.data[index];
                                legendHtml += `
                                    <div class="chart-legend-item">
                                        <span class="legend-dot" style="background-color: ${color};"></span>
                                        <span>${label}: <strong>${value}</strong></span>
                                    </div>
                                `;
                            });
                             $('.chart-legend-container').html(legendHtml);

                            // Update Stats - Re-aligned side-by-side
                            $('#total_work_orders').text(response.total_works || 0);
                            $('#not_scanned_count').text(response.not_scanned_count || 0);
                            $('#estimated_kanban').text(response.pending_works || 0);
                            $('#approved_works_count').text(response.approved_works || 0);
                        }
                    }
                });
            }

            // Initial Load
            updateChart();
            list();

            // Update on filter change
            $('#cycleArrivalFilter').on('change', function() {
                updateChart();
                // Table reload removed as requested
                // $('#example1').DataTable().ajax.reload();
            });
        });
    </script>
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
        $(document).on("click", "#btn_export_pdf", function() {
            var createdAt = $('#created_at').val();
            if (!createdAt) {
                Swal.fire({ icon: 'warning', title: 'Warning', text: 'No record selected!' });
                return;
            }

            // Set iframe source to PDF Stream URL
            var previewUrl = "{{ route('uploadrekapadm.exportPdf') }}?created_at=" + encodeURIComponent(createdAt);
            $('#pdfPreviewFrame').attr('src', previewUrl);

            // Show Modal
            $('#pdfPreviewModal').modal('show');
        });

        // Handle Direct Download from Preview Modal
        $('#modalDownloadPdf').on('click', function() {
            var createdAt = $('#created_at').val();
            var downloadUrl = "{{ route('uploadrekapadm.exportPdf') }}?created_at=" + encodeURIComponent(createdAt) + "&download=1";
            window.location.href = downloadUrl;
        });


        function list() {
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 10,
                order: [[1, 'desc']], // Sort by Date Created Descending
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "{{ route('uploadrekapadm.list') }}",
                },
                columns: [{
                        data: null,
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        className: 'text-center align-middle',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'arrival1',
                        name: 'arrival1',
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'arrival2',
                        name: 'arrival2',
                        className: 'text-center align-middle'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center align-middle',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return '<div class="d-flex justify-content-center">' +
                                '<a href="#" id="btn_edit" title="Detail" data-id="' + data +
                                '" class="btn-action btn-detail-custom mx-1">' +
                                '<i class="fas fa-search"></i>' +
                                '</a>' +
                                '<a href="#" id="btn_delete" title="Delete" data-id="' + data +
                                '" class="btn-action btn-delete-custom mx-1">' +
                                '<i class="far fa-trash-alt"></i>' +
                                '</a>' +
                                '</div>';
                        }
                    }
                ],
                drawCallback: function() {
                    $(this).find('thead th').css('width', ''); // Reset th width to let DataTables calculate
                },
                columnDefs: [{
                    "targets": [0],
                    "orderable": false,
                }],
                autoWidth: false,
                scrollX: false, // Disabled scrollX as it conflicts with table-layout: fixed
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                }
            });

            // Adjust columns on window resize and sidebar toggle
            $(window).on('resize', function() {
                table.columns.adjust();
            });

            $('[data-widget="pushmenu"]').on('click', function() {
                setTimeout(function() {
                    table.columns.adjust();
                }, 300); // Wait for sidebar animation to finish
            });

            $(document).on('collapsed.lte.pushmenu shown.lte.pushmenu', function() {
                setTimeout(function() {
                    table.columns.adjust();
                }, 300);
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
                orderCellsTop: true,
                ajax: {
                    url: "{{ route('uploadrekapadm.listdetail') }}",
                    data: function(d) {
                        d.created_at = $('#created_at').val();
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
                    { data: 'doc_dn', name: 'doc_dn' },
                    { data: 'part_name', name: 'part_name' },
                    { data: 'part_no', name: 'part_no' },
                    { data: 'job_no', name: 'job_no' },
                    { data: 'qty_kanban', name: 'qty_kanban' },
                    {
                        data: 'cycle_arrival',
                        name: 'cycle_arrival',
                        className: 'text-center',
                        render: function(data) {
                            if (!data) return '-';
                            let today = new Date();
                            today.setHours(0,0,0,0);
                            let arrival = new Date(data);
                            arrival.setHours(0,0,0,0);

                            let bg = '';
                            let color = 'inherit';
                            if (arrival.getTime() === today.getTime()) {
                                bg = '#28a745'; // Hijau
                                color = '#fff';
                            } else if (arrival < today) {
                                bg = '#ff6b6b'; // Merah smooth
                                color = '#fff';
                            }

                            return `<span class="badge" style="background-color: ${bg}; color: ${color}; font-size: 14px; padding: 5px 10px;">${data}</span>`;
                        }
                    },
                    {
                        data: 'cycle1',
                        name: 'cycle1',
                        render: function(d, type, row){
                            if(row.cycle != 1 && row.cycle != '1') return '';
                            let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981';
                            let tp = (row.type_pallet || '').toUpperCase();
                            if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; }
                            else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; }
                            let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : '';
                            let op = d > 0 ? `<div class="cycle-val">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`;
                        }
                    },
                    { data: 'cycle2', name: 'cycle2', render: function(d, type, row){ if(row.cycle != 2 && row.cycle != '2') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle3', name: 'cycle3', render: function(d, type, row){ if(row.cycle != 3 && row.cycle != '3') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle4', name: 'cycle4', render: function(d, type, row){ if(row.cycle != 4 && row.cycle != '4') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle5', name: 'cycle5', render: function(d, type, row){ if(row.cycle != 5 && row.cycle != '5') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle6', name: 'cycle6', render: function(d, type, row){ if(row.cycle != 6 && row.cycle != '6') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle7', name: 'cycle7', render: function(d, type, row){ if(row.cycle != 7 && row.cycle != '7') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle8', name: 'cycle8', render: function(d, type, row){ if(row.cycle != 8 && row.cycle != '8') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    { data: 'cycle9', name: 'cycle9', render: function(d, type, row){ if(row.cycle != 9 && row.cycle != '9') return ''; let bg = '', txt = '', hr_c = 'rgba(0,0,0,0.1)', cbc = '#10b981'; let tp = (row.type_pallet || '').toUpperCase(); if(tp == 'BOX'){ bg = '#eff6ff'; txt = '#1e40af'; } else if(tp == 'BESI'){ bg = '#1e293b'; txt = '#f8fafc'; hr_c = 'rgba(255,255,255,0.2)'; cbc = '#34d399'; } let st = bg ? `style="background-color: ${bg}; color: ${txt};"` : ''; let op = d > 0 ? `<div class="cycle-val">${d}</div>` : ''; let cp = row.createdby ? `<div class="created-by-tag" style="color: ${cbc};"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : ''; return `<div class="cycle-box shadow-sm" ${st}>${op}${(op && cp ? `<hr class="cycle-sep" style="border-top-color: ${hr_c}">` : '')}${cp}</div>`; } },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `<a href="#" id="btn_pdf" title="Generate QR" data-id="${data}" class="btn-qr-custom shadow-sm">
                                <i class="fas fa-solid fa-qrcode"></i>
                                </a>`;
                        }
                    },
                ],
                columnDefs: [{
                    "targets": [0],
                    "orderable": false,
                }],
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: true,
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}"> Loading...'
                }
            });
        }



        $('#saveChanges').on('click', function() {
            let dataToSend = [];

            $('.actual-sheet').each(function() {
                let actualSheet = $(this).val();
                let id = $(this).data('id');

                dataToSend.push({
                    id: id,
                    actual_sheet: actualSheet
                });
            });

            // Send the data to the server via AJAX
            $.ajax({
                url: "{{ route('uploadrekapadm.update') }}", // Your update route here
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // Include CSRF token for security
                    data: dataToSend
                },
                success: function(response) {
                    // Handle success with SweetAlert
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Data berhasil diperbarui.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error with SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memperbarui data: ' + error,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });

        // Menyimpan referensi ke elemen
        const fileInput = document.getElementById('fileInput');
        const importButton = document.getElementById('importButton');

        // Menonaktifkan tombol jika tidak ada file yang dipilih
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                importButton.disabled = false; // Aktifkan tombol jika ada file yang dipilih
            } else {
                importButton.disabled = true; // Nonaktifkan tombol jika tidak ada file
            }
        });

        // Aktifkan tombol saat file dipilih
        document.getElementById('fileInput').addEventListener('change', function() {
            document.getElementById('importButton').disabled = !this.files.length;
        });

        // Konfirmasi sebelum submit form
        document.getElementById('importForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Cegah submit otomatis

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengimpor DN?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, impor!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit jika konfirmasi
                }
            });
        });

        // ✅ Toast sukses → background hijau + teks putih
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                background: '#28a745', // hijau
                color: '#fff', // teks putih
                customClass: {
                    title: 'swal-text-white',
                    popup: 'swal-popup-white',
                    icon: 'swal-icon-white'
                }
            });
        @endif

        // ✅ Toast error
        @if (session('error'))
            @php
                $msg = session('error');
                $isK1K2Error = str_contains($msg, 'K1') || str_contains($msg, 'K2');
            @endphp

            Swal.fire({
                icon: '{{ $isK1K2Error ? 'info' : 'error' }}',
                title: '{{ $isK1K2Error ? 'No DN tidak valid' : 'Gagal' }}',
                text: '{{ $msg }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                background: '{{ $isK1K2Error ? '#17a2b8' : '#dc3545' }}',
                color: '#fff',
                customClass: {
                    title: 'swal-text-white',
                    popup: 'swal-popup-white',
                    icon: 'swal-icon-white'
                }
            });
        @endif

        $(document).on("click", "#btn_edit", function() {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var created_at = id;

            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('#created_at').val(created_at);

            fetchSummary(created_at);
            listdetail();
        });

        function fetchSummary(createdAt) {
            $.ajax({
                url: "{{ route('uploadrekapadm.getSummary') }}",
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

        // ✅ Precision alignment trigger
        $('#myModal2').on('shown.bs.modal', function() {
            var table = $('#example2').DataTable();
            table.columns.adjust();
        });

        // ✅ Resize Recalculation (Fix Zoom Issue)
        $(window).on('resize', function() {
            var table = $('#example2').DataTable();
            table.columns.adjust();
        });

        // ✅ Cycle Small Modal Trigger
        $(document).on("click", ".btn-cycle-detail", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var cycle = $(this).data('cycle');
            $('#targetCycleNum').text(cycle);
            $('#resetCycleInput').val(cycle); // Set hidden input
            $('#resetPassword').val(''); // Clear password
            $('#resetConfirm').val(''); // Clear confirmation
            $('#cycleDetailModal').modal('show');
        });

        // ✅ Handle Reset Submission
        $('#resetCycleForm').on('submit', function(e) {
            e.preventDefault();

            var cycle = $('#resetCycleInput').val();
            var password = $('#resetPassword').val();
            var confirm = $('#resetConfirm').val();
            var createdAt = $('#created_at').val(); // Get current batch filter

            // Validation
            if (password !== '572') {
                Swal.fire({
                    icon: 'error',
                    title: 'Access Denied',
                    text: 'Incorrect Password!',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            if (confirm !== 'RESET') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Confirmation',
                    text: 'Please type "RESET" to confirm overwrite.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            // Proceed with AJAX
            $.ajax({
                url: "{{ route('uploadrekapadm.resetCycle') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cycle: cycle,
                    created_at: createdAt
                },
                success: function(response) {
                    $('#cycleDetailModal').modal('hide');
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.msg,
                            showConfirmButton: true
                        }).then(() => {
                            fetchSummary(createdAt);
                            listdetail(); // Refresh table
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: response.msg
                        });
                    }
                },
                error: function(xhr) {
                    $('#cycleDetailModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        });

        $(document).on("click", "#btn_delete", function() {
            var id = $(this).data('id');
            var created_at = id;
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
                        url: "{{ route('uploadrekapadm.destroy') }}",
                        data: {
                            created_at: created_at,
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
    </script>
@endpush

@push('stylesheets')
    <style>
        .swal2-popup.swal-popup-white { border-radius: 12px !important; }
        .swal2-title.swal-text-white { color: #fff !important; }
    </style>
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

