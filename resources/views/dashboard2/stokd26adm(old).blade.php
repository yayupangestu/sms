<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stock Strength Dashboard (Hour) ASTRA DAIHATSU MOTOR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #111;
            --muted: #ffffff;
            --line: #e5e7eb;
            --bg: #ffffff;
            --sheet: #f9fafb;
            --accent: #fd0037;
            /* red for KOSONG */
            --warn: #f59e0b;
            /* MIN */
            --ok: #10b981;
            /* SAFE */
            --axis: #9ca3af;
            --blue: #60a5fa;
            --radius: 14px;
            --chart-max: 32;
            /* hours */
            --safe-hour: 16;
            /* vertical SAFE line on the chart */
            --sidebar: 320px;

            /* reserved datapanel on the right */
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            margin: 0;
            background: #eef2f6;
            font-family: Inter, system-ui, Segoe UI, Arial, sans-serif;
            color: var(--ink)
        }

        .page {
            height: 100%;
            display: grid;
            grid-template-columns: 1fr var(--sidebar);
            gap: 20px;
            padding: 20px;
        }

        .sheet {
            height: 100%;
            width: 100%;
            background: var(--bg);
            border: 1px solid #cbd5e1;
            border-radius: 18px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, .08);
            padding: 18px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* === Sidebar (2 list terpisah) === */
        .sidebar {
            height: 100%;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, .04);
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            overflow: auto;
        }

        .side-section {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px
        }

        .side-title {
            font-weight: 800;
            font-size: 25px;
            margin-bottom: 8px;
            color: #111
        }

        .side-sub {
            font-size: 11px;
            color: var(--muted);
            margin: -4px 0 8px
        }

        .side-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .side-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: var(--sheet);
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 30px
        }

        .side-item .left {
            display: flex;
            flex-direction: column
        }

        .side-item .code {
            font-weight: 700
        }

        .side-item .line {
            color: var(--muted);
            /* font-size: 20px */
        }

        .badge {
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 20px;
            background: #eef2ff;
            color: #1f2937;
            border: 1px solid #e5e7eb
        }

        /* Header */
        .header {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px
        }

        .brand-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 16px;
            align-items: center
        }

        .brand {
            height: 42px;
            width: 120px;
            background: #edf2f7;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-weight: 700;
            color: #64748b
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            font-size: 12px
        }

        .meta .cell {
            background: var(--sheet);
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 10px
        }

        .meta .key {
            display: block;
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 2px
        }

        .update-box {
            border: 2px solid #ef4444;
            border-radius: 12px;
            padding: 8px 14px;
            text-align: center;
            background: #fff
        }

        .update-box .t {
            font-size: 12px;
            color: #ef4444;
            font-weight: 700;
            letter-spacing: .04em
        }

        .update-box .time {
            font-size: 25px;
            font-weight: 800;
            margin-top: 2px
        }

        .title {
            text-align: center;
            margin: 12px 0 16px;
            font-weight: 900;
            font-size: 1.5rem;
            /* lebih besar */
            letter-spacing: 0.03em;
            color: #1e3a8a;
            /* biru gelap */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            /* sedikit bayangan */
            padding-bottom: 6px;
            border-bottom: 3px solid #3b82f6;
            /* garis bawah biru */
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            /* gradasi biru lembut */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            /* teks gradasi */
        }


        .subtitle {
            font-size: 12px;
            color: var(--muted);
            text-align: center;
            margin: 0 0 10px
        }

        /* Table + Chart */
        .table-wrap {
            flex: 1 1 auto;
            min-height: 0;
            overflow: auto;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: var(--sheet)
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 12px;
            table-layout: fixed
        }

        thead th {
            position: sticky;
            top: 0;
            background: #ffffff;
            border-bottom: 1px solid var(--line);
            z-index: 2;
            padding: 8px 8px;
            text-align: center;
            font-weight: 700;
            color: #111
        }

        tbody td {
            background: #fff;
            border-bottom: 1px solid var(--line);
            padding: 7px 8px
        }

        tbody tr:nth-child(odd) td {
            background: #fcfcfd
        }

        th,
        td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        th:first-child,
        td:first-child {
            border-left: 0;
            border-top-left-radius: 12px
        }

        th:last-child,
        td:last-child {
            border-right: 0
        }

        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px
        }

        tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px
        }

        .c-line {
            width: 800px
        }

        .c-part {
            width: 250px
        }

        .c-job {
            width: 200px;
            text-align: center
        }

        .c-num1 {
            width: 200px;
            text-align: right
        }

        .c-num {
            width: 250px;
            text-align: right
        }

        .c-month {
            width: 250px;
            text-align: right
        }

        .c-daily {
            width: 200px;
            text-align: right
        }


        .c-status {
            width: 200px;
            text-align: center
        }

        .c-chart {
            position: relative;
        }

        /* Tabel */
        #stockTable thead th {
            background: linear-gradient(to bottom, #6f7fab, #c5d5f8);
            color: rgb(0, 0, 0);
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #1E40AF;
            position: sticky;
            /* agar header sticky saat scroll */
            top: 0;
            z-index: 2;
        }

        /* Container chart harus relative agar safe-line & safe-tag mengikuti kolom */
        .c-chart {
            position: relative;
        }

        Garis SAFE .c-chart .safe-line {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 9px;
            background-color: #16a34a;
            left: calc((1 / 3) * 100%);
        }

        /* Label SAFE */
        .c-chart .safe-tag {
            position: absolute;
            top: 50%;
            left: calc((1 / 3) * 100%);
            transform: translate(-50%, -50%);
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
            white-space: nowrap;
        }



        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 68px;
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 11px;
            color: #fff
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 25px;
            border-radius: 4px;
            color: white;
        }

        .status-kosong {
            background: var(--accent);
        }

        .status-min {
            background: var(--warn);
            color: #111;
        }

        .status-safe {
            background: var(--ok);
        }

        .status-danger {
            background: #e5ff00;
            /* merah */
            color: #000000;
        }




        /* Chart cell */
        .chart-cell {
            position: relative;
            height: 28px;
            padding: 0 10px;
            background: #fff
        }

        .chart-axis {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(0, 0, 0, 0.06) 1px, transparent 1px) 0 0/40px 100%,
                linear-gradient(#f3f4f6, #f3f4f6) 0 100%/100% 1px no-repeat;
            pointer-events: none;
        }

        .axis-labels {
            position: relative;
            top: 0;
            z-index: 3;
            background: #fff;
            border-bottom: 1px solid var(--line);
            height: 36px
        }

        .axis-scale {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 100%;
            display: flex;
            gap: 0
        }

        .axis-scale span {
            flex: 0 0 40px;
            text-align: center;
            font-size: 10px;
            color: var(--axis);
            line-height: 36px
        }

        .safe-line {
            position: absolute;
            top: 0;
            bottom: 0;
            /* biar membentang sampai bawah */
            width: 4px;
            /* garis lebih tebal */
            background: var(--ok);
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.15);
        }

        .safe-tag {
            position: absolute;
            top: -9px;
            left: calc((var(--safe-hour) / var(--chart-max)) * 100% + 4px);
            background: var(--ok);
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 6px;
            font-weight: 700
        }

        .bar {
            position: absolute;
            left: 10px;
            top: 5px;
            bottom: 5px;
            border-radius: 5px;
            display: flex;
            align-items: center
        }

        .bar>.dots {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: 22px;
            gap: 4px;
            margin-left: 6px
        }

        .dot {
            height: 18px;
            border-radius: 4px;
            background: #bfdbfe
        }

        .bar.kosong {
            background: rgba(225, 29, 72, .10);
            border: 1px solid rgba(225, 29, 72, .5)
        }

        .bar.min {
            background: rgba(245, 158, 11, .12);
            border: 1px solid rgba(245, 158, 11, .6)
        }

        .bar.safe {
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .6)
        }




        /* Legend */
        .legend {
            display: flex;
            gap: 14px;
            align-items: center;
            font-size: 25px;
            /* color: var(--muted); */
            color: #000000;
            margin-top: 6px
        }

        .lg {
            display: inline-flex;
            align-items: center;
            gap: 6px
        }

        .lg i {
            width: 30px;
            height: 20px;
            border-radius: 3px;
            display: inline-block
        }

        .lg .i1 {
            background: rgba(225, 29, 72, .8)
        }

        .lg .i2 {
            background: rgba(245, 158, 11, .9)
        }

        .lg .i3 {
            background: rgba(16, 185, 129, 1)
        }

         .lg .i4 {
            background: rgb(239, 243, 0)
        }

        @media (max-width:1100px) {
            :root {
                --sidebar: 0px;
            }

            .page {
                grid-template-columns: 1fr
            }

            .sidebar {
                display: none
            }
        }

        @media print {
            body {
                background: white
            }

            .page {
                padding: 0;
                gap: 0;
                grid-template-columns: 1fr
            }

            .sidebar {
                display: none
            }

            .sheet {
                box-shadow: none;
                border-radius: 0;
                border: 0
            }
        }

        #stockTable thead th {
            text-align: center;
            /* horizontal center */
            vertical-align: middle;
            /* vertikal center */
            font-size: 25px;
            /* ukuran font */
        }
        /* Sidebar section */
