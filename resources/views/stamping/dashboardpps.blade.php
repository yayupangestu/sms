<html>

<head>
    <title>
        Dashboard Patan Production Stamping
    </title>
    <style>
        body {
            background-color: #001f3f;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
            background-color: #003366;
            color: white;
            position: relative;
        }

        .header img {
            height: 50px;
        }

        .header .clock-container {
            position: absolute;
            top: 5px;
            right: 10px;
            text-align: right;
        }

        .header h3 {
            font-size: 40px;
            margin: 0;
            color: white;
        }

        .title {
            margin: 20px 0;
            font-size: 50px;
        }

        .update {
            background-color: #003366;
            padding: 10px;
            text-align: right;
            width: 100%;
        }

        .update div {
            margin: 5px 0;
        }

        .dashboard {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}

.section {
    background-color: #004080;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    max-width: 1200px; /* Bisa disesuaikan */
    overflow-x: auto;
}


.section h2 {
    background-color: #373a3e;
    padding: 8px;
    margin: 0;
    text-align: center;
    color: white;
    font-size: 50px;
    border-radius: 3px;
}

.shift {
    margin: 10px 0;
    background-color: #0059b3;
    padding: 10px;
    border-radius: 5px;
    overflow-x: auto;
}

.shift table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Biar wrap teks dan tidak melar */
    background-color: #003366;
    color: white;
}

.shift th,
.shift td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    font-size: 16px;
    word-wrap: break-word;
    white-space: normal;
    overflow-wrap: break-word;
}

.shift th {
    background-color: #002752;
    font-size: 17px;
    font-weight: bold;
    color: white;
}

/* Responsive di layar kecil */
@media screen and (max-width: 768px) {
    .section {
        width: 100%;
    }

    .shift th,
    .shift td {
        font-size: 14px;
        padding: 6px;
    }

    .section h2 {
        font-size: 18px;
    }
}


.status-finish,
.status-process,
.status-wait,
.status-ready,
.status-trouble,
.status-blank,
.status-dies,
.status-cancel,
.status-prepare,
.status-inprocess {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    min-width: 100px;
    text-align: center;
    font-weight: bold;
    margin: 2px; /* Jarak antar badge */
    color: white; /* Warna teks tetap jelas */
}


/* Warna tetap seperti semula */
.status-finish { background-color: #d3d3d3; color: #000000}
.status-process { background-color: #1e90ff; color: rgb(255, 255, 255); }
.status-blank { background-color: #8eb5dc; color: rgb(255, 254, 254); }
.status-prepare { background-color: #00d5ff; color: #000000 }
.status-ready { background-color: #00ff7f; color: rgb(0, 0, 0); }
.status-trouble { background-color: #ff0000; }
.status-dies { background-color: #ff2f00; }
.status-cancel { background-color: #ffee54; color: rgb(0, 0, 0); }
.status-inprocess { background-color: #7db3b2; color: rgb(255, 255, 255); }

/* Efek berkedip tetap ada */
.blinking {
    animation: blink-animation 1s infinite alternate;
}

@keyframes blink-animation {
    from { opacity: 1; }
    to { opacity: 0.5; }
}



    .blinking {
    animation: blink-animation 3s infinite;
    }

    @keyframes blink-animation {
        50% {
            opacity: 0;
        }
    }

    .btn-home {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        background-color: orange;
        color: black;
        transition: background 0.3ms;
    }

    .shift-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        background-color: #007bff;
        color: white;
        transition: background 0.3s;
    }

    .shift-btn:hover {
        background-color: #fafafa;
    }

    .shift-btn.active {
        background-color: #28a745;
    }

            table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 3px solid black; /* Menambahkan kotak (border) pada tiap sel */
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4; /* Warna latar belakang untuk header */
        }

        #shiftDisplayWrapper {
    background-color: #6a849f;
    color: white;
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 2.2rem;
}


/* 🔴 Animasi blink smooth merah */
@keyframes blinkRed {
    0% { background-color: rgba(255, 0, 0, 0.2); }
    50% { background-color: rgba(255, 0, 0, 0.8); }
    100% { background-color: rgba(255, 0, 0, 0.2); }
}

.blink-red {
    animation: blinkRed 1.2s infinite ease-in-out;
    border-radius: 6px;
    color: white;
    font-weight: bold;
}


    </style>
</head>

<body>

    <div class="header" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; position: relative;">
        <!-- Logo Container -->
        <div style="background-color: #ffffff; padding: 5px; border-radius: 8px;">
            <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
        </div>

        <!-- Clock Container -->
        <div class="clock-container">
            <h3 id="clock" class="text-right"></h3>
        </div>
    </div>

    <!-- Shift Buttons (Dibuat terpisah dari header agar bisa turun) -->
    <!-- Shift Buttons (Dibuat terpisah dari header agar bisa turun ke bawah) -->
<div class="shift-buttons" style="display: flex; justify-content: flex-start; gap: 10px; margin-top: 20px; padding-left: 20px;">
     <a href="home" style="margin-left: 20px;">
        <button class="btn-home">
            <i class="fa fas fa-arrow-left"></i> HOME
        </button>
    </a>
</div>

<div class="shift-buttons" style="display: flex; justify-content: flex-start; gap: 10px; margin-top: 20px; padding-left: 20px;">
   <button class="shift-btn active" onclick="filterShift(1)">SHIFT-1</button>
   <button class="shift-btn" onclick="filterShift(2)">SHIFT-2</button>
   <button class="shift-btn" onclick="filterShift(3)">SHIFT-3</button>

</div>


    <div class="container">
        <div class="title">
            DASHBOARD PATAN PRODUCTION STAMPING
        </div>

        <div class="dashboard">



            <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE A1</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay1">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableA1">
                        <thead>
                          <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE A2</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay2">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableA2">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE B1</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay3">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableB1">
                        <thead>
                       <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE B2</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay4">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableB2">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

             <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE B3</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay5">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableB3">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

             <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE C1</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay6">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableC1">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

             <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE C2</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay7">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableC2">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

             <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE TRANSFERS</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay8">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="table3000">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE KOMATSU</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay9">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableKomatsu">
                        <thead>
                             <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="fw-bold mb-0">LINE FUKUI</h2>
                    <div class="badge bg-primary fs-4" id="shiftDisplayWrapper">
                        SHIFT <span id="shiftDisplay10">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableFukui">
                        <thead>
                           <tr>
                                <th width="30px" style="font-size: 20px">NO</th>
                                <th width="100px" style="font-size: 25px">PART NO</th>
                                <th width="100px" style="font-size: 25px">MODEL</th>
                                <th width="100px" style="font-size: 25px">PLAN</th>
                                <th Width="100px" style="font-size: 25px">ACTUAL</th>
                                <th width="120px" style="font-size: 25px">STATUS</th>
                                <th width="120px" style="font-size: 25px">TIME START</th>
                                <th width="120px" style="font-size: 25px">TIME END</th>
                                {{-- <th width="120px" style="font-size: 30px">GSPH</th> --}}
                                   <th width="150px" style="font-size: 30px">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>



</html>
