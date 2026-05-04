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
                                <th width="60px" style="font-size: 20px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                        SHIFT <span id="shiftDisplay8">1</span>
                    </div>
                </div>
                <div class="shift">
                    <table id="tableKomatsu2">
                        <thead>
                            <tr>
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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
                                <th width="60px" style="font-size: 30px">NO</th>
                                <th width="120px" style="font-size: 30px">PART NO</th>
                                <th width="120px" style="font-size: 30px">MODEL</th>
                                <th width="120px" style="font-size: 30px">PLAN</th>
                                <th Width="125px" style="font-size: 30px">ACTUAL</th>
                                <th width="160px" style="font-size: 30px">STATUS</th>
                                <th width="120px" style="font-size: 30px">TIME START</th>
                                <th width="120px" style="font-size: 30px">TIME END</th>
                                <th width="120px" style="font-size: 30px">GSPH</th>
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

    <script>
   let currentShift = 1;

function updateClock() {
    const clockElement = document.getElementById("clock");
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember'];
    const dayName = days[now.getDay()];
    const monthName = months[now.getMonth()];
    const date = now.getDate();
    const year = now.getFullYear();
    clockElement.innerText = `${dayName}, ${date} ${monthName} ${year}, ${hours}:${minutes}:${seconds}`;
}
setInterval(updateClock, 1000);
updateClock();

function fetchAndUpdateData() {
    const url = "{{ route('dashboard.data') }}";
    const finalUrl = `${url}?shift=${currentShift}`;

    fetch(finalUrl, { method: "GET" })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            updateTableData(data);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function filterShift(shift) {
    currentShift = shift;
    document.querySelectorAll('.shift-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById('shiftDisplay1').innerText = currentShift;
    document.getElementById('shiftDisplay2').innerText = currentShift;
    document.getElementById('shiftDisplay3').innerText = currentShift;
    document.getElementById('shiftDisplay4').innerText = currentShift;
    document.getElementById('shiftDisplay5').innerText = currentShift;
    document.getElementById('shiftDisplay6').innerText = currentShift;
    document.getElementById('shiftDisplay7').innerText = currentShift;
    document.getElementById('shiftDisplay8').innerText = currentShift;
    document.getElementById('shiftDisplay9').innerText = currentShift;
    document.getElementById('shiftDisplay10').innerText = currentShift;
    fetchAndUpdateData();
}

// Fungsi prioritas urutan status → berdasarkan status_proses
function getStatusPriority(item) {
    const status = parseInt(item.status_proses, 10);

    if (isNaN(status) || status === null) return 99; // kalau null atau undefined taruh paling belakang

    if (status === 2) return 1;  // PROSES diutamakan pertama
    if (status === 3) return 2;  // FINISH diutamakan kedua
    if (status === 1) return 3;  // READY diutamakan ketiga
    if (status === 7) return 4;  // IN PROCESS
    if (status === 4) return 5;  // READY BLANK
    if (status === 6) return 6;  // RMTA
    if (status === 5) return 7;  // PROCESS CANCEL

    return 99; // Status lain bebas
}


function animateRowMovement(tableId, newData) {
    const tableBody = document.querySelector(`#${tableId} tbody`);
    const oldRows = Array.from(tableBody.querySelectorAll("tr"));
    const newOrder = newData.map(item => item.job_no);
    let movedRows = [];

    oldRows.forEach(row => {
        const jobNo = row.children[2].innerText;
        const newIndex = newOrder.indexOf(jobNo);
        if (newIndex !== -1) {
            const oldIndex = oldRows.indexOf(row);
            if (oldIndex !== newIndex) {
                movedRows.push(jobNo);
                row.style.transition = "transform 0.8s ease-in-out, background-color 0.8s ease-in-out";
                row.style.transform = `translateY(${(oldIndex - newIndex) * -30}px)`;
                row.style.background = "#000080";
                row.style.color = "#ffffff";
            }
        }
    });

    setTimeout(() => {
        // Urutkan berdasarkan prioritas status
        newData.sort((a, b) => getStatusPriority(a) - getStatusPriority(b));

        tableBody.innerHTML = "";
        newData.forEach((item, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td style="font-size: 30px">${index + 1}</td>
                <td style="font-size: 30px">${item.part_no2}</td>
                <td style="font-size: 30px">${item.model_id || '-'}</td>
                <td style="font-size: 30px">${item.qty_plan}</td>
                <td style="font-size: 30px">${item.actual_production != null ? item.actual_production : 0}</td>
                <td style="font-size: 30px">${getStatusLabel(item.status_proses, item.qty_out_material, item.qty_plan, item.status_proses2, item.sts_wip)}</td>
                 <td style="font-size:30px">${item.time_startProses || '-'}</td>
                <td style="font-size: 30px">${item.time_endProses || '-'}</td>
                 <td style="font-size:30px">${item.gsph || '-'}</td>
                <td style="font-size: 30px">${item.description || '-'}</td>
            `;

            if (movedRows.includes(item.job_no)) {
                row.style.background = "#000080";
                row.style.color = "#ffffff";
                setTimeout(() => {
                    row.style.transition = "background-color 0.8s ease-in-out";
                    row.style.background = "";
                    row.style.color = "";
                }, 800);
            }

            tableBody.appendChild(row);
        });
    }, 800);
}

function updateTableData(data) {
    animateRowMovement("tableB3",       data.planningDataB3         || []);
    animateRowMovement("tableC1",       data.planningDataC1         || []);
    animateRowMovement("tableC2",       data.planningDataC2         || []);
    animateRowMovement("tableA1",       data.planningDataA1         || []);
    animateRowMovement("tableA2",       data.planningDataA2         || []);
    animateRowMovement("tableB1",       data.planningDataB1         || []);
    animateRowMovement("tableB2",       data.planningDataB2         || []);
    animateRowMovement("tableKomatsu",  data.planningDataKomatsu    || []);
    animateRowMovement("tableFukui",    data.planningDataFukui      || []);
    animateRowMovement("tableKomatsu2", data.planningData3000      || []);

}

function getStatusLabel(status_proses, qty_out_material, qty_plan, status_proses2, sts_wip) {
    const normalizedStatus = parseInt(status_proses, 10);
    const normalizedStatus2 = parseInt(status_proses2, 10);
    const normalizedStatus3 = parseInt(sts_wip, 10);

    if ((status_proses === null || status_proses === '') && (qty_out_material === null || qty_out_material == 0)) {
        return `<span class="status-prepare">PREPARE</span>`;
    }

    if (normalizedStatus === 1 && normalizedStatus2 === 2) {
        return `<span class="status-blank blinking">Proses Blank</span>`;
    }

    if (normalizedStatus === 6) {
        return `<span class="status-dies">RMTA</span>`;
    }

    if ((qty_out_material === null || qty_out_material == 0) && normalizedStatus === 1) {
        return `<span class="status-ready">READY TRANSIT</span>`;
    }

    if (normalizedStatus === 1) {
        return `<span class="status-ready">READY</span>`;
    }

    // // ✅ Jika sts_wip bernilai 1 → tampilkan badge "IN PROSES"
    // if (normalizedStatus3 === 1) {
    //     return `<span class="status-inprocess blinking">IN PROSES</span>`;
    // }

    if (normalizedStatus === 2) {
        return `<span class="status-process blinking">PROCESS</span>`;
    }

    if (normalizedStatus === 3) {
        return `<span class="status-finish">FINISH</span>`;
    }

    if (normalizedStatus === 4) {
        return `<span class="status-blank">READY BLANK</span>`;
    }

    if (normalizedStatus === 7) {
        return `<span class="status-inprocess blinking">IN PROCESS</span>`;

    }
    if (normalizedStatus === 5) {
        return `<span class="status-cancel blinking">PROCESS CANCEL</span>`;
    }


    return `<span class="status-ready">READY</span>`;
}


setInterval(fetchAndUpdateData, 5000);
fetchAndUpdateData();

    </script>


</html>
