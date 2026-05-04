@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        /* ============================================================
                       GLOBAL PAGE BACKGROUND & THEME
                    ============================================================ */
        section.content {
            background: linear-gradient(to bottom, #003366 0%, #ffffff 100%) !important;
            padding: 30px 20px;
            min-height: 100vh;
        }

        /* ============================================================
                       CARD STYLE – Modern & Clean
                    ============================================================ */
        .card {
            background: #ffffff;
            border-radius: 16px;
            border: none;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header {
            background: #ffffff !important;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 25px;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #003366;
            letter-spacing: -0.5px;
        }

        /* Button in header */
        .card-tools .btn {
            border-radius: 8px;
        }

        /* Reset card header overrides */
        .card-header.btn-success,
        .card-header {
            background-color: #ffffff !important;
        }

        /* ============================================================
                       TABLE STYLE – ERP Look
                    ============================================================ */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table thead th {
            background: #003366;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            padding: 16px 12px;
            border: none;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 10px;
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #ececec;
            color: #333;
        }

        .table tbody tr:hover {
            background: #f8f8f8;
        }

        /* Table striping */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #fbfbfb;
        }

        /* ============================================================
                       BUTTON STYLING – Clean / Corporate
                    ============================================================ */
        .btn {
            border-radius: 6px !important;
            font-weight: 500;
        }

        .btn-success {
            background-color: #003366;
            border-color: #003366;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 51, 102, 0.2);
        }

        .btn-success:hover {
            background-color: #004080;
            border-color: #004080;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-warning {
            background: #dcb676;
            border-color: #dcb676;
            color: #fff;
        }

        .btn-warning:hover {
            background: #c9a161;
        }

        .btn-secondary {
            background: #b4b4b4;
            border-color: #b4b4b4;
        }

        /* ============================================================
                       MODAL – ERP Style
                    ============================================================ */
        .modal-content {
            border-radius: 10px;
            border: 1px solid #dddddd;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.07);
        }

        .modal-header {
            background: #f3f3f3 !important;
            border-bottom: 1px solid #dddddd;
        }

        .modal-title {
            font-weight: 600;
            color: #3a3a3a;
        }

        .modal-body {
            background: #fff;
        }

        /* Form input */
        .form-control,
        .select2 {
            border: 1px solid #cfcfcf !important;
            border-radius: 6px !important;
        }

        .form-control:focus,
        .select2:focus {
            border-color: #8f8f8f !important;
            box-shadow: none !important;
        }

        /* Label */
        .col-form-label {
            font-weight: 600;
            color: #3a3a3a;
        }

        /* ============================================================
                       STATUS COLORS (lebih profesional)
                    ============================================================ */
        .status-waiting-leader {
            background-color: #e0e7ff !important;
            color: #333 !important;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .status-storeroom {
            background-color: #fff3c4 !important;
            color: #333 !important;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .status-approved {
            background-color: #d4f1ff !important;
            color: #333 !important;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .status-approved2 {
            background-color: #d9f7d9 !important;
            color: #333 !important;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .status-approved3 {
            background-color: #ccf7ef !important;
            color: #333 !important;
            padding: 4px 10px;
            border-radius: 8px;
        }

        /* ============================================================
                       SWEET ALERT TOAST – Corporate Colors
                    ============================================================ */
        .swal2-toast {
            border-radius: 8px !important;
            background-color: #f5f5f5 !important;
            color: #333 !important;
            border: 1px solid #dcdcdc;
        }

        .swal2-toast-custom-success {
            background-color: #4caf50 !important;
            color: #fff !important;
        }

        .swal2-popup.swal2-toast.colored-toast {
            background-color: #d7ffd7 !important;
            color: #256029 !important;
        }

        ////

        /* Section titles and spacing */
        .form-section {
            height: 100%;
            margin-bottom: 25px;
            padding: 24px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Header clean ERP */
        .custom-modal-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-modal-header h4 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        /* Category Filter Cards Styling */
        .category-filter-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 20px;
            background: #fdfdfd;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .category-cards-container {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .category-card {
            background: #ffffff;
            border: 1.5px solid #edf2f7;
            border-radius: 10px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .category-card:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .category-card.active {
            background: #003366;
            border-color: #003366;
            color: white;
            box-shadow: 0 8px 20px rgba(0, 51, 102, 0.3);
        }

        .category-card .card-icon {
            font-size: 18px;
            opacity: 0.9;
        }

        .category-card.active .card-icon {
            opacity: 1;
        }

        .category-card .card-text {
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Custom Search Styling */
        .search-wrapper {
            position: relative;
            flex-grow: 1;
            max-width: 400px;
        }

        .search-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-wrapper .form-control {
            padding-left: 42px;
            height: 48px;
            border-radius: 24px !important;
            border: 1.5px solid #edf2f7;
            background: #ffffff;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .search-wrapper .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1) !important;
        }

        /* Form */
        /* Label sedikit lebih besar dan ada jarak */
        .form-label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px !important;
            /* jarak label ke input */
        }

        /* Membuat input besar
                        .form-control.input-big,
                        .select2-container .select2-selection--single {
                            height: 50px !important;
                            font-size: 16px !important;
                            padding: 10px 14px !important;
                        } */

        /* Supaya tulisan select2 mengikuti tinggi */
        /* .select2-selection__rendered {
                            line-height: 48px !important;
                        } */
        /* .select2-selection__arrow {
                            height: 48px !important;
                        } */

        /* Kasih jarak antar kolom input */
        .mb-3 {
            margin-bottom: 20px !important;
        }

        /* Table ERP Style */
        .table-bordered th {
            background: #f3f3f3;
            font-weight: 600;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dcdcdc !important;
        }

        /* Buttons */
        .btn-success {
            background: #003366;
            border-color: #003366;
        }

        .btn-warning {
            background: #dcb676;
            border-color: #dcb676;
            color: white;
        }


        .label-required::after {
            content: " *";
            color: red;
            font-weight: bold;
            font-size: 20px;
            /* 🔥 ukuran lebih besar */
            line-height: 1;
        }

        input[type="file"] {
            padding: 6px !important;
            background: #fafafa;
            border: 2px solid #000000 !important;
            border-radius: 6px !important;
        }


        /* Clean modern info box */
        .clean-box {
            background: #ffffff;
            border-radius: 16px;
            min-height: 110px;
            display: flex;
            align-items: center;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 10px;
        }

        .clean-box:hover {
            transform: translateY(-5px);
            box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Icon style */
        .clean-icon {
            border-radius: 12px !important;
            width: 70px !important;
            height: 70px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Texts */
        .info-box-text {
            font-size: 15px;
            font-weight: 600;
            color: #555;
        }

        .info-box-number {
            font-size: 20px;
            font-weight: 700;
            margin-top: 4px;
            color: #222;
        }

        .info-box-number small {
            font-size: 14px;
        }


        .progress-wrapper {
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            height: 18px;
            position: relative;
        }

        .progress-bar-custom {
            height: 100%;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            color: #fff;
            line-height: 18px;
            transition: width .4s ease;
        }

        .progress-green {
            background: #28a745;
        }

        .progress-yellow {
            background: #ffc107;
            color: #000;
        }

        .progress-red {
            background: #dc3545;
        }
        /* =========================================
           IMPROVED FORM STYLING (NEW)
           ========================================= */
        .modal-body {
            background-color: #f8f9fa;
            padding: 25px;
        }

        .form-section {
            background: #ffffff;
            padding: 24px; /* increased padding */
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            margin-bottom: 24px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            position: relative;
        }

        .form-section-title {
            font-size: 18px; /* Increased from 14px */
            font-weight: 700;
            color: #003366; /* Match theme blue */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            font-size: 20px; /* Increased icon */
        }

        .form-label {
            font-size: 16px; /* Increased from 13px */
            font-weight: 600;
            color: #444; /* Darker for contrast */
            margin-bottom: 8px !important;
        }

        .label-required::after {
            content: "*";
            color: #dc3545;
            margin-left: 3px;
            font-size: 18px;
        }

        .form-control, .form-select, .select2-container .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 8px !important;
            padding: 10px 14px;
            font-size: 16px; /* Increased from 14px */
            height: auto;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus, .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #003366 !important;
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1) !important;
        }

        .select2-container .select2-selection--single {
             height: 48px !important; /* Increased height */
             padding: 8px 14px !important; /* Adjusted padding */
             display: flex;
             align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
        }

        textarea.form-control {
            border-radius: 8px !important;
            resize: vertical;
        }

        /* Button styling fix */
        .modal-footer-custom {
            /* border-top: 1px solid #e9ecef; */
            padding-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-save-custom {
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            color: white;
            padding: 12px 36px; /* Larger button */
            font-size: 16px; /* Larger text */
            box-shadow: 0 4px 15px rgba(0, 51, 102, 0.3);
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .btn-save-custom:hover {
            background: linear-gradient(135deg, #004080 0%, #002244 100%);
            transform: translateY(-1px);
            color: #fff;
        }

        /* FORCE MODAL TO BE ULTRA WIDE - MOVED TO ENSURE PRECEDENCE */
        body .modal-dialog.modal-xl {
            width: 95vw !important;
            max-width: 1800px !important;
            margin: 1.5rem auto !important;
        }

        #myModal2 .modal-content {
            border-radius: 12px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5) !important;
            border: none;
            min-height: 85vh;
        }

        #myModal2 .modal-body {
            padding: 2rem 3.5rem !important;
        }


    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Kerja Harian DIE MTC</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <div class="col-6 col-md-3 mb-3">
                <div class="info-box clean-box">
                    <span class="info-box-icon clean-icon bg-warning">
                        <i class="fas fa-server"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">LIST DIES</span>
                        <span class="info-box-number">{{ $TotalDies }}</span>

                        <button class="btn btn-sm btn-default mt-2" onclick="showDiesList()">
                            LIHAT LIST
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="info-box clean-box">
                    <span class="info-box-icon clean-icon bg-warning">
                        <i class="fas fa-server"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">LIST DIES AKAN PREVENTIVE</span>
                        <span class="info-box-number">{{ $TotalStrokeKurang }}</span>
                        <button class="btn btn-sm btn-default mt-2" data-toggle="modal" data-target="#modalStroke">
                            LIHAT LIST
                        </button>
                    </div>
                </div>
            </div>
            <!-- <div class="col-6 col-md-3 mb-3">
                <div class="info-box clean-box">
                    <span class="info-box-icon clean-icon bg-danger">
                        <i class="fas fa-server"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">HISTORY LKH</span>
                        <span class="info-box-number">{{ $TotalHistory }}</span>
                        <button class="btn btn-sm btn-default mt-2" onclick="location.reload()">
                            REFRESH
                        </button>
                    </div>
                </div>
            </div> -->


            <div class="col-6 col-md-3 mb-3">
                <div class="info-box clean-box">
                    <span class="info-box-icon clean-icon bg-success">
                        <i class="fas fa-server"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">HISTORY LKH</span>
                        <span class="info-box-number">{{ $TotalDies }}</span>
                        <button class="btn btn-sm btn-default mt-2" data-toggle="modal" data-target="#modalStroke2">
                            LIHAT LIST
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <section class="content" style="background-color: rgb(130, 129, 129)">
        {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: rgb(97, 255, 113)">
                        <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">ListLaporan Kerja
                                Harian DIE MTC</b></h3>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- CATEGORY FILTER & SEARCH HEADER -->
                        <div class="category-filter-wrapper">
                            <div class="category-cards-container">
                                <div class="category-card active" data-category="ALL">
                                    <i class="fas fa-list card-icon"></i>
                                    <span class="card-text">ALL DATA</span>
                                </div>
                                <div class="category-card" data-category="PREVENTIVE">
                                    <i class="fas fa-shield-alt card-icon"></i>
                                    <span class="card-text">PREVENTIVE</span>
                                </div>
                                <div class="category-card" data-category="CORRECTIVE">
                                    <i class="fas fa-tools card-icon"></i>
                                    <span class="card-text">CORRECTIVE</span>
                                </div>
                                <div class="category-card" data-category="IMPROVEMENT">
                                    <i class="fas fa-rocket card-icon"></i>
                                    <span class="card-text">IMPROVEMENT</span>
                                </div>
                            </div>

                            <div class="search-wrapper">
                                <i class="fas fa-search"></i>
                                <input type="text" id="customSearch" class="form-control" placeholder="Cari data laporan...">
                            </div>
                        </div>

                        <table id="example1" class="table table-hover table-bordered">
                            <thead class="table" style="background-color: #c0bcbcf8">
                                <tr>
                                    <th width="50">No</th>
                                    <th>DOC JOB</th>
                                    <th>CATEGORY</th>
                                    <th>PART NO</th>
                                    <th>DATE</th>
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
    </section>

    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header custom-modal-header">
                    <h4 class="modal-title" id="title1">Form Laporan Kerja DIE MTC - Add</h4>
                    <h4 class="modal-title" id="title2">Form Laporan Kerja DIE MTC- Edit</h4>

                    <div class="ml-auto d-flex gap-1">
                        <!-- Tombol SAVE -->
                        <button type="button" class="btn btn-success btn-sm" id="btnReload">
                            <i class="fa fa-sync mr-1"></i> Refresh
                        </button>

                        <!-- Tombol CLOSE -->
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>


                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="alert"></div>
                    </div>

                    <!-- FORM CONTAINER GRID 2 COLUMNS -->
                    <div class="row">

                        <!-- LEFT COLUMN -->
                        <div class="col-lg-6">

                            <!-- SECTION 1: INFO UMUM -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="far fa-calendar-alt"></i> Informasi Umum
                                </div>
                                <div class="row g-3">
                                    <!-- DATE PLAN -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">Date</label>
                                        <input type="hidden" id="id" class="form-control">
                                        <input type="text" id="date_plan" class="form-control" required placeholder="Pilih Tanggal">
                                    </div>

                                     <!-- LINE -->
                                     <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">LINE</label>
                                        <select id="line_id" class="form-control" required>
                                            <option value="">- pilih -</option>
                                          <option value="">- pilih -</option>
                                            <option value="LINE A1">LINE A1</option>
                                            <option value="LINE A2">LINE A2</option>
                                            <option value="LINE B1">LINE B1</option>
                                            <option value="LINE B2">LINE B2</option>
                                            <option value="LINE B3">LINE B3</option>
                                            <option value="LINE C1">LINE C2</option>
                                            <option value="LINE C2">LINE C1</option>
                                            <option value="AMINO">LINE AMINO</option>
                                            <option value="FUKUI">LINE FUKUI</option>
                                            <option value="KOMATSU">LINE KOMATSU</option>
                                              <option value="TRANSFERS">LINE TRANSFERS</option>
                                               <option value="AREA">AREA</option>
                                        </select>
                                    </div>

                                     <!-- PIC -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">PIC</label>
                                        <select id="pic" class="form-control select2" multiple="multiple" style="width: 100%;" required>
                                            <option value="Heru S">Heru S</option>
                                            <option value="Agung P">Agung P</option>
                                            <option value="Sutisna W">Sutisna W</option>
                                            <option value="Deni S">Deni S</option>
                                            <option value="Syifa T">Syifa T</option>
                                            <option value="Agus">Agus P</option>
                                            <option value="Fateh R">Fateh R</option>
                                            <option value="Ibnu M">Ibnu M</option>
                                            <option value="Wima Adi">Wima Adi</option>
                                            <option value="Endang T">Endang T</option>
                                            <option value="Herman S">Herman S</option>
                                            <option value="Danang">Danang</option>
                                        </select>
                                    </div>

                                    <!-- CATEGORY -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">Kategori</label>
                                        <select id="category" class="form-control" required>
                                            <option value="">- pilih -</option>
                                            <option value="CORRECTIVE">CORRECTIVE</option>
                                            <option value="PREVENTIVE">PREVENTIVE</option>
                                            <option value="IMPROVEMENT">IMPROVEMENT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 2: PART & PROCESS -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-cogs"></i> Detail Part & Proses
                                </div>
                                <div class="row g-3">
                                    <!-- JOB / PART -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label label-required">JOB NO / PART NO</label>
                                        <select id="product_id" class="form-control select2" style="width:100%" required>
                                            <option value="">- Cari Part / Job -</option>
                                        </select>
                                    </div>

                                     <!-- PROSES -->
                                     <div class="col-md-12 mb-3">
                                         <label class="form-label label-required">Proses</label>
                                       <select id="proses" class="form-control" required>
                                            <option value="">- pilih -</option>
                                            <option value="OP-10">OP-10</option>
                                            <option value="OP-20">OP-20</option>
                                            <option value="OP-30">OP-30</option>
                                            <option value="OP-40">OP-40</option>
                                            <option value="OP-50">OP-50</option>
                                            <option value="OP-60">OP-60</option>
                                            <option value="OP-70">OP-70</option>
                                        </select>
                                    </div>

                                     <!-- STANDARD PART -->
                                     <div class="col-md-12 mb-3">
                                        <label class="form-label">Standart Part yang Digunakan</label>
                                        <input type="text" id="standard_part" class="form-control"
                                            placeholder="Tuliskan part std yang digunakan (jika ada)">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-lg-6">

                             <!-- SECTION 3: MASALAH & PENANGGULANGAN -->
                             <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-tools"></i> Masalah & Penanggulangan
                                </div>
                                 <div class="row g-3">
                                     <!-- PROBLEM -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label label-required">PROBLEM</label>
                                        <textarea id="problem" class="form-control" rows="3" placeholder="Deskripsikan masalah secara detail..." required></textarea>
                                    </div>

                                    <!-- TINDAKAN -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label label-required">PENANGGULANGAN</label>
                                        <textarea id="tindakan" class="form-control" rows="3" placeholder="Langkah perbaikan yang dilakukan..."></textarea>
                                    </div>
                                 </div>
                             </div>

                            <!-- SECTION 4: WAKTU & REMARKS -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-clock"></i> Downtime & Catatan
                                </div>
                                <div class="row g-3">
                                     <!-- DOWNTIME START -->
                                     <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">Start</label>
                                        <input type="text" id="dt_start" class="form-control bg-white" required placeholder="00:00">
                                    </div>

                                    <!-- DOWNTIME FINISH -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">Finish</label>
                                        <input type="text" id="dt_finish" class="form-control bg-white" required placeholder="00:00">
                                    </div>

                                    <!-- REMARKS -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Remarks</label>
                                        <textarea id="remarks" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- TOMBOL ACTION -->
                    <div class="modal-footer-custom">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-save-custom Save">
                            <i class="fas fa-save mr-2"></i> Simpan Laporan
                        </button>
                    </div>

                </div>


                    <!-- TABLE LIST -->
                    <div class="mt-4">
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Job No</th>
                                        <th>Part No</th>
                                        <th>Model</th>
                                        <th>Line</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <input type="hidden" id="job_no" name="job_no">
    <input type="hidden" id="part_no" name="part_no">
    <input type="hidden" id="model_id" name="model_id">
    <input type="hidden" id="doc_job" name="doc_job">

    <div class="modal fade" id="ModalFoto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Foto</h5>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Close
                    </button>
                </div>

                <div class="modal-body">
                    <div style="display:flex; gap:20px;">
                        <img id="img_awal" style="width:45%; border:1px solid #000000;">
                        <img id="img_akhir" style="width:45%; border:1px solid #000000;">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalStroke" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">List Dies Kurang Stroke</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <table id="tableStroke1" class="table table-bordered table-sm w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>Part No</th>
                                <th>Std Stroke</th>
                                <th>Jml Stroke</th>
                                <th>Progress (%)</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($StrokeList as $row)
                                <tr>
                                    <td>{{ $row->part_no }}</td>
                                    <td>{{ $row->std_stroke }}</td>
                                    <td>{{ $row->jml_stroke }}</td>
                                    <td class="font-weight-bold">
                                        {{ $row->persen_progress }}%
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm btn-history"
                                                data-part_no="{{ $row->part_no }}"
                                                title="History LKH">
                                            <i class="fas fa-history"></i> History
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalStroke2" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">List Dies Over Stroke</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <table id="tableStroke2" class="table table-bordered table-sm w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>Part No</th>
                                <th>Std Stroke</th>
                                <th>Jml Stroke</th>
                                <th>Progress (%)</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($StrokeList2 as $row)
                                <tr>
                                    <td>{{ $row->part_no }}</td>
                                    <td>{{ $row->std_stroke }}</td>
                                    <td>{{ $row->jml_stroke }}</td>
                                    <td class="font-weight-bold">
                                        {{ $row->persen_progress }}%
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm btn-history"
                                                data-part_no="{{ $row->part_no }}"
                                                title="History LKH">
                                            <i class="fas fa-history"></i> History
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL 1 --}}
    <div class="modal fade" id="modalDies" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title">LIST DIES</h5>

                    <div>
                        <button id="btnRefreshStroke" class="btn btn-sm btn-primary">
                            <i class="fas fa-sync-alt"></i> Refresh Stroke
                        </button>

                        <button type="button" class="btn-close ms-2" data-bs-dismiss="modal"></button>
                    </div>
                </div>


                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tableDies" class="table table-bordered table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Part Name</th>
                                    <th>Part No</th>
                                    <th>Job No</th>
                                    <th>Model</th>
                                    <th>Line</th>
                                    <th>Std Stroke</th>
                                    <th>Actual Stroke</th>
                                    <th>Progress (%)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal History -->
    <div class="modal fade" id="modalHistory" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-history mr-2"></i>History LKH - <span id="historyPartNo"></span></h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tableHistory" class="table table-bordered table-hover w-100">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Problem</th>
                                    <th>Perbaikan</th>
                                    <th>Downtime</th>
                                    <th>PIC</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script>
        flatpickr("#date_plan", {
            dateFormat: "d/m/Y", // format: hari/bulan/tahun
            defaultDate: "today"
        });


        flatpickr("#dt_start", {
            enableTime: true,
            dateFormat: "d/m/Y H:i", // 24 jam format Indonesia
            time_24hr: true
        });

        flatpickr("#dt_finish", {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            time_24hr: true
        });



        $(document).ready(function() {
            list();
            getDoc();
        });

        $(document).on("click", "#btnReload", function() {
            location.reload();
        });


        function getDoc() {
            var d = new Date(),
                month = ('0' + (d.getMonth() + 1)).slice(-2),
                day = ('0' + d.getDate()).slice(-2),
                year = d.getFullYear();

            $.ajax({
                type: 'GET',
                url: "{{ route('lkhdies.getdoc') }}",
                success: function(result) {
                    $("#doc_job").val("LKH/DM/STAMPING/" + year + month + "/" + result.jml);
                }
            });
        }


        $('#product_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var job_no = selectedOption.data('job_no');
            var part_no = selectedOption.data('part_no');
            var model_id = selectedOption.data('model_id');
            // Assign the values to hidden inputs or directly to an AJAX request payload
            $('#job_no').val(job_no);
            $('#part_no').val(part_no);
            $('#model_id').val(model_id);

        });

        $(document).ready(function () {
            // Load job list
            $.get("{{ route('dies.list.progress') }}", function (data) {

                let $select = $("#product_id");
                $select.empty().append('<option value="">- Cari Part / Job -</option>');

                data.forEach(item => {
                    $select.append(`
                        <option value="${item.id}"
                            data-job_no="${item.job_no}"
                            data-part_no="${item.part_no}"
                              data-model_id="${item.model_id}"
                            data-progress="${item.progress}">
                            ${item.job_no} | ${item.part_no} | ${item.model_id}
                            (${item.progress ?? 0}%)
                        </option>
                    `);
                });

                $select.trigger('change.select2');
            });

            });


            $(document).on('change', '#product_id', function () {

            let progress = parseFloat(
                $('#product_id option:selected').data('progress')
            );

            let $preventive = $('#category option[value="PREVENTIVE"]');

            if (!isNaN(progress) && progress >= 10) {
                // ✅ BOLEH PREVENTIVE
                $preventive.prop('disabled', false);
            } else {
                // ❌ BELUM BOLEH
                $preventive.prop('disabled', true);

                // kalau sedang terpilih, reset
                if ($('#category').val() === 'PREVENTIVE') {
                    $('#category').val('');
                }
            }
            });



        function list() {
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: false,

                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 15,
                dom: 'lrtip', // Sembunyikan search box bawaan
                ajax: {
                    url: "{{ route('lkhdies.list') }}"
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
                        data: 'doc_job',
                        name: 'doc_job'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'part_nos',
                        name: 'part_nos',
                        render: function(data) {
                            if (!data) return '-';
                            let parts = data.split(', ');
                            let badges = parts.map(p => `<span class="badge badge-info mr-1" style="font-size: 16px; font-weight: 700; background-color: #4a6e58; color: white; padding: 5px 10px;">${p}</span>`);
                            return badges.join('');
                        }
                    },
                    {
                        data: 'date_plan',
                        name: 'date_plan'
                    },
                    {
                        data: 'doc_job',
                        name: 'doc_job',
                        render: function(data) {

                            return `
                                <div style="display:flex; justify-content:center; align-items:center; gap:8px;">

                                    <a href="{{ url('lkhdies/diemtc-lkh/pdf') }}/${data}"
                                       target="_blank"
                                       class="btn btn-danger btn-sm"
                                       title="PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                   <a href="#"
                                       class="btn btn-info btn-sm btn-edit"
                                       title="Detail"
                                       data-id="${data}">
                                       <i class="fas fa-search"></i>
                                    </a>

                                  <a href="#"
                                       class="btn btn-danger btn-sm btn-delete"
                                       title="Delete"
                                       data-id="${data}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>

                                </div>
                            `;
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

            // Event Filter Kartu Kategori
            $('.category-card').on('click', function() {
                $('.category-card').removeClass('active');
                $(this).addClass('active');

                let category = $(this).data('category');
                if (category === 'ALL') {
                    table.column(2).search('').draw();
                } else {
                    table.column(2).search(category).draw();
                }
            });

            // Event Custom Search
            $('#customSearch').on('keyup', function() {
                table.search(this.value).draw();
            });
        }

        function listdetail() {

            var doc_job = $("#doc_job").val();

            $('#example2').DataTable({
                processing: true,
                serverSide: false,

                destroy: true,
                ajax: {
                    url: "{{ route('lkhdies.listdetail') }}",
                    data: {
                        doc_job: doc_job
                    }
                },
                columns: [{
                        data: null,
                        name: 'id',
                        render: (d, t, r, m) => m.row + 1
                    },
                    {
                        data: 'job_no',
                        name: 'job_no'
                    },
                    {
                        data: 'part_no',
                        name: 'part_no'
                    },
                    {
                        data: 'model_id',
                        name: 'model_id'
                    },
                    {
                        data: 'line_id',
                        name: 'line_id'
                    },

                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (id, type, row) {

                            let awal  = row.foto_awal  ? `/dist/img/${row.foto_awal}`  : '/no-image.png';
                            let akhir = row.foto_akhir ? `/dist/img/${row.foto_akhir}` : '/no-image.png';

                            let viewUrl = `{{ route('lkhdies.pdf', ':id') }}`.replace(':id', id);
                            return `
    <div style="display:flex; justify-content:center; align-items:center; gap:2px;">

        <button type="button"
            class="btn btn-info btn-sm"
            style="margin-right:6px;"
            onclick="openImageModal('${awal}', '${akhir}')"
            title="Lihat Foto">
            <i class="fa fa-image"></i>
        </button>

        <a href="${viewUrl}"
           target="_blank"
           class="btn btn-danger btn-sm"
           style="margin-right:6px;"
           title="Buka LKH">
            <i class="fas fa-file-pdf"></i>
        </a>

        <button type="button"
            class="btn btn-outline-danger btn-sm btn-delete-line"
            title="Delete"
            data-id="${id}">
            <i class="far fa-trash-alt"></i>
        </button>

    </div>
`;


                        }
                    }




                ]
            });
        }

        function openImageModal(awal, akhir) {
            $("#img_awal").attr("src", awal);
            $("#img_akhir").attr("src", akhir);
            $("#ModalFoto").modal("show");
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

            // Sync with Category Card Filter
            let activeCategory = $('.category-card.active').data('category');
            let $categorySelect = $('#category');

            // Reset options state first
            $categorySelect.find('option').prop('disabled', false);

            if (activeCategory !== 'ALL') {
                $categorySelect.val(activeCategory);
                // Disable other categories
                $categorySelect.find('option').each(function() {
                    let val = $(this).val();
                    if (val !== activeCategory && val !== "") {
                        $(this).prop('disabled', true);
                    }
                });
            } else {
                $categorySelect.val('');
            }
        });

        $('#myModal2').on('shown.bs.modal', function() {
            $('#product_id').select2({
                dropdownParent: $('#myModal2'), // modal tempat select berada
                width: '100%'
            });
            $('#pic').select2({
                dropdownParent: $('#myModal2'),
                width: '100%',
                placeholder: "- Pilih PIC -"
            });
        });

        $(document).on("click", ".btn-edit", function(e) {
    e.preventDefault();

    $("#title1").hide();
    $("#title2").show();

    let docJob = $(this).data('id'); // ✅ doc_job

    $("#doc_job").val(docJob);

    $('#myModal2').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });

    listdetail();
});


        $(document).on("click", ".close", function() {
            clear();
            $("#alert").html('');
            list();
        });

        function clear() {

            // reset semua input text, number, textarea
            $('#myModal2').find('input[type="text"], input[type="number"], textarea').val('');

            // reset semua input date & datetime-local
            $('#myModal2').find('input[type="date"], input[type="datetime-local"]').val('');

            // reset select biasa
            $('#myModal2').find('select').val('').trigger('change');

            // reset PIC specifically for multi-select
            $('#pic').val(null).trigger('change');

            // reset file input
            $('#foto_awal').val('');
            $('#foto_akhir').val('');

            // hapus preview image kalau ada
            $("#preview_awal").attr("src", "");
            $("#preview_akhir").attr("src", "");
        }

        function checkFileSize(input) {
            const file = input.files[0];
            if (file && file.size > 500 * 1024) { // 500 KB
                alert("Ukuran foto maksimal 500 KB!");
                input.value = "";
            }
        }

        $(document).on("click", ".Save", function() {
            if (!validasi()) return;

            let category = $('#category').val();
            if (!category) {
                Swal.fire({
                    title: 'Kategori Belum Dipilih',
                    text: "Kategori masih kosong, apakah Anda yakin ingin melanjutkan tanpa kategori?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#003366',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm();
                    }
                });
            } else {
                submitForm();
            }
        });

        function submitForm() {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            formData.append('doc_job', $('#doc_job').val());
            formData.append('job_no', $('#job_no').val());
            formData.append('part_no', $('#part_no').val());
            formData.append('model_id', $('#model_id').val());
            formData.append('proses', $('#proses').val());
            formData.append('line_id', $('#line_id').val());
            formData.append('date_plan', $('#date_plan').val());
            formData.append('problem', $('#problem').val());
            formData.append('category', $('#category').val());
            formData.append('tindakan', $('#tindakan').val());

            // Handle PIC array
            let picVal = $('#pic').val();
            if (Array.isArray(picVal)) {
                picVal = picVal.join(', ');
            }
            formData.append('pic', picVal);

            formData.append('dt_start', $('#dt_start').val());
            formData.append('dt_finish', $('#dt_finish').val());
            formData.append('remarks', $('#remarks').val());

            $.ajax({
                type: "POST",
                url: "{{ route('lkhdies.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        listdetail();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON ? xhr.responseJSON.msg : 'Terjadi kesalahan saat menyimpan data.',
                    });
                }
            });
        }


        // ============================
        // VALIDASI FIELD WAJIB
        // ============================
        function validasi() {

            let errors = [];

            if ($('#part_no').val() === '') errors.push("Part No harus diisi.");
            if ($('#line_id').val() === '') errors.push("Line ID harus diisi.");
            if ($('#model_id').val() === '') errors.push("Model ID harus diisi.");
            if ($('#proses').val() === '') errors.push("Proses harus diisi.");
            if ($('#problem').val() === '') errors.push("Problem harus diisi.");
            if ($('#tindakan').val() === '') errors.push("Tindakan harus diisi.");
            if ($('#tindakan').val() === '') errors.push("Tindakan harus diisi.");

            let picVal = $('#pic').val();
            if (!picVal || picVal.length === 0) errors.push("PIC harus diisi.");

            if ($('#dt_start').val() === '') errors.push("Downtime Start harus diisi.");
            if ($('#dt_finish').val() === '') errors.push("Downtime Finish harus diisi.");

            // Jika foto wajib → aktifkan
            // if (!$('#foto_awal')[0].files.length) errors.push("Foto awal harus diupload.");
            // if (!$('#foto_akhir')[0].files.length) errors.push("Foto akhir harus diupload.");

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form belum lengkap',
                    html: errors.join("<br>"),
                });
                return false;
            }

            return true;
        }

        // function showDiesList() {
        //     $.ajax({
        //         url: "{{ route('lkhdies.getList') }}",
        //         type: "GET",
        //         success: function (data) {

        //             let rows = "";
        //             data.forEach((item, index) => {
        //                 rows += `
    //                     <tr>
    //                         <td>${index + 1}</td>
    //                         <td>${item.part_name ?? '-'}</td>
    //                         <td>${item.part_no ?? '-'}</td>
    //                         <td>${item.job_no ?? '-'}</td>
    //                         <td>${item.model_id ?? '-'}</td>
    //                         <td>${item.line_id ?? '-'}</td>
    //                         <td>${item.std_stroke ?? '-'}</td>
    //                     </tr>
    //                 `;
        //             });

        //             $("#tableDies tbody").html(rows);
        //             $("#modalDies").modal('show');
        //         }
        //     });

        //     }


        function showDiesList() {
            $.ajax({
                url: "{{ route('lkhdies.getList') }}",
                type: "GET",
                success: function(data) {

                    let rows = "";

                    data.forEach((item, index) => {

                        let progress = parseFloat(item.progress) || 0;

                        let progressClass = 'progress-green';
                        if (progress >= 100) {
                            progressClass = 'progress-red';
                        } else if (progress >= 89) {
                            progressClass = 'progress-yellow';
                        }

                        let width = Math.min(progress, 100);

                        rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.part_name ?? '-'}</td>
                        <td>${item.part_no ?? '-'}</td>
                        <td>${item.job_no ?? '-'}</td>
                        <td>${item.model_id ?? '-'}</td>
                        <td>${item.line_id ?? '-'}</td>
                        <td>${item.std_stroke ?? '-'}</td>
                        <td>${item.actual_stroke ?? 0}</td>
                        <td>
                            <div class="progress-wrapper">
                                <div class="progress-bar-custom ${progressClass}"
                                     style="width:${width}%">
                                    ${progress}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm btn-history"
                                    data-part_no="${item.part_no}"
                                    title="History LKH">
                                <i class="fas fa-history"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    });

                    // 🔥 HANCURKAN DATATABLE SEBELUM RE-INIT
                    if ($.fn.DataTable.isDataTable('#tableDies')) {
                        $('#tableDies').DataTable().destroy();
                    }

                    $("#tableDies tbody").html(rows);

                    // 🔥 INIT DATATABLE
                    $('#tableDies').DataTable({
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ordering: true,
                        autoWidth: false,
                        responsive: true
                    });

                    $("#modalDies").modal('show');
                }
            });
        }



        $('#btnRefreshStroke').on('click', function() {

            if (!confirm('Update actual stroke ke tabel list dies?')) return;

            $.ajax({
                url: "{{ route('lkhdies.refreshStroke') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $('#btnRefreshStroke')
                        .prop('disabled', true)
                        .html('<i class="fas fa-spinner fa-spin"></i> Updating...');
                },
                success: function(res) {
                    alert(res.message);

                    // reload table
                    $('#tableDies').DataTable().destroy();
                    showDiesList();
                },
                error: function() {
                    alert('Gagal update stroke');
                },
                complete: function() {
                    $('#btnRefreshStroke')
                        .prop('disabled', false)
                        .html('<i class="fas fa-sync-alt"></i> Refresh Stroke');
                }
            });
        });





        $(document).on("click", ".btn-delete-line", function () {

            let id = $(this).data('id');

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
                        url: "{{ route('lkhdies.destroyline') }}",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function (result) {

                            Swal.fire({
                                icon: result.success ? 'success' : 'error',
                                title: result.success ? 'Success' : 'Error',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            listdetail(); // reload tabel
                        }
                    });

                }
            });
            });


            $(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();

    let doc_lkh = $(this).data('id');

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
                url: "{{ route('lkhdies.destroy') }}",
                data: {
                    doc_job: doc_lkh,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {

                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: result.msg,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.msg,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }

                    list(); // reload datatable
                }
            });

        }
    });
});

        // Initialize Stroke Tables on Modal Show
        $('#modalStroke, #modalStroke2').on('shown.bs.modal', function () {
            let tableId = $(this).find('table').attr('id');
            if (tableId && !$.fn.DataTable.isDataTable('#' + tableId)) {
                $('#' + tableId).DataTable({
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    searching: true,
                    info: true,
                    autoWidth: false,
                    responsive: true
                });
            }
        });

        // History LKH Handler
        $(document).on('click', '.btn-history', function() {
            let partNo = $(this).data('part_no');
            let jobNo = $(this).data('job_no') || ''; // Optional filter

            $('#historyPartNo').text(partNo);
            $('#modalHistory').modal('show');

            if ($.fn.DataTable.isDataTable('#tableHistory')) {
                $('#tableHistory').DataTable().destroy();
            }

            $('#tableHistory').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('lkhdies.getHistory') }}",
                    data: {
                        part_no: partNo,
                        job_no: jobNo
                    }
                },
                columns: [
                    {
                        data: null,
                        render: (d, t, r, m) => m.row + 1,
                        className: 'text-center'
                    },
                    { data: 'tanggal', className: 'text-center' },
                    {
                        data: 'category',
                        className: 'text-center',
                        render: function(data) {
                            let cls = 'badge-secondary';
                            if(data === 'PREVENTIVE') cls = 'badge-success';
                            if(data === 'CORRECTIVE') cls = 'badge-danger';
                            if(data === 'IMPROVEMENT') cls = 'badge-warning';
                            return `<span class="badge ${cls}">${data}</span>`;
                        }
                    },
                    { data: 'problem' },
                    { data: 'perbaikan' },
                    {
                        data: 'dt_total',
                        className: 'text-center',
                        render: d => d ? d + ' mnt' : '-'
                    },
                    { data: 'pic', className: 'text-center' },
                    {
                        data: 'status',
                        render: function(data) {
                            return `<small class="text-muted">${data || '-'}</small>`;
                        }
                    }
                ],
                pageLength: 10,
                destroy: true
            });
        });
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
