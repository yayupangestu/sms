<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Andon Dashboard</title>
    {{-- <link rel="stylesheet" href="style.css" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
  </head>

  <style>
    :root {
    --bg-color: #121212;
    --grid-line-color: #555555;
    --box-bg: #003366; /* Deep solid blue */
    --box-border: #ffffff;
    --text-color: #ffffff;
    --header-height: 45px;
    --col-min-width: 230px; /* Reduced from 330px to a more compact size */
    --accent-yellow: #fbff00;
    --accent-green: #2fff00;
    --accent-total: #ffffff;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: var(--bg-color);
    color: var(--text-color);
    font-family: 'Roboto', 'Segoe UI', sans-serif; /* Clean industrial font */
    height: 100vh;
    width: 100vw;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Top Bar - Toyota Style (Black with White Text) */
.top-bar {
    height: 60px;
    background-color: #000;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    border-bottom: 2px solid var(--accent-yellow);
    flex-shrink: 0;
}

.logo-section h1 {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.clock-section {
    font-family: 'Courier New', monospace; /* Monospace for numbers */
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--accent-yellow);
    display: flex;
    gap: 20px;
}

.dashboard-container {
    display: flex;
    flex-direction: column;
    flex: 1;
    width: 100%;
    overflow-x: auto;
    overflow-y: auto; /* Enable vertical scrolling if boxes exceed height */
    background-color: #000;
}

.nav-section {
    display: flex;
    gap: 10px;
}

.nav-btn {
    background: transparent;
    border: 1px solid var(--accent-yellow);
    color: var(--accent-yellow);
    padding: 5px 15px;
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.2s;
    border-radius: 2px;
}

.nav-btn:hover {
    background: var(--accent-yellow);
    color: #000;
}

/* Header Row (Dates) */
.header-row {
    display: flex;
    min-width: fit-content;
    border-bottom: 2px solid #fff;
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #222; /* Slightly lighter than bg */
}

.date-header {
    width: var(--col-min-width);
    height: var(--header-height);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    border-right: 1px solid var(--grid-line-color);
    text-transform: uppercase;
    color: #fff;
    background-color: #222;
}

.date-header:last-child {
  border-right: none;
}

/* Grid Container */
.grid-container {
    display: flex;
    flex: 3;
    min-width: fit-content;
}

/* Day Column - remove gap if any */
.day-column {
    width: var(--col-min-width);
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 10px;
    border-right: 1px solid var(--grid-line-color);
    background-color: #1a1a1a;
    min-height: 100%;
}

.day-column:last-child {
  border-right: none;
}

/* Box Styling - Readable & Professional */
.job-box {
    background-color: var(--box-bg);
    border: 1px solid var(--box-border);
    border-radius: 4px; /* Restore slight rounding */
    padding: 10px 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.5);
    height: 310px; /* Fixed height for uniform length */
    justify-content: space-between; /* Spread rows evenly */
    flex-shrink: 0;
}

.job-box:hover {
    border-color: var(--accent-yellow); /* Highlight on hover */
    background-color: #004080;
}

/* White background for Preventive Done (Act Stroke = 0) */
.job-box.prevented {
    background-color: #ffffff !important;
    border-color: #000000;
}

.job-box.prevented .label {
    color: #555 !important;
}

.job-box.prevented .value,
.job-box.prevented .highlight,
.job-box.prevented .highlight2,
.job-box.prevented .highlight3 {
    color: #000000 !important;
}

.job-box.prevented .job-row {
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

/* Toggleable white background for all cards */
.prevented .toggle-card-bg {
    border-color: #555;
}
.toggle-card-bg:hover {
    background: #fff;
}
.prevented .toggle-card-bg:hover {
    background: #555;
}

body.white-cards .job-box {
    background-color: #ffffff !important;
    border-color: #000000;
}
body.white-cards .job-box .label {
    color: #555 !important;
}
body.white-cards .job-box .value,
body.white-cards .job-box .highlight,
body.white-cards .job-box .highlight2,
body.white-cards .job-box .highlight3 {
    color: #000000 !important;
}
body.white-cards .job-box .job-row {
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.job-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline; /* Align text baselines */
    border-bottom: 1px solid rgba(255,255,255,0.1); /* Subtle separators */
    padding-bottom: 2px;
}

.job-row:last-child {
    border-bottom: none;
}

.label {
    font-size: 0.85rem; /* Balanced size */
    font-weight: 700;
    color: #bbb;
    text-transform: uppercase;
    min-width: 85px;
}

.value {
    font-size: 1.1rem; /* Balanced size */
    font-weight: 700;
    color: #fff;
    text-align: right;
    white-space: normal;
    overflow: visible;
    word-break: break-word;
    overflow-wrap: break-word;
    line-height: 1.1;
}

.highlight {
    color: var(--accent-yellow);
    font-size: 1.2rem;
}

.highlight2 {
    color: var(--accent-green);
    font-size: 1.2rem;
}

.highlight3 {
    color: var(--accent-total);
    font-size: 1.2rem;
}
/* Scrollbar styling for Webkit */
.dashboard-container::-webkit-scrollbar {
    height: 10px;
}

.dashboard-container::-webkit-scrollbar-track {
    background: #222;
}

.dashboard-container::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 0; /* Square scrollbar */
}

.dashboard-container::-webkit-scrollbar-thumb:hover {
    background: var(--accent-yellow);
}

  </style>
  <body>
    <header class="top-bar">
        <div class="logo-section">
            <h1>CONTROL BOARD LIST PREVENTIVE DIES</h1>
        </div>

        <div class="nav-section">
            <button id="navLeft" class="nav-btn">&lt; PREV</button>
            <button id="navRight" class="nav-btn">NEXT &gt;</button>
        </div>

        <div class="clock-section" id="clockDisplay">
            <span id="currentDate">-- --- ----</span>
            <span id="currentTime">--:--:--</span>
        </div>
    </header>

    <div class="dashboard-container" id="dashboardScroll">
      <!-- Header Row with Dates -->
      <div class="header-row" id="dateHeader">
        <!-- Dates will be injected here -->
      </div>

      <!-- Main Grid -->
      <div class="grid-container" id="mainGrid">
        <!-- Columns and Boxes will be injected here -->
      </div>
    </div>
  </body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const dateHeader = document.getElementById("dateHeader");
        const mainGrid   = document.getElementById("mainGrid");

        const DAYS_IN_MONTH = 31;
        const MAX_BOX_PER_DAY = 5;

        /* ================================
           TOGGLE BG PERSISTENCE
        ================================= */
        window.toggleCardBg = function(jobKey, boxEl) {
            boxEl.classList.toggle('prevented');

            const isWhite = boxEl.classList.contains('prevented');
            let overrides = JSON.parse(localStorage.getItem('cardColorOverrides') || '{}');
            overrides[jobKey] = isWhite;
            localStorage.setItem('cardColorOverrides', JSON.stringify(overrides));

            const actStrokeSpan = boxEl.querySelector('.act-stroke-val');
            if (actStrokeSpan) {
                if (isWhite) {
                    actStrokeSpan.textContent = '0';
                } else {
                    actStrokeSpan.textContent = actStrokeSpan.getAttribute('data-original');
                }
            }
        };

        /* ================================
           CREATE BOX
        ================================= */
        function createBoxElement(jobData) {
            const boxEl = document.createElement('div');

            // ✅ Basis awal: Jika actual_stroke adalah 0
            let isPrevented = jobData.actual_stroke == 0;

            // ✅ Membaca memori override dari local storage jika user pernah mengklik
            const jobKey = jobData.job_no || jobData.part_no || '-';
            let overrides = JSON.parse(localStorage.getItem('cardColorOverrides') || '{}');
            if (overrides[jobKey] !== undefined) {
                 isPrevented = overrides[jobKey];
            }

            boxEl.className = 'job-box' + (isPrevented ? ' prevented' : '');

            boxEl.innerHTML = `
                <div class="job-row">
                    <span class="label" style="display: flex; align-items: center; gap: 6px;">
                        <button title="Ubah Warna Card" style="width: 12px; height: 12px; border-radius: 50%; border: 1px solid currentColor; background: transparent; cursor: pointer; padding: 0;" onclick="toggleCardBg('${jobKey}', this.closest('.job-box'))"></button>
                        Cust
                    </span>
                    <span class="value">${jobData.customer ?? '-'}</span>
                </div>
                <div class="job-row">
                    <span class="label">Part No</span>
                    <span class="value">${jobData.part_no ?? '-'}</span>
                </div>
                <div class="job-row">
                    <span class="label">Job</span>
                    <span class="value">${jobData.job_no ?? '-'}</span>
                </div>
                <div class="job-row">
                    <span class="label">Model</span>
                    <span class="value highlight">${jobData.model_id ?? '-'}</span>
                </div>
                 <div class="job-row">
                    <span class="label">Std Stroke</span>
                    <span class="value highlight">${jobData.std_stroke ?? '-'}</span>
                </div>
                <div class="job-row">
                    <span class="label">Act Stroke</span>
                    <span class="value highlight2 act-stroke-val" data-original="${jobData.actual_stroke ?? '-'}">${isPrevented ? '0' : (jobData.actual_stroke ?? '-')}</span>
                </div>
                <div class="job-row">
                    <span class="label">Line</span>
                    <span class="value">${jobData.line_id ?? '-'}</span>
                </div>
                <div class="job-row">
    <span class="label">Total Stroke</span>
    <span class="value highlight">${jobData.actual_stroke_all ?? 0}</span>
</div>



            `;
            return boxEl;
        }


           /* ================================
           PROGRESS YANG DIBAWAH MENAMPILKAN TOTAL STROKE DARI AWAL MASPRO
        ================================= */
        /* ================================
           RENDER DASHBOARD FROM DB
        ================================= */
        function renderDashboard(data) {

dateHeader.innerHTML = '';
mainGrid.innerHTML   = '';
const MAX_BOX_PER_DAY = 3; /* Limit 3 cards per day for better readability */

const now = new Date();
const year = now.getFullYear();
const month = now.getMonth();
// ✅ Dapatkan jumlah hari yang benar (dynamic) untuk bulan ini
const TOTAL_DAYS = new Date(year, month + 1, 0).getDate();

const months = ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];
const currentMonth = months[month];

let dataIndex = 0;

for (let day = 1; day <= TOTAL_DAYS; day++) {

    const headerCell = document.createElement('div');
    headerCell.className = 'date-header';
    const displayDay = day.toString().padStart(2, '0');
    headerCell.textContent = `${displayDay} ${currentMonth}`;
    dateHeader.appendChild(headerCell);

    const column = document.createElement('div');
    column.className = 'day-column';

    for (let i = 0; i < MAX_BOX_PER_DAY; i++) {
        if (dataIndex >= data.length) break;

        column.appendChild(createBoxElement(data[dataIndex]));
        dataIndex++;
    }

    mainGrid.appendChild(column);
}

}



        /* ================================
           FETCH DATA FROM LARAVEL
        ================================= */
        function loadDiesData() {
    fetch("{{ route('andon.dies.data') }}")
        .then(res => res.json())
        .then(data => {
            console.log("DATA DARI SERVER:", data); // ⬅️ WAJIB
            renderDashboard(data);
        })
        .catch(err => console.error("Gagal load data:", err));
}

        /* ================================
           NAVIGATION
        ================================= */
        const scrollContainer = document.querySelector('.dashboard-container');
        const navLeft  = document.getElementById('navLeft');
        const navRight = document.getElementById('navRight');

        if (navLeft && navRight && scrollContainer) {
            navLeft.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
            });
            navRight.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
            });
        }

        /* ================================
           CLOCK
        ================================= */
        function updateClock() {
            const now = new Date();
            const dateEl = document.getElementById('currentDate');
            const timeEl = document.getElementById('currentTime');

            const day   = now.getDate().toString().padStart(2, '0');
            const months = ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];
            const month = months[now.getMonth()];
            const year  = now.getFullYear();

            if(dateEl) dateEl.textContent = `${day}-${month}-${year}`;

            const h = now.getHours().toString().padStart(2,'0');
            const m = now.getMinutes().toString().padStart(2,'0');
            const s = now.getSeconds().toString().padStart(2,'0');

            if(timeEl) timeEl.textContent = `${h}:${m}:${s}`;
        }

        setInterval(updateClock, 1000);
        updateClock();

        /* ================================
           INIT
        ================================= */
        loadDiesData();

        // OPTIONAL auto refresh tiap 10 detik
        // setInterval(loadDiesData, 10000);

    });
    </script>


