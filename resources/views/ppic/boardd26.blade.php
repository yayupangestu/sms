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

        .bg-temporary {
            background-color: #ffffff;
            border: 2px solid #ccc; /* Add border for visibility on white background */
            color: #000000;
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
      background: #5ea76a;
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
        <span id="kapTitle">TMMIN</span>

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
                            ETD: 06:05 WIB<br />
                            ETA: 07:55 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>2</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 08:30 WIB<br />
                            ETA: 10:20 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>3</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 10:59 WIB<br />
                            ETA: 12:50 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>4</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 13:14 WIB<br />
                            ETA: 15:30 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>5</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 19:20 WIB<br />
                            ETA: 21:10 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>6</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 22:40 WIB<br />
                            ETA: 00:30 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px; font-weight:bold">
                        Cycle <span>7</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 01:50 WIB<br />
                            ETA: 02:40 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px;">
                        Cycle <span>8</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 03:15 WIB<br />
                            ETA: 05:06 WIB
                        </div>
                    </th>
                    <th style="font-size: 70px; color: white; width: 330px;">
                        Cycle <span>9</span><br />
                        <div
                            style="background-color: #ffffff; color: #1C2536; font-size: 60px; margin-top: 2px; line-height: 1.2; font-weight:bold;">
                            ETD: 03:35 WIB<br />
                            ETA: 02:15 WIB
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
      { title: 'TMMIN', visibleCycles: [1,2,3,4] },
      { title: 'TMMIN', visibleCycles: [5,6,7,8] }
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
                font-size:22px;cursor:pointer;color:#333;"></button>
    </div>
    <hr>
    <div style="display:flex;flex-direction:column;margin-bottom:50px; gap:20px;">

        <div style="display:flex;align-items:center;">
           <div style="width:50px;height:50px;border:3px solid #333;
                        border-radius:8px;margin-right:15px;position:relative;">
                <span style="position:absolute;top:30%;left:50%;
                             transform:translate(-50%,-50%);
                             font-size:80px;font-weight:bold;color:#28a745;">&#10003;</span>
            </div>
            <span style="font-size:50px;color:#333;">RAW MATERIAL</span>
        </div>

        <div style="display:flex;align-items:center;">
           <div style="width:50px;height:50px;border:3px solid #333;
                        border-radius:8px;margin-right:15px;position:relative;">
                <span style="position:absolute;top:30%;left:50%;
                             transform:translate(-50%,-50%);
                             font-size:80px;font-weight:bold;color:#28a745;">&#10003;</span>
            </div>
            <span style="font-size:50px;color:#333;">BELUM PROSES</span>
        </div>

        <div style="display:flex;align-items:center;">
           <div style="width:50px;height:50px;border:3px solid #333;
                        border-radius:8px;margin-right:15px;position:relative;">
                <span style="position:absolute;top:30%;left:50%;
                             transform:translate(-50%,-50%);
                             font-size:80px;font-weight:bold;color:#28a745;">&#10003;</span>
            </div>
            <span style="font-size:50px;color:#333;">BUTTON PUSH</span>
        </div>

        <div style="display:flex;align-items:center;">
           <div style="width:50px;height:50px;border:3px solid #333;
                        border-radius:8px;margin-right:15px;position:relative;">
                <span style="position:absolute;top:30%;left:50%;
                             transform:translate(-50%,-50%);
                             font-size:80px;font-weight:bold;color:#28a745;">&#10003;</span>
            </div>
            <span style="font-size:50px;color:#333;">SUB ASSY</span>
        </div>

        <div style="display:flex;align-items:center;">
            <div style="width:50px;height:50px;border:3px solid #333;
                        border-radius:8px;margin-right:15px;position:relative;">
                <span style="position:absolute;top:30%;left:50%;
                             transform:translate(-50%,-50%);
                             font-size:80px;font-weight:bold;color:#28a745;">&#10003;</span>
            </div>
            <span style="font-size:50px;color:#333;">PC-STORE</span>
        </div>

    </div>

    <div style="display:flex;justify-content:flex-end;padding:12px 20px;">
        <button id="closePopupBottom"
                style="padding:25px 30px;font-size:40px;
                background:#d33;color:#fff;border:none;
                border-radius:50px;cursor:pointer;">
            CLOSE
        </button>
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

        // Event close (× dan tombol bawah)
        document.getElementById('closePopup').addEventListener('click', () => {
            popup.remove();
        });
        document.getElementById('closePopupBottom').addEventListener('click', () => {
            popup.remove();
        });
    }

    // ========================= RELAY AUTO =========================
    // Daftar jadwal cycle (jam & menit)
    const relaySchedules = [{
            hh: 15,
            mm: 34,
            name: "Cycle-1"
        },
        {
            hh: 8,
            mm: 15,
            name: "Cycle-2"
        },
        {
            hh: 8,
            mm: 21,
            name: "Cycle-3"
        },
        {
            hh: 8,
            mm: 23,
            name: "Cycle-4"
        },
        {
            hh: 8,
            mm: 26,
            name: "Cycle-5"
        },
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
            .then(res => res.text()) // biasanya device balas plain text
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
    // async function updatePressData() {
    //     try {
    //         const response = await fetch("{{ route('press.data.json') }}");
    //         const pressData = await response.json();

    //         const grouped = {};
    //         pressData.forEach(item => {
    //             if (!grouped[item.cycle]) grouped[item.cycle] = [];
    //             grouped[item.cycle].push(item);
    //         });

    //         const today = new Date();

    //         // Mapping ETA/ETD per cycle (mirip subassy)
    //         const cycleTimes = {
    //             1: {
    //                 eta: "07:25",
    //                 etd: "06:05"
    //             },
    //             2: {
    //                 eta: "13:55",
    //                 etd: "08:00"
    //             },
    //             3: {
    //                 eta: "11:15",
    //                 etd: "09:55"
    //             },
    //             4: {
    //                 eta: "13:55",
    //                 etd: "12:35"
    //             },
    //             5: {
    //                 eta: "21:10",
    //                 etd: "19:50"
    //             },
    //             6: {
    //                 eta: "23:10",
    //                 etd: "21:50"
    //             },
    //             7: {
    //                 eta: "01:30",
    //                 etd: "00:10"
    //             },
    //             8: {
    //                 eta: "03:35",
    //                 etd: "02:15"
    //             },
    //         };

    //         function parseTime(timeStr, baseDate = today) {
    //             const [h, m] = timeStr.split(":").map(Number);
    //             const d = new Date(baseDate);
    //             d.setHours(h, m, 0, 0);
    //             return d;
    //         }

    //         for (let cycle = 1; cycle <= 8; cycle++) {
    //             const td = document.querySelector(`#press-row td[data-cycle='${cycle}'] .wrap-columns`);
    //             if (!td) continue;

    //             td.innerHTML = '';

    //             if (grouped[cycle]) {
    //                 grouped[cycle].forEach(data => {
    //                     let bgColor = data.type_pallet === 'BESI' ? 'bg-besi' :
    //                         (data.type_pallet === 'BOX' ? 'bg-box' : '');

    //                     if (cycleTimes[cycle] && data.created_at && data.qty_order > 0) {
    //                         const createdAt = new Date(data.created_at);
    //                         const etdBase = parseTime(cycleTimes[cycle].etd, createdAt);

    //                         // set ETD berdasarkan cycle
    //                         let etd = new Date(createdAt);
    //                         etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

    //                         if (cycle >= 1 && cycle <= 6) {
    //                             etd.setDate(etd.getDate() + 1); // H+1
    //                         } else if (cycle === 7 || cycle === 8) {
    //                             etd.setDate(etd.getDate() + 2); // H+2
    //                         }

    //                         if (today > etd) {
    //                             bgColor = 'bg-expired blink-expired';
    //                         }
    //                     }

    //                     const div = document.createElement('div');
    //                     div.className = `data-box ${bgColor}`;
    //                     div.setAttribute("data-uniqno", data.uniqNo);
    //                     div.setAttribute("data-qty", data.qty_order);
    //                     const strength = parseFloat(data.strength ?? 0);
    //                     div.innerHTML = `
    //                       <strong style="font-size: 110%;">${data.uniqNo}:</strong>
    //                       <span style="font-size: 120%" class="qty-box-white">
    //                         ${data.qty_order}
    //                         ${
    //                           strength > 1.0
    //                             ? '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>'
    //                             : '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>'
    //                         }
    //                       </span>
    //                     `;
    //                     div.addEventListener('click', (e) => {
    //                         showPopupBox(e.target.closest('.data-box'), "press");
    //                     });

    //                     td.appendChild(div);
    //                 });
    //             }
    //         }
    //     } catch (error) {
    //         console.error('Error updating press data:', error);
    //     }
    // }

    async function updatePressData() {
        try {
            const response = await fetch("{{ route('press.data.json') }}");
            const pressData = await response.json();

            const today = new Date();

            // Mapping ETA/ETD per cycle
            const cycleTimes = {
                1: {
                    eta: "06:04",
                    etd: "07:55"
                },
                2: {
                    eta: "08:29",
                    etd: "10:20"
                },
                3: {
                    eta: "10:59",
                    etd: "12:50"
                },
                4: {
                    eta: "13:14",
                    etd: "15:05"
                },
                5: {
                    eta: "19:19",
                    etd: "21:10"
                },
                6: {
                    eta: "22:39",
                    etd: "00:30"
                },
                7: {
                    eta: "00:49",
                    etd: "02:40"
                },
                8: {
                    eta: "00:49",
                    etd: "05:06"
                },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // 🔹 Group data by job_no (supaya bisa alokasikan qty_act)
            const groupedByJob = {};
            pressData.forEach(item => {
                if (!groupedByJob[item.job_no]) groupedByJob[item.job_no] = [];
                groupedByJob[item.job_no].push(item);
            });

            // 🔹 Kosongkan cell sebelum isi ulang
            for (let cycle = 1; cycle <= 8; cycle++) {
                const td = document.querySelector(`#press-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (td) td.innerHTML = '';
            }

            // 🔹 Proses per job_no → alokasi qty_act ke cycle
            Object.keys(groupedByJob).forEach(jobNo => {
                const jobItems = groupedByJob[jobNo].sort((a, b) => a.cycle - b.cycle);
                let remainingAct = parseInt(jobItems[0].qty_act ?? 0); // total qty_act per job_no

                jobItems.forEach(data => {
                    // Filter based on cycle_arrival
                    if (data.cycle_arrival) {
                        const todayDate = new Date();
                        todayDate.setHours(0, 0, 0, 0);

                        // Manual parse to ensure local time
                        const [y, m, d] = data.cycle_arrival.split('-').map(Number);
                        const arrivalDate = new Date(y, m - 1, d);
                        arrivalDate.setHours(0, 0, 0, 0);

                        const diffTime = arrivalDate.getTime() - todayDate.getTime();
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        // Allow today (0) and tomorrow (1). Hide if > 1 day in future or if diffDays is negative but logic below handles past?
                        // Actually original logic was `if (todayDate < arrivalDate) return;` which hides ALL future.
                        // New logic: if diffDays > 1 return. (Allows 0 and 1).
                        if (diffDays > 1) return;
                    }
                    let bgColor =
                        data.type_pallet === 'BESI' ? 'bg-besi' :
                        data.type_pallet === 'BOX' ? 'bg-box' : '';
                    let extraHtml = '';

                    if (cycleTimes[data.cycle] && data.cycle_arrival && data.qty_order > 0) {
                        // Manual parse to ensure local time (avoid UTC issues)
                        const [y, m, d] = data.cycle_arrival.split('-').map(Number);
                        const cycleArrival = new Date(y, m - 1, d);

                        const [h, min] = cycleTimes[data.cycle].etd.split(':').map(Number);
                        let etd = new Date(cycleArrival);
                        etd.setHours(h, min, 0, 0);

                        // H+1 Logic
                        const todayDate = new Date();
                        todayDate.setHours(0,0,0,0);
                        const diffTime = cycleArrival.getTime() - todayDate.getTime();
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays === 1) {
                            bgColor = 'bg-temporary';
                            extraHtml = `<div style="font-size: 80%; font-weight:bold; color: red; margin-top: 2px;">${data.cycle_arrival}</div>`;
                        } else if (today > etd) {
                            bgColor = 'bg-expired blink-expired';
                        }
                    }

                    const qtyOrder = parseInt(data.qty_order ?? 0);
                    const strength = parseFloat(data.strength ?? 0);

                    // 🔹 Tentukan ikon (alokasi qty_act berurutan per cycle)
                    let iconHtml;
                    if (strength > 1.0) {
                        iconHtml =
                            '<i class="fas fa-check-circle" style="color:#28a745;font-weight:bold;margin-left:5px;"></i>';
                    } else if (remainingAct >= qtyOrder) {
                        iconHtml =
                            '<i class="fas fa-check-circle" style="color:#28a745;font-weight:bold;margin-left:5px;"></i>';
                        remainingAct -= qtyOrder; // alokasikan qty_act
                    } else {
                        iconHtml =
                            '<i class="fas fa-exclamation-circle" style="color:#ffc107;font-weight:bold;margin-left:5px;"></i>';
                    }

                    // 🔹 Buat box element
                    const div = document.createElement('div');
                    div.className = `data-box ${bgColor}`;
                    div.setAttribute("data-uniqno", data.uniqNo);
                    div.setAttribute("data-qty", data.qty_order);

                    div.innerHTML = `
                    <strong style="font-size: 110%;">${data.uniqNo}:</strong>
                    <span style="font-size: 120%" class="qty-box-white">
                        ${data.qty_order} ${iconHtml}
                    </span>
                    ${extraHtml}
                `;

                    div.addEventListener('click', (e) => {
                        showPopupBox(e.target.closest('.data-box'), "press");
                    });

                    const td = document.querySelector(
                        `#press-row td[data-cycle='${data.cycle}'] .wrap-columns`);
                    if (td) td.appendChild(div);
                });
            });

        } catch (error) {
            console.error('Error updating press data:', error);
        }
    }



    // ========================= SUBASSY DATA =========================
    // async function updateSubassyData() {
    //     try {
    //         const response = await fetch("{{ route('subassy.data.json') }}");
    //         const subassyData = await response.json();

    //         const today = new Date();

    //         // Mapping ETA/ETD per cycle
    //         const cycleTimes = {
    //             1: {
    //                 eta: "07:25",
    //                 etd: "06:05"
    //             },
    //             2: {
    //                 eta: "13:55",
    //                 etd: "08:00"
    //             },
    //             3: {
    //                 eta: "11:15",
    //                 etd: "09:55"
    //             },
    //             4: {
    //                 eta: "13:55",
    //                 etd: "12:35"
    //             },
    //             5: {
    //                 eta: "21:10",
    //                 etd: "19:50"
    //             },
    //             6: {
    //                 eta: "23:10",
    //                 etd: "21:50"
    //             },
    //             7: {
    //                 eta: "01:30",
    //                 etd: "00:10"
    //             },
    //             8: {
    //                 eta: "03:35",
    //                 etd: "02:15"
    //             },
    //         };

    //         function parseTime(timeStr, baseDate = today) {
    //             const [h, m] = timeStr.split(":").map(Number);
    //             const d = new Date(baseDate);
    //             d.setHours(h, m, 0, 0);
    //             return d;
    //         }

    //         // Kelompokkan data per cycle, lalu per job_no
    //         const grouped = {};
    //         subassyData.forEach(item => {
    //             if (!grouped[item.cycle]) grouped[item.cycle] = {};
    //             if (!grouped[item.cycle][item.job_no]) grouped[item.cycle][item.job_no] = [];
    //             grouped[item.cycle][item.job_no].push(item);
    //         });

    //         for (let cycle = 1; cycle <= 8; cycle++) {
    //             const td = document.querySelector(`#subassy-row td[data-cycle='${cycle}'] .wrap-columns`);
    //             if (!td) continue;

    //             td.innerHTML = '';

    //             if (grouped[cycle]) {
    //                 // urutkan job_no agar tampil berurutan
    //                 const sortedJobNos = Object.keys(grouped[cycle]).sort();

    //                 sortedJobNos.forEach(jobNo => {
    //                     grouped[cycle][jobNo].forEach(data => {
    //                         let bgColor =
    //                             data.type_pallet === 'BESI' ?
    //                             'bg-besi' :
    //                             data.type_pallet === 'BOX' ?
    //                             'bg-box' :
    //                             '';

    //                         if (cycleTimes[cycle]) {
    //                             const etdBase = parseTime(cycleTimes[cycle].etd);
    //                             const createdAt = new Date(data.created_at);
    //                             let etd = new Date(createdAt);
    //                             etd.setHours(etdBase.getHours(), etdBase.getMinutes(), 0, 0);

    //                             if (cycle >= 1 && cycle <= 6) {
    //                                 etd.setDate(etd.getDate() + 1); // H+1
    //                             } else if (cycle === 7 || cycle === 8) {
    //                                 etd.setDate(etd.getDate() + 2); // H+2
    //                             }

    //                             if (today > etd) {
    //                                 bgColor = 'bg-expired blink-expired';
    //                             }
    //                         }

    //                         const div = document.createElement('div');
    //                         div.className = `data-box ${bgColor}`;
    //                         div.setAttribute("data-uniqno", data.uniqNo);
    //                         div.setAttribute("data-qty", data.qty_order);
    //                         const strength = parseFloat(data.strength ?? 0);
    //                         div.innerHTML = `
    //                       <strong style="font-size: 110%;">${data.uniqNo}:</strong>
    //                       <span style="font-size: 120%" class="qty-box-white">
    //                         ${data.qty_order}
    //                         ${
    //                           strength > 1.0
    //                             ? '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>'
    //                             : '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>'
    //                         }
    //                       </span>
    //                     `;

    //                         div.addEventListener('click', (e) => {
    //                             showPopupBox(e.target.closest('.data-box'), "subassy");
    //                         });

    //                         td.appendChild(div);
    //                     });
    //                 });
    //             }
    //         }
    //     } catch (error) {
    //         console.error('Error updating subassy data:', error);
    //     }
    // }

    async function updateSubassyData() {
        try {
            const response = await fetch("{{ route('subassy.data.json') }}");
            const subassyData = await response.json();

            const today = new Date();

            // Mapping ETA/ETD per cycle
            const cycleTimes = {
                1: {
                    eta: "06:04",
                    etd: "07:55"
                },
                2: {
                    eta: "08:29",
                    etd: "10:20"
                },
                3: {
                    eta: "10:59",
                    etd: "12:50"
                },
                4: {
                    eta: "13:14",
                    etd: "15:05"
                },
                5: {
                    eta: "19:19",
                    etd: "21:10"
                },
                6: {
                    eta: "22:39",
                    etd: "00:30"
                },
                7: {
                    eta: "00:49",
                    etd: "02:40"
                },
                8: {
                    eta: "00:49",
                    etd: "05:06"
                },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // 🔹 Group data by job_no
            const groupedByJob = {};
            subassyData.forEach(item => {
                if (!groupedByJob[item.job_no]) groupedByJob[item.job_no] = [];
                groupedByJob[item.job_no].push(item);
            });

            // 🔹 Kosongkan cell sebelum isi ulang
            for (let cycle = 1; cycle <= 8; cycle++) {
                const td = document.querySelector(`#subassy-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (td) td.innerHTML = '';
            }

            // 🔹 Proses tiap job_no
            Object.keys(groupedByJob).forEach(jobNo => {
                const jobItems = groupedByJob[jobNo].sort((a, b) => a.cycle - b.cycle);
                let remainingAct = parseInt(jobItems[0].qty_act ?? 0); // total qty_act untuk job_no ini

                jobItems.forEach(data => {
                    // Filter based on cycle_arrival
                    if (data.cycle_arrival) {
                        const todayDate = new Date();
                        todayDate.setHours(0, 0, 0, 0);

                        // Manual parse to ensure local time
                        const [y, m, d] = data.cycle_arrival.split('-').map(Number);
                        const arrivalDate = new Date(y, m - 1, d);
                        arrivalDate.setHours(0, 0, 0, 0);

                        const diffTime = arrivalDate.getTime() - todayDate.getTime();
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        // Allow today (0) and tomorrow (1). Hide if > 1 day in future.
                        if (diffDays > 1) return;
                    }
                    let bgColor =
                        data.type_pallet === 'BESI' ? 'bg-besi' :
                        data.type_pallet === 'BOX' ? 'bg-box' : '';
                    let extraHtml = '';

                    if (cycleTimes[data.cycle] && data.cycle_arrival && data.qty_order > 0) {
                        // Manual parse to ensure local time
                        const [y, m, d] = data.cycle_arrival.split('-').map(Number);
                        const cycleArrival = new Date(y, m - 1, d);

                        const [h, min] = cycleTimes[data.cycle].etd.split(':').map(Number);
                        let etd = new Date(cycleArrival);
                        etd.setHours(h, min, 0, 0);

                        // H+1 Logic
                        const todayDate = new Date();
                        todayDate.setHours(0,0,0,0);
                        const diffTime = cycleArrival.getTime() - todayDate.getTime();
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays === 1) {
                            bgColor = 'bg-temporary';
                            extraHtml = `<div style="font-size: 80%; font-weight:bold; color: red; margin-top: 2px;">${data.cycle_arrival}</div>`;
                        } else if (today > etd) {
                            bgColor = 'bg-expired blink-expired';
                        }
                    }

                    const qtyOrder = parseInt(data.qty_order ?? 0);
                    const strength = parseFloat(data.strength ?? 0);

                    // 🔹 Tentukan ikon
                    let iconHtml;
                    if (strength > 1.0) {
                        iconHtml = '<i class="fas fa-check-circle" style="color:#28a745;font-weight:bold;margin-left:5px;"></i>';
                    } else if (remainingAct >= qtyOrder) {
                        iconHtml = '<i class="fas fa-check-circle" style="color:#28a745;font-weight:bold;margin-left:5px;"></i>';
                        remainingAct -= qtyOrder; // alokasikan qty_act
                    } else {
                        iconHtml = '<i class="fas fa-exclamation-circle" style="color:#ffc107;font-weight:bold;margin-left:5px;"></i>';
                    }

                    // 🔹 Buat box element
                    const div = document.createElement('div');
                    div.className = `data-box ${bgColor}`;
                    div.setAttribute("data-uniqno", data.uniqNo);
                    div.setAttribute("data-qty", data.qty_order);

                    div.innerHTML = `
                        <strong style="font-size: 110%;">${data.uniqNo}:</strong>
                        <span style="font-size: 120%" class="qty-box-white">
                            ${data.qty_order} ${iconHtml}
                        </span>
                        ${extraHtml}
                    `;

                    div.addEventListener('click', (e) => {
                        showPopupBox(e.target.closest('.data-box'), "subassy");
                    });

                    const td = document.querySelector(`#subassy-row td[data-cycle='${data.cycle}'] .wrap-columns`);
                    if (td) td.appendChild(div);
                });
            });

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
               1: {
                    eta: "06:04",
                    etd: "07:55"
                },
                2: {
                    eta: "08:29",
                    etd: "10:20"
                },
                3: {
                    eta: "10:59",
                    etd: "12:50"
                },
                4: {
                    eta: "13:14",
                    etd: "15:05"
                },
                5: {
                    eta: "19:19",
                    etd: "21:10"
                },
                6: {
                    eta: "22:39",
                    etd: "00:30"
                },
                7: {
                    eta: "00:49",
                    etd: "02:40"
                },
                8: {
                    eta: "00:49",
                    etd: "05:06"
                },
            };

            function parseTime(timeStr, baseDate = today) {
                const [h, m] = timeStr.split(":").map(Number);
                const d = new Date(baseDate);
                d.setHours(h, m, 0, 0);
                return d;
            }

            // Group by job_no dulu (agar bisa akumulasi qty_act)
            const grouped = {};
            nutData.forEach(item => {
                if (!grouped[item.job_no]) grouped[item.job_no] = [];
                grouped[item.job_no].push(item);
            });

            for (let cycle = 1; cycle <= 8; cycle++) {
                const td = document.querySelector(`#nut-row td[data-cycle='${cycle}'] .wrap-columns`);
                if (!td) continue;
                td.innerHTML = '';

                // Loop per job_no
                Object.keys(grouped).forEach(jobNo => {
                    // Sort by cycle supaya urut
                    const items = grouped[jobNo].sort((a, b) => a.cycle - b.cycle);

                    // Hitung qty_act total per job_no
                    const totalAct = items.reduce((sum, d) => sum + (parseInt(d.qty_act) || 0), 0);

                    let allocated = 0;
                    items.forEach(data => {
                        // Filter based on cycle_arrival
                        if (data.cycle_arrival) {
                            const todayDate = new Date();
                            todayDate.setHours(0, 0, 0, 0);

                            // Manual parse to ensure local time
                            const [y, m, d] = data.cycle_arrival.split('-').map(Number);
                            const arrivalDate = new Date(y, m - 1, d);
                            arrivalDate.setHours(0, 0, 0, 0);

                            const diffTime = arrivalDate.getTime() - todayDate.getTime();
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                            // Allow today (0) and tomorrow (1). Hide if > 1 day in future.
                            if (diffDays > 1) return;
                        }
                        let bgColor = data.type_pallet === 'BESI' ? 'bg-besi' :
                            (data.type_pallet === 'BOX' ? 'bg-box' : '');
                        let extraHtml = '';

                        // Expired check
                        if (cycleTimes[data.cycle] && data.cycle_arrival && data.qty_order > 0) {
                            // Manual parse to ensure local time
                            const [y, m, d] = data.cycle_arrival.split('-').map(Number);
                            const cycleArrival = new Date(y, m - 1, d);

                            const [h, min] = cycleTimes[data.cycle].etd.split(':').map(Number);
                            let etd = new Date(cycleArrival);
                            etd.setHours(h, min, 0, 0);

                            // H+1 Logic
                            const todayDate = new Date();
                            todayDate.setHours(0,0,0,0);
                            const diffTime = cycleArrival.getTime() - todayDate.getTime();
                            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                            if (diffDays === 1) {
                                bgColor = 'bg-temporary';
                                extraHtml = `<div style="font-size: 80%; font-weight:bold; color: red; margin-top: 2px;">${data.cycle_arrival}</div>`;
                            } else if (today > etd) {
                                bgColor = 'bg-expired blink-expired';
                            }
                        }

                        // ✅ Alokasi centang sesuai qty_act
                        let isChecked = false;
                        if (allocated + data.qty_order <= totalAct) {
                            isChecked = true;
                            allocated += data.qty_order;
                        }

                        const strength = parseFloat(data.strength ?? 0);
                        const icon = isChecked
                            ? '<i class="fas fa-check-circle" style="color: #28a745; font-weight:bold; margin-left: 5px;"></i>'
                            : '<i class="fas fa-exclamation-circle" style="color: #ffc107; font-weight:bold; margin-left: 5px;"></i>';

                        const div = document.createElement('div');
                        div.className = `data-box ${bgColor}`;
                        div.setAttribute("data-uniqno", data.uniqNo);
                        div.setAttribute("data-qty", data.qty_order);
                        div.innerHTML = `
                            <strong style="font-size: 110%;">${data.uniqNo}:</strong>
                            <span style="font-size: 120%" class="qty-box-white">
                                ${data.qty_order} ${icon}
                            </span>
                            ${extraHtml}
                        `;

                        div.addEventListener('click', (e) => {
                            showPopupBox(e.target.closest('.data-box'), "nut");
                        });

                        if (data.cycle === cycle) {
                            td.appendChild(div);
                        }
                    });
                });
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
