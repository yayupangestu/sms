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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .category-card:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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


        /* ============================================================
                                                               MODERN ANIMATED PROGRESS BAR
                                            ============================================================ */
        .progress-wrapper {
            background: #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            height: 24px;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.08);
            border: 1px solid #cbd5e1;
            margin: 4px 0;
        }

        .progress-bar-custom {
            height: 100%;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            background-size: 30px 30px;
            background-image: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.15) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.15) 50%,
                    rgba(255, 255, 255, 0.15) 75%,
                    transparent 75%,
                    transparent);
            animation: progress-bar-stripes 1.2s linear infinite;
        }

        @keyframes progress-bar-stripes {
            from {
                background-position: 30px 0;
            }

            to {
                background-position: 0 0;
            }
        }

        .progress-text-centered {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            z-index: 5;
            pointer-events: none;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.9), 0 -1px 2px rgba(255, 255, 255, 0.9);
        }

        .progress-green {
            background-color: #10b981 !important;
            /* Premium Emerald */
        }

        .progress-yellow {
            background-color: #f59e0b !important;
            /* Premium Amber */
            color: #000;
        }

        .progress-red {
            background-color: #ef4444 !important;
            /* Premium Rose */
        }

        /* ============================================================
                                                               RESUME CARDS & BADGES STYLE
                                            ============================================================ */
        .resume-card {
            border-radius: 14px;
            border: 2px solid transparent;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            background: #ffffff;
            cursor: pointer;
        }

        .resume-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .resume-card.active {
            transform: scale(1.02);
        }

        .resume-red {
            border-left: 6px solid #ef4444 !important;
            background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%);
        }

        .resume-red:hover,
        .resume-red.active {
            border-color: #ef4444 !important;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
        }

        .resume-yellow {
            border-left: 6px solid #f59e0b !important;
            background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);
        }

        .resume-yellow:hover,
        .resume-yellow.active {
            border-color: #f59e0b !important;
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.2);
        }

        .resume-green {
            border-left: 6px solid #10b981 !important;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        }

        .resume-green:hover,
        .resume-green.active {
            border-color: #10b981 !important;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
        }

        .resume-card .card-body {
            padding: 16px 20px !important;
        }

        .resume-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s;
        }

        .resume-red .resume-icon-wrapper {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .resume-yellow .resume-icon-wrapper {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .resume-green .resume-icon-wrapper {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .resume-card.active .resume-icon-wrapper {
            transform: rotate(15deg) scale(1.1);
        }

        /* ============================================================
                                                               INTERACTIVE & MODERN TABLE DIES
                                            ============================================================ */
        #tableDies {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0 !important;
        }

        #tableDies thead th {
            background: linear-gradient(to right, #002244, #003366);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border: none;
        }

        #tableDies tbody tr {
            transition: all 0.2s ease;
        }

        #tableDies tbody tr:hover {
            background-color: #f8fafc !important;
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.015);
        }

        #tableDies tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155;
            font-size: 14px;
        }

        /* High quality badges inside table */
        .table-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .badge-job {
            background-color: #f1f5f9;
            color: #0f172a;
            border: 1px solid #cbd5e1;
        }

        .badge-model {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .badge-line {
            background-color: #faf5ff;
            color: #6b21a8;
            border: 1px solid #e9d5ff;
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
            padding: 24px;
            /* increased padding */
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            margin-bottom: 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            position: relative;
        }

        .form-section-title {
            font-size: 18px;
            /* Increased from 14px */
            font-weight: 700;
            color: #003366;
            /* Match theme blue */
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
            font-size: 20px;
            /* Increased icon */
        }

        .form-label {
            font-size: 16px;
            /* Increased from 13px */
            font-weight: 600;
            color: #444;
            /* Darker for contrast */
            margin-bottom: 8px !important;
        }

        .label-required::after {
            content: "*";
            color: #dc3545;
            margin-left: 3px;
            font-size: 18px;
        }

        .form-control,
        .form-select,
        .select2-container .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 8px !important;
            padding: 10px 14px;
            font-size: 16px;
            /* Increased from 14px */
            height: auto;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #003366 !important;
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1) !important;
        }

        .select2-container .select2-selection--single {
            height: 48px !important;
            /* Increased height */
            padding: 8px 14px !important;
            /* Adjusted padding */
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
            padding: 12px 36px;
            /* Larger button */
            font-size: 16px;
            /* Larger text */
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5) !important;
            border: none;
            min-height: 85vh;
        }

        #myModal2 .modal-body {
            padding: 2rem 3.5rem !important;
        }

        /* ============================================================
                                                               INTERACTIVE & MODERN HISTORY TABLE
                                            ============================================================ */
        #tableHistory {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0 !important;
        }

        #tableHistory thead th {
            background: linear-gradient(to right, #002244, #003366);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border: none;
        }

        #tableHistory tbody tr {
            transition: all 0.2s ease;
        }

        #tableHistory tbody tr:hover {
            background-color: #f8fafc !important;
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.015);
        }

        #tableHistory tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155;
            font-size: 14px;
        }

        /* Category badges in history table */
        .history-badge-preventive {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            display: inline-block;
        }

        .history-badge-corrective {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            display: inline-block;
        }

        .history-badge-improvement {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            display: inline-block;
        }

        /* Downtime badge highlight */
        .history-downtime-highlight {
            background-color: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 12px;
            display: inline-block;
        }

        .history-downtime-critical {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 12px;
            display: inline-block;
        }

        /* PIC Badge in history */
        .history-badge-pic {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
            display: inline-block;
        }

        /* ============================================================
                               DARK MODE / MODE MALAM SYSTEM
           ============================================================ */
        body.dark-mode {
            background-color: #0b0f19 !important;
            color: #cbd5e1 !important;
        }

        body.dark-mode section.content {
            background: linear-gradient(to bottom, #0f172a 0%, #0b0f19 100%) !important;
        }

        body.dark-mode .content-header h1 {
            color: #f8fafc !important;
        }

        body.dark-mode .card {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .card-header {
            background: #0f172a !important;
            border-bottom: 1px solid #334155 !important;
        }

        body.dark-mode .card-title,
        body.dark-mode .card-title b {
            color: #38bdf8 !important;
        }

        body.dark-mode .table thead th {
            background: #0f172a !important;
            color: #38bdf8 !important;
            border-bottom: 2px solid #334155 !important;
        }

        body.dark-mode .table-bordered th,
        body.dark-mode .table-bordered td {
            border: 1px solid #334155 !important;
        }

        body.dark-mode .table tbody td {
            background: #1e293b !important;
            color: #cbd5e1 !important;
            border-bottom: 1px solid #334155 !important;
        }

        body.dark-mode .table tbody tr:hover {
            background: #334155 !important;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: #0f172a !important;
        }

        body.dark-mode .clean-box {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3) !important;
        }

        body.dark-mode .clean-box:hover {
            box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.45) !important;
        }

        body.dark-mode .info-box-text {
            color: #94a3b8 !important;
        }

        body.dark-mode .info-box-number {
            color: #f8fafc !important;
        }

        body.dark-mode .clean-box .btn-default {
            background: #334155 !important;
            color: #cbd5e1 !important;
            border-color: #475569 !important;
        }

        body.dark-mode .clean-box .btn-default:hover {
            background: #475569 !important;
            color: #ffffff !important;
        }

        body.dark-mode .category-filter-wrapper {
            background: #0f172a !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .category-card {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        body.dark-mode .category-card:hover:not(.active) {
            background: #334155 !important;
            color: #f8fafc !important;
        }

        body.dark-mode .category-card.active {
            background: #0284c7 !important;
            border-color: #0284c7 !important;
            color: white !important;
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.4) !important;
        }

        body.dark-mode .search-wrapper .form-control {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        body.dark-mode .search-wrapper .form-control:focus {
            border-color: #0284c7 !important;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.25) !important;
        }

        body.dark-mode .modal-content {
            background: #1e293b !important;
            color: #cbd5e1 !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .modal-header {
            background: #0f172a !important;
            border-bottom: 1px solid #334155 !important;
        }

        body.dark-mode .modal-body {
            background: #0f172a !important;
        }

        body.dark-mode .form-control {
            background: #0f172a !important;
            color: #f8fafc !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .form-control:focus {
            border-color: #38bdf8 !important;
        }

        body.dark-mode .select2-container--default .select2-selection--single {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #f8fafc !important;
        }

        body.dark-mode .select2-dropdown {
            background-color: #1e293b !important;
            color: #cbd5e1 !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #0284c7 !important;
        }

        body.dark-mode .form-section {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode label,
        body.dark-mode .col-form-label {
            color: #cbd5e1 !important;
        }

        body.dark-mode .resume-card {
            background: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid #334155 !important;
        }

        body.dark-mode .resume-card h3 {
            color: #ffffff !important;
        }

        body.dark-mode .dataTables_wrapper .dataTables_info,
        body.dark-mode .dataTables_wrapper .dataTables_paginate {
            color: #cbd5e1 !important;
        }

        body.dark-mode .page-link {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        body.dark-mode .page-item.active .page-link {
            background-color: #0284c7 !important;
            border-color: #0284c7 !important;
            color: white !important;
        }

        body.dark-mode .btn-close,
        body.dark-mode .close {
            color: #ffffff !important;
            text-shadow: none !important;
            opacity: 0.8 !important;
        }

        body.dark-mode .btn-close:hover,
        body.dark-mode .close:hover {
            opacity: 1 !important;
        }

        /* Dark Mode Toggle styling */
        #darkModeToggle {
            border-color: #003366;
            color: #003366;
            background: transparent;
        }
        #darkModeToggle:hover {
            background: #003366;
            color: #ffffff;
            transform: translateY(-2px);
        }
        body.dark-mode #darkModeToggle {
            border-color: #38bdf8;
            color: #38bdf8;
        }
        body.dark-mode #darkModeToggle:hover {
            background: #38bdf8;
            color: #0f172a;
        }

        /* Custom Table/Card Header for LKH Dies */
        .custom-card-header {
            background: linear-gradient(to right, #002244, #003366) !important;
            padding: 16px 24px !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
            border-bottom: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }

        body.dark-mode .custom-card-header {
            background: linear-gradient(to right, #0f172a, #1e293b) !important;
            border-bottom: 1px solid #334155 !important;
        }

        /* ============================================================
                            PREMIUM STAT CARD STYLING
           ============================================================ */
        .premium-stat-card {
            border-radius: 12px !important;
            padding: 14px 18px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            min-height: 105px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .premium-stat-card:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04) !important;
        }

        /* Smooth pastel colored backgrounds for light mode */
        .premium-stat-card.card-gold {
            background: linear-gradient(135deg, #fefdf0, #fef9c3) !important;
            border: 1px solid #fef08a !important;
        }
        .premium-stat-card.card-orange {
            background: linear-gradient(135deg, #fffaf5, #ffedd5) !important;
            border: 1px solid #fed7aa !important;
        }
        .premium-stat-card.card-emerald {
            background: linear-gradient(135deg, #f5fdf7, #dcfce7) !important;
            border: 1px solid #bbf7d0 !important;
        }

        /* Hover glows */
        .premium-stat-card.card-gold:hover {
            border-color: #facc15 !important;
            box-shadow: 0 12px 20px -8px rgba(234, 179, 8, 0.3) !important;
        }
        .premium-stat-card.card-orange:hover {
            border-color: #f97316 !important;
            box-shadow: 0 12px 20px -8px rgba(249, 115, 22, 0.3) !important;
        }
        .premium-stat-card.card-emerald:hover {
            border-color: #10b981 !important;
            box-shadow: 0 12px 20px -8px rgba(16, 185, 129, 0.3) !important;
        }

        /* Dark Mode overrides for smooth colors */
        body.dark-mode .premium-stat-card.card-gold {
            background: linear-gradient(135deg, #1e293b, #282515) !important;
            border-color: #423910 !important;
        }
        body.dark-mode .premium-stat-card.card-orange {
            background: linear-gradient(135deg, #1e293b, #2d2112) !important;
            border-color: #472d0c !important;
        }
        body.dark-mode .premium-stat-card.card-emerald {
            background: linear-gradient(135deg, #1e293b, #122c1e) !important;
            border-color: #103e25 !important;
        }

        body.dark-mode .premium-stat-card:hover {
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.5) !important;
        }

        .stat-card-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            margin-bottom: 4px !important;
        }

        .stat-card-title {
            font-size: 10px !important;
            font-weight: 800 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        body.dark-mode .stat-card-title {
            color: #94a3b8 !important;
        }

        .stat-card-number {
            font-size: 26px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1 !important;
        }

        body.dark-mode .stat-card-number {
            color: #f8fafc !important;
        }

        .stat-card-icon {
            width: 36px !important;
            height: 36px !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 16px !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
            transition: all 0.3s !important;
        }

        .premium-stat-card:hover .stat-card-icon {
            transform: scale(1.08) rotate(3deg) !important;
        }

        .stat-card-footer {
            margin-top: 10px !important;
            display: flex !important;
            justify-content: flex-start !important;
        }

        .stat-card-btn {
            background: rgba(255, 255, 255, 0.7) !important;
            color: #475569 !important;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            border-radius: 20px !important;
            padding: 4px 12px !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            transition: all 0.2s !important;
            cursor: pointer !important;
        }

        .stat-card-btn:hover {
            background: #0f172a !important;
            color: #ffffff !important;
            border-color: #0f172a !important;
            transform: translateY(-0.5px) !important;
        }

        .stat-card-btn i {
            font-size: 10px !important;
            transition: all 0.2s !important;
        }

        .stat-card-btn:hover i {
            transform: translateX(1.5px) !important;
        }

        body.dark-mode .stat-card-btn {
            background: rgba(30, 41, 59, 0.6) !important;
            color: #cbd5e1 !important;
            border-color: rgba(71, 85, 105, 0.6) !important;
        }

        body.dark-mode .stat-card-btn:hover {
            background: #0284c7 !important;
            color: #ffffff !important;
            border-color: #0284c7 !important;
        }
    </style>
    <script>
        // Check and apply dark mode preference immediately to avoid page flashing
        if (localStorage.getItem('lkhdies_dark_mode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    </script>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-family: 'Outfit', 'Inter', sans-serif; font-weight: 700; letter-spacing: 0.5px;">Laporan Kerja Harian DIE MTC</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end align-items-center mt-2 mt-sm-0">
                    <button type="button" id="darkModeToggle" class="btn btn-outline-primary d-flex align-items-center shadow-sm" style="border-radius: 30px; padding: 8px 18px; font-weight: 600; transition: all 0.3s; border-width: 2px;">
                        <i class="fas fa-moon mr-2"></i>
                        <span>Mode Malam</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <div class="row">

            <!-- CARD 1: LIST DIES -->
            <div class="col-12 col-md-4 mb-3">
                <div class="premium-stat-card card-gold shadow-sm">
                    <div class="stat-card-header">
                        <div>
                            <span class="stat-card-title">List Dies</span>
                            <div class="stat-card-number mt-2">{{ $TotalDies }}</div>
                        </div>
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #facc15, #ca8a04);">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <button class="stat-card-btn" onclick="showDiesList()">
                            <span>LIHAT LIST</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- CARD 2: LIST DIES AKAN PREVENTIVE -->
            <div class="col-12 col-md-4 mb-3">
                <div class="premium-stat-card card-orange shadow-sm">
                    <div class="stat-card-header">
                        <div>
                            <span class="stat-card-title">Dies Akan Preventive</span>
                            <div class="stat-card-number mt-2">{{ $TotalStrokeKurang }}</div>
                        </div>
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <button class="stat-card-btn" data-toggle="modal" data-target="#modalStroke">
                            <span>LIHAT LIST</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- CARD 3: HISTORY LKH -->
            <div class="col-12 col-md-4 mb-3">
                <div class="premium-stat-card card-emerald shadow-sm">
                    <div class="stat-card-header">
                        <div>
                            <span class="stat-card-title">History LKH</span>
                            <div class="stat-card-number mt-2">{{ $TotalDies }}</div>
                        </div>
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <i class="fas fa-history"></i>
                        </div>
                    </div>
                    <div class="stat-card-footer">
                        <button class="stat-card-btn" data-toggle="modal" data-target="#modalStroke2">
                            <span>LIHAT LIST</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <section class="content">
        {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 16px; overflow: hidden; border: none; margin-bottom: 30px;">
                        <div class="custom-card-header">
                            <h3 class="mb-0" style="color: white !important; font-size: 1.25rem; font-family: 'Outfit', 'Inter', sans-serif; font-weight: 700; display: flex; align-items: center;">
                                <i class="fas fa-list-alt mr-2 text-warning"></i>
                                <span>List Laporan Kerja Harian DIE MTC</span>
                            </h3>
                            <div>
                                <button class="btn btn-success btn-sm shadow-sm" id="btn_add" style="background-color: #22c55e; border-color: #22c55e; border-radius: 8px !important; font-weight: 600; padding: 6px 16px;">
                                    <i class="fa fa-plus mr-1"></i> Add
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 24px;">
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
                                    <input type="text" id="customSearch" class="form-control"
                                        placeholder="Cari data laporan...">
                                </div>
                            </div>

                            <table id="example1" class="table table-hover table-bordered table-striped" style="border-radius: 10px; overflow: hidden; border: none !important;">
                                <thead>
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
                                        <input type="text" id="date_plan" class="form-control" required
                                            placeholder="Pilih Tanggal">
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
                                        <select id="pic" class="form-control select2" multiple="multiple"
                                            style="width: 100%;" required>
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
                                        <textarea id="problem" class="form-control" rows="3"
                                            placeholder="Deskripsikan masalah secara detail..." required></textarea>
                                    </div>

                                    <!-- TINDAKAN -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label label-required">PENANGGULANGAN</label>
                                        <textarea id="tindakan" class="form-control" rows="3"
                                            placeholder="Langkah perbaikan yang dilakukan..."></textarea>
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
                                        <input type="text" id="dt_start" class="form-control bg-white" required
                                            placeholder="00:00">
                                    </div>

                                    <!-- DOWNTIME FINISH -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label label-required">Finish</label>
                                        <input type="text" id="dt_finish" class="form-control bg-white" required
                                            placeholder="00:00">
                                    </div>

                                    <!-- REMARKS -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Remarks</label>
                                        <textarea id="remarks" class="form-control" rows="2"
                                            placeholder="Catatan tambahan..."></textarea>
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
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">

                <div class="modal-header d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(to right, #002244, #003366); color: white; padding: 16px 24px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                    <h5 class="modal-title font-weight-bold mb-0" style="font-size: 18px; letter-spacing: 0.5px;">
                        <i class="fa fa-image mr-2 text-warning"></i>Detail Foto
                    </h5>
                    <button type="button" class="close text-black" data-dismiss="modal"
                        style="opacity: 0.8; outline: none; border: none; background: transparent; font-size: 28px; line-height: 1;">&times;</button>
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
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">

                <div class="modal-header d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(to right, #991b1b, #ef4444); color: white; padding: 16px 24px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                    <h5 class="modal-title font-weight-bold mb-0" style="font-size: 18px; letter-spacing: 0.5px;">
                        <i class="fas fa-arrow-down mr-2 text-warning"></i>List Dies Kurang Stroke
                    </h5>
                    <button type="button" class="close text-black" data-dismiss="modal"
                        style="opacity: 0.8; outline: none; border: none; background: transparent; font-size: 28px; line-height: 1;">&times;</button>
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
                                        <button class="btn btn-info btn-sm btn-history" data-part_no="{{ $row->part_no }}"
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
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">

                <div class="modal-header d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(to right, #991b1b, #ef4444); color: white; padding: 16px 24px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                    <h5 class="modal-title font-weight-bold mb-0" style="font-size: 18px; letter-spacing: 0.5px;">
                        <i class="fas fa-arrow-up mr-2 text-warning"></i>List Dies Over Stroke
                    </h5>
                    <button type="button" class="close text-black" data-dismiss="modal"
                        style="opacity: 0.8; outline: none; border: none; background: transparent; font-size: 28px; line-height: 1;">&times;</button>
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
                                        <button class="btn btn-info btn-sm btn-history" data-part_no="{{ $row->part_no }}"
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
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">

                <div class="modal-header d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(to right, #002244, #003366); color: white; padding: 16px 24px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                    <h5 class="modal-title font-weight-bold mb-0" style="font-size: 18px; letter-spacing: 0.5px;">
                        <i class="fas fa-list mr-2 text-warning"></i>LIST DIES
                    </h5>
                    <button type="button" class="close text-black" data-dismiss="modal"
                        style="opacity: 0.8; outline: none; border: none; background: transparent; font-size: 28px; line-height: 1;">&times;</button>
                </div>


                <div class="modal-body">
                    <!-- Dynamic Resume Badges -->
                    <div class="row mb-4">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <div class="card resume-card resume-red" id="card-filter-red" data-filter="red">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="resume-icon-wrapper">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="text-left ml-3">
                                            <div class="text-muted small font-weight-bold"
                                                style="letter-spacing: 0.5px; font-size: 11px;">OVER STROKE (>100%)</div>
                                            <h3 class="mb-0 font-weight-bold text-dark mt-1" id="count-over-stroke"
                                                style="font-size: 26px; line-height: 1;">0</h3>
                                        </div>
                                    </div>
                                    <span class="badge badge-danger p-2 font-weight-bold"
                                        style="font-size: 10px; border-radius: 6px;">Over Limit</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <div class="card resume-card resume-yellow" id="card-filter-yellow" data-filter="yellow">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="resume-icon-wrapper">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <div class="text-left ml-3">
                                            <div class="text-muted small font-weight-bold"
                                                style="letter-spacing: 0.5px; font-size: 11px;">CRITICAL (90% - 100%)</div>
                                            <h3 class="mb-0 font-weight-bold text-dark mt-1" id="count-critical-stroke"
                                                style="font-size: 26px; line-height: 1;">0</h3>
                                        </div>
                                    </div>
                                    <span class="badge badge-warning p-2 font-weight-bold text-dark"
                                        style="font-size: 10px; border-radius: 6px;">Warning</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card resume-card resume-green" id="card-filter-green" data-filter="green">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="resume-icon-wrapper">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="text-left ml-3">
                                            <div class="text-muted small font-weight-bold"
                                                style="letter-spacing: 0.5px; font-size: 11px;">NORMAL (>90%)</div>
                                            <h3 class="mb-0 font-weight-bold text-dark mt-1" id="count-normal-stroke"
                                                style="font-size: 26px; line-height: 1;">0
                                            </h3>
                                        </div>
                                    </div>
                                    <span class="badge badge-success p-2 font-weight-bold"
                                        style="font-size: 10px; border-radius: 6px;">Safe</span>
                                </div>
                            </div>
                        </div>
                    </div>

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
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <div class="modal-header d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(to right, #002244, #003366); color: white; padding: 16px 24px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                    <h5 class="modal-title font-weight-bold mb-0" style="font-size: 18px; letter-spacing: 0.5px;">
                        <i class="fas fa-history mr-2 text-warning"></i>HISTORY LKH - <span id="historyPartNo"
                            class="text-warning"></span>
                    </h5>
                    <button type="button" class="close text-black" data-dismiss="modal"
                        style="opacity: 0.8; outline: none; border: none; background: transparent; font-size: 28px; line-height: 1;">&times;</button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <!-- History Summary Stats -->
                    <div class="row mb-4">
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-light border-0 shadow-sm"
                                style="border-radius: 12px; border-left: 4px solid #0284c7 !important;">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small font-weight-bold"
                                            style="font-size: 11px; letter-spacing: 0.5px;">TOTAL REPORTS</div>
                                        <h4 class="mb-0 font-weight-bold text-dark mt-1" id="history-stat-total"
                                            style="font-size: 22px;">0</h4>
                                    </div>
                                    <div class="rounded d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px; background-color: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-light border-0 shadow-sm"
                                style="border-radius: 12px; border-left: 4px solid #ef4444 !important;">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small font-weight-bold"
                                            style="font-size: 11px; letter-spacing: 0.5px;">TOTAL DOWNTIME</div>
                                        <h4 class="mb-0 font-weight-bold text-dark mt-1" id="history-stat-downtime"
                                            style="font-size: 22px;">0 Mnt</h4>
                                    </div>
                                    <div class="rounded d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px; background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <div class="card bg-light border-0 shadow-sm"
                                style="border-radius: 12px; border-left: 4px solid #10b981 !important;">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small font-weight-bold"
                                            style="font-size: 11px; letter-spacing: 0.5px;">PREVENTIVE</div>
                                        <h4 class="mb-0 font-weight-bold text-dark mt-1" id="history-stat-preventive"
                                            style="font-size: 22px;">0</h4>
                                    </div>
                                    <div class="rounded d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card bg-light border-0 shadow-sm"
                                style="border-radius: 12px; border-left: 4px solid #f59e0b !important;">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small font-weight-bold"
                                            style="font-size: 11px; letter-spacing: 0.5px;">CORRECTIVE / IMPROV</div>
                                        <h4 class="mb-0 font-weight-bold text-dark mt-1" style="font-size: 20px;">
                                            <span id="history-stat-corrective">0</span> / <span
                                                id="history-stat-improvement">0</span>
                                        </h4>
                                    </div>
                                    <div class="rounded d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tableHistory" class="table table-bordered table-hover w-100">
                            <thead>
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
        // Global variables for List Dies filtering
        window.activeDiesFilter = null;

        // Register custom DataTable search filter for #tableDies
        if ($.fn.dataTable) {
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    if (settings.nTable.id !== 'tableDies') {
                        return true;
                    }
                    if (!window.activeDiesFilter) {
                        return true;
                    }
                    let rowNode = settings.aoData[dataIndex].nTr;
                    let category = $(rowNode).find('.progress-wrapper').attr('data-category');
                    return category === window.activeDiesFilter;
                }
            );
        }

        // Click event handler for resume cards
        $(document).off('click', '.resume-card').on('click', '.resume-card', function () {
            let filterVal = $(this).data('filter');

            if ($(this).hasClass('active')) {
                $('.resume-card').removeClass('active');
                window.activeDiesFilter = null;
            } else {
                $('.resume-card').removeClass('active');
                $(this).addClass('active');
                window.activeDiesFilter = filterVal;
            }

            if ($.fn.DataTable.isDataTable('#tableDies')) {
                $('#tableDies').DataTable().draw();
            }
        });

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



        $(document).ready(function () {
            list();
            getDoc();
        });

        $(document).on("click", "#btnReload", function () {
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
                success: function (result) {
                    $("#doc_job").val("LKH/DM/STAMPING/" + year + month + "/" + result.jml);
                }
            });
        }


        $('#product_id').on('change', function () {
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
            // Dark Mode toggle event listener and handler
            $(document).on('click', '#darkModeToggle', function() {
                $('body').toggleClass('dark-mode');
                let isDark = $('body').hasClass('dark-mode');
                localStorage.setItem('lkhdies_dark_mode', isDark ? 'enabled' : 'disabled');
                updateDarkModeToggleState(isDark);
            });

            // Initialize Toggle button icon and text state on page load
            let isDarkModeEnabled = $('body').hasClass('dark-mode');
            updateDarkModeToggleState(isDarkModeEnabled);

            function updateDarkModeToggleState(isDark) {
                let $btn = $('#darkModeToggle');
                if (isDark) {
                    $btn.find('i').attr('class', 'fas fa-sun text-warning mr-2');
                    $btn.find('span').text('Mode Terang');
                    $btn.removeClass('btn-outline-primary').addClass('btn-outline-warning');
                } else {
                    $btn.find('i').attr('class', 'fas fa-moon mr-2');
                    $btn.find('span').text('Mode Malam');
                    $btn.removeClass('btn-outline-warning').addClass('btn-outline-primary');
                }
            }

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
                    render: function (data, type, row, meta) {
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
                    render: function (data) {
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
                    render: function (data) {

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
            $('.category-card').on('click', function () {
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
            $('#customSearch').on('keyup', function () {
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

                        let awal = row.foto_awal ? `/dist/img/${row.foto_awal}` : '/no-image.png';
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
        $(document).on("click", "#btn_add", function () {
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
                $categorySelect.find('option').each(function () {
                    let val = $(this).val();
                    if (val !== activeCategory && val !== "") {
                        $(this).prop('disabled', true);
                    }
                });
            } else {
                $categorySelect.val('');
            }
        });

        $('#myModal2').on('shown.bs.modal', function () {
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

        $(document).on("click", ".btn-edit", function (e) {
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


        // Clean up inputs and refresh main dashboard when form modal is closed
        $('#myModal2').on('hidden.bs.modal', function () {
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

        $(document).on("click", ".Save", function () {
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
                success: function (result) {
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
                error: function (xhr) {
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
            // Reset active card filters when opening the list
            window.activeDiesFilter = null;
            $('.resume-card').removeClass('active');

            $.ajax({
                url: "{{ route('lkhdies.getList') }}",
                type: "GET",
                success: function (data) {
                    let rows = "";
                    let countRed = 0;
                    let countYellow = 0;
                    let countGreen = 0;

                    data.forEach((item, index) => {
                        let progress = parseFloat(item.progress) || 0;

                        let progressClass = 'progress-green';
                        let progressCategory = 'green';

                        if (progress > 100) {
                            progressClass = 'progress-red';
                            progressCategory = 'red';
                            countRed++;
                        } else if (progress >= 90 && progress <= 100) {
                            progressClass = 'progress-yellow';
                            progressCategory = 'yellow';
                            countYellow++;
                        } else {
                            progressClass = 'progress-green';
                            progressCategory = 'green';
                            countGreen++;
                        }

                        let width = Math.min(progress, 100);

                        // Wrap columns in high-quality ERP-style badges
                        let jobBadge = `<span class="table-badge badge-job">${item.job_no ?? '-'}</span>`;
                        let modelBadge = `<span class="table-badge badge-model">${item.model_id ?? '-'}</span>`;
                        let lineBadge = `<span class="table-badge badge-line">${item.line_id ?? '-'}</span>`;

                        rows += `
                                                            <tr>
                                                                <td class="text-center font-weight-bold">${index + 1}</td>
                                                                <td class="text-left font-weight-bold" style="color: #0f172a; min-width: 200px;">${item.part_name ?? '-'}</td>
                                                                <td class="text-center font-weight-bold" style="color: #475569;">${item.part_no ?? '-'}</td>
                                                                <td class="text-center">${jobBadge}</td>
                                                                <td class="text-center">${modelBadge}</td>
                                                                <td class="text-center">${lineBadge}</td>
                                                                <td class="text-center font-weight-bold text-secondary">${item.std_stroke ?? '-'}</td>
                                                                <td class="text-center font-weight-bold text-primary">${item.actual_stroke ?? 0}</td>
                                                                <td style="min-width: 140px; vertical-align: middle;">
                                                                    <div class="progress-wrapper" data-category="${progressCategory}">
                                                                        <div class="progress-bar-custom ${progressClass}" style="width:${width}%"></div>
                                                                        <div class="progress-text-centered">${progress}%</div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button class="btn btn-info btn-sm btn-history"
                                                                            data-part_no="${item.part_no}"
                                                                            title="History LKH"
                                                                            style="border-radius: 8px; font-weight: 600; padding: 5px 12px; transition: all 0.2s;">
                                                                        <i class="fas fa-history mr-1"></i> History
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            `;
                    });

                    // Update dynamic badge counters
                    $('#count-over-stroke').text(countRed);
                    $('#count-critical-stroke').text(countYellow);
                    $('#count-normal-stroke').text(countGreen);

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
                        responsive: true,
                        dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rtip',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Cari data dies...",
                            lengthMenu: "Tampilkan _MENU_ data"
                        }
                    });

                    $("#modalDies").modal('show');
                }
            });
        }



        $('#btnRefreshStroke').on('click', function () {

            if (!confirm('Update actual stroke ke tabel list dies?')) return;

            $.ajax({
                url: "{{ route('lkhdies.refreshStroke') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function () {
                    $('#btnRefreshStroke')
                        .prop('disabled', true)
                        .html('<i class="fas fa-spinner fa-spin"></i> Updating...');
                },
                success: function (res) {
                    alert(res.message);

                    // reload table
                    $('#tableDies').DataTable().destroy();
                    showDiesList();
                },
                error: function () {
                    alert('Gagal update stroke');
                },
                complete: function () {
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
        $(document).on('click', '.btn-history', function () {
            let partNo = $(this).data('part_no');
            let jobNo = $(this).data('job_no') || ''; // Optional filter

            $('#historyPartNo').text(partNo);

            // Reset stats values initially
            $('#history-stat-total').text('0');
            $('#history-stat-downtime').text('0 Mnt');
            $('#history-stat-preventive').text('0');
            $('#history-stat-corrective').text('0');
            $('#history-stat-improvement').text('0');

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
                    },
                    dataSrc: function (json) {
                        let totalRecords = json.data ? json.data.length : 0;
                        let totalDowntime = 0;
                        let countPreventive = 0;
                        let countCorrective = 0;
                        let countImprovement = 0;

                        if (json.data && Array.isArray(json.data)) {
                            json.data.forEach(row => {
                                totalDowntime += parseInt(row.dt_total) || 0;
                                if (row.category === 'PREVENTIVE') countPreventive++;
                                else if (row.category === 'CORRECTIVE') countCorrective++;
                                else if (row.category === 'IMPROVEMENT') countImprovement++;
                            });
                        }

                        // Update dynamic analytics cards
                        $('#history-stat-total').text(totalRecords);
                        $('#history-stat-downtime').text(totalDowntime + ' Mnt');
                        $('#history-stat-preventive').text(countPreventive);
                        $('#history-stat-corrective').text(countCorrective);
                        $('#history-stat-improvement').text(countImprovement);

                        return json.data || [];
                    }
                },
                columns: [
                    {
                        data: null,
                        render: (d, t, r, m) => `<span class="font-weight-bold text-secondary">${m.row + 1}</span>`,
                        className: 'text-center'
                    },
                    {
                        data: 'tanggal',
                        className: 'text-center font-weight-bold text-dark'
                    },
                    {
                        data: 'category',
                        className: 'text-center',
                        render: function (data) {
                            let badgeClass = 'history-badge-preventive';
                            if (data === 'CORRECTIVE') badgeClass = 'history-badge-corrective';
                            else if (data === 'IMPROVEMENT') badgeClass = 'history-badge-improvement';
                            return `<span class="${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: 'problem',
                        className: 'text-left font-weight-bold',
                        style: 'color: #0f172a;'
                    },
                    {
                        data: 'perbaikan',
                        className: 'text-left',
                        style: 'color: #334155;'
                    },
                    {
                        data: 'dt_total',
                        className: 'text-center',
                        render: function (d) {
                            let val = parseInt(d) || 0;
                            if (val === 0) return `<span class="text-muted">-</span>`;
                            if (val > 30) {
                                return `<span class="history-downtime-critical"><i class="fas fa-exclamation-triangle mr-1"></i>${val} Mnt</span>`;
                            }
                            return `<span class="history-downtime-highlight"><i class="fas fa-clock mr-1"></i>${val} Mnt</span>`;
                        }
                    },
                    {
                        data: 'pic',
                        className: 'text-center',
                        render: function (d) {
                            return d ? `<span class="history-badge-pic"><i class="fas fa-user-circle mr-1 text-secondary"></i>${d}</span>` : `<span class="text-muted">-</span>`;
                        }
                    },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function (data) {
                            return data ? `<span class="badge badge-secondary p-2 font-weight-bold" style="font-size: 11px; border-radius: 6px;">${data}</span>` : `<span class="text-muted">-</span>`;
                        }
                    }
                ],
                pageLength: 10,
                destroy: true,
                dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rtip',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari riwayat LKH...",
                    lengthMenu: "Tampilkan _MENU_ data"
                }
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