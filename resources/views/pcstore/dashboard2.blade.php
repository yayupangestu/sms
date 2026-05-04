<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stamping Production - Dashboard</title>
    <!-- Modern Typography -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=JetBrains+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-deep: #05070a;
            --bg-card: rgba(16, 20, 24, 0.8);
            --border-glass: rgba(255, 255, 255, 0.1);
            --accent-blue: #3d8af7;
            --text-primary: #ffffff;
            --text-secondary: #a0aec0;
            --terminal-green: #00ff9d;
            --terminal-alert: #ff4d4d;
            --terminal-warn: #fbbf24;
            --terminal-font: 'JetBrains Mono', monospace;
            --ui-font: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-deep);
            background-image:
                radial-gradient(circle at 50% 0%, rgba(61, 138, 247, 0.15) 0%, transparent 50%),
                linear-gradient(rgba(0, 0, 0, 0.4) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.4) 1px, transparent 1px);
            background-size: 100% 100%, 20px 20px, 20px 20px;
            color: var(--text-primary);
            font-family: var(--ui-font);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Glass Container */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: rgba(0, 0, 0, 0.5);
            border-bottom: 1px solid var(--border-glass);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header .logo-box {
            background: white;
            padding: 8px 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
        }

        .header img {
            height: 40px;
            width: auto;
        }

        .header-title-wrapper {
            text-align: center;
            flex-grow: 1;
        }

        .header-title-wrapper h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: linear-gradient(to right, #fff, var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .clock-panel {
            text-align: right;
            min-width: 250px;
        }

        #clock {
            font-family: var(--terminal-font);
            font-size: 20px;
            color: var(--terminal-green);
            text-shadow: 0 0 10px rgba(0, 255, 157, 0.3);
            margin: 0;
        }

        .system-date {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Controls */
        .controls-bar {
            padding: 15px 30px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-terminal {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glass);
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-terminal:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-blue);
        }

        .btn-terminal.active {
            background: var(--accent-blue);
            color: white;
            box-shadow: 0 0 15px rgba(61, 138, 247, 0.4);
        }

        .btn-home {
            background: #f59e0b;
            color: #000;
            border: none;
        }

        /* Dashboard Grid */
        .dashboard-container {
            padding: 0 20px 20px 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (min-width: 1800px) {
            .dashboard-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1400px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Line Cards */
        .line-card {
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .line-card-header {
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--border-glass);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .line-card-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            color: var(--accent-blue);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .line-card-header h2::before {
            content: '';
            display: block;
            width: 4px;
            height: 20px;
            background: var(--accent-blue);
            border-radius: 2px;
        }

        .shift-badge {
            font-family: var(--terminal-font);
            background: rgba(61, 138, 247, 0.2);
            color: var(--accent-blue);
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 15px;
            border: 1px solid rgba(61, 138, 247, 0.3);
        }

        /* Tables Terminal Style */
        .terminal-table-wrapper {
            padding: 0;
            flex-grow: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        th {
            background: rgba(0, 0, 0, 0.3) !important;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 16px;
            letter-spacing: 1px;
            padding: 12px 10px;
            text-align: center;
            border-bottom: 1px solid var(--border-glass);
        }

        td {
            padding: 12px 10px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            font-family: var(--terminal-font);
            font-size: 16px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
            color: #fff;
        }

        .col-part {
            color: #fff;
            font-weight: 600;
            width: 120px;
        }

        .col-model {
            color: var(--text-secondary);
            width: 80px;
        }

        .col-plan {
            color: var(--terminal-warn);
            font-weight: 700;
            width: 60px;
        }

        .col-actual {
            color: var(--terminal-green);
            font-weight: 700;
            width: 60px;
        }

        .col-time {
            color: var(--text-secondary);
            font-size: 16px;
            width: 90px;
        }

        .col-remark {
            color: var(--text-secondary);
            font-size: 16px;
            text-align: left;
        }

        /* Status Badges - FIDS Style */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            min-width: 100px;
            letter-spacing: 1.5px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .status-badge::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: 0.5s;
        }

        .status-badge:hover::after {
            left: 100%;
        }

        .status-ready {
            background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
            color: #fff;
            border-left: 3px solid #34d399;
        }

        .status-process {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #fff;
            border-left: 3px solid #60a5fa;
            animation: pulse-blue 2s infinite;
        }

        .status-finish {
            background: linear-gradient(135deg, #4ef00e 0%, #ebfceb 100%);
            color: #000000;
            border-left: 3px solid #94a3b8;
        }

        .status-trouble {
            background: linear-gradient(135deg, #991b1b 0%, #ef4444 100%);
            color: #fff;
            border-left: 3px solid #f87171;
            animation: pulse-red 1s infinite;
        }

        .status-prepare {
            background: linear-gradient(135deg, #9ba330 0%, #f1e863 100%);
            color: #020202;
            border-left: 3px solid #818cf8;
        }

        .status-cancel {
            background: linear-gradient(135deg, #2a0f0f 0%, #b92e2e 100%);
            color: #94a3b8;
            border-left: 3px solid #475569;
        }

        @keyframes pulse-blue {
            0% {
                box-shadow: 0 0 0 0 rgba(61, 138, 247, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(61, 138, 247, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(61, 138, 247, 0);
            }
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 77, 77, 0.4);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(255, 77, 77, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 77, 77, 0);
            }
        }

        /* Blink for Alert Numbers */
        .blink-red {
            color: var(--terminal-alert) !important;
            animation: blinker 0.8s linear infinite;
            font-weight: 800;
        }

        @keyframes blinker {
            50% {
                opacity: 0.2;
            }
        }

        .status-blink {
            animation: blinker 1s linear infinite;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-blue);
            border-radius: 3px;
        }
    </style>
</head>


<body>

    <div class="header">
        <div class="logo-box">
            <img src="dist/img/adw3.png" alt="Logo">
        </div>

        <div class="header-title-wrapper">
            <h1>Stamping Production MONITORING</h1>
        </div>

        <div class="clock-panel glass-panel" style="padding: 10px 20px;">
            <p id="clock">00:00:00</p>
            <div class="system-date" id="systemDate">Lading...</div>
        </div>
    </div>

    <div class="controls-bar">
        <a href="home" style="text-decoration: none;">
            <button class="btn-terminal btn-home">
                <i class="fa-solid fa-house"></i> Home
            </button>
        </a>
        <div style="flex-grow: 1; display: flex; gap: 10px; justify-content: center;">
            <button class="btn-terminal shift-btn active" id="btn-shift-1" onclick="filterShift(1)">(Shift
                1)</button>
            <button class="btn-terminal shift-btn" id="btn-shift-2" onclick="filterShift(2)">(Shift
                2)</button>
            <button class="btn-terminal shift-btn" id="btn-shift-3" onclick="filterShift(3)">(Shift
                3)</button>
        </div>
        <div class="btn-terminal" style="border-color: var(--terminal-green); color: var(--terminal-green);">
            <i class="fa-solid fa-tower-broadcast"></i> LIVE
        </div>
    </div>

    <div class="dashboard-container">
        <div class="dashboard-grid">
            <!-- Line A1 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE A1</h2>
                    <div class="shift-badge"> <span id="shiftDisplay1"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableA1">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line A2 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE A2</h2>
                    <div class="shift-badge"> <span id="shiftDisplay2"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableA2">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line B1 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE B1</h2>
                    <div class="shift-badge"> <span id="shiftDisplay3"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableB1">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line B2 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE B2</h2>
                    <div class="shift-badge"> <span id="shiftDisplay4"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableB2">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line B3 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE B3</h2>
                    <div class="shift-badge"> <span id="shiftDisplay5"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableB3">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line C1 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE C1</h2>
                    <div class="shift-badge"> <span id="shiftDisplay6"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableC1">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line C2 -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE C2</h2>
                    <div class="shift-badge"> <span id="shiftDisplay7"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableC2">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line TRANSFERS -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE TRANSFERS</h2>
                    <div class="shift-badge"> <span id="shiftDisplay8"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="table3000">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line KOMATSU -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE KOMATSU</h2>
                    <div class="shift-badge"> <span id="shiftDisplay9"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableKomatsu">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Line FUKUI -->
            <div class="line-card glass-panel">
                <div class="line-card-header">
                    <h2>LINE FUKUI</h2>
                    <div class="shift-badge"> <span id="shiftDisplay10"></span></div>
                </div>
                <div class="terminal-table-wrapper">
                    <table id="tableFukui">
                        <thead>
                            <tr>
                                <th width="40">NO</th>
                                <th>PART NO</th>
                                <th>MODEL</th>
                                <th width="70">PLAN</th>
                                <th width="70">ACTUAL</th>
                                <th width="110">STATUS</th>
                                <th width="90">START</th>
                                <th width="90">END</th>
                                <th>REMARK</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        let currentShift = 1;

        function updateClock() {
            const clockElement = document.getElementById("clock");
            const dateElement = document.getElementById("systemDate");
            const now = new Date();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            const dayName = days[now.getDay()];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();

            if (clockElement) clockElement.innerText = `${hours}:${minutes}:${seconds}`;
            if (dateElement) dateElement.innerText = `${dayName}, ${date} ${monthName} ${year}`;
        }

        setInterval(updateClock, 1000);
        updateClock();

        function fetchAndUpdateData() {
            const url = "{{ route('dashboard2.data') }}";
            const finalUrl = `${url}?shift=${currentShift}`;

            fetch(finalUrl, { method: "GET" })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    updateTableData(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function filterShift(shift) {
            currentShift = shift;
            // Update active state of buttons
            document.querySelectorAll('.shift-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById(`btn-shift-${shift}`);
            if (activeBtn) activeBtn.classList.add('active');

            // Update  numbers
            for (let i = 1; i <= 10; i++) {
                const el = document.getElementById(`shiftDisplay${i}`);
                if (el) el.innerText = currentShift;
            }
            fetchAndUpdateData();
        }

        function getStatusPriority(item) {
            const status = parseInt(item.status_proses, 10);
            if (isNaN(status) || status === null) return 99;
            if (status === 2) return 1;  // PROCESS
            if (status === 7) return 2;  // IN PROCESS
            if (status === 1) return 5;  // READY
            if (status === 4) return 4;  // READY BLANK
            if (status === 3) return 3;  // FINISH
            return 90;
        }

        function animateRowMovement(tableId, newData) {
            const tableBody = document.querySelector(`#${tableId} tbody`);
            if (!tableBody) return;

            const oldRows = Array.from(tableBody.querySelectorAll("tr"));
            const newOrder = newData.map(item => item.job_no);
            let movedRows = [];

            // Sort data by priority
            newData.sort((a, b) => getStatusPriority(a) - getStatusPriority(b));

            tableBody.innerHTML = "";
            newData.forEach((item, index) => {
                const row = document.createElement("tr");

                const actualVal = item.actual_production != null ? item.actual_production : 0;
                const actualClass = item.description_sts == 1 ? 'blink-red' : '';

                row.innerHTML = `
                    <td style="color: var(--text-secondary); font-size: 11px;">${String(index + 1).padStart(2, '0')}</td>
                    <td class="col-part">${item.part_no2}</td>
                    <td class="col-model">${item.model_id || '-'}</td>
                    <td class="col-plan">${item.qty_plan}</td>
                    <td class="col-actual ${actualClass}">${actualVal}</td>
                    <td>${getStatusLabel(item)}</td>
                    <td class="col-time">${item.time_startProses || '--:--'}</td>
                    <td class="col-time">${item.time_endProses || '--:--'}</td>
                    <td class="col-remark">${item.description || '-'}</td>
                `;

                tableBody.appendChild(row);
            });
        }

        function updateTableData(data) {
            const mapping = {
                "tableA1": data.planningDataA1,
                "tableA2": data.planningDataA2,
                "tableB1": data.planningDataB1,
                "tableB2": data.planningDataB2,
                "tableB3": data.planningDataB3,
                "tableC1": data.planningDataC1,
                "tableC2": data.planningDataC2,
                "table3000": data.planningData3000,
                "tableKomatsu": data.planningDataKomatsu,
                "tableFukui": data.planningDataFukui
            };

            Object.entries(mapping).forEach(([id, dataset]) => {
                animateRowMovement(id, dataset || []);
            });
        }

        function getStatusLabel(item) {
            const status = parseInt(item.status_proses, 10);
            const status2 = parseInt(item.status_proses2, 10);
            const qtyOut = item.qty_out_material;

            if ((item.status_proses === null || item.status_proses === '') && (qtyOut === null || qtyOut == 0)) {
                return `<span class="status-badge status-prepare">PREPARING</span>`;
            }
            if (status === 1 && status2 === 2) {
                return `<span class="status-badge status-process status-blink">PROSES BLANK</span>`;
            }
            if (status === 6) {
                return `<span class="status-badge status-trouble">RMTA / ALER</span>`;
            }
            if ((qtyOut === null || qtyOut == 0) && status === 1) {
                return `<span class="status-badge status-prepare">READY TRANSIT</span>`;
            }
            if (status === 1) {
                return `<span class="status-badge status-ready">PREPARE</span>`;
            }
            if (status === 2) {
                return `<span class="status-badge status-process status-blink">IN PROCESS</span>`;
            }
            if (status === 3) {
                return `<span class="status-badge status-finish">FINISH</span>`;
            }
            if (status === 4) {
                return `<span class="status-badge status-ready">READY BLANK</span>`;
            }
            if (status === 7) {
                return `<span class="status-badge status-process status-blink">PROCESS WIP</span>`;
            }
            if (status === 5) {
                return `<span class="status-badge status-cancel status-blink">CANCELLED</span>`;
            }
            return `<span class="status-badge status-ready">STANDBY</span>`;
        }

        setInterval(fetchAndUpdateData, 5000);
        fetchAndUpdateData();
    </script>
</body>

</html>



</html>
