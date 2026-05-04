<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Robot Dashboamrd</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Orbitron:wght@600;700&display=swap"
    rel="stylesheet">
  <style>
    :root {
      /* Colors for Light Theme */
      --deep-bg: #f4f7f6;
      /* Smooth off-white/gray */
      --card-bg: #ffffff;
      --accent-cyan: #0284c7;
      --accent-blue: #1e40af;
      --good: #059669;
      /* Darker green for legibility on white */
      --warn: #d97706;
      /* Darker amber */
      --bad: #dc2626;
      /* Darker red */
      --text-primary: #1e293b;
      /* Dark text */
      --text-secondary: #64748b;
      /* Slate */
      --border-color: #cbd5e1;
      /* Smooth border */

      /* Transitions */
      --transition-fast: 0.2s ease;
      --transition-normal: 0.3s ease;
    }

    * {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      background-color: var(--deep-bg);
      background-image:
        radial-gradient(circle at 10% 20%, rgba(224, 242, 254, 0.8) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(224, 242, 254, 0.8) 0%, transparent 40%);
      font-family: 'Inter', sans-serif;
      color: var(--text-primary);
      overflow-x: hidden;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background: var(--deep-bg);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--border-color);
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--text-secondary);
    }

    /* Header */
    .header {
      position: sticky;
      top: 0;
      z-index: 50;
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.9);
      border-bottom: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem 2rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .logo {
      height: 48px;
      padding: 4px 10px;
      border-radius: 8px;
    }

    .header h1 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: -0.025em;
      background: linear-gradient(to right, #1e3a8a, var(--accent-cyan));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav-btn {
      background: #f1f5f9;
      color: #1e3a8a;
      border: 1px solid #cbd5e1;
      padding: 0.6rem 1.2rem;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.875rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all var(--transition-fast);
      text-decoration: none;
    }

    .nav-btn:hover {
      background: #1e3a8a;
      color: white;
      border-color: #1e3a8a;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
    }

    /* Slide Controls */
    .slide-controls {
      display: flex;
      gap: 0.5rem;
      align-items: center;
      margin-right: 1rem;
    }

    .slide-btn {
      background: #ffffff;
      color: #1e3a8a;
      border: 1px solid var(--border-color);
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1rem;
      transition: all var(--transition-fast);
    }

    .slide-btn:hover {
      background: #1e3a8a;
      color: #ffffff;
      border-color: #1e3a8a;
      transform: scale(1.05);
    }

    .slide-info {
      font-weight: 700;
      color: var(--text-secondary);
      font-size: 0.9rem;
      min-width: 80px;
      text-align: center;
    }

    .auto-slide-input {
      width: 50px;
      padding: 0.5rem;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      font-weight: 700;
      text-align: center;
      color: #1e3a8a;
      margin-left: 0.5rem;
    }

    .btn-auto {
      background: #f1f5f9;
      color: #1e3a8a;
      border: 1px solid #cbd5e1;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      cursor: pointer;
      transition: all var(--transition-fast);
      margin-left: 0.5rem;
    }

    .btn-auto.active {
      background: var(--accent-cyan);
      color: white;
      border-color: var(--accent-cyan);
      box-shadow: 0 0 10px rgba(2, 132, 199, 0.4);
    }



    /* Stats Header */
    .stats-header {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      padding: 1.5rem 2rem 0.5rem;
    }

    .stat-card {
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      padding: 1.25rem;
      border-radius: 16px;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.03);
    }

    .stat-label {
      color: var(--text-secondary);
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .stat-value {
      font-family: 'Orbitron', sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--accent-cyan);
    }

    /* Grid */
    .robots-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      padding: 1.5rem 2rem;
    }

    .robot__hourly {
      padding: 0 1.25rem 1.25rem;
    }

    .hourly-table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      background: #f8fafc;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      overflow: hidden;
      table-layout: fixed;
    }

    .hourly-table th,
    .hourly-table td {
      border: 1px solid #cbd5e1;
    }

    .hourly-table th {
      padding: 0.5rem 0.2rem;
      background: #e2e8f0;
      color: var(--text-secondary);
      font-size: 0.85rem;
      font-weight: 800;
      line-height: 1.3;
    }

    .hourly-table td {
      padding: 0.5rem 0.2rem;
      font-family: 'Orbitron', sans-serif;
      font-weight: 700;
      font-size: 1.15rem;
      color: var(--text-primary);
    }

    .row-label {
      background: #cbd5e1 !important;
      color: var(--text-primary) !important;
      font-family: 'Inter', sans-serif !important;
      font-size: 0.85rem !important;
      font-weight: 800 !important;
    }

    .hourly-table tr:last-child td {
      border-bottom: none;
    }



    /* Robot card */
    .robot {
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      border-radius: 16px;
      overflow: hidden;
      transition: border-color var(--transition-normal), box-shadow var(--transition-normal);
      display: flex;
      flex-direction: column;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
    }

    .robot:hover {
      border-color: #93c5fd;
      box-shadow: 0 8px 25px rgba(37, 99, 235, 0.08);
    }

    .robot__head {
      padding: 0.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      border-bottom: 1px solid #1e3a8a;
      background: #1e3a8a;
      color: #ffffff;
    }

    .robot__name {
      font-weight: 700;
      font-size: 1.15rem;
      letter-spacing: 0.05em;
      color: #ffffff;
      text-transform: uppercase;
    }

    /* Robot Body */
    .robot__body {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      padding: 1rem;
    }

    /* Part/Job section */
    .part {
      background: #ffffff;
      border: 1px solid #1e3a8a;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      display: flex;
      flex-direction: column;
    }

    .part:hover {
      border-color: #94a3b8;
    }

    .part__title {
      font-size: 1.15rem;
      font-weight: 800;
      color: #000;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .led-small {
      display: inline-block;
      width: 16px;
      height: 16px;
      border-radius: 50%;
    }

    .led-small.green {
      background: var(--good);
      box-shadow: 0 0 12px var(--good);
      animation: flipflop 1.2s infinite ease-in-out;
    }

    .led-small.red {
      background: var(--bad);
      box-shadow: 0 0 8px var(--bad);
    }

    @keyframes flipflop {

      0%,
      100% {
        opacity: 1;
        transform: scale(1);
        box-shadow: 0 0 12px var(--good);
      }

      50% {
        opacity: 0.3;
        transform: scale(0.85);
        box-shadow: 0 0 2px var(--good);
      }
    }

    /* Detailed Industrial Robot Animation Styles */
    .robot-svg {
      width: 140px;
      height: 100px;
      overflow: visible;
    }

    .r-yellow {
      fill: #f59e0b;
    }

    .r-yellow-light {
      fill: #fbbf24;
    }

    .r-gray-dark {
      fill: #1e293b;
    }

    .r-gray-mid {
      fill: #475569;
    }

    .r-gray-light {
      fill: #94a3b8;
    }

    .r-orange {
      fill: #f97316;
    }

    .r-white-glow {
      fill: rgba(255, 255, 255, 0.4);
    }

    /* Reset origins to 0 0 for hierarchical translation compatibility */
    .r-arm-lower,
    .r-arm-upper,
    .r-forearm,
    .r-wrist {
      transform-origin: 0 0;
      animation-duration: 8s;
    }

    .is-welding .r-arm-lower {
      animation: industrial-j2 8s infinite ease-in-out;
    }

    .is-welding .r-arm-upper {
      animation: industrial-j3 8s infinite ease-in-out;
    }

    .is-welding .r-forearm {
      animation: industrial-wrist 8s infinite ease-in-out;
    }

    .is-welding .r-wrist {
      animation: industrial-j2 8s infinite ease-in-out alternate;
    }

    .r-spark {
      opacity: 0;
    }

    .r-hot-spot {
      opacity: 0;
      transition: opacity 0.3s;
    }

    .is-welding .r-spark {
      opacity: 1;
      animation: industrial-spark 0.4s infinite alternate;
    }

    .is-welding .r-hot-spot {
      opacity: 0.6;
    }

    @keyframes industrial-j2 {

      0%,
      100% {
        transform: rotate(5deg);
      }

      50% {
        transform: rotate(-30deg);
      }
    }

    @keyframes industrial-j3 {

      0%,
      100% {
        transform: rotate(-10deg);
      }

      50% {
        transform: rotate(50deg);
      }
    }

    @keyframes industrial-wrist {

      0%,
      100% {
        transform: rotate(5deg);
      }

      50% {
        transform: rotate(-30deg);
      }
    }

    @keyframes industrial-spark {
      0% {
        opacity: 0;
        transform: scale(0.4) rotate(-45deg);
      }

      100% {
        opacity: 1;
        transform: scale(1.6) rotate(-45deg);
      }
    }

    /* Workpiece Pulse */
    .is-welding .r-workpiece-glow {
      animation: glow-pulse 1s infinite alternate;
    }

    @keyframes glow-pulse {
      from {
        fill: #475569;
      }

      to {
        fill: #f97316;
        filter: blur(2px);
      }
    }

    /* Active Slot Pulse */
    .active-slot {
      background: var(--good) !important;
      color: white !important;
      animation: flipflop-green 1.5s infinite ease-in-out;
      position: relative;
    }

    @keyframes flipflop-green {

      0%,
      100% {
        background: #059669;
        /* var(--good) */
        box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.4);
      }

      50% {
        background: #10b981;
        /* Lighter green */
        box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.1);
      }
    }

    .part-divider {
      height: 1px;
      background: #1e3a8a;
      margin: 0.5rem 0;
    }

    .part__stats-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      text-align: center;
    }

    .part__stats-header {
      font-size: 0.95rem;
      color: var(--text-primary);
      font-weight: 700;
      padding-bottom: 0.25rem;
    }

    .part__stats-values {
      font-family: 'Inter', sans-serif;
      font-size: 1.4rem;
      font-weight: 700;
      padding-top: 0.25rem;
      color: #000;
    }

    .text-good {
      color: var(--good);
    }

    .text-warn {
      color: var(--warn);
    }

    .text-bad {
      color: var(--bad);
    }

    @keyframes progress-shimmer {
      0% {
        background-position: 30px 0;
      }

      100% {
        background-position: 0 0;
      }
    }

    .progress-bar-animated {
      background-image: linear-gradient(45deg,
          rgba(255, 255, 255, 0.2) 25%,
          transparent 25%,
          transparent 50%,
          rgba(255, 255, 255, 0.2) 50%,
          rgba(255, 255, 255, 0.2) 75%,
          transparent 75%,
          transparent);
      background-size: 30px 30px;
      animation: progress-shimmer 1.5s linear infinite;
    }

    /* Responsive fixes */
    @media (max-width: 1400px) {
      .robots-container {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 900px) {
      .robots-container {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .stats-header {
        grid-template-columns: repeat(2, 1fr);
        padding: 1rem;
      }

      .robot__body {
        grid-template-columns: 1fr;
        padding: 1rem;
      }

      .header-left h1 {
        font-size: 1.1rem;
      }
    }

    /* Page Animations */
    @keyframes slideInFromRight {
      from { transform: translateX(50px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideInFromLeft {
      from { transform: translateX(-50px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    .animate-slide-right {
      animation: slideInFromRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .animate-slide-left {
      animation: slideInFromLeft 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

  </style>
</head>

<body>

  <header class="header">
    <div class="header-left">
      <img src="dist/img/adw3.png" alt="Logo" class="logo" />
      <h1>ROBOT IOT DASHBOARD</h1>
    </div>
    <div id="live-clock"
      style="font-size: 1.35rem; font-weight: 800; font-family: 'Orbitron', sans-serif; letter-spacing: 0.05em; color: #1e3a8a;">
    </div>
    <div class="header-right" style="display: flex; align-items: center;">
      <div class="slide-controls">
        <button class="slide-btn" onclick="prevSlide()" title="Previous Slide">
          <i class="fas fa-chevron-left"></i>
        </button>
        <div class="slide-info" id="slide-info">Page 1 / 1</div>
        <button class="slide-btn" onclick="nextSlide()" title="Next Slide">
          <i class="fas fa-chevron-right"></i>
        </button>
        <div style="display: flex; align-items: center; border-left: 1px solid var(--border-color); margin-left: 0.75rem; padding-left: 0.75rem;">
          <input type="number" id="auto-slide-seconds" class="auto-slide-input" value="30" min="5" title="Interval (seconds)">
          <button id="btn-auto-slide" class="btn-auto" onclick="toggleAutoSlide()" title="Toggle Auto Slide">
            <i class="fas fa-play"></i>
          </button>
        </div>
      </div>

      <a href="home" class="nav-btn">
        <i class="fas fa-arrow-left"></i>
        <span>BACK TO HOME</span>
      </a>
    </div>

  </header>

  <div class="robots-container" id="robots-container"></div>

  <script>
    const robotsDataFromDB = @json($robotsData);
    const hourlyDataFromDB = @json($initialHourly);
    const container = document.getElementById("robots-container");

    let currentPage = 0;
    const itemsPerPage = 9;
    let slideDirection = 'right';

    let autoSlideTimer = null;

    let currentProductionData = robotsDataFromDB;

    let currentHourlyData = hourlyDataFromDB;


    let lastValues = {};
    let lastUpdateTimes = {};



    function getStatus(job) {
      if (job.actual === 0 || job.job === "-") return "red";

      const job_parts = job.job.split(" / ");
      if (job_parts.length < 2) return "red";

      const job_no = job_parts[1].trim();
      const now = Date.now();

      // Threshold 5 menit = 300000 ms
      if (lastUpdateTimes[job_no] && (now - lastUpdateTimes[job_no] <= 300000)) {
        return "green";
      }
      return "red";
    }

    function getEffClass(eff) {
      if (eff >= 100) return "text-good";
      if (eff >= 90) return "text-warn";
      return "text-bad";
    }

    function makePart(part) {
      if (part.job === "-" && part.plan === 0) {
        const el = document.createElement("div");
        el.className = "part";
        el.style.minHeight = "165px";
        el.style.border = "1px dashed var(--border-color)";
        el.style.background = "rgba(0,0,0,0.02)";
        return el;
      }

      const eff = part.plan > 0 ? (part.actual / part.plan) * 100 : 0;
      const effClass = getEffClass(eff);
      const partStatus = getStatus(part) === "green" ? "green" : "red";

      let barColor = "#2563eb"; // Blue
      if (eff >= 100) barColor = "var(--good)"; // Green for 100%

      const el = document.createElement("div");
      el.className = "part";
      el.innerHTML = `
      <div class="part__title">
        <span class="led-small ${partStatus}"></span>
        <span>ITEM: ${part.job}</span>
      </div>
      <div class="part-divider"></div>
      <div class="part__stats-row part__stats-header">
        <div>PLANNING</div>
        <div>ACTUAL</div>
        <div>EFFICIENCY</div>
      </div>
      <div class="part-divider" style="margin-top: 0;"></div>
      <div class="part__stats-row part__stats-values">
        <div>${part.plan}</div>
        <div>${part.actual}</div>
        <div style="color: black !important; font-weight: 800;">${eff.toFixed(1)}%</div>
      </div>
      <div style="margin-top: 0.85rem; background: #e2e8f0; border-radius: 9999px; height: 10px; overflow: hidden; width: 100%; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
        <div class="progress-bar-animated" style="background-color: ${barColor}; width: ${Math.min(eff, 100)}%; height: 100%; transition: width 0.5s ease; border-radius: 9999px;"></div>
      </div>
    `;
      return el;
    }

    function makeRobot(name, jobs, hourlyActual, hourlyTarget) {
      const status = jobs.some(j => getStatus(j) === "green") ? "green" : "red";
      const greenCount = jobs.filter(j => getStatus(j) === "green").length;
      const redCount = jobs.filter(j => j.job !== "-" && getStatus(j) === "red").length;

      // Determine current slot for highlighting
      const now = new Date();
      const timeStr = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');
      let currentSlot = -1;

      if (timeStr >= '07:30' && timeStr < '08:30') currentSlot = 0;
      else if (timeStr >= '08:30' && timeStr < '09:30') currentSlot = 1;
      else if (timeStr >= '09:30' && timeStr < '10:30') currentSlot = 2;
      else if (timeStr >= '10:30' && timeStr < '11:30') currentSlot = 3;
      else if (timeStr >= '12:15' && timeStr < '13:15') currentSlot = 4;
      else if (timeStr >= '13:15' && timeStr < '14:15') currentSlot = 5;
      else if (timeStr >= '14:15' && timeStr < '15:15') currentSlot = 6;
      else if (timeStr >= '15:15' && timeStr <= '16:30') currentSlot = 7;

      const robot = document.createElement("div");
      robot.className = "robot";

      robot.innerHTML = `
      <div class="robot__head" style="justify-content: space-between; padding: 0.2rem 1.5rem; align-items: center; min-height: 130px;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
          <div class="robot-animation ${status === 'green' ? 'is-welding' : ''}">
            <svg class="robot-svg" viewBox="0 0 160 120">
              <!-- Stable Flat Robot Structure -->

              <!-- Static Workpiece Table -->
              <g transform="translate(115, 95)">
                 <rect x="-20" y="0" width="40" height="6" fill="#475569" class="r-workpiece-glow" rx="2" />
                 <rect x="-8" y="6" width="16" height="15" fill="#334155" />
                 <line x1="-120" y1="18" x2="40" y2="18" stroke="#1e293b" stroke-width="2" />
              </g>

              <!-- Hierarchical Robot Skeleton (Locking System) -->

              <!-- Static Workpiece Table -->
              <g transform="translate(115, 100)">
                 <rect x="-20" y="0" width="45" height="4" fill="#64748b" class="r-workpiece-glow" rx="1" />
                 <rect x="-10" y="4" width="20" height="11" fill="#334155" />
                 <line x1="-130" y1="15" x2="45" y2="15" stroke="#1e293b" stroke-width="2" />
              </g>

              <!-- Static Base Block -->
              <rect class="r-gray-dark" x="10" y="105" width="55" height="10" rx="1" />
              <rect class="r-gray-mid" x="15" y="95" width="45" height="12" rx="2" />

              <!-- SHOULDER ROOT (Anchor) -->
              <g transform="translate(38, 95)">
                 <g class="r-arm-lower">
                    <!-- Lower Arm (Amber) -->
                    <rect class="r-yellow" x="-6" y="-50" width="12" height="50" rx="3" />
                    <rect class="r-white-glow" x="-4" y="-45" width="2" height="40" rx="1" />
                    <circle class="r-gray-dark" cx="0" cy="0" r="11" />
                    <circle class="r-yellow-light" cx="0" cy="0" r="4" />

                    <!-- ELBOW ROOT -->
                    <g transform="translate(0, -45)">
                       <g class="r-arm-upper">
                          <!-- Upper Arm (Amber) -->
                          <rect class="r-yellow" x="-6" y="-6" width="50" height="12" rx="3" />
                          <circle class="r-gray-dark" cx="0" cy="0" r="9" />
                          <circle class="r-yellow-light" cx="0" cy="0" r="3" />

                          <!-- FOREARM & TORCH UNIT -->
                          <g transform="translate(42, 0)">
                             <g class="r-forearm">
                                <!-- Forearm (Slate) - Extended overlap -->
                                <rect class="r-gray-dark" x="-5" y="-4" width="35" height="8" rx="2" transform="rotate(45, 0, 0)" />

                                <!-- Tool Hub & Spark -->
                                <g transform="translate(25, 25)">
                                   <g class="r-wrist">
                                      <g transform="rotate(45)">
                                         <path d="M0 0 L15 0" stroke="#1e293b" stroke-width="5" stroke-linecap="round" />
                                         <circle class="r-orange r-hot-spot" cx="25" cy="0" r="6" style="filter: blur(2px);" />
                                         <rect class="r-orange" x="15" y="-2" width="10" height="4" rx="1" />
                                         <g transform="translate(25, 0)">
                                            <g class="r-spark">
                                               <path d="M0 0 L15 -10 M0 0 L22 0 M0 0 L15 10" stroke="#fbbf24" stroke-width="2.5" stroke-linecap="round" />
                                            </g>
                                         </g>
                                      </g>
                                      <circle class="r-gray-dark" cx="0" cy="0" r="7" />
                                      <circle class="r-yellow-light" cx="0" cy="0" r="2" />
                                   </g>
                                </g>

                                <!-- Joint Cover Hub -->
                                <circle class="r-gray-dark" cx="0" cy="0" r="9" />
                                <circle class="r-yellow-light" cx="0" cy="0" r="3" />
                             </g>
                          </g>
                       </g>
                    </g>
                 </g>
              </g>

            </svg>
          </div>
          <div class="robot__name" style="font-size: 1.6rem; font-weight: 800;">${name}</div>
        </div>
        <div class="robot__status-info" style="text-align: right; line-height: 1.2;">
          <div style="font-size: 1.3rem; font-weight: 900; letter-spacing: 0.05em; color: ${status === 'green' ? '#4ade80' : '#f87171'};">
            ${status === 'green' ? 'ONLINE' : 'OFFLINE'}
          </div>
          <div class="robot__status-label" style="font-size: 1.00rem; font-weight: 600; color: #cbd5e1;">
            <span style="color: #4ade80;">${greenCount}</span> ITEM PROSES |
            <span style="color: #f87171;">${redCount}</span> ITEM BELUM PROSES
          </div>
        </div>
      </div>
      <div class="robot__body"></div>
      <div class="robot__hourly">
        <table class="hourly-table">
          <thead>
            <tr>
              <th style="width: 12%;">TIME</th>
              <th class="${currentSlot === 0 ? 'active-slot' : ''}">07:30<br>08:30</th>
              <th class="${currentSlot === 1 ? 'active-slot' : ''}">08:30<br>09:30</th>
              <th class="${currentSlot === 2 ? 'active-slot' : ''}">09:30<br>10:30</th>
              <th class="${currentSlot === 3 ? 'active-slot' : ''}">10:30<br>11:30</th>
              <th class="${currentSlot === 4 ? 'active-slot' : ''}">12:15<br>13:15</th>
              <th class="${currentSlot === 5 ? 'active-slot' : ''}">13:15<br>14:15</th>
              <th class="${currentSlot === 6 ? 'active-slot' : ''}">14:15<br>15:15</th>
              <th class="${currentSlot === 7 ? 'active-slot' : ''}">15:15<br>16:30</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="row-label">TARGET</td>
              <td class="text-warn">${hourlyTarget[0]}</td>
              <td class="text-warn">${hourlyTarget[1]}</td>
              <td class="text-warn">${hourlyTarget[2]}</td>
              <td class="text-warn">${hourlyTarget[3]}</td>
              <td class="text-warn">${hourlyTarget[4]}</td>
              <td class="text-warn">${hourlyTarget[5]}</td>
              <td class="text-warn">${hourlyTarget[6]}</td>
              <td class="text-warn">${hourlyTarget[7]}</td>
            </tr>
            <tr>
              <td class="row-label">ACTUAL</td>
              <td class="text-good">${hourlyActual[0]}</td>
              <td class="text-good">${hourlyActual[1]}</td>
              <td class="text-good">${hourlyActual[2]}</td>
              <td class="text-good">${hourlyActual[3]}</td>
              <td class="text-good">${hourlyActual[4]}</td>
              <td class="text-good">${hourlyActual[5]}</td>
              <td class="text-good">${hourlyActual[6]}</td>
              <td class="text-good">${hourlyActual[7]}</td>
            </tr>
          </tbody>
        </table>
      </div>
    `;

      const body = robot.querySelector(".robot__body");
      jobs.forEach(j => {
        body.appendChild(makePart(j));
      });

      return robot;
    }

   const robotConfig = [
      {
        name: "ROBOT 4",
        jobs: [
          { job: "61307-BZ140 / R130 / D03" },
          { job: "61308-BZ140 / R131 / D03" },
          { job: "57068-BZ150 / R059 / D03" },
          { job: "-", plan: 0 }
        ]
      },
      {
        name: "ROBOT 5",
        jobs: [
          { job: "57604-BZ260 / R-083 / V1 ALL" },
          { job: "57604-BZ280 / R-084 / V2 ALL" },
          { job: "57604-BZ260/80/270/300 / R083/084 / ALL VARIANT", plan: 0 },
          { job: "-", plan: 0 }
        ]
      },
      {
        name: "ROBOT 6",
        jobs: [
          { job: "57604-BZ260 / R083/V1 LOKAL" },
          { job: "57604-BZ280 / R084/V2 LOKAL" },
          { job: "57604-BZ300 / R083/V1 EXPORT" },
          { job: "57604-BZ270 / R084/V2 EXPORT " }
        ]
      },
      {
        name: "ROBOT 7",
        jobs: [
          { job: "57603-BZ290/280/300/270 / R081/82/EXPORT LOKAL" },
          { job: "57604-BZ290/300 / R081/EXPORT LOKAL" },
          { job: "57603-BZ290/310 / R082/EXPORT LOKAL " },
          { job: "-", plan: 0 }
        ]
      },
      {
        name: "ROBOT 8",
        jobs: [
          { job: "57603-BZ290 / R-081/V1 " },
          { job: "57604-BZ310 / R-082/V2 " },
          { job: "57603-BZ290 / T124/V1 / EXPORT " },
          { job: "57604-BZ310 / T125/V2 / EXPORT" }
        ]
      },
      {
        name: "ROBOT 9",
        jobs: [
          { job: "58025-BZ060 / NA-019 / D26ADM", plan: 400 },
          { job: "51055-BZ040 / NT-0106 / D14", plan: 160 },
          { job: "51056-BZ040 / NT-0107 / D14", plan: 160 },
          { job: "58307-BZ200 / SC-0690 / D30", plan: 200 }
        ]
      },
      {
        name: "ROBOT 11",
        jobs: [
          { job: "58013-BZ050 / GT-5979 / D40", plan: 40 },
          { job: "53205-BZ133 / GT-5922 / DD40", plan: 24 },
          { job: "53205-BZ083 / GT-5921 / D40", plan: 120 },
          { job: "53205-BZ240 / GT-6239 / D72", plan: 12 },
          { job: "58013-BZ090 / GT-6283 / D72", plan: 20 },
          { job: "-", plan: 0 }
        ]
      },
      {
        name: "ROBOT 15",
        jobs: [
          { job: "52029-BZ010 / NZ-001(LOKAL) / D40" },
          { job: "52029-BZ010 / NZ-001(EXPORT) / D40" },
          { job: "61607-BZ120 / NT-0394 / D14" },
          { job: "61608-BZ120 / NT-0395 / D14" },
          { job: "57034-BZ060 / T087 / EXPORT" },
          { job: "57034-BZ100 / T383 / LOKAL" }
        ]
      },
      {
        name: "ROBOT 16",
        jobs: [
          { job: "58026-BZ060 / T147 / D26 TMMIN" },
          { job: "57023-BZ030 / SC-0668 / D30" },
          { job: "57024-BZ040 / SC-0669 / D30" },
          { job: "-", plan: 0 },
         { job: "-", plan: 0 }
        ]
      },
      {
        name: "ROBOT 17",

        jobs: [
          { job: "NEW-PART / R-0100 / V1" },
          { job: "NEW-PART-2 / R-0101 / V2" },
          { job: "-", plan: 0 },
          { job: "-", plan: 0 }
        ]
      },
    ];

    function updateGlobalStats(data) {
      let totalPlan = 0;
      let totalActual = 0;
      let activeBots = 0;

      robotConfig.forEach(r => {
        let botActive = false;
        r.jobs.forEach(job => {
          if (job.job === "-") return;
          const job_parts = job.job.split(" / ");
          const job_no = (job_parts.length > 1 ? job_parts[1] : job.job).trim();
          const matchingRows = data.filter(d => d.job_no.trim() === job_no);

          const actual = matchingRows.reduce((sum, r) => sum + (parseInt(r.qty_proses) || 0), 0);
          const planFromDB = matchingRows.length > 0
            ? matchingRows.reduce((sum, r) => sum + (parseInt(r.qty_plan) || 0), 0)
            : job.plan;

          totalPlan += planFromDB;
          totalActual += actual;

          const augmentedJob = { ...job, actual: actual, plan: planFromDB };
          if (getStatus(augmentedJob) === "green") {
            botActive = true;
          }
        });
        if (botActive) activeBots++;
      });

      const overallEff = totalPlan > 0 ? (totalActual / totalPlan) * 100 : 0;

      const elPlan = document.getElementById("global-plan");
      const elActual = document.getElementById("global-actual");
      const elEff = document.getElementById("global-eff");
      const elActive = document.getElementById("active-robots");

      if (elPlan) elPlan.innerText = totalPlan.toLocaleString();
      if (elActual) elActual.innerText = totalActual.toLocaleString();
      if (elEff) elEff.innerText = overallEff.toFixed(1) + "%";
      if (elActive) elActive.innerText = activeBots;
    }

    function renderRobots(productionData = currentProductionData, hourlyData = currentHourlyData, isAutoUpdate = false) {
      if (!isAutoUpdate) {
        // Add animation class removal to allow re-triggering
        container.classList.remove("animate-slide-right", "animate-slide-left");
        // Force reflow
        void container.offsetWidth;
        // Add animation class
        container.classList.add(slideDirection === 'right' ? "animate-slide-right" : "animate-slide-left");
      }

      container.innerHTML = "";



      // Update our global reference to latest data
      currentProductionData = productionData;
      currentHourlyData = hourlyData;

      const totalPages = Math.ceil(robotConfig.length / itemsPerPage);

      if (currentPage >= totalPages) currentPage = 0;

      const slideInfo = document.getElementById("slide-info");
      if (slideInfo) {
        slideInfo.innerText = `Page ${currentPage + 1} / ${totalPages}`;
      }

      const startIndex = currentPage * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const currentSlideRobots = robotConfig.slice(startIndex, endIndex);

      currentSlideRobots.forEach(r => {

        let robotHourlyActual = [0, 0, 0, 0, 0, 0, 0, 0];
        let robotHourlyTarget = [0, 0, 0, 0, 0, 0, 0, 0];

        const augmentedJobs = r.jobs.map(job => {
          if (job.job === "-") return { ...job, actual: 0 };

          const job_parts = job.job.split(" / ");
          const job_no = (job_parts.length > 1 ? job_parts[1] : job.job).trim();

          const matchingRows = productionData.filter(d => d.job_no.trim() === job_no);

          const actual = matchingRows.reduce((sum, r) => sum + (parseInt(r.qty_proses) || 0), 0);
          const plan = matchingRows.length > 0
            ? matchingRows.reduce((sum, r) => sum + (parseInt(r.qty_plan) || 0), 0)
            : job.plan;

          if (matchingRows.length > 0 && lastValues[job_no] !== actual) {
            lastUpdateTimes[job_no] = Date.now();
            lastValues[job_no] = actual;
          }

          // Accumulate hourly data (Actual and Target) for this robot
          matchingRows.forEach(row => {
            const key = row.job_no.trim() + '|' + row.part_no.trim();
            if (hourlyData && hourlyData[key]) {
              for (let i = 0; i < 8; i++) {
                if (hourlyData[key].actual) {
                  robotHourlyActual[i] += hourlyData[key].actual[i];
                }
                if (hourlyData[key].target) {
                  robotHourlyTarget[i] += hourlyData[key].target[i];
                }
              }
            }
          });

          return { ...job, actual, plan };
        });

        container.appendChild(makeRobot(r.name, augmentedJobs, robotHourlyActual, robotHourlyTarget));
      });

      updateGlobalStats(productionData);
    }

    function checkUpdates() {
      // Menambahkan cache-buster agar browser tidak mengambil data lama dari memori (Cache)
      const url = "{{ route('dashboardwelding1.getData') }}?_=" + new Date().getTime();

      fetch(url, { cache: "no-store" })
        .then(res => res.json())
        .then(newData => {
          if (newData.production && newData.hourly) {
            renderRobots(newData.production, newData.hourly, true);
          } else {
            renderRobots(newData, null, true); // fallback for original structure if needed
          }
        })

        .catch(err => console.error("Fetch error:", err));
    }

    function nextSlide() {
      slideDirection = 'right';
      const totalPages = Math.ceil(robotConfig.length / itemsPerPage);
      currentPage = (currentPage + 1) % totalPages;
      renderRobots();
    }

    function prevSlide() {
      slideDirection = 'left';
      const totalPages = Math.ceil(robotConfig.length / itemsPerPage);
      currentPage = (currentPage - 1 + totalPages) % totalPages;
      renderRobots();
    }

    function toggleAutoSlide() {
      const btn = document.getElementById("btn-auto-slide");
      const icon = btn.querySelector("i");
      const secondsInput = document.getElementById("auto-slide-seconds");

      if (autoSlideTimer) {
        clearInterval(autoSlideTimer);
        autoSlideTimer = null;
        btn.classList.remove("active");
        icon.className = "fas fa-play";
      } else {
        const interval = parseInt(secondsInput.value) * 1000;
        if (isNaN(interval) || interval < 3000) {
          alert("Please enter a valid interval (min 3 seconds)");
          return;
        }

        autoSlideTimer = setInterval(() => {
          nextSlide();
        }, interval);

        btn.classList.add("active");
        icon.className = "fas fa-pause";
      }
    }
    // Initial render
    renderRobots();

    // Clock
    function updateClock() {
      const now = new Date();
      const timeStr = now.toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
      const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' });
      document.getElementById("live-clock").innerText = `${dateStr} | ${timeStr}`;
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Polling every 5 seconds
    setInterval(checkUpdates, 9000);
  </script>

</body>

</html>
