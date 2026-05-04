<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphic Charts Dashboard</title>
   <!-- <link rel="stylesheet" href="{{ asset('css/summarydiesmtc.css') }}"> -->
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
    --primary-color: #0ea5e9;
    --secondary-color: #64748b;
    /* Slate 500 */
    --bg-color: #f1f5f9;
    /* Light Gray Background */
    --card-bg: #ffffff;
    /* White Cards */
    --text-color: #334155;
    /* Slate 700 */
    --border-color: #e2e8f0;
    /* Light Border */
    --accent-blue: #2563eb;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Afacad', sans-serif;
    background-color: var(--bg-color);
    color: var(--text-color);
    padding: 1rem;
    height: 100vh; /* Base height */
    min-width: 1280px; /* Force minimum width to prevent layout break on zoom */
    min-height: 720px; /* Force minimum height to prevent squashing */
    overflow: auto; /* Allow scrollbars when zooming in */
    display: flex;
    flex-direction: column;
}

.dashboard-container {
    width: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0; /* Important for deeply nested flexbox scrolling */
}

.main-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(90deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);
    /* Deep Blue Gradient */
    padding: 0.5rem 1rem;
    margin-bottom: 1rem;
    border-bottom: 4px solid #38bdf8;
    /* Light blue bottom border accent */
    flex-shrink: 0;
    color: white;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.logo-box {
    background: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 150px;
    border: 1px solid #cbd5e1;
}

.logo-text {
    font-size: 1.2rem;
    font-weight: 800;
    font-style: italic;
    color: #2563eb;
    /* Blue logo text */
    line-height: 1;
}

.logo-sub {
    font-size: 0.4rem;
    color: #0f172a;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 2px;
}

.header-title h1 {
    font-size: 2rem;
    font-weight: 600;
    color: #ffffff;
    letter-spacing: 0.5px;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.header-right {
    display: flex;
    align-items: center;
}

.datetime-display {
    background: linear-gradient(90deg, #0ea5e9, #0284c7);
    /* Light Blue Gradient Button */
    padding: 0.5rem 1.5rem;
    border-radius: 20px 0 0 20px;
    /* Rounded left side like tab */
    font-family: 'Afacad', sans-serif;
    font-weight: 600;
    font-size: 1.25rem;
    color: white;
    box-shadow: -2px 2px 5px rgba(0, 0, 0, 0.2);
    margin-right: -1rem;
    /* Extend to edge if needed */
}

/* Charts Section (Split Layout) */
.main-layout {
    display: flex;
    gap: 1.5rem;
    flex: 1;
    min-height: 0;
}



.left-panel {
    flex: 3; /* Increased from 2 to make bar charts much wider */
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding-right: 0.5rem;
    overflow-y: auto; /* Allow scrolling if charts get too tall on small screens */
}

/* Scrollbar styling for panels */
.left-panel::-webkit-scrollbar,
.table-container::-webkit-scrollbar {
    width: 6px;
}

.left-panel::-webkit-scrollbar-thumb,
.table-container::-webkit-scrollbar-thumb {
    background-color: #4b5563;
    border-radius: 4px;
}

.left-panel::-webkit-scrollbar-track,
.table-container::-webkit-scrollbar-track {
    background-color: transparent;
}


.right-panel {
    flex: 1.2;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-height: 100%;
    overflow: hidden;
    background: #020617; /* Midnight Dark */
    padding: 1rem;
    border-radius: 12px;
    box-shadow: inset 0 0 40px rgba(0,0,0,0.8);
    border: 1px solid #1e293b;
}

.chart-card {
    background: var(--card-bg);
    border-radius: 8px;
    padding: 0.75rem 1.25rem; /* Reduced vertical padding slightly */
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    flex: 1; /* Automatically share height equally */
    min-height: 0; /* Important: prevents fixed height */
    border: 1px solid var(--border-color);
}

.chart-card h2 {
    margin-bottom: 0.75rem;
    font-size: 1.4rem;
    /* Increased from 1.2rem */
    color: #4cceac;
    /* Accent Green/Cyan for titles often seen in dark dashboards */
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

/* Bar Chart Container for Chart.js */
.bar-chart-container {
    position: relative;
    flex: 1; /* Grow to fill available space */
    min-height: 0; /* Let flexbox handle minimum height */
    width: 100%;
}

/* Pie Chart Styles */
.pie-card {
    flex: 0 0 auto;
    height: 310px; /* Adjusted height */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    background: rgba(15, 23, 42, 0.8) !important; /* Unified Glass */
    backdrop-filter: blur(8px);
    border: 1px solid rgba(51, 65, 85, 0.5);
}

.andon-card {
    flex: 1; /* Fill remaining space */
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: var(--card-bg);
    border-radius: 8px;
    padding: 0.75rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-color);
}

    /* Premium Right Panel Card */
    .right-panel .andon-card {
        background: rgba(15, 23, 42, 0.8); /* Glass effect */
        backdrop-filter: blur(8px);
        border: 1px solid rgba(51, 65, 85, 0.5);
        border-radius: 8px;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }

    .andon-card.small {
        flex: 0 0 auto;
        margin-bottom: 0.5rem;
    }

    .andon-card.large {
        flex: 1 1 auto; /* Force growth to fill remaining space */
        display: flex;
        flex-direction: column;
        min-height: 0;
        height: 100%; /* Encourage filling parent height */
    }

    .andon-table-wrapper {
        flex: 1;
        overflow-y: auto;
        margin-top: 0.5rem;
        scrollbar-width: thin;
        scrollbar-color: #334155 transparent;
    }

.andon-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1.1rem; /* Increased font size */
}

    .andon-table th {
        background: rgba(30, 41, 59, 0.9);
        color: #94a3b8;
        padding: 8px 12px;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 2px;
        position: sticky;
        top: 0;
        z-index: 10;
        text-align: left;
        border-bottom: 2px solid #334155;
    }

    .andon-table td {
        background: transparent;
        padding: 10px 12px;
        border-bottom: 1px solid rgba(51, 65, 85, 0.3);
        color: #f8fafc;
        vertical-align: middle;
    }

    .andon-table tr:hover td {
        background: rgba(51, 65, 85, 0.2);
    }

.status-check {
    color: #10b981;
    font-weight: bold;
}

.status-warning {
    color: #f59e0b;
    font-weight: bold;
}

.pie-chart-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    width: 100%;
}

