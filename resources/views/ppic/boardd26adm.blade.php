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
        .table-container {
    transition: transform 0.6s ease;
    will-change: transform;
  }

  /* Animasi geser */
  .slide-left {
    transform: translateX(-100%);
  }
  .slide-right {
    transform: translateX(100%);
  }
  .slide-center {
    transform: translateX(0%);
  }
    </style>
</head>

<body>
 <div class="header-datetime"
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
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 60px; /* jarak antara jam & KAP */
    ">
        <!-- Kotak warna di pojok kiri (sejajar ke samping) -->
        <div
            style="
position: absolute;
left: 20px;
top: 50%;
transform: translateY(-50%);
display: flex;
flex-direction: row;
gap: 20px;
">

            <!-- Kotak Hitam + Kotak Putih + Label -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                <div
                    style="
    width: 200px;
    height: 80px;
    background: black;
    border-radius: 6px;
    display: flex;
    justify-content: center;
    align-items: center;
  ">
                    <div style="width: 100px; height: 40px; background: white; border-radius: 4px;"></div>
                </div>
                <span style="font-size: 30px; font-weight: bold; color: white;">BESI</span>
            </div>

            <!-- Kotak Biru + Kotak Putih + Label -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                <div
                    style="
    width: 200px;
    height: 80px;
    background: blue;
    border-radius: 6px;
    display: flex;
    justify-content: center;
    align-items: center;
  ">
                    <div style="width: 100px; height: 40px; background: white; border-radius: 4px;"></div>
                </div>
                <span style="font-size: 30px; font-weight: bold; color: white;">BOX</span>
            </div>

            <!-- Kotak Merah + Kotak Putih + Label -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                <div
                    style="
    width: 200px;
    height: 80px;
    background: red;
    border-radius: 6px;
    display: flex;
    justify-content: center;
    align-items: center;
  ">
                    <div style="width: 100px; height: 40px; background: white; border-radius: 4px;"></div>
                </div>
                <span style="font-size: 30px; font-weight: bold; color: white;">DELAY</span>
            </div>

        </div>


        <!-- Waktu -->
        <span id="datetime"></span>

        <!-- Judul KAP -->
        <span id="kapTitle">KAP-1</span>

        <!-- Tombol NEXT -->
        <button id="nextPageBtn"
            style="
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      padding: 20px 40px;
      font-size: 32px;
      font-weight: bold;
      background: #1C2536;
      color: #fff;
      border: none;
      border-radius: 12px;
      cursor: pointer;`
      box-shadow: 0 6px 10px rgba(0,0,0,0.3);
    ">
            NEXT ➜
        </button>
    </div>




    <div  class="table-container slide-center" id="tableContainer" style="border: 2px solid #1C2536; border-top: none; border-radius: 0 0 8px 8px;">
        <table>
            <thead>
                <tr>
                    <th style="width:20px;"></th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>1</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 07:25 WIB<br />
                            ETD: 05:55 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>2</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 09:30 WIB<br />
                            ETD: 08:00 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>3</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 12:35 WIB<br />
                            ETD: 11:05 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>4</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 14:40 WIB<br />
                            ETD: 13:10 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>5</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 17:00 WIB<br />
                            ETD: 15:30 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>6</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 22:50 WIB<br />
                            ETD: 20:35 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        cycle <span>7</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 01:25 WIB<br />
                            ETD: 23:55 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px;">
                        cycle <span>8</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: 03:40 WIB<br />
                            ETD: 02:10 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px;">
                        cycle <span>9</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETA: -<br />
                            ETD: -
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
                    @for ($cycle = 1; $cycle <= 9; $cycle++)
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
                    @for ($cycle = 1; $cycle <= 9; $cycle++)
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
                    @for ($cycle = 1; $cycle <= 9; $cycle++)
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
 (function(){
  document.addEventListener('DOMContentLoaded', function () {
    const kapTitle = document.getElementById('kapTitle');
    const headerThs = Array.from(document.querySelectorAll('thead th'));
    const allCells = Array.from(document.querySelectorAll('tbody td[data-cycle]'));
    const nextBtn = document.getElementById('nextPageBtn');
    const tableContainer = document.getElementById('tableContainer');

    const pages = [
      { title: 'KAP-1', visibleCycles: [1,2,3,] },
      { title: 'KAP-1', visibleCycles: [4, 5,6,] },
        { title: 'KAP-1', visibleCycles: [7,8,9] },

    ];

    let currentPageIndex = 0;

    function renderPage(direction = "left") {
      const page = pages[currentPageIndex];
      kapTitle.textContent = page.title;

      // animasi geser
      tableContainer.classList.remove("slide-center","slide-left","slide-right");
      void tableContainer.offsetWidth; // reset reflow

      if (direction === "left") {
        tableContainer.classList.add("slide-right");
        setTimeout(() => {
          updateVisibility(page);
          tableContainer.classList.remove("slide-right");
          tableContainer.classList.add("slide-center");
        }, 50);
      } else {
        tableContainer.classList.add("slide-left");
        setTimeout(() => {
          updateVisibility(page);
          tableContainer.classList.remove("slide-left");
          tableContainer.classList.add("slide-center");
        }, 50);
      }
    }

    function updateVisibility(page) {
      headerThs.forEach((th, idx) => {
        if (idx === 0) { th.style.display = ''; return; }
        const cycleNum = idx;
        th.style.display = page.visibleCycles.includes(cycleNum) ? '' : 'none';
      });

      allCells.forEach(td => {
        const cycleNum = parseInt(td.getAttribute('data-cycle'), 10);
        td.style.display = page.visibleCycles.includes(cycleNum) ? '' : 'none';
      });
    }

    renderPage();

    // Tombol NEXT ➜
    nextBtn.addEventListener('click', function () {
      currentPageIndex = (currentPageIndex + 1) % pages.length;
      renderPage("left");
    });

    // Swipe
    let startX = 0, startY = 0, isDown = false;

    document.addEventListener("touchstart", e => {
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;
    });
    document.addEventListener("touchend", e => {
      const diffX = e.changedTouches[0].clientX - startX;
      const diffY = e.changedTouches[0].clientY - startY;
      handleSwipe(diffX, diffY);
    });

    document.addEventListener("mousedown", e => {
      isDown = true;
      startX = e.clientX;
      startY = e.clientY;
    });
    document.addEventListener("mouseup", e => {
      if (!isDown) return;
      isDown = false;
      const diffX = e.clientX - startX;
      const diffY = e.clientY - startY;
      handleSwipe(diffX, diffY);
    });

    function handleSwipe(diffX, diffY) {
      if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
        if (diffX < 0) {
          // kiri → next
          currentPageIndex = (currentPageIndex + 1) % pages.length;
          renderPage("left");
        } else {
          // kanan → prev
          currentPageIndex = (currentPageIndex - 1 + pages.length) % pages.length;
          renderPage("right");
        }
      }
    }
  });
})();


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
    // Hapus popup dan overlay lama jika ada
    const oldPopup = document.querySelector('.popup-box');
    const oldOverlay = document.querySelector('.popup-overlay');
    if (oldPopup) oldPopup.remove();
    if (oldOverlay) oldOverlay.remove();

    // Ambil posisi element yang diklik
    const rect = target.getBoundingClientRect();
    const uniqNo = target.getAttribute("data-uniqno") || "-";
    const isWarning = target.getAttribute("data-warning") === "true";
    const qty = target.getAttribute("data-qty") || "-";
    const sourceName = source || "-";

    const steps = [
        "RAW MATERIAL",
        "PLANNING",
        "STAMPING PROSES",
        "BUTTON PUSH",
        "SUB ASSY",
        "PC-STORE"
    ];

    // Buat overlay transparan untuk mendeteksi klik di luar
    const overlay = document.createElement('div');
    overlay.className = 'popup-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100vw';
    overlay.style.height = '100vh';
    overlay.style.background = 'rgba(0,0,0,0.1)';
    overlay.style.zIndex = '9998';
    document.body.appendChild(overlay);

    // Buat popup
    const popup = document.createElement('div');
    popup.className = 'popup-box';
    popup.style.position = 'absolute';
    popup.style.top = `${rect.top + window.scrollY}px`;
    popup.style.background = '#fff';
    popup.style.border = 'none';
    popup.style.borderRadius = '16px';
    popup.style.boxShadow = '0 10px 30px rgba(0,0,0,0.3)';
    popup.style.zIndex = '9999';
    popup.style.minWidth = '450px';
    popup.style.overflow = 'hidden';
    popup.style.fontFamily = "'Inter', sans-serif";

    popup.innerHTML = `
    <!-- Header -->
    <div style="background: #1C2536; padding: 25px 35px; color: #fff; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 22px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Tracking Posisi Barang</div>
            <div style="font-size: 38px; font-weight: 800; margin-top: 8px;">${sourceName.toUpperCase()} | ${uniqNo}</div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 20px; opacity: 0.8;">Quantity</div>
            <div style="font-size: 32px; font-weight: 700;">${qty}</div>
        </div>
    </div>

    <!-- Stepper Content -->
    <div style="padding: 40px 50px; background: #fff;">
        <div style="position: relative;" id="trackingStepperContent">
            <!-- Vertical Line -->
            <div style="position: absolute; left: 19px; top: 15px; bottom: 15px; width: 4px; background: #e0e0e0; z-index: 1;"></div>

            <!-- Steps -->
            ${steps.map((step, index) => {
                // Default: jika bukan warning, semua sukses
                let isCompleted = !isWarning;
                let statusText = isCompleted ? 'Completed' : 'Pending';

                return `
                <div class="tracking-step" data-step="${step.replace(/\s+/g, '_')}" style="display: flex; align-items: center; margin-bottom: 45px; position: relative; z-index: 2;">
                    <div class="step-icon" style="width: 42px; height: 42px; border-radius: 50%; background: ${isCompleted ? '#3b82f6' : '#e0e0e0'}; display: flex; align-items: center; justify-content: center; margin-right: 25px; box-shadow: ${isCompleted ? '0 0 12px rgba(59, 130, 246, 0.4)' : 'none'};">
                        <span class="icon-content" style="color: #fff; font-size: 24px; font-weight: bold;">${isCompleted ? '&#10003;' : ''}</span>
                    </div>
                    <div>
                        <div style="font-size: 32px; font-weight: 700; color: #1C2536; line-height: 1.2;">${step}</div>
                        <div class="status-label" style="font-size: 18px; color: #6b7280; font-weight: 500;">${statusText}</div>
                    </div>
                </div>
                `;
            }).join('')}
        </div>
    </div>

    <!-- Footer -->
    <div style="padding: 25px 35px; background: #f9fafb; border-top: 1px solid #eee; display: flex; justify-content: center;">
        <button id="closePopupBottom"
                style="width: 100%; padding: 20px; font-size: 30px; font-weight: 700; background: #ef4444; color: #fff; border: none; border-radius: 15px; cursor: pointer; transition: background 0.3s; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2);">
            CLOSE TRACKING
        </button>
        <button id="closePopup" style="display:none;"></button>
    </div>
`;

    // Tambahkan popup ke body
    document.body.appendChild(popup);

    // Fetch actual status if warning
    if (isWarning && uniqNo !== "-") {
        fetch(`/boardd26adm/api/get-tracking-status?job_no=${uniqNo}`)
            .then(res => res.json())
            .then(statusData => {
                Object.keys(statusData).forEach(stepKey => {
                    const stepDiv = popup.querySelector(`[data-step='${stepKey}']`);
                    if (stepDiv) {
                        const isOk = statusData[stepKey];
                        const iconDiv = stepDiv.querySelector('.step-icon');
                        const iconSpan = stepDiv.querySelector('.icon-content');
                        const labelDiv = stepDiv.querySelector('.status-label');

                        if (isOk) {
                            iconDiv.style.background = '#3b82f6';
                            iconDiv.style.boxShadow = '0 0 12px rgba(59, 130, 246, 0.4)';
                            iconSpan.innerHTML = '&#10003;';
                            labelDiv.textContent = 'Completed';
                        } else {
                            iconDiv.style.background = '#e0e0e0';
                            iconDiv.style.boxShadow = 'none';
                            iconSpan.innerHTML = '';
                            labelDiv.textContent = 'Pending';
                        }
                    }
                });
            })
            .catch(err => console.error("Error fetching tracking status:", err));
    }


    // Hitung posisi horizontal
    const popupWidth = popup.offsetWidth;
    if (rect.right + popupWidth > window.innerWidth) {
        popup.style.left = `${rect.left - popupWidth - 10 + window.scrollX}px`;
    } else {
        popup.style.left = `${rect.right + 10 + window.scrollX}px`;
    }

    // Fungsi untuk menutup popup dan overlay
    const closePopupFn = () => {
        popup.remove();
        overlay.remove();
    };

    // Event close (Klik overlay, Klik popup itu sendiri, dan tombol-tombol)
    overlay.addEventListener('click', closePopupFn);
    popup.addEventListener('click', closePopupFn);
    document.getElementById('closePopup').addEventListener('click', closePopupFn);
    document.getElementById('closePopupBottom').addEventListener('click', closePopupFn);
}

// ========================= RELAY AUTO =========================
// Daftar jadwal cycle (jam & menit)
const relaySchedules = [
    { hh: 15, mm: 34, name: "Cycle-1" },
    { hh: 8, mm: 15, name: "Cycle-2" },
    { hh: 8, mm: 21, name: "Cycle-3" },
    { hh: 8, mm: 23, name: "Cycle-4" },
    { hh: 8, mm: 26, name: "Cycle-5" },
];

// Simpan trigger terakhir (format "HH:MM")
let lastTrigger = null;

// Cek relay setiap 1 detik
setInterval(checkRelayAuto, 1000);

function checkRelayAuto() {
    const now = new Date();
    const hh = now.getHours();
    const mm = now.getMinutes();
    const currentTime = `${hh}:${mm}`;

    // Cari apakah ada jadwal yang cocok
    const schedule = relaySchedules.find(s => s.hh === hh && s.mm === mm);

    if (schedule && lastTrigger !== currentTime) {
        triggerRelay(schedule.name, currentTime);
        lastTrigger = currentTime; // Supaya tidak spam dalam 1 menit
    }
}

// Fungsi untuk menyalakan relay langsung ke device
function triggerRelay(cycleName, time) {
    console.log(`Relay otomatis ON - ${cycleName} (${time})`);

    fetch("http://20.20.18.237/relay2/on")
        .then(res => res.text())   // biasanya device balas plain text
        .then(data => {
            console.log("Relay response:", data);
        })
        .catch(err => {
            console.error("Relay error:", err);
        });
}


// Cek relay setiap 30 detik
// setInterval(checkRelayAuto, 1000);


    // ========================= PRESS DATA =========================
  // ========================= PRESS DATA =========================
    async function updatePressData() {
        try {
            const response = await fetch("{{ route('press.data.adm') }}");
            const pressData = await response.json();

            const today = new Date();

            // Mapping ETA/ETD per cycle
            const cycleTimes = {
                1: { eta: "07:25", etd: "06:05" },
                2: { eta: "13:55", etd: "08:00" },
                3: { eta: "12:35", etd: "11:05" },
                4: { eta: "13:55", etd: "12:35" },
                5: { eta: "21:10", etd: "19:50" },
                6: { eta: "23:10", etd: "21:50" },
                7: { eta: "01:30", etd: "00:10" },
                8: { eta: "03:35", etd: "02:15" },
                9: { eta: "03:35", etd: "02:15" },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // Group data by job_no
            const grouped = {};
            pressData.forEach(item => {
                if (!grouped[item.job_no]) grouped[item.job_no] = [];
                grouped[item.job_no].push(item);
            });

            // Kosongkan cell sebelum isi ulang
            for (let cycle = 1; cycle <= 9; cycle++) {
                const td = document.querySelector(`#press-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (td) td.innerHTML = '';
            }

            // Proses tiap job_no
            Object.keys(grouped).forEach(jobNo => {
                const jobItems = grouped[jobNo].sort((a, b) => a.cycle - b.cycle);
                let remainingAct = parseInt(jobItems[0].qty_act ?? 0); // total qty_act per job_no

                jobItems.forEach(data => {
                    let bgColor =
                        data.type_pallet === 'BESI' ? 'bg-besi' :
                        data.type_pallet === 'BOX' ? 'bg-box' : '';

                    if (cycleTimes[data.cycle] && data.cycle_arrival && data.qty_order > 0) {
                        const cycleArrival = new Date(data.cycle_arrival);
                        const etdBase = parseTime(cycleTimes[data.cycle].etd, cycleArrival);

                        let etd = new Date(cycleArrival);
                        etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

                        if (today > etd) {
                            bgColor = 'bg-expired blink-expired';
                        }
                    }

                    const qtyOrder = parseInt(data.qty_order ?? 0);
                    const strength = parseFloat(data.strength ?? 0);

                    let iconHtml;
                    let isWarning = false;
                    if (strength > 1.0) {
                        // ✅ Strength valid langsung centang
                        iconHtml = '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>';
                    } else if (remainingAct >= qtyOrder) {
                        // ✅ alokasikan qty_act ke cycle ini
                        iconHtml = '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>';
                        remainingAct -= qtyOrder;
                    } else {
                        // ⚠️ qty_act tidak cukup
                        iconHtml = '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>';
                        isWarning = true;
                    }

                    const div = document.createElement('div');
                    div.className = `data-box ${bgColor}`;
                    div.setAttribute("data-uniqno", data.uniqNo);
                    div.setAttribute("data-warning", isWarning);
                    div.setAttribute("data-qty", data.qty_order);

                    div.innerHTML = `
                        <strong style="font-size: 90%;">${data.uniqNo}</strong>
                        <span style="font-size: 90%" class="qty-box-white">
                            ${data.qty_order} ${iconHtml}
                        </span>
                    `;

                    div.addEventListener('click', (e) => {
                        showPopupBox(e.target.closest('.data-box'), "press");
                    });

                    const td = document.querySelector(`#press-row td[data-cycle='${data.cycle}'] .wrap-columns`);
                    if (td) td.appendChild(div);
                });
            });

        } catch (error) {
            console.error('Error updating press data:', error);
        }
    }

   // ========================= SUBASSY DATA =========================
    async function updateSubassyData() {
        try {
            const response = await fetch("{{ route('subassy.data.adm') }}");
            const subassyData = await response.json();

            const today = new Date();

            // Mapping ETA/ETD per cycle
            const cycleTimes = {
                1: { eta: "07:25", etd: "06:05" },
                2: { eta: "13:55", etd: "08:00" },
                3: { eta: "12:35", etd: "11:05" },
                4: { eta: "13:55", etd: "12:35" },
                5: { eta: "21:10", etd: "19:50" },
                6: { eta: "23:10", etd: "21:50" },
                7: { eta: "00:30", etd: "00:10" },
                8: { eta: "00:40", etd: "00:20" },
                9: { eta: "00:50", etd: "00:30" },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // Kelompokkan data per cycle dan per job_no
            const grouped = {};
            subassyData.forEach(item => {
                if (!grouped[item.job_no]) grouped[item.job_no] = [];
                grouped[item.job_no].push(item);
            });

            // Kosongkan semua cell sebelum isi ulang
            for (let cycle = 1; cycle <= 9; cycle++) {
                const td = document.querySelector(`#subassy-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (td) td.innerHTML = '';
            }

            // Proses setiap job_no
            Object.keys(grouped).forEach(jobNo => {
                const jobItems = grouped[jobNo].sort((a, b) => a.cycle - b.cycle); // urutkan berdasarkan cycle
                let remainingAct = parseInt(jobItems[0].qty_act ?? 0); // total qty_act untuk job ini

                jobItems.forEach(item => {
                    let bgColor =
                        item.type_pallet === 'BESI' ? 'bg-besi' :
                        item.type_pallet === 'BOX' ? 'bg-box' : '';

                    // ETA/ETD logic
                    if (cycleTimes[item.cycle] && item.cycle_arrival && item.qty_order > 0) {
                        const cycleArrival = new Date(item.cycle_arrival);
                        const etdBase = parseTime(cycleTimes[item.cycle].etd, cycleArrival);

                        let etd = new Date(cycleArrival);
                        etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

                        if (today > etd) {
                            bgColor = 'bg-expired blink-expired';
                        }
                    }

                    const qtyOrder = parseInt(item.qty_order ?? 0);
                    const strength = parseFloat(item.strength ?? 0);

                    let iconHtml;
                    let isWarning = false;

                    if (strength > 1.0) {
                        // ✅ langsung hijau kalau strength valid
                        iconHtml = '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>';
                    } else if (remainingAct >= qtyOrder) {
                        // ✅ alokasikan qty_act untuk cycle ini
                        iconHtml = '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>';
                        remainingAct -= qtyOrder;
                    } else {
                        // ⚠️ qty_act tidak cukup
                        iconHtml = '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>';
                        isWarning = true;
                    }

                    const div = document.createElement('div');
                    div.className = `data-box ${bgColor}`;
                    div.setAttribute("data-uniqno", item.uniqNo);
                    div.setAttribute("data-warning", isWarning);
                    div.setAttribute("data-qty", item.qty_order);

                    div.innerHTML = `
                        <strong style="font-size: 90%;">${item.uniqNo}</strong>
                        <span style="font-size: 90%" class="qty-box-white">
                            ${item.qty_order} ${iconHtml}
                        </span>
                    `;

                    div.addEventListener('click', (e) => {
                        showPopupBox(e.target.closest('.data-box'), "subassy");
                    });

                    const td = document.querySelector(`#subassy-row td[data-cycle='${item.cycle}'] .wrap-columns`);
                    if (td) td.appendChild(div);
                });
            });
        } catch (error) {
            console.error('Error updating subassy data:', error);
        }
    }

    async function updateNutData() {
        try {
            const response = await fetch("{{ route('nut.data.adm') }}");
            const nutData = await response.json();

            const today = new Date();

            // Mapping ETA/ETD per cycle
            const cycleTimes = {
                1: { eta: "07:25", etd: "06:05" },
                2: { eta: "13:55", etd: "08:00" },
                3: { eta: "12:35", etd: "11:05" },
                4: { eta: "13:55", etd: "12:35" },
                5: { eta: "21:10", etd: "19:50" },
                6: { eta: "23:10", etd: "21:50" },
                7: { eta: "01:30", etd: "00:10" },
                8: { eta: "03:35", etd: "02:15" },
                9: { eta: "03:35", etd: "02:15" },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // Kelompokkan data per job_no
            const grouped = {};
            nutData.forEach(item => {
                if (!grouped[item.job_no]) grouped[item.job_no] = [];
                grouped[item.job_no].push(item);
            });

            // Kosongkan semua cell sebelum isi ulang
            for (let cycle = 1; cycle <= 9; cycle++) {
                const td = document.querySelector(`#nut-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (td) td.innerHTML = '';
            }

            // Proses setiap job_no
            Object.keys(grouped).forEach(jobNo => {
                const jobItems = grouped[jobNo].sort((a, b) => a.cycle - b.cycle);
                let remainingAct = parseInt(jobItems[0].qty_act ?? 0); // total qty_act per job_no

                jobItems.forEach(item => {
                    let bgColor =
                        item.type_pallet === 'BESI' ? 'bg-besi' :
                        item.type_pallet === 'BOX' ? 'bg-box' : '';

                    // ETA/ETD logic
                    if (cycleTimes[item.cycle] && item.cycle_arrival && item.qty_order > 0) {
                        const cycleArrival = new Date(item.cycle_arrival);
                        const etdBase = parseTime(cycleTimes[item.cycle].etd, cycleArrival);

                        let etd = new Date(cycleArrival);
                        etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

                        if (today > etd) {
                            bgColor = 'bg-expired blink-expired';
                        }
                    }

                    const qtyOrder = parseInt(item.qty_order ?? 0);
                    const strength = parseFloat(item.strength ?? 0);

                    let iconHtml;
                    let isWarning = false;

                    if (strength > 1.0) {
                        // ✅ langsung hijau kalau strength valid
                        iconHtml = '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>';
                    } else if (remainingAct >= qtyOrder) {
                        // ✅ alokasikan qty_act untuk cycle ini
                        iconHtml = '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>';
                        remainingAct -= qtyOrder;
                    } else {
                        // ⚠️ qty_act tidak cukup
                        iconHtml = '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>';
                        isWarning = true;
                    }

                    const div = document.createElement('div');
                    div.className = `data-box ${bgColor}`;
                    div.setAttribute("data-uniqno", item.uniqNo);
                    div.setAttribute("data-warning", isWarning);
                    div.setAttribute("data-qty", item.qty_order);

                    div.innerHTML = `
                        <strong style="font-size: 90%;">${item.uniqNo}</strong>
                        <span style="font-size: 90%" class="qty-box-white">
                            ${item.qty_order} ${iconHtml}
                        </span>
                    `;

                    div.addEventListener('click', (e) => {
                        showPopupBox(e.target.closest('.data-box'), "nut");
                    });

                    const td = document.querySelector(`#nut-row td[data-cycle='${item.cycle}'] .wrap-columns`);
                    if (td) td.appendChild(div);
                });
            });

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
