<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
:root {
    --header-h: 64px;
    --cols: 2fr 2fr 1fr 1.6fr 1fr 1.2fr;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; }
body {
    background: #001f4d;
    font-family: 'Inter', sans-serif;
    color: #001f4d;
}

/* Header */
header {
    height: var(--header-h);
    display: flex;
    align-items: center;
    padding: 0 20px;
    background: #001f4d;
    color: #001f4d;
    font-weight: bold;
    font-size: 26px;
    gap: 12px;
}
header .logo {
    height: 63px; width: auto;
    background: #001f4d;
    border-radius: 10px;
}

/* Layout */
.board {
    height: calc(100vh - var(--header-h));
    padding: 20px;
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(2, 1fr);
}
.panel {
    background: rgba(7, 42, 87, 0.14);
    border: 1px solid rgba(7, 42, 87, 0.22);
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(7,42,87,0.08);
    overflow: hidden;
    display: flex;
}

/* Table */
.shop-table {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    display: flex;
    flex-direction: column;
}
.shop-table thead {
    flex: 0 0 auto;
    background: #4a7bbb;
    color: #fff;
}
.shop-table thead tr {
    display: grid;
    grid-template-columns: var(--cols);
}
.shop-table thead th {
    text-align: left;
    padding: 12px;
    font-size: 18px;
    border-right: 3px solid rgba(255,255,255,0.6);
}
.shop-table thead th:last-child { border-right: none; }

.shop-table tbody {
    flex: 1 1 auto;
    display: grid;
    grid-auto-rows: 64px;
    width: 100%;
}
.shop-table tbody tr {
    display: grid;
    grid-template-columns: var(--cols);
    align-items: center;
    font-size: 17px;
    font-weight: 500;
    letter-spacing: 1px;
    background: #072a57;
    color: #fff;
    border-bottom: 2px solid rgba(255, 255, 255, 0.274);
}
.shop-table tbody tr:last-child { border-bottom: none; }

.shop-table td {
    padding: 8px 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border-right: 3px solid rgba(255, 255, 255, 0.6);
    color: #fff;
}
.shop-table td:last-child { border-right: none; }

/* Highlight untuk Line tertentu */
.highlight-line {
    background-color: #3796e3;
    animation: blink 1.5s infinite;
    font-weight: bold;
    border-radius: 4px;
    transition: background-color 0.3s ease-in-out;
}


/* === Badge LINE STORE (status = 1) === */
.badge-line-store {
    display: inline-block;
    background-color: #2fff00;
    color: #000000;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 10px;
    font-size: 14px;
    animation: fadeBlue 2s infinite;
}
@keyframes fadeBlue {
    0%, 100% { background-color: #2fff00; }
    50% { background-color: rgb(155, 224, 155); }
}

/* === Badge REPAIR (status = 2) === */
.badge-repair {
    display: inline-block;
    background-color: #3d91ff;
    color: #000000;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 10px;
    font-size: 14px;
    animation: fadeRed 2s infinite;
}
@keyframes fadeRed {
    0%, 100% { background-color: #3d91ff; }
    50% { background-color: #7da6dd; }
}

/* Responsive */
@media (max-width: 900px) {
    .board { grid-template-columns: 1fr; }
}
</style>
</head>

<body>
    <header style="display: flex; align-items: center; justify-content: space-between; background-color: #001f4d; padding: 10px 30px; font-family: Arial, sans-serif; font-weight: bold; color: #333; position: relative;">

        <!-- LOGO (KIRI) -->
        <div style="background-color: #ffffff; padding: 5px; border-radius: 8px;">
            <img src="dist/img/adw3.png" class="brand-image" style="width: 150px; height: auto;">
        </div>

        <!-- TEKS TENGAH -->
        <div style="position: absolute; left: 50%; transform: translateX(-50%); font-size: 26px; color:#ffffff">
            Delivery Board
        </div>

        <!-- JAM (KANAN) -->
        <div id="clock" style="font-size: 22px; background: #ffffff; padding: 5px 12px; border-radius: 8px; box-shadow: 0 0 4px rgba(0,0,0,0.1);">
            00:00:00
        </div>
    </header>

    <main class="board">
        <section class="panel">
            <table class="shop-table">
                <thead>
                    <tr>
                        <th>Part No</th>
                        <th>Job</th>
                        <th>From</th>
                        <th>Date</th>
                        <th>Out</th>
                        <th>Destinasi</th>
                    </tr>
                </thead>
                <tbody id="panel-a"></tbody>
            </table>
        </section>

        <section class="panel">
            <table class="shop-table">
                <thead>
                    <tr>
                        <th>Part No</th>
                        <th>Job</th>
                        <th>From</th>
                        <th>Date</th>
                        <th>Out</th>
                        <th>Destinasi</th>
                    </tr>
                </thead>
                <tbody id="panel-b"></tbody>
            </table>
        </section>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    const s = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('clock').textContent = `${h}:${m}:${s}`;
}
setInterval(updateClock, 1000);
updateClock();

       function fetchScanOutData() {
    $.ajax({
        url: '{{ route("dashboard1ls.getScanOutData") }}',
        method: 'GET',
        success: function(data) {
            let tbodyA = $("#panel-a");
            let tbodyB = $("#panel-b");
            tbodyA.empty();
            tbodyB.empty();

            // Ambil maksimal 44 data total
            let limitedData = data.slice(0, 44);

            let countA = 0;
            let countB = 0;

            limitedData.forEach((item) => {
                let lineClass = '';
                if (['LINE B1','LINE B2','LINE B3','LINE C1','LINE C2','TRANSFERS','LINE A1','LINE A2'].includes(item.line_proses)) {
                    lineClass = 'highlight-line';
                }

                let statusBadge = '';
                if (item.status == 1) {
                    statusBadge = `<span class="badge-line-store">LINE STORE</span>`;
                } else if (item.status == 3) {
                    statusBadge = `<span class="badge-repair">PC-STORE</span>`;
                } else {
                    statusBadge = `<span>${item.status ?? 'WAIT'}</span>`;
                }

                let row = `
                    <tr>
                        <td>${item.part_no2}</td>
                        <td>${item.job_no}</td>
                        <td class="${lineClass}">${item.line_proses}</td>
                        <td>${item.date_plan}</td>
                        <td>${item.date_scan ?? '-'}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `;

                // Isi panel A dulu sampai 22 data, baru lanjut ke panel B
                if (countA < 22) {
                    tbodyA.append(row);
                    countA++;
                } else if (countB < 22) {
                    tbodyB.append(row);
                    countB++;
                }
            });
        },
        error: function(err) {
            console.error("Error fetching data:", err);
        }
    });
}


        // Load pertama kali
        fetchScanOutData();
        // Auto-refresh tiap 5 detik
        setInterval(fetchScanOutData, 5000);
        </script>


</body>

</html>