.side-section {
    background-color: #292f45;
    color: #fff;
    padding: 15px;
    border-radius: 8px;
    width: 300px;
    font-family: Arial, sans-serif;
}

/* Title */
.side-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #00bfff;
}

/* List items */
.side-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.side-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #1e2a5f;
    padding: 8px 12px;
    margin-bottom: 5px;
    border-radius: 6px;
    transition: background-color 0.3s, transform 0.2s;
    cursor: pointer;
}

/* Hover effect */
.side-item:hover {
    background-color: #2540a8;
    transform: translateX(5px); /* efek geser saat hover */
}

/* Arrow */
.side-item .arrow {
    color: #00ffcc;
    margin-right: 8px;
    font-size: 16px;
    transition: transform 0.3s;
}

/* Geser panah saat hover item */
.side-item:hover .arrow {
    transform: rotate(90deg);
}

/* Badge */
.side-item .badge {
    background-color: #ff6b6b;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

    </style>
</head>

<body>
    <div class="page">
        <div class="sheet">
            <div class="header">
                <div class="brand-row">
                    <img src="dist/img/adw3.png" class="brand-image" style="width: 150px; height: auto;">
                    <div class="meta">
                        <div style="font-size: 25px" class="cell"><strong>PC STORE</strong></div>

                        <div style="font-size: 25px" class="cell"><span class="key">PERIODE DATE</span><strong>31
                                MEI 2023</strong></div>
                        <div class="cell">
                            <span class="key">REPORT DATE</span>
                            <strong style="font-size: 25px" id="periodDate">--</strong>
                        </div>

                    </div>
                </div>
                <div class="update-box">
                    <div class="t">UPDATE</div>
                    <div class="time" id="updateTime">--:-- --</div>
                </div>

            </div>

            <div class="title">STOCK STRENGTH CHART</div>

            <div class="table-wrap">
                <table id="stockTable">
                    <thead>
                        <tr>
                            <th style="font-size: 35px" class="c-line">PART NAME</th>
                            <th style="font-size: 35px" class="c-job">JOB</th>
                            <th style="font-size: 35px" class="c-part">PART NO</th>
                             <th style="font-size: 35px" class="c-job">MODEL</th>
                            <th style="font-size: 35px" class="c-month">MONTHLY</th>
                            <th style="font-size: 35px" class="c-daily">DAILY</th>
                            <th style="font-size: 35px" class="c-num1">STOCK</th>
                            <th style="font-size: 35px" class="c-num">STRENGTH</th>
                            <th style="font-size: 35px" class="c-status">STATUS</th>
                            <th class="c-chart">
                                <div class="axis-labels">
                                    <div class="axis-scale" aria-hidden="true"></div>
                                    <div class="safe-tag">SAFE</div>
                                    <div class="safe-line"></div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody><!-- rows generated by JS --></tbody>
                </table>
            </div>

            <div class="legend" aria-hidden="true">
                <span class="lg"><i class="i1"></i>EMPTY</span>
                 <span class="lg"><i class="i4"></i>ORDER</span>
                <span class="lg"><i class="i2"></i> MINIMAL</span>
                <span class="lg"><i class="i3"></i> SAFE</span>
            </div>
        </div>
        <!-- ===== Sidebar Lists ===== -->
        <aside class="sidebar">
            {{-- <section class="side-section" id="prioritySidebar">
                <div class="side-title">PRIORITAS PROSES</div>
                <div class="side-sub"></div>
                <ul class="side-list">
                    <li class="side-item">
                        <div class="left"><span class="code"></span><span class="line"></span></div>
                        <span class="badge"></span>
                    </li>
                </ul>
            </section> --}}

            <section class="side-section" id="transitSidebar">
                <div class="side-title">TRANSIT AREA ITEM</div>
                <div class="side-sub"></div>
                <ul class="side-list">
                    <li class="side-item">
                        <div class="left"><span class="code"></span><span class="line"></span></div>
                        <span class="badge"></span>
                    </li>
                </ul>
            </section>

            {{-- <section class="side-section">
                <div class="side-title">Incoming PC Store</div>
                <div class="side-sub">5 dummy data</div>
                <ul class="side-list">
                    <li class="side-item">
                        <div class="left"><span class="code">S72038270101</span><span class="line">Robot
                                Weld</span></div><span class="badge">200 pcs</span>
                    </li>
                    <li class="side-item">
                        <div class="left"><span class="code">S72038270102</span><span
                                class="line">A1-Direct</span></div><span class="badge">150 pcs</span>
                    </li>
                    <li class="side-item">
                        <div class="left"><span class="code">S72038270103</span><span class="line">Weld+Nut</span>
                        </div><span class="badge">300 pcs</span>
                    </li>
                    <li class="side-item">
                        <div class="left"><span class="code">S72038270104</span><span
                                class="line">B2-Direct</span></div><span class="badge">100 pcs</span>
                    </li>
                    <li class="side-item">
                        <div class="left"><span class="code">S72038270105</span><span class="line">Psw
                                Manual</span></div><span class="badge">180 pcs</span>
                    </li>
                </ul>
            </section> --}}
        </aside>
    </div>
    <script>
        function updatePeriodDate() {
            const el = document.getElementById("periodDate");
            if (!el) return;
            const now = new Date();
            const options = {
                day: "2-digit",
                month: "long",
                year: "numeric"
            };
            el.textContent = now.toLocaleDateString("id-ID", options).toUpperCase();
        }
        updatePeriodDate();

        function updateClock() {
            const timeEl = document.getElementById("updateTime");
            if (!timeEl) return;
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            hours = hours % 12 || 12;
            const minutesStr = minutes < 10 ? "0" + minutes : minutes;
            const secondsStr = seconds < 10 ? "0" + seconds : seconds;
            const ampm = now.getHours() >= 12 ? "PM" : "AM";
            timeEl.textContent = `${hours}:${minutesStr}:${secondsStr} ${ampm}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // ==== Tabel Utama ====
        async function loadPcStoreData() {
            try {
                const res = await fetch("{{ route('pcstore.dataAdm') }}");
                const rows = await res.json();
                const tbody = document.querySelector("#stockTable tbody");
                tbody.innerHTML = "";

                rows.sort((a, b) => Number(a.strength || 0) - Number(b.strength || 0));

                rows.forEach(r => {
                    const strength = Number(r.strength || 0);
                    let statusText = "",
                        statusClass = "";

                    if (strength > 1.0) {
                        statusText = "SAFE";
                        statusClass = "status-safe";
                    } else if (strength >= 0.5) {
                        statusText = "MINIMAL";
                        statusClass = "status-min";
                    } else if (strength > 0.0 && strength < 0.5) {
                        statusText = "ORDER";
                        statusClass = "status-danger";
                    }
                    else {
                        statusText = "EMPTY";
                        statusClass = "status-kosong";
                    }

                    const tr = document.createElement("tr");
                    tr.dataset.strength = strength;
                    tr.dataset.status = statusText;
                    tr.innerHTML = `
    <td style="font-size:30px; font-weight:bold; vertical-align:middle; border:1px solid #ccc;">${r.part_name}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;" class="c-job">${r.job_no}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;">${r.part_no}</td>
     <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;">${r.model}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;" class="c-month">${r.monthly_volume}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;" class="c-daily">${r.daily_volume}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;" class="c-job">${r.qty_act}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;" class="c-num">${strength.toFixed(1)}</td>
    <td style="font-size:30px; font-weight:bold; text-align:center; vertical-align:middle; border:1px solid #ccc;" class="c-status">
        <span class="badge ${statusClass}">${statusText}</span>
    </td>
    <td class="c-chart chart-cell" style="border:5px solid #ccc;"><div class="chart-axis"></div></td>
`;

                    tbody.appendChild(tr);
                });

                renderBars();
                renderPriorityProses();
                renderTransit();

            } catch (err) {
                console.error("Error fetching data:", err);
            }
        }

        function renderBars() {
            const max = 3.0,
                safeThreshold = 1.0;
            document.querySelectorAll("#stockTable tbody tr").forEach(tr => {
                const hours = parseFloat(tr.dataset.strength || "0");
                const cell = tr.querySelector(".chart-cell");
                if (!cell) return;
                cell.innerHTML = "";
                cell.style.position = "relative";

                const bar = document.createElement("div");
                bar.className = "bar";
                bar.style.width = Math.max(0, Math.min(100, (hours / max) * 100)) + "%";
                bar.style.height = "25px";
                bar.style.borderRadius = "4px";
                bar.style.background = "#76b6e0";
                bar.style.transition = "width 0.5s ease";
                cell.appendChild(bar);

                const safeLine = document.createElement("div");
                safeLine.className = "safe-line";
                safeLine.style.position = "absolute";
                safeLine.style.top = "0";
                safeLine.style.bottom = "0";
                safeLine.style.width = "6px";
                safeLine.style.background = "#16a34a";
                safeLine.style.left = `${(safeThreshold/max)*100}%`;
                cell.appendChild(safeLine);

                const safeTag = document.createElement("span");
                safeTag.textContent = "SAFE";
                safeTag.style.position = "absolute";
                safeTag.style.left = `${(safeThreshold/max)*100}%`;
                safeTag.style.top = "-20px";
                safeTag.style.transform = "translateX(-50%)";
                safeTag.style.fontSize = "10px";
                safeTag.style.fontWeight = "bold";
                safeTag.style.color = "#16a34a";
                cell.appendChild(safeTag);
            });
        }

        async function renderPriorityProses() {
            try {
                const res = await fetch("{{ route('pcstore.dataAdm') }}");
                const rows = await res.json();
                const priorityData = rows.filter(r => {
                    const s = Number(r.strength || 0);
                    return s >= 0.1 && s <= 0.5;
                });
                const ul = document.querySelector("#prioritySidebar .side-list");
                ul.innerHTML = "";
                priorityData.forEach(item => {
                    const s = Number(item.strength || 0);
                    const li = document.createElement("li");
                    li.className = "side-item";
                    li.innerHTML =
                        `<div style="font-size:20px" class="left"><span class="code">${item.part_no||""}</span><span style="font-size:20px" class="left"><span class="code">${item.job_no||"-"}</span></div><span class="badge" style="background-color:#f87171;">${s.toFixed(2)}</span>`;
                    ul.appendChild(li);
                });
                document.querySelector("#prioritySidebar .side-sub").textContent =
                    `${priorityData.length} priority data`;
            } catch (err) {
                console.error("Error fetching priority data:", err);
            }
        }

          function formatDateTimeIndo(datetime) {
    if (!datetime) return "-";

    let d = new Date(datetime);

    let day = String(d.getDate()).padStart(2, "0");
    let month = String(d.getMonth() + 1).padStart(2, "0");
    let year = d.getFullYear();

    let hours = String(d.getHours()).padStart(2, "0");
    let minutes = String(d.getMinutes()).padStart(2, "0");
    let seconds = String(d.getSeconds()).padStart(2, "0");

    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
}

async function renderTransit() {
    try {
        const res = await fetch("{{ route('scan_out_weldings.dataAdm') }}");
        const rows = await res.json();
        const ul = document.querySelector("#transitSidebar .side-list");
        ul.innerHTML = "";

        rows.forEach(item => {
            const li = document.createElement("li");
            li.className = "side-item";

            li.innerHTML = `
                <div class="left" style="font-size:20px; display:flex; flex-direction:column;">
                    <span class="uniqNo" style="
                        font-weight:bold;
                        padding-bottom:4px;
                        border-bottom: 2px solid #00ffff;
                        margin-bottom:4px;
                    ">
                        ${formatDateTimeIndo(item.created_at)}
                    </span>
                    <span class="uniqNo" style="color:#00ffff; font-weight:bold;">${item.uniqNo || "-"}</span>
                    <span class="code">${item.part_no || "-"}</span>
                    <span class="line">${item.job_no || "-"}</span>
                </div>
                <span class="badge" style="background-color:#3b82f6; font-size:20px">${item.qty_act || "-"}</span>
            `;

            ul.appendChild(li);
        });

        document.querySelector("#transitSidebar .side-sub").textContent = `${rows.length} transit data`;
    } catch (err) {
        console.error("Error fetching transit data:", err);
    }
}


        document.addEventListener("DOMContentLoaded", () => {
            loadPcStoreData();
            setInterval(loadPcStoreData, 5000);
        });
    </script>




</body>

</html>