.pie-chart {
    width: 100%; /* Fill the container's width */
    max-width: 450px; /* Reduced max size for smaller circle */
    aspect-ratio: 1/1;
    height: auto;
    border-radius: 50%;
    /* Gradient */
    background: conic-gradient(var(--c) calc(var(--p) * 1%),
            #2e3a59 0
        );
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    /* Ultra-premium shadow effect */
    box-shadow:
        0 15px 35px rgba(0, 0, 0, 0.4),
        0 0 20px rgba(14, 165, 233, 0.2);
    margin-bottom: 1rem; /* Reduced from 2rem to pull legend closer */
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
}

/* Enhanced Hover Effect */
.pie-chart:hover {
    transform: scale(1.08); /* More pronounced zoom */
    box-shadow:
        0 20px 45px rgba(0, 0, 0, 0.5),
        0 0 40px rgba(14, 165, 233, 0.5); /* Glowing effect */
}

.pie-chart::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background:
        linear-gradient(to right, transparent 49.5%, #4b5563 49.5%, #4b5563 50.5%, transparent 50.5%),
        linear-gradient(to bottom, transparent 49.5%, #4b5563 49.5%, #4b5563 50.5%, transparent 50.5%);
    z-index: 1;
    pointer-events: none;
    opacity: 0.3;
    /* Subtle grid on pie */
}

/* To create the 'Donut' hole effect matching dark theme */
.pie-chart::after {
    content: '';
    position: absolute;
    width: 70%;
    height: 70%;
    background: var(--card-bg);
    border-radius: 50%;
    z-index: 0;
}

.pie-label {
    font-size: 5vw; /* Proportional but smaller */
    font-weight: 900;
    color: #ffffff;
    text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    z-index: 2;
    position: relative;
    background: transparent;
    border: none;
}

.pie-legend {
    margin-top: 1rem;
    display: flex;
    flex-direction: row;
    gap: 1.5rem;
    align-items: center;
}

.legend-item {
    font-size: 1.8rem; /* Even larger legend text */
    font-weight: 700;
    color: var(--secondary-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.dot {
    width: 25px; /* Even larger dots */
    height: 25px;
    border-radius: 50%;
    display: inline-block;
}

.dot.target {
    background: #fcd34d;
    box-shadow: 0 0 5px #fcd34d;
}

.dot.actual {
    background: #10b981;
    box-shadow: 0 0 5px #10b981;
}


/* Table Styles removed as Report List is removed */



/* --- Modal & Button Styles --- */

.chart-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 0.5rem;
}

.chart-header h2 {
    margin-bottom: 0;
    /* Override previous margin */
    border-bottom: none;
    padding-bottom: 0;
}

.view-btn {
    background: transparent;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    padding: 4px;
    cursor: pointer;
    color: var(--secondary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.view-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Modal Overlay */
.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    /* Black w/ opacity */
    backdrop-filter: blur(4px);
}

/* Modal Content */
.modal-content {
    background-color: var(--card-bg);
    margin: 10% auto;
    /* 10% from the top and centered */
    padding: 2rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    position: relative;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.close-btn {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
}

.close-btn:hover,
.close-btn:focus {
    color: var(--text-color);
    text-decoration: none;
    cursor: pointer;
}

.modal-body {
    margin-top: 1rem;
    color: var(--text-color);
    font-size: 1.1rem;
}
        .chart-filter {
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            background-color: #f8fafc;
            margin-left: auto;
            cursor: pointer;
            transition: all 0.2s;
        }
        .chart-filter:hover {
            border-color: #3b82f6;
            background-color: #fff;
        }

        /* Summary Table Styling */
        .summary-table-wrapper {
            margin-top: 10px;
            overflow-x: auto;
            border: 1px solid #64748b;
            border-radius: 4px;
            width: 100%;
            display: block;
        }
        .summary-table {
            width: 100%;
            min-width: 1800px; /* Safe width for 31 columns */
            border-collapse: collapse;
            font-size: 20px; /* Increased back up from 16px to 20px for readability */
            table-layout: fixed;
        }
        .summary-table th, .summary-table td {
            border: 1px solid #94a3b8;
            text-align: center;
            padding: 6px 8px; /* Slightly more padding for larger text */
            height: auto;
            vertical-align: middle;
            font-weight: bold;
        }
        .summary-table .header-gray {
            background-color: #cbd5e1;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            font-size: 16px; /* Increased title size */
        }
        .summary-table .desc-col {
            width: 180px; /* Adjusted width for bigger text */
            text-align: center;
            font-weight: bold;
            font-size: 18px; /* Increased label size */
        }
        .summary-table .weekend {
            background-color: #ef4444 !important;
            color: #fff !important;
        }
        .summary-table .target-row td {
            font-weight: 900; /* Extra bold */
        }
        .summary-table .actual-row td {
            font-weight: 900; /* Extra bold */
            color: #000;
        }
        .chart-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Header -->
        <!-- Header -->
        <header class="main-header">
            <div class="header-left">

                <div class="header-title">
                    <h1>Dashboard Summary DIE MTC</h1>
                </div>
            </div>
            <div class="header-right d-flex align-items-center">
                <div class="datetime-display" id="currentDateTime">
                    Selasa, 6 Januari 2026, 13:04:45
                </div>
            </div>
        </header>

        <!-- Main Split Layout -->
        <div class="main-layout">

            <!-- LEFT PANEL: 3 Bar Charts -->
            <div class="left-panel">


                  <!-- Bar Chart 3: PM Achievement Monthly -->
                <div class="chart-card">
                    <div class="chart-header">
                        <button class="view-btn" onclick="openModal('PM Achievement')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <h2>PM Achievement</h2>
                        <input type="month" id="filterPM" class="chart-filter" value="{{ $currentMonthYear }}">
                    </div>
                    <div class="bar-chart-container">
                        <canvas id="pmChart"></canvas>
                    </div>
                    <div class="summary-table-wrapper">
                        <table class="summary-table" id="summaryTablePM"></table>
                    </div>
                </div>

                <!-- Bar Chart 2: Down Time -->
                <div class="chart-card">
                    <div class="chart-header">
                        <button class="view-btn" onclick="openModal('Down Time')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <h2>DownTime Line</h2>
                        <input type="month" id="filterDownTime" class="chart-filter" value="{{ $currentMonthYear }}">
                    </div>
                    <div class="bar-chart-container">
                        <canvas id="downTimeChart"></canvas>
                    </div>
                    <!-- Summary Table Below Chart -->
                    <div class="summary-table-wrapper">
                        <table class="summary-table" id="summaryTableDownTime">
                            <!-- Populated via JS -->
                        </table>
                    </div>
                </div>

                    <div class="chart-card">
                    <div class="chart-header">
                        <button class="view-btn" onclick="openModal('Repair')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <h2>Repair</h2>
                        <input type="month" id="filterRepair" class="chart-filter" value="{{ $currentMonthYear }}">
                    </div>
                    <div class="bar-chart-container">
                        <canvas id="repairChart"></canvas>
                    </div>
                    <div class="summary-table-wrapper">
                        <table class="summary-table" id="summaryTableRepair"></table>
                    </div>
                </div>



            </div>

            <!-- RIGHT PANEL: Pie Chart + Andon Table -->
            <div class="right-panel">
                <div class="chart-card pie-card">
                    <h2 style="font-size: 1.1rem;">Daily Achievement</h2>
                    <div class="pie-chart-container">
                        <div class="pie-chart" style="--p: 0; --c: #10b981; --b: #fcd34d; max-width: 250px;">
                            <span class="pie-label" style="font-size: 3rem;">0%</span>
                        </div>

                        <div class="pie-legend" style="margin-top: 0.5rem; gap: 0.75rem;">
                            <div class="legend-item" style="font-size: 1.1rem;">
                                <span class="dot target" style="width: 15px; height: 15px;"></span> Target
                            </div>
                            <div class="legend-item" style="font-size: 1.1rem;">
                                <span class="dot actual" style="width: 15px; height: 15px;"></span> Actual
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DIES PM TODAY -->
                <div class="andon-card small">
                    <div class="chart-header">
                        <h2 class="fids-header">Dies PM Today</h2>
                    </div>

                    <div class="andon-table-wrapper">
                        <table class="andon-table">
                            <thead>
                                <tr>
                                    <th style="font-size: 1.5rem;">Part No</th>
                                    <th style="font-size: 1.5rem;">Model</th>
                                    <th style="font-size: 1.5rem;">Line</th>
                                    <th style="font-size: 1.5rem;">OP</th>
                                    <th style="font-size: 1.5rem;">Act</th>
                                    <th style="font-size: 1.5rem;">Std</th>
                                </tr>
                            </thead>
                            <tbody id="andonTodayBody">
                                <!-- Populated via JS -->
                                <tr><td colspan="6" style="text-align:center;">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- FIXED: Added missing closing div for andon-card small -->

                <!-- LKH TODAY -->
                <div class="andon-card large">
                    <div class="chart-header">
                        <h2 class="fids-header">LKH Today</h2>
                    </div>
                    <div class="andon-table-wrapper">
                        <table class="andon-table">
                            <thead>
                                <tr>
                                    <th style="font-size: 1.5rem;">Part No</th>
                                    <th style="font-size: 1.5rem;">Model</th>
                                    <th style="font-size: 1.5rem;">Line</th>
                                    <th style="font-size: 1.5rem;">Problem</th>
                                    <th style="font-size: 1.5rem;">Proses</th>
                                    <th style="font-size: 1.5rem;">DT</th>
                                    <th style="font-size: 1.5rem;">PIC</th>
                                </tr>
                            </thead>
                            <tbody id="lkhTodayBody">
                                <tr><td colspan="7" style="text-align:center;">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Generic Modal (Empty) -->
    <div id="chartModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Modal Details</h2>
            <div class="modal-body">
                <!-- Empty Content as requested "MODAL SAJA TANPA DATA" -->
                <p>No data available.</p>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js DataLabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <!-- Custom Script -->
    <script>
        Chart.register(ChartDataLabels);

        const DATA_URL = "{{ route('dashboardsummarydies.data') }}";
        const labels = Array.from({length: 31}, (_, i) => i + 1);

        const dataLabelConfig = {
            color: '#000',
            anchor: 'end',
            align: 'end',
            offset: -2,
            font: { weight: 'bold', size: 30 },
            formatter: (value, context) => {
                // Hide labels for the Target Line dataset (index 1)
                if (context.datasetIndex === 1) return '';
                return (value > 0 ? value : '');
            }
        };

        const chartOptions = (backgroundColor) => ({
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { top: 45 } }, // Increased padding for data labels
            plugins: {
                legend: { display: false },
                datalabels: dataLabelConfig
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '20%', // Added grace for top labels
                    ticks: {
                        font: { size: 10, weight: 'bold' }, // Significantly increased Y-axis text size
                        precision: 0,
                        color: '#334155'
                    },
                    grid: {
                        display: true,
                        lineWidth: 1.5, // Thicker horizontal grid lines
                        color: 'rgba(0, 0, 0, 0.15)'
                    }
                },
                x: {
                    ticks: {
                        font: { size: 14, weight: 'bold' }, // Significantly increased X-axis text size
                        color: '#334155'
                    },
                    grid: {
                        display: true,
                        lineWidth: 1.5, // Thicker vertical grid lines
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        });

        const initChart = (id, label, color, showTarget = false) => {
            const ctx = document.getElementById(id).getContext('2d');
            const datasets = [{
                label: label,
                data: Array(31).fill(0),
                backgroundColor: color,
                borderRadius: 4,
                order: 2
            }];

            if (showTarget) {
                datasets.push({
                    label: 'Target Line',
                    data: Array(31).fill(0),
                    type: 'line',
                    borderColor: '#10b981', // Green for Target
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#10b981',
                    fill: false,
                    tension: 0,
                    order: 1
                });
            }

            return new Chart(ctx, {
                type: 'bar', // Explicitly set type for mixed charts
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: chartOptions(color)
            });
        };

        const chartRepair = initChart('repairChart', 'Repair (minutes)', '#3b82f6', true);
        const chartDownTime = initChart('downTimeChart', 'DownTime Line (minutes)', '#ef44446c', true);
        const chartPM = initChart('pmChart', 'PM (count)', '#10b981', true);

        async function fetchChartData(chart, type, date) {
            try {
                const response = await fetch(`${DATA_URL}?type=${type}&date=${date}`);
                const data = await response.json();
                // Update Bar Data
                chart.data.datasets[0].data = data;

                // Update Target Line for DownTime, Repair, and PM
                if ((type === 'downtime' || type === 'repair' || type === 'pm') && chart.data.datasets[1]) {
                    const [y, m] = date.split('-').map(Number);
                  const targets = Array.from({length: 31}, (_, i) => {
    const d = i + 1;

    // KHUSUS tanggal 1 & 2
    if (d === 1 || d === 2) return 0;

    const dayDate = new Date(y, m - 1, d);
    const isWeekend = dayDate.getDay() === 0 || dayDate.getDay() === 6;
    if (isWeekend) return 0;

    if (type === 'pm') {
        const specialDates = [19, 20, 21, 22, 23, 27, 29];
        return specialDates.includes(d) ? 2 : 3;
    }

    return type === 'repair' ? 5 : 20;
});

                    chart.data.datasets[1].data = targets;
                }

                chart.update();

                // Update summary tables for all chart types
                if (type === 'downtime') {
                    updateSummaryTable(data, date, 'summaryTableDownTime', 'ACTUAL MENIT');
                } else if (type === 'repair') {
                    updateSummaryTable(data, date, 'summaryTableRepair', 'ACTUAL REPAIR');
                } else if (type === 'pm') {
                    updateSummaryTable(data, date, 'summaryTablePM', ' ACTUAL PM');
                }
            } catch (error) {
                console.error(`Error fetching ${type} data:`, error);
            }
        }

        function updateSummaryTable(data, dateStr, tableId, label) {
            const table = document.getElementById(tableId);
            if (!table) return;
            const [year, month] = dateStr.split('-').map(Number);
            const daysInMonth = new Date(year, month, 0).getDate();

            // Determine target value and label based on table type
            let targetValue, targetLabel;
            if (tableId === 'summaryTableRepair') {
                targetValue = 5;
                targetLabel = 'TARGET REPAIR';
            } else if (tableId === 'summaryTablePM') {
                targetValue = 15; // Changed to 15
                targetLabel = 'TARGET PM';
            } else { // DownTime
                targetValue = 20;
                targetLabel = 'TARGET MENIT';
            }

            // All tables now have 3 rows: Header dates, Target/Repair, and Actual
            let headerRow = `<tr><th rowspan="2" class="header-gray desc-col">DESKRIPSI</th><th colspan="31" class="header-gray">TANGGAL</th></tr><tr>`;
            let targetRow = `<tr class="target-row"><td class="header-gray">${targetLabel}</td>`;
            let actualRow = `<tr class="actual-row"><td class="header-gray">${label}</td>`;

            for (let i = 1; i <= 31; i++) {
                if (i <= daysInMonth) {
                    const dayDate = new Date(year, month - 1, i);
                    const isWeekend = dayDate.getDay() === 0 || dayDate.getDay() === 6; // Sun or Sat
                    const weekendClass = isWeekend ? 'weekend' : '';

                    headerRow += `<th class="header-gray ${weekendClass}">${i}</th>`;

                   let cellValue;

// KHUSUS tanggal 1 dan 2
if (i === 1 || i === 2) {
    cellValue = 0;
}
// weekend
else if (isWeekend) {
    cellValue = 0;
}
// tabel PM
else if (tableId === 'summaryTablePM') {
    const specialDates = [19, 20, 21, 22, 23, 27, 29];
    cellValue = specialDates.includes(i) ? 2 : 3;
}
// default
else {
    cellValue = targetValue;
}


                    targetRow += `<td class="${weekendClass}">${cellValue}</td>`;
                    actualRow += `<td class="${weekendClass}">${data[i-1] || 0}</td>`;
                } else {
                    headerRow += `<th class="header-gray"></th>`;
                    targetRow += `<td></td>`;
                    actualRow += `<td></td>`;
                }
            }
            headerRow += `</tr>`;
            targetRow += `</tr>`;
            actualRow += `</tr>`;

            table.innerHTML = headerRow + targetRow + actualRow;
        }

        // Event Listeners
        document.getElementById('filterRepair').addEventListener('change', (e) => fetchChartData(chartRepair, 'repair', e.target.value));
        document.getElementById('filterDownTime').addEventListener('change', (e) => fetchChartData(chartDownTime, 'downtime', e.target.value));
        document.getElementById('filterPM').addEventListener('change', (e) => fetchChartData(chartPM, 'pm', e.target.value));

        // Live Clock
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('currentDateTime').innerText =
                `${dayName}, ${day} ${monthName} ${year}, ${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Fetch Andon Today
        async function fetchAndonToday() {
            try {
                const res = await fetch("{{ route('andon.dies.today') }}");
                const data = await res.json();
                const tbody = document.getElementById('andonTodayBody');
                tbody.innerHTML = '';

                let totalActual = 0;
                let totalTarget = 0;
                const todayStr = new Date().toISOString().split('T')[0];

                data.forEach(item => {
                    const row = document.createElement('tr');

                    // Check if preventive was done today
                    const isDoneToday = item.date_prev && item.date_prev.startsWith(todayStr);
                    const rowActual = isDoneToday ? parseInt(item.op_proses || 0) : 0;

                    totalActual += rowActual;
                    totalTarget += parseInt(item.op_proses || 0);

                    // For standard stroke progress (warning color)
                    // (This is just visual for the row, still using the basic logic)
                    const rowProgress = (rowActual / item.std_stroke) * 100;
                    const statusClass = isDoneToday ? 'status-check' : '';

                    row.innerHTML = `
                        <td style="font-size: 1.5rem;" class="glow-yellow">${item.part_no}</td>
                        <td style="font-size: 1.5rem;" class="glow-white">${item.model_id}</td>
                        <td style="font-size: 1.5rem;">${item.line_id}</td>
                        <td style="font-size: 1.5rem; color:#6fa8dc" class="glow-cyan">${item.op_proses || 0}</td>
                        <td style="font-size: 1.8rem; color:#10b981" class="${isDoneToday ? 'glow-green' : 'glow-white'}">${item.actual_stroke || 0}</td>
                        <td style="font-size: 1.5rem; color:#e2f027">${item.std_stroke}</td>
                    `;
                    tbody.appendChild(row);
                });

                // Update Pie Chart Data
                const pieChart = document.querySelector('.pie-chart');
                const pieLabel = document.querySelector('.pie-label');
                const legendActual = document.querySelector('.dot.actual').parentElement;
                const legendTarget = document.querySelector('.dot.target').parentElement;

                const percent = totalTarget > 0 ? Math.round((totalActual / totalTarget) * 100) : 0;

                pieChart.style.setProperty('--p', percent);
                pieLabel.innerText = percent + '%';

                legendActual.innerHTML = `<span class="dot actual" style="width: 15px; height: 15px;"></span> Actual (${totalActual})`;
                legendTarget.innerHTML = `<span class="dot target" style="width: 15px; height: 15px;"></span> Target (${totalTarget})`;
            } catch (err) {
                console.error("Error fetching andon today:", err);
                const tbody = document.getElementById('andonTodayBody');
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Error loading data</td></tr>';
            }
        }
        // Fetch LKH Today
        async function fetchLkhToday() {
            try {
                const res = await fetch("{{ route('andon.lkh.today') }}");
                const data = await res.json();
                const tbody = document.getElementById('lkhTodayBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; font-size: 2rem;">No data for today</td></tr>';
                    return;
                }

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td style="font-size: 1.8rem;" class="glow-yellow">${item.part_no || ''}</td>
                        <td style="font-size: 1.6rem;">${item.model_id || ''}</td>
                        <td style="font-size: 1.6rem;" class="glow-white">${item.line_id || ''}</td>
                        <td style="font-size: 1.6rem; font-style: italic;">${item.problem || ''}</td>
                        <td style="font-size: 1.6rem;" class="glow-cyan">${item.proses || ''}</td>
                        <td style="font-size: 2rem;color:#10b981" class="glow-green">${item.dt_total || 0}</td>
                        <td style="font-size: 1.6rem;">${item.pic || ''}</td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (err) {
                console.error("Error fetching lkh today:", err);
                const tbody = document.getElementById('lkhTodayBody');
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; font-size: 2rem;">Error loading data</td></tr>';
            }
        }

        // Initial Load
        window.addEventListener('load', () => {
            fetchChartData(chartRepair, 'repair', document.getElementById('filterRepair').value);
            fetchChartData(chartDownTime, 'downtime', document.getElementById('filterDownTime').value);
            fetchChartData(chartPM, 'pm', document.getElementById('filterPM').value);
            fetchAndonToday();
            fetchLkhToday();
        });

        // Auto Refresh (Every 30 seconds)
        setInterval(() => {
            fetchChartData(chartRepair, 'repair', document.getElementById('filterRepair').value);
            fetchChartData(chartDownTime, 'downtime', document.getElementById('filterDownTime').value);
            fetchChartData(chartPM, 'pm', document.getElementById('filterPM').value);
            fetchAndonToday();
            fetchLkhToday();
        }, 30000);

        // Modal Logic
        const modal = document.getElementById('chartModal');
        const modalTitle = document.getElementById('modalTitle');
        function openModal(title) { modal.style.display = 'block'; modalTitle.innerText = title + ' Details'; }
        function closeModal() { modal.style.display = 'none'; }
        window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }
    </script>
</body>

</html>


