@extends('layouts.app')

@section('content')
    <style>
        /* dashboard.css */

        /* Updated dashboard.css */

        .custom-dashboard {
            background: linear-gradient(to bottom right, #767d81 0%, #ffffff 100%);
            /* background: rgba(8, 16, 40, 255); */
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .dashboard-title {
            font-size: 26px;
            font-weight: bold;
            color: #ffffff;
        }


        .new-order-btn:hover {
            background-color: #e55e5e;
        }


        .metric-card {
            background: linear-gradient(135deg, #3a8ed6, #62b6f4);
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
            transform: translateY(-5px);
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

        .inventory-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .inventory-table th,
        .inventory-table td {
            vertical-align: middle;
            font-size: 14px;
        }


        .partner-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .partner-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
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






        .card-title {
            font-size: 20px;
            margin: 0;
        }

        /* Table Styling */
        .table.inventory-table {
            width: 100%;
            margin-bottom: 0;
            background-color: #fff;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .table thead th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            border-top: none;
        }

        .table tbody tr {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        /* Badge Styling */
        .badge {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 20px;
            color: #fff;
            font-weight: 600;
        }






        .metric-card {
            background: rgba(11, 23, 57, 255);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            max-width: 100%;
        }


        .cards-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            /* background: rgba(11, 23, 57, 255); */
            background: linear-gradient(to bottom right, #767d81 0%, #ffffff 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            flex: 1 1 300px;
            max-width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        .card-title {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .card-value {
            font-size: 1rem;
            font-weight: bold;
            margin: 0;
        }

        .card-values-horizontal {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .card-values-horizontal2 {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
            font-size: 1.0rem;
            padding: 10px;
        }

        .value-box {
            background-color: #898989;
            color: #000;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.05);
            min-width: 80px;
            text-align: center;
            flex: 1;
        }

        .value-box2 {
            flex: 1;
            padding: 16px;
            font-weight: bold;
            font-size: 1.3rem;
            background-color: #2d2d2d4a;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .status-normal {

            color: rgb(0, 0, 0);
        }

        .status-safe {

            color: rgb(0, 0, 0);
        }


        .status-critical {

            color: rgb(0, 0, 0);
        }


        .table-container {
            margin-top: 20px;
        }

        .box-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .mini-box {
            background-color: #125dcd4a;
            border: 1px solid #ddd;
            color: #000;
            border-radius: 6px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 5px;
        }

        .custom-button {
            background: #3d3d3d;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .custom-button:hover {
            background: #00000096;
        }

        .mini-box .label-text {
            font-size: 14px;
            color: #ffffff;
            margin-left: 6px;
        }

        /* ===========================
           RESPONSIVE SECTION BELOW
           =========================== */
        @media (max-width: 1024px) {
            .box-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .cards-container {
                flex-direction: column;
                gap: 16px;
            }

            .card {
                width: 100%;
            }

            .card-values-horizontal,
            .card-values-horizontal2 {
                flex-direction: column;
                align-items: center;
            }

            .box-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .custom-button {
                width: 100%;
                text-align: center;
            }

            .button-group {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .box-grid {
                grid-template-columns: 1fr;
            }

            .mini-box {
                font-size: 13px;
                height: 45px;
            }

            .value-box2 {
                font-size: 1.1rem;
                padding: 12px;
            }
        }

        @keyframes blinkYellow {

            0%,
            100% {
                background-color: rgb(0, 0, 0);
                opacity: 1;
            }

            50% {
                background-color: rgb(255, 251, 0);
                opacity: 0.2;
            }
        }

        @keyframes blinkRed {

            0%,
            100% {
                background-color: red;
                opacity: 1;
            }

            50% {
                background-color: red;
                opacity: 0.2;
            }
        }

        .mini-box2 {
            background-color: #125dcd4a;
            border: 1px solid #ddd;
            color: #000;
            border-radius: 6px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        /* box-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
          gap: 10px;
          padding: 10px;
        } */

        .mini-box2 {
            position: relative;
            /* penting supaya pseudo-element bisa posisi relatif terhadap box */
            background-color: #7af5ed43;
            padding: 15px 10px 10px 10px;
            /* beri ruang atas agak lebih supaya lingkaran tidak overlap tulisan */
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: 0.3s ease;
        }

        .mini-box2:hover {
            background-color: #e0e0e0;
        }

        .mini-box2 {
            position: relative;
            /* supaya ::before posisinya benar */
            background-color: #4b4b4b3a;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .mini-box2::before {
            content: "";
            position: absolute;
            top: 8px;
            left: 8px;
            width: 12px;
            height: 12px;
            background-color: #000000;
            /* default hitam */
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.6);
            transition: background-color 0.3s ease;
        }

        /* class untuk blinking lingkaran hijau */
        /* blinking hijau (status_proses = 2) */
        .blink-green::before {
            animation: blinkGreen 1s infinite;
            background-color: #00ff3c;
            box-shadow: 0 0 10px #28a745;
        }

        @keyframes blinkGreen {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        /* blinking merah (status_proses = 4,5,6) */
        .blink-red::before {
            animation: blinkRed 1s infinite;
            background-color: #dc3545;
            /* merah */
            box-shadow: 0 0 10px #dc3545;
        }

        @keyframes blinkRed {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            min-width: 300px;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease;
        }

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

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid py-4 custom-dashboard">
        <!-- Top Header -->
        <div class="container-fluid">
            <div style="background: linear-gradient(to bottom right, #767d81 0%, #003366 100%);"
                class="row mb-4 align-items-center">
                <div class="col-md-6" style="position: relative;">
                    <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                        <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                    </div>
                    <strong>
                        <h3 style="color: white; display: inline;">Shopfloor Managament System</h3>
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


        <div class="container-fluid">
            <div class="cards-container">
                <div class="card">
                    <div style="text-align: center;">
                        <p style="
                                    display: inline-block;
                                    font-family: Arial;
                                    background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
                                    color: white;
                                    padding: 12px 20px;
                                    border-radius: 12px;
                                    font-weight: bold;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                    user-select: none;
                                    margin: 0;
                                ">
                            📦 INFORMATION RAW MATERIAL
                        </p>
                    </div>
                    <br>
                    <div class="card-values-horizontal">
                        <div class="value-box">
                            <p class="card-value" id="total-count">
                                {{ DB::table('rm_stoks')->select(DB::raw('count(id) as jml'))->first()->jml }}
                                <span class="status-normal">
                                    (TOTAL) <i style="color: #1900ff; font-size:120%" class="fa-solid fa-bell"></i>
                                </span>
                            </p>
                        </div>
                        <div class="value-box">
                            <p class="card-value" id="safe-count">
                                {{ DB::table('rm_stoks')
        ->where(function ($query) {
            $query->whereColumn('actual_sheet', '>', 'minimal')
                ->orWhereColumn('actual_sheet', '=', 'minimal');
        })
        ->count()
                                        }}
                                <span class="status-safe">(SAFE) <span style="color:green; font-size:110%">▲</span></span>
                            </p>
                        </div>

                        <div class="value-box">
                            <p class="card-value" id="critical-count">
                                {{ DB::table('rm_stoks')->where(function ($query) {
        $query->whereColumn('actual_sheet', '<', 'minimal')->orWhere('actual_sheet', '<', 0);
    })->where('actual_sheet', '!=', 0)->count() }}
                                <span class="status-critical"> (CRITICAL) <span style="color: red; font-size:110%">▼</span>
                                </span>
                            </p>
                        </div>
                    </div>

                    <br>
                    <div class="box-grid">
                        <div class="mini-box" id="po-total">
                            {{ $countDocPO }} <span class="label-text">TOTAL PO</span>
                        </div>
                        <div class="mini-box" id="po-close">
                            {{ $countCloseStatus }} <span class="label-text">PO CLOSE</span>
                        </div>
                        <div class="mini-box" id="po-open">
                            {{ $countStatusNull }} <span class="label-text">PO OPEN</span>
                        </div>
                        <div class="mini-box" id="po-percentage">
                            {{ $percentage }} <span class="label-text">%</span>
                        </div>

                    </div>

                    <br>
                    <div class="button-group">
                        <button onclick="window.location.href='dashboardrm'" class="custom-button">See more PO</button>
                        <button onclick="window.location.href='dashboardrmstok'" class="custom-button">See more
                            Stok</button>
                        <button onclick="window.location.href='dashboardmps'" class="custom-button">See more RM
                            Suplai</button>
                    </div>
                </div>

                <div class="card" style="padding: 20px;">
                    <div style="text-align: center;">
                        <p style="
                                    display: inline-block;
                                    font-family: Arial;
                                    background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
                                    color: white;
                                    padding: 12px 20px;
                                    border-radius: 12px;
                                    font-weight: bold;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                    user-select: none;
                                    margin: 0;
                                ">
                            📦 INFORMATION STAMPING BLANK
                        </p>
                    </div>
                    <br>
                    <p onclick="window.location.href='linestoreindex2'" style="
                              display: inline-block;
                              padding: 4px 10px;
                              background: linear-gradient(to right, #4b6cb7, #182848);
                              color: white;
                              font-weight: bold;
                              font-family: Arial, sans-serif;
                              font-size: 0.85rem;
                              border-radius: 6px;
                              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
                              letter-spacing: 0.5px;
                              margin: 0;
                              cursor: zoom-in;
                          ">
                        INHOUSE
                    </p>
                    <div class="card-values-horizontal">
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')->select(DB::raw('count(id) as jml'))->first()->jml }}
                                <span class="status-normal">PART TOTAL</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'INHOUSE')
        ->whereColumn('qty_actual', '>', 'qty_min')
        ->count() }}
                                <span class="status-safe">RM SAFE</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'INHOUSE')
        ->whereColumn('qty_actual', '<=', 'qty_min')
        ->where('qty_actual', '!=', 0)
        ->count() }}
                                <span class="status-critical">RM CRITICAL</span>
                            </p>
                        </div>
                    </div>

                    <p onclick="window.location.href='linestoreindex'" style="
                            display: inline-block;
                            padding: 4px 10px;
                            background: linear-gradient(to right, #4b6cb7, #182848);
                            color: white;
                            font-weight: bold;
                            font-family: Arial, sans-serif;
                            font-size: 0.85rem;
                            border-radius: 6px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
                            letter-spacing: 0.5px;
                            margin: 0;
                              cursor: zoom-in;
                         ">
                        OUTHOUSE
                    </p>


                    <div class="card-values-horizontal2">
                        <div class="value-box2">
                            <p class="card-value">
                                {{  DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->select(DB::raw('count(id) as jml'))
        ->first()->jml }}
                                <span class="status-normal">PART TOTAL</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->where(function ($query) {
            $query->whereColumn('qty_actual', '>', 'qty_min') // qty_act > qty_min
                ->orWhereColumn('qty_actual', '=', 'qty_min'); // qty_actual = qty_min
        })
        ->count() }}
                                <span class="status-safe">PART SAFE</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->where(function ($query) {
            $query->whereColumn('qty_actual', '<', 'qty_min'); // qty_actual < minimal
            // Kondisi qty_actual < 0 tetap ada untuk perhitungan total
        })
        ->where('qty_actual', '!=', 0) // Exclude actual_sheet = 0
        ->count() }}
                                <span class="status-critical">PART CRITICAL</span>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div style="text-align: center;">
                        <p style="
                                display: inline-block;
                                font-family: Arial;
                                background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
                                color: white;
                                padding: 12px 20px;
                                border-radius: 12px;
                                font-weight: bold;
                                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                user-select: none;
                                margin: 0;
                            ">
                            📦INFORMATION PROSES STAMPING
                        </p>
                    </div>
                    <br>
                    <div class="box-grid">
                        <div class="mini-box2" id="machine-a1">Machine A1</div>
                        <div class="mini-box2" id="machine-a2">Machine A2</div>
                        <div class="mini-box2" id="machine-b1">Machine B1</div>
                        <div class="mini-box2" id="machine-b2">Machine B2</div>
                        <div class="mini-box2" id="machine-b3">Machine B3</div>
                        <div class="mini-box2" id="machine-c1">Machine C1</div>
                        <div class="mini-box2" id="machine-c2">Machine C2</div>
                        <div class="mini-box2">Machine TRANSFERS</div>
                        <div class="mini-box2">FUKUI</div>
                        <div class="mini-box2">KOMATSU</div>
                        <div class="mini-box2">-</div>
                        <button onclick="window.location.href='dashboardstamping'" style="background-color: #007bff"
                            class="mini-box">View Plan</button>
                    </div>
                </div>


            </div>



            <div class="cards-container">

                <div class="card" style="padding: 20px;">
                    <div style="text-align: center;">
                        <p style="
                                    display: inline-block;
                                    font-family: Arial;
                                    background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
                                    color: white;
                                    padding: 12px 20px;
                                    border-radius: 12px;
                                    font-weight: bold;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                    user-select: none;
                                    margin: 0;
                                ">
                            📦 INFORMATION LINE STORE
                        </p>
                    </div>
                    <br>
                    <p onclick="window.location.href='linestoreindex2'" style="
                              display: inline-block;
                              padding: 4px 10px;
                              background: linear-gradient(to right, #4b6cb7, #182848);
                              color: white;
                              font-weight: bold;
                              font-family: Arial, sans-serif;
                              font-size: 0.85rem;
                              border-radius: 6px;
                              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
                              letter-spacing: 0.5px;
                              margin: 0;
                              cursor: zoom-in;
                          ">
                        INHOUSE
                    </p>
                    <div class="card-values-horizontal">
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')->select(DB::raw('count(id) as jml'))->first()->jml }}
                                <span class="status-normal">PART TOTAL</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'INHOUSE')
        ->whereColumn('qty_actual', '>', 'qty_min')
        ->count() }}
                                <span class="status-safe">RM SAFE</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'INHOUSE')
        ->whereColumn('qty_actual', '<=', 'qty_min')
        ->where('qty_actual', '!=', 0)
        ->count() }}
                                <span class="status-critical">RM CRITICAL</span>
                            </p>
                        </div>
                    </div>

                    <p onclick="window.location.href='linestoreindex'" style="
                            display: inline-block;
                            padding: 4px 10px;
                            background: linear-gradient(to right, #4b6cb7, #182848);
                            color: white;
                            font-weight: bold;
                            font-family: Arial, sans-serif;
                            font-size: 0.85rem;
                            border-radius: 6px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
                            letter-spacing: 0.5px;
                            margin: 0;
                              cursor: zoom-in;
                         ">
                        OUTHOUSE
                    </p>


                    <div class="card-values-horizontal2">
                        <div class="value-box2">
                            <p class="card-value">
                                {{  DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->select(DB::raw('count(id) as jml'))
        ->first()->jml }}
                                <span class="status-normal">PART TOTAL</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->where(function ($query) {
            $query->whereColumn('qty_actual', '>', 'qty_min') // qty_act > qty_min
                ->orWhereColumn('qty_actual', '=', 'qty_min'); // qty_actual = qty_min
        })
        ->count() }}
                                <span class="status-safe">PART SAFE</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->where(function ($query) {
            $query->whereColumn('qty_actual', '<', 'qty_min'); // qty_actual < minimal
            // Kondisi qty_actual < 0 tetap ada untuk perhitungan total
        })
        ->where('qty_actual', '!=', 0) // Exclude actual_sheet = 0
        ->count() }}
                                <span class="status-critical">PART CRITICAL</span>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div style="text-align: center;">
                        <p style="
                                    display: inline-block;
                                    font-family: Arial;
                                    background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
                                    color: white;
                                    padding: 12px 20px;
                                    border-radius: 12px;
                                    font-weight: bold;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                    user-select: none;
                                    margin: 0;
                                ">
                            📦INFORMATION PROSES WELDING
                        </p>
                    </div>
                    <br>
                    <div class="box-grid">
                        <div class="mini-box">ROBOT 1</div>
                        <div class="mini-box">ROBOT 2</div>
                        <div class="mini-box">ROBOT 3</div>
                        <div class="mini-box">ROBOT 4</div>
                        <div class="mini-box">ROBOT 5</div>
                        <div class="mini-box">ROBOT 6</div>
                        <div class="mini-box">ROBOT 7</div>
                        <div class="mini-box">ROBOT 8</div>
                        <div class="mini-box">ROBOT 9</div>
                        <div class="mini-box">ROBOT 10</div>
                        <div class="mini-box">ROBOT 11</div>
                        <div class="mini-box">ROBOT 12</div>
                        <div class="mini-box">ROBOT 13</div>
                        <div class="mini-box">ROBOT 14</div>
                        <div class="mini-box">-</div>
                        <button onclick="window.location.href='#'" style="background-color: #007bff" class="mini-box">View
                            Plan</button>
                    </div>
                </div>

                <div class="card" style="padding: 20px;">
                    <div style="text-align: center;">
                        <p style="
                                    display: inline-block;
                                    font-family: Arial;
                                    background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
                                    color: white;
                                    padding: 12px 20px;
                                    border-radius: 12px;
                                    font-weight: bold;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                                    user-select: none;
                                    margin: 0;
                                ">
                            📦 INFORMATION PC-STORE
                        </p>
                    </div>
                    <br>
                    <p onclick="window.location.href='dashboard1'" style="
                              display: inline-block;
                              padding: 4px 10px;
                              background: linear-gradient(to right, #4b6cb7, #182848);
                              color: white;
                              font-weight: bold;
                              font-family: Arial, sans-serif;
                              font-size: 0.85rem;
                              border-radius: 6px;
                              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
                              letter-spacing: 0.5px;
                              margin: 0;
                              cursor: zoom-in;
                          ">
                        PART DIRECT
                    </p>
                    <div class="card-values-horizontal">
                        <div
                            style="position: relative; background: #f0f0f0; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(4, 12, 255, 0.386);">
                            <!-- Lingkaran sebagai indikator status, sesuaikan warnanya jika perlu -->
                            <div
                                style="position: absolute; top: 10px; left: 10px; width: 12px; height: 12px; background-color: blue; border-radius: 50%; box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);">
                            </div>

                            <!-- Menampilkan jumlah PART TOTAL -->
                            <p style="margin: 0; font-size: 20px; font-weight: bold; color:#000">
                                {{ DB::table('pc_store_directs')->select(DB::raw('count(id) as jml'))->first()->jml }}
                                <span style="display: block; font-size: 12px; color: #333; margin-top: 4px;">PART
                                    TOTAL</span>
                            </p>
                        </div>

                        <div
                            style="position: relative; background: #f0f0f0; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(55, 255, 0, 0.23);">
                            <!-- Lingkaran hijau -->
                            <div
                                style="position: absolute; top: 10px; left: 10px; width: 12px; height: 12px; background-color: green; border-radius: 50%; box-shadow: 0 0 2px rgba(63, 241, 4, 0.3);">
                            </div>

                            <!-- Isi data -->
                            <p style="margin: 0; font-size: 20px; font-weight: bold; color:#000">
                                {{ DB::table('pc_store_directs')->where('status', 'SAFE')->count() }}
                                <span style="display: block; font-size: 12px; color: green; margin-top: 4px;">ITEM PART
                                    SAFE</span>
                            </p>
                        </div>

                        <div
                            style="position: relative; background: #ffffff; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
                            <!-- Lingkaran kuning berkedip -->
                            <div
                                style="position: absolute;top: 10px;left: 10px; width: 12px; height: 12px; border-radius: 50%; background-color: yellow; animation: blinkYellow 1s infinite;">
                            </div>
                            <!-- Isi data -->
                            <p style="margin: 0; font-size: 20px; font-weight: bold; color:#000">
                                {{ DB::table('pc_store_directs')->where('status', 'WARNING')->count() }}
                                <span
                                    style="display: block; font-size: 12px; color: rgb(255, 111, 0); margin-top: 4px;">ITEM
                                    PART WARNING</span>
                            </p>
                        </div>
                        <div
                            style="position: relative; background: #ffffff; padding: 16px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
                            <!-- Lingkaran merah berkedip -->
                            <div style="position: absolute; top: 10px; left: 10px; width: 12px; height: 12px; border-radius: 50%; background-color: red; animation: blinkRed 1s infinite;
                                    "></div>
                            <!-- Isi data -->
                            <p style="margin: 0; font-size: 20px; font-weight: bold; color: #000;">
                                {{ DB::table('pc_store_directs')->where('status', 'DANGER')->count() }}
                                <span style="display: block; font-size: 12px; color: red; margin-top: 4px;">ITEM PART
                                    DANGER</span>
                            </p>
                        </div>
                    </div>

                    <p onclick="window.location.href='linestoreindex'" style="
                            display: inline-block;
                            padding: 4px 10px;
                            background: linear-gradient(to right, #4b6cb7, #182848);
                            color: white;
                            font-weight: bold;
                            font-family: Arial, sans-serif;
                            font-size: 0.85rem;
                            border-radius: 6px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
                            letter-spacing: 0.5px;
                            margin: 0;
                              cursor: zoom-in;
                        ">
                        PART SUB-ASSY
                    </p>


                    <div class="card-values-horizontal2">
                        <div class="value-box2">
                            <p class="card-value">
                                {{  DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->select(DB::raw('count(id) as jml'))
        ->first()->jml }}
                                <span class="status-normal">PART TOTAL</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->where(function ($query) {
            $query->whereColumn('qty_actual', '>', 'qty_min') // qty_act > qty_min
                ->orWhereColumn('qty_actual', '=', 'qty_min'); // qty_actual = qty_min
        })
        ->count() }}
                                <span class="status-safe">PART SAFE</span>
                            </p>

                        </div>
                        <div class="value-box2">
                            <p class="card-value">
                                {{ DB::table('line_store_stoks')
        ->where('home_line', 'OUTHOUSE')
        ->where(function ($query) {
            $query->whereColumn('qty_actual', '<', 'qty_min'); // qty_actual < minimal
            // Kondisi qty_actual < 0 tetap ada untuk perhitungan total
        })
        ->where('qty_actual', '!=', 0) // Exclude actual_sheet = 0
        ->count()   }}
                                <span class="status-critical">PART CRITICAL</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="machineModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="modalTitle">Machine Info</h3>
            <p id="modalBody">Detail informasi mesin akan muncul di sini.</p>
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


        async function fetchDashboardData() {
            try {
                const response = await fetch('{{ route("dashboard1.data") }}');
                if (!response.ok) throw new Error('Network error');
                const data = await response.json();

                document.getElementById('total-count').innerHTML = `${data.total} <span class="status-normal">(TOTAL) <i style="color: #1900ff; font-size:120%" class="fa-solid fa-bell"></i></span>`;
                document.getElementById('safe-count').innerHTML = `${data.safe} <span class="status-safe">(SAFE) <span style="color:green; font-size:110%">▲</span></span>`;
                document.getElementById('critical-count').innerHTML = `${data.critical} <span class="status-critical">(CRITICAL) <span style="color: red; font-size:110%">▼</span></span>`;

                document.getElementById('po-total').innerHTML = `${data.countDocPO} <span class="label-text">TOTAL PO</span>`;
                document.getElementById('po-close').innerHTML = `${data.countCloseStatus} <span class="label-text">PO CLOSE</span>`;
                document.getElementById('po-open').innerHTML = `${data.countStatusNull} <span class="label-text">PO OPEN</span>`;
                document.getElementById('po-percentage').innerHTML = `${data.percentage} <span class="label-text">%</span>`;

            } catch (error) {
                console.error('Fetch error:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchDashboardData();
            setInterval(fetchDashboardData, 5000); // refresh tiap 60 detik
        });

        function updateMachineStatuses() {
            $.ajax({
                type: 'GET',
                url: "{{ route('check.line.statuses') }}",
                success: function (data) {
                    const machines = ['a1', 'a2', 'b1', 'b2', 'b3', 'c1', 'c2'];

                    machines.forEach(function (machine) {
                        const box = $('#machine-' + machine);
                        const status = Number(data[`line_${machine}_status`]);

                        box.removeClass('blink-green blink-red');

                        if (status === 2) {
                            box.addClass('blink-green');
                        } else if (status === 4) {
                            box.addClass('blink-red');
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching machine statuses:', error);
                }
            });
        }

        setInterval(updateMachineStatuses, 5000);




        $(document).ready(function () {
            // Event close modal
            $('.close').on('click', function () {
                $('#machineModal').removeClass('show'); // atau $('#machineModal').hide();
            });

            // Klik di luar modal content untuk menutup
            $(window).on('click', function (e) {
                if ($(e.target).is('#machineModal')) {
                    $('#machineModal').removeClass('show'); // atau $('#machineModal').hide();
                }
            });
        });

        $('.mini-box2').on('click', function () {
            const machineName = $(this).text().trim();

            const machineMap = {
                "Machine B3": "LINE B3",
                "Machine C1": "LINE C1",
                "Machine C2": "LINE C2"
            };

            const lineName = machineMap[machineName];
            if (!lineName) {
                alert("Data mesin belum tersedia untuk " + machineName);
                return;
            }

            $.ajax({
                type: 'GET',
                url: "{{ route('machine.detail') }}",
                data: { mesin: lineName },
                success: function (response) {
                    $('#modalTitle').text(lineName);

                    if (response.status === 'success') {
                        const statusMap = {
                            null: 'Planning Ready',
                            1: 'Material Ready',
                            2: 'Proses',
                            4: 'Trouble Mesin',
                            5: 'Trouble Dies'
                        };

                        let content = '';
                        response.data.forEach(function (item) {
                            const statusValue = item.status_proses;
                            const statusText = statusMap[statusValue] ?? `Status ${statusValue}`;

                            content += `
                                <div style="margin-bottom:10px; border-bottom:1px solid #ccc; padding-bottom:5px;">
                                    <strong>Part No:</strong> ${item.part_no2}<br>
                                    <strong>Status:</strong> ${statusText}<br>
                                    <strong>Waktu:</strong> ${item.created_at ?? '-'}<br>
                                    <strong>Keterangan:</strong> ${item.keterangan ?? '-'}
                                </div>
                            `;
                        });

                        $('#modalBody').html(content);
                    } else {
                        $('#modalBody').html('Tidak ada data untuk status 2/4/5/6.');
                    }

                    $('#machineModal').addClass('show');
                },
                error: function () {
                    alert('Gagal mengambil data.');
                }
            });
        });





    </script>
@endpush