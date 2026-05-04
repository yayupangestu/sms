<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Table Layout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin-left: 60px;
            background-color: #ffffff;
            color: white;
            padding: 1rem;
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #82ae9a;
            padding: 10px;
            border-radius: 5px;
            width: 99%;
            color: rgb(250, 250, 250);
        }

        .header-datetime {
            font-size: 100px;
            font-weight: bold;
            white-space: nowrap;
            background-color: #5e79a7
        }

        .header-title {
            text-align: center;
            font-size: 80px;
            font-weight: bold;
            text-transform: uppercase;
            flex: 1;
        }

        .table-container {
            width: 100%;
            background-color: #fff;
            border: 2px solid #1C2536;
            border-top: none;
            border-radius: 0 0 8px 8px;
            padding: 10px;
            box-sizing: border-box;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 20px solid #fe0000;
            padding: 4px;
            font-size: 30px;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            text-align: center;
            font-weight: normal;
            background-color: #374151;
            color: white;
        }

        th span {
            font-weight: bold;
        }


        .vertical-text {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70%;
        }

        .vertical-text-1 {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vertical-cell {
            vertical-align: top;
            padding: 0;
            margin: 0;
            height: 100%;
            /* pastikan td menyesuaikan tinggi */
        }

        .vertical-text-1 {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 100px;
            color: rgb(0, 0, 0);
            background-color: #ffffff;
            /* border: 1px solid #ff0000; */
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto;
            /* tinggi menyesuaikan data */

            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }




        .text-right {
            text-align: right;
            padding-right: 8px;
            line-height: 1.3;
            font-size: 11px;
            font-weight: bold;
        }

        .text-right span {
            font-weight: normal;
        }

        .wrap-flex {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .text-sm {
            font-size: 12px;
        }

        .border {
            border: 1px solid #ccc;
        }

        .bg-light {
            background-color: #f9f9f9;
        }

        .p-1 {
            padding: 4px;
        }

        .m-1 {
            margin: 4px;
        }

        .rounded {
            border-radius: 4px;
        }

        td>table {
            border-collapse: collapse;
            width: 100%;
        }

        td>table td {
            vertical-align: top;
            padding: 0 5px;
        }

        /* Width control */
        th,
        td {
            width: 200px;
        }

        td:first-child {
            width: 100px;
        }

        .wrap-columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }

        .column {
            display: flex;
            flex-direction: column;
            flex: 1 0 22%;
            /* fleksibel, 4 kolom per baris */
        }

        .column {
            display: flex;
            flex-direction: column;
            gap: 8px;
            border-right: 10px solid rgb(0, 0, 0);
            padding-right: 10px;
        }

        .data-box {
            padding: 10px;
            margin: 6px;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 40px;
            min-width: 30px;
            /* Lebar minimum diperbesar */
            max-width: 350px;
            /* Lebar maksimum */
            width: 100%;
            /* Agar kotaknya proporsional dalam kolom */
            text-align: center;
            box-sizing: border-box;
        }

        .bg-besi {
            background-color: #000000;
            color: rgb(250, 250, 250);
        }

        .bg-box {
            background-color: #4639ff;
        }


        .qty-box-white {
            background-color: white;
            color: black;
            padding: 5px 8px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            transform: translateX(-5px);
            /* Geser ke kiri */
        }

        .blink-job {
            animation: blink 1s infinite;
        }


        .blink-expired {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                background-color: #ff0000;
            }

            /* merah tua */
            50% {
                background-color: #ff6b6b;
            }

            /* merah terang */
            100% {
                background-color: #ff0000;
            }

            /* balik lagi */
        }


        .popup-box {
            position: absolute;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            min-width: 500px;
            min-height: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            font-size: 18px;
            font-weight: bold;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .popup-box button {
            align-self: flex-start;
            /* 👉 tombol di kiri */
            margin-top: 20px;
            padding: 8px 20px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 30px;
        }

        .data-box {
            cursor: pointer;
            /* 👉 ubah cursor jadi tangan */
        }


        .data-box:hover {
            opacity: 0.8;
            transform: scale(1.02);
            transition: 0.2s;
        }
    </style>
</head>

<body>

    <div class="header-wrapper">
        <div class="header-datetime" id="datetime"></div>
        <div class="header-title">JADWAL PENGIRIMAN</div>
    </div>


    <div
        style="
    width: 99%;
    background: #5e79a7;
    color: #ffffff;
    padding: 14px 20px;
    text-align: center;
    font-size: 90px;
    font-weight: 800;
    letter-spacing: 1px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  ">
        TMMIN
    </div>

    <div class="table-container" style="border: 2px solid #1C2536; border-top: none; border-radius: 0 0 8px 8px;">
        <table>
            <thead>
                <tr>
                    <th style="width:20px;"></th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>1</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 07:25 WIB<br />
                            ETD: 06:05 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>2</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 13:55 WIB<br />
                            ETD: 08:00 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>3</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 11:15 WIB<br />
                            ETD: 09:55 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>4</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 13:55 WIB<br />
                            ETD: 12:35 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>5</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 21:10 WIB<br />
                            ETD: 19:50 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>6</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 23:10 WIB<br />
                            ETD: 21:50 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>7</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 01:30 WIB<br />
                            ETD: 00:10 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px;">
                        cycle <span>8</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 03:35 WIB<br />
                            ETD: 02:15 WIB
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- PRESS -->
                <tr id="press-row">
                    <td class="vertical-cell">
                        <div style="background-color: #000000;color:#ffffff" class="vertical-text-1">PRESS</div>
                    </td>
                    @for ($cycle = 1; $cycle <= 8; $cycle++)
                        <td data-cycle="{{ $cycle }}">
                            <div class="wrap-columns">
                                {{-- data akan diisi oleh JS --}}
                            </div>
                        </td>
                    @endfor
                </tr>
                <!-- SUB-ASSY -->
                <tr id="subassy-row">
                    <td class="vertical-cell">
                        <div style="background-color: #000000;color:#ffffff" class="vertical-text-1">SUB ASSY</div>
                    </td>
                    @for ($cycle = 1; $cycle <= 8; $cycle++)
                        <td data-cycle="{{ $cycle }}">
                            <div class="wrap-columns">
                                {{-- data akan diisi oleh JS --}}
                            </div>
                        </td>
                    @endfor
                </tr>

                <!-- NUT -->
                <tr id="nut-row">
                    <td class="vertical-cell">
                        <div style="background-color: #000000;color:#ffffff" class="vertical-text-1">NUT</div>
                    </td>
                    @for ($cycle = 1; $cycle <= 8; $cycle++)
                        <td data-cycle="{{ $cycle }}">
                            <div class="wrap-columns">
                                {{-- data akan diisi oleh JS --}}
                            </div>
                        </td>
                    @endfor
                </tr>

            </tbody>
        </table>
    </div>

</body>
<script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const formatted = now.toLocaleString('id-ID', options);
        document.getElementById('datetime').textContent = formatted;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
    // ========================= UNIVERSAL POPUP =========================
    function showPopupBox(target, source) {
        // Hapus popup lama jika ada
        const oldPopup = document.querySelector('.popup-box');
        if (oldPopup) oldPopup.remove();

        // Ambil posisi element yang diklik
        const rect = target.getBoundingClientRect();
        const uniqNo = target.getAttribute("data-uniqno") || "-";
        const qty_order = target.getAttribute("data-qty_order") || "-";
        const qty = target.getAttribute("data-qty") || "-";
        const sourceName = source || "-";

        // Buat popup
        const popup = document.createElement('div');
        popup.className = 'popup-box';
        popup.innerHTML = `
  <div style="display:flex;justify-content:space-between;align-items:center;
            background:#f1f1f1;padding:12px 16px;border-bottom:1px solid #ccc;
            font-size:50px;font-weight:bold;color:#333;">
  <span>${sourceName.toUpperCase()} | ${uniqNo} | ${qty}</span>
  <button id="closePopup" style="border:none;background:transparent;
          font-size:22px;cursor:pointer;color:#333;">×</button>
</div>

<div style="display:flex;flex-direction:column;margin-bottom:250px; gap:10px;">
  <div style="display:flex;align-items:center;">
    <div style="width:22px;height:22px;border:2px solid #333;
                border-radius:6px;margin-right:10px;"></div>
    <span style="font-size:50px;color:#333;">B/P</span>
  </div>

  <div style="display:flex;align-items:center;">
    <div style="width:22px;height:22px;border:2px solid #333;
                border-radius:6px;margin-right:10px;"></div>
    <span style="font-size:50px;color:#333;">B/P</span>
  </div>

  <div style="display:flex;align-items:center;">
    <div style="width:22px;height:22px;border:2px solid #333;
                border-radius:6px;margin-right:10px;"></div>
    <span style="font-size:50px;color:#333;">B/P</span>
  </div>
</div>

  


  `;

        // Style dasar popup
        popup.style.position = 'absolute';
        popup.style.top = `${rect.top + window.scrollY}px`;
        popup.style.background = '#fff';
        popup.style.border = '1px solid #ccc';
        popup.style.borderRadius = '8px';
        popup.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        popup.style.zIndex = '9999';
        popup.style.minWidth = '280px';

        // Tambahkan popup ke body
        document.body.appendChild(popup);

        // Hitung posisi horizontal
        const popupWidth = popup.offsetWidth;
        if (rect.right + popupWidth > window.innerWidth) {
            popup.style.left = `${rect.left - popupWidth - 10 + window.scrollX}px`;
        } else {
            popup.style.left = `${rect.right + 10 + window.scrollX}px`;
        }

        // Event close
        document.getElementById('closePopup').addEventListener('click', () => {
            popup.remove();
        });
    }


    // ========================= PRESS DATA =========================
    async function updatePressData() {
        try {
            const response = await fetch("{{ route('press.data.json') }}");
            const pressData = await response.json();

            const grouped = {};
            pressData.forEach(item => {
                if (!grouped[item.cycle]) grouped[item.cycle] = [];
                grouped[item.cycle].push(item);
            });

            const today = new Date();

            // Mapping ETA/ETD per cycle (mirip subassy)
            const cycleTimes = {
                1: {
                    eta: "07:25",
                    etd: "06:05"
                },
                2: {
                    eta: "13:55",
                    etd: "08:00"
                },
                3: {
                    eta: "11:15",
                    etd: "09:55"
                },
                4: {
                    eta: "13:55",
                    etd: "12:35"
                },
                5: {
                    eta: "21:10",
                    etd: "19:50"
                },
                6: {
                    eta: "23:10",
                    etd: "21:50"
                },
                7: {
                    eta: "01:30",
                    etd: "00:10"
                },
                8: {
                    eta: "03:35",
                    etd: "02:15"
                },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            for (let cycle = 1; cycle <= 8; cycle++) {
                const td = document.querySelector(`#press-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (!td) continue;

                td.innerHTML = '';

                if (grouped[cycle]) {
                    grouped[cycle].forEach(data => {
                        let bgColor = data.type_pallet === 'BESI' ? 'bg-besi' :
                            (data.type_pallet === 'BOX' ? 'bg-box' : '');

                        if (cycleTimes[cycle] && data.created_at && data.qty_order > 0) {
                            const createdAt = new Date(data.created_at);
                            const etdBase = parseTime(cycleTimes[cycle].etd, createdAt);

                            // set ETD berdasarkan cycle
                            let etd = new Date(createdAt);
                            etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

                            if (cycle >= 1 && cycle <= 6) {
                                etd.setDate(etd.getDate() + 1); // H+1
                            } else if (cycle === 7 || cycle === 8) {
                                etd.setDate(etd.getDate() + 2); // H+2
                            }

                            if (today > etd) {
                                bgColor = 'bg-expired blink-expired';
                            }
                        }

                        const div = document.createElement('div');
                        div.className = `data-box ${bgColor}`;
                        div.setAttribute("data-uniqno", data.uniqNo);
                        div.setAttribute("data-qty", data.qty_order);
                        const strength = parseFloat(data.strength ?? 0);
                        div.innerHTML = `
                          <strong style="font-size: 110%;">${data.uniqNo}:</strong>
                          <span style="font-size: 120%" class="qty-box-white">
                            ${data.qty_order}
                            ${
                              strength > 1.0
                                ? '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>'
                                : '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>'
                            }
                          </span>
                        `;
                        div.addEventListener('click', (e) => {
                            showPopupBox(e.target.closest('.data-box'), "press");
                        });

                        td.appendChild(div);
                    });
                }
            }
        } catch (error) {
            console.error('Error updating press data:', error);
        }
    }


    // ========================= SUBASSY DATA =========================
    async function updateSubassyData() {
        try {
            const response = await fetch("{{ route('subassy.data.json') }}");
            const subassyData = await response.json();

            const today = new Date();

            // Mapping ETA/ETD per cycle
            const cycleTimes = {
                1: {
                    eta: "07:25",
                    etd: "06:05"
                },
                2: {
                    eta: "13:55",
                    etd: "08:00"
                },
                3: {
                    eta: "11:15",
                    etd: "09:55"
                },
                4: {
                    eta: "13:55",
                    etd: "12:35"
                },
                5: {
                    eta: "21:10",
                    etd: "19:50"
                },
                6: {
                    eta: "23:10",
                    etd: "21:50"
                },
                7: {
                    eta: "01:30",
                    etd: "00:10"
                },
                8: {
                    eta: "03:35",
                    etd: "02:15"
                },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // Kelompokkan data per cycle, lalu per job_no
            const grouped = {};
            subassyData.forEach(item => {
                if (!grouped[item.cycle]) grouped[item.cycle] = {};
                if (!grouped[item.cycle][item.job_no]) grouped[item.cycle][item.job_no] = [];
                grouped[item.cycle][item.job_no].push(item);
            });

            for (let cycle = 1; cycle <= 8; cycle++) {
                const td = document.querySelector(`#subassy-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (!td) continue;

                td.innerHTML = '';

                if (grouped[cycle]) {
                    // urutkan job_no agar tampil berurutan
                    const sortedJobNos = Object.keys(grouped[cycle]).sort();

                    sortedJobNos.forEach(jobNo => {
                        grouped[cycle][jobNo].forEach(data => {
                            let bgColor =
                                data.type_pallet === 'BESI' ?
                                'bg-besi' :
                                data.type_pallet === 'BOX' ?
                                'bg-box' :
                                '';

                            if (cycleTimes[cycle]) {
                                const etdBase = parseTime(cycleTimes[cycle].etd);
                                const createdAt = new Date(data.created_at);
                                let etd = new Date(createdAt);
                                etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

                                if (cycle >= 1 && cycle <= 6) {
                                    etd.setDate(etd.getDate() + 1); // H+1
                                } else if (cycle === 7 || cycle === 8) {
                                    etd.setDate(etd.getDate() + 2); // H+2
                                }

                                if (today > etd) {
                                    bgColor = 'bg-expired blink-expired';
                                }
                            }

                            const div = document.createElement('div');
                            div.className = `data-box ${bgColor}`;
                            div.setAttribute("data-uniqno", data.uniqNo);
                            div.setAttribute("data-qty", data.qty_order);
                            const strength = parseFloat(data.strength ?? 0);
                        div.innerHTML = `
                          <strong style="font-size: 110%;">${data.uniqNo}:</strong>
                          <span style="font-size: 120%" class="qty-box-white">
                            ${data.qty_order}
                            ${
                              strength > 1.0
                                ? '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>'
                                : '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>'
                            }
                          </span>
                        `;

                            div.addEventListener('click', (e) => {
                                showPopupBox(e.target.closest('.data-box'), "subassy");
                            });

                            td.appendChild(div);
                        });
                    });
                }
            }
        } catch (error) {
            console.error('Error updating subassy data:', error);
        }
    }





    // ========================= NUT DATA =========================
    async function updateNutData() {
    try {
        const response = await fetch("{{ route('nut.data.json') }}");
        const nutData = await response.json();

        const today = new Date();

        // Mapping ETA/ETD per cycle
        const cycleTimes = {
            1: { eta: "07:25", etd: "06:05" },
            2: { eta: "13:55", etd: "08:00" },
            3: { eta: "11:15", etd: "09:55" },
            4: { eta: "13:55", etd: "12:35" },
            5: { eta: "21:10", etd: "19:50" },
            6: { eta: "23:10", etd: "21:50" },
            7: { eta: "01:30", etd: "00:10" },
            8: { eta: "03:35", etd: "02:15" },
        };

        function parseTime(timeStr, baseDate = today) {
            const [h, m] = timeStr.split(":").map(Number);
            const d = new Date(baseDate);
            d.setHours(h, m, 0, 0);
            return d;
        }

        // Kelompokkan data per cycle
        const grouped = {};
        nutData.forEach(item => {
            if (!grouped[item.cycle]) grouped[item.cycle] = [];
            grouped[item.cycle].push(item);
        });

        for (let cycle = 1; cycle <= 8; cycle++) {
            const td = document.querySelector(`#nut-row td[data-cycle='${cycle}'] .wrap-columns`);
            if (!td) continue;

            td.innerHTML = '';

            if (grouped[cycle]) {
                grouped[cycle].forEach(data => {
                    let bgColor = data.type_pallet === 'BESI' ? 'bg-besi' :
                                  (data.type_pallet === 'BOX' ? 'bg-box' : '');

                    if (cycleTimes[cycle] && data.created_at && data.qty_order > 0) {
                        const createdAt = new Date(data.created_at);
                        const etdBase = parseTime(cycleTimes[cycle].etd, createdAt);
                        let etd = new Date(createdAt);
                        etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

                        if (cycle >= 1 && cycle <= 6) {
                            etd.setDate(etd.getDate() + 1); // H+1
                        } else if (cycle === 7 || cycle === 8) {
                            etd.setDate(etd.getDate() + 2); // H+2
                        }

                        if (today > etd) {
                            bgColor = 'bg-expired blink-expired';
                        }
                    }

                    const div = document.createElement('div');
                    div.className = `data-box ${bgColor}`;
                    div.setAttribute("data-uniqno", data.uniqNo);
                    div.setAttribute("data-qty", data.qty_order);

                    // Tambahkan strength jika ada
                    const strength = parseFloat(data.strength ?? 0);

                    div.innerHTML = `
                        <strong style="font-size: 110%;">${data.uniqNo}:</strong>
                        <span style="font-size: 120%" class="qty-box-white">
                            ${data.qty_order}
                            ${
                                strength > 1.0
                                ? '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>'
                                : '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>'
                            }
                        </span>
                    `;

                    div.addEventListener('click', (e) => {
                        showPopupBox(e.target.closest('.data-box'), "nut");
                    });

                    td.appendChild(div);
                });
            }
        }

    } catch (error) {
        console.error('Error updating nut data:', error);
    }
}


    updatePressData();
    setInterval(updatePressData, 10000);
    updateSubassyData();
    setInterval(updateSubassyData, 10000);
    updateNutData();
    setInterval(updateNutData, 10000);
</script>

</html>
