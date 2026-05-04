<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Robot Dashboard</title>
  <style>
  :root{
  --navy:#12306b;
  --navy-2:#1f3f87;
  --bg:#eef2f7;
  --panel:#ffffff;
  --ink:#0f172a;
  --good:#16a34a;
  --warn:#f59e0b;
  --bad:#dc2626;
  --line:#c7d2fe;

  --fs-robot-head: 18px;
  --fs-job-title: 16px;
  --fs-row: 14px;
  --fs-eff: 15px;
}

*{ box-sizing:border-box; }
html, body{ height:100%; margin:0; }
body{
  background:var(--bg);
  font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Arial, sans-serif;
  color:var(--ink);
}

/* Header */
.header{
  position: sticky; top: 0; z-index: 5;
  display:flex; justify-content:space-between; align-items:center;
  background:var(--navy); color:white; padding:10px 16px;
  box-shadow: 0 2px 0 #0e2452, 0 8px 24px rgba(0,0,0,.15);
}
.header-left{ display:flex; align-items:center; gap:12px; }
.logo{ width:180px; height:80px; background:#fff; border-radius:7px; object-fit:contain; }
.header h1{ margin:0; font-size:22px; font-weight:800; letter-spacing:.2px; }
.nav-btn{ background:white; color:var(--navy); border:0; padding:12px 18px; border-radius:8px; font-weight:700; cursor:pointer; }
.nav-btn:hover{ background:#e0e7ff; }

/* Grid */
.robots-container{
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap:16px;
  padding:16px;
}

/* Robot card */
.robot{
  display:flex; flex-direction:column;
  border:3px solid var(--navy);
  background:var(--panel);
  border-radius:12px;
  overflow:hidden;
  min-height:260px;
  box-shadow: 0 1px 0 var(--line);
}

/* Robot header */
.robot__head{
  display:flex; align-items:center; justify-content:center; gap:8px;
  background:linear-gradient(0deg, var(--navy-2), var(--navy));
  color:white; font-weight:800;
  padding:8px 10px;
  font-size: var(--fs-robot-head);
}
.led{
  width:14px; height:14px; border-radius:50%;
  border:2px solid #fff;
}
.led.green{ background:#22e88a; }
.led.yellow{ background:#ffd633; }
.led.red{ background:#ff3b3b; }

/* Body: 4 jobs (2x2) */
.robot__body{
  display:grid;
  grid-template-columns: repeat(2, 1fr);
  gap:8px;
  padding:10px;
}

/* Job card */
.part{
  border:2px solid var(--navy);
  border-radius:8px;
  padding:6px;
}
.part__title{
  display:flex; align-items:center; gap:6px;
  font-weight:700; font-size: var(--fs-job-title);
  border-bottom:1px solid var(--navy);
  padding-bottom:4px; margin-bottom:4px;
}
.info-led{
  width:10px; height:10px; border-radius:50%;
}
.info-led.green{ background:#22e88a; }
.info-led.yellow{ background:#ffd633; }
.info-led.red{ background:#ff3b3b; }

.part__rows {
  display: grid;
  grid-template-columns: 1fr auto; /* kiri label, kanan angka */
  font-size: var(--fs-row);
  padding: 3px 0;
  border-bottom: 1px solid #ccc; /* garis pemisah */
}

.part__rows:last-child {
  border-bottom: none; /* baris terakhir (EFFICIENCY) tanpa garis */
}

.part__eff{ margin-top:4px; font-weight:800; text-align:right; font-size:var(--fs-eff); }
.part__eff.eff-good{ color:var(--good); }
.part__eff.eff-mid{ color:var(--warn); }
.part__eff.eff-bad{ color:var(--bad); }

/* Legend */
.legend{
  border:1px solid var(--navy);
  background:#f8fbff;
  border-radius:12px;
  padding:12px;
  min-height:100px;
  grid-column: span ;
}
.legend strong{ font-size:20px; color:var(--navy); }
  </style>
</head>
<body>

  <header class="header">
    <div class="header-left">
      <img src="dist/img/adw3.png" alt="Logo" class="logo" />
      <h1>ROBOT DASHBOARD</h1>
    </div>
    <div class="header-right">
      <button id="togglePage" class="nav-btn">Next Page</button>
    </div>
  </header>

  <div class="robots-container" id="robots-container"></div>

  <!-- <div class="legend">
    <strong>LEGEND</strong><br>
    <span style="color:green">● Green</span>: Active / Running<br>
    <span style="color:gold">● Yellow</span>: Paused / Changeover / Standby<br>
    <span style="color:red">● Red</span>: Down / Fault (Dead)
  </div> -->

  <script>
    function ledClass(status) {
      if (status === "red") return "red";
      if (status === "yellow") return "yellow";
      return "green";
    }
    function effClass(eff) {
      if (eff >= 100) return "eff-good";
      if (eff >= 90) return "eff-mid";
      return "eff-bad";
    }

    function makePart(part){
      const eff = part.plan > 0 ? (part.actual / part.plan) * 100 : 0;
      const el = document.createElement("div");
      el.className = "part";
      el.innerHTML = `
  <div class="part__title">
    <span class="info-led ${ledClass(part.status)}"></span>
    JOB: ${part.job}
  </div>
  <div class="part__rows"><span>PLANNING</span><span>${part.plan}</span></div>
  <div class="part__rows"><span>ACTUAL</span><span>${part.actual}</span></div>
  <div class="part__rows">
    <span>EFFICIENCY</span>
    <span class="part__eff ${effClass(eff)}">${eff.toFixed(1)}%</span>
  </div>
`;

      return el;
    }

    function makeRobot(name, jobs, status="green") {
      const robot = document.createElement("div");
      robot.className = "robot";

      const header = document.createElement("div");
      header.className = "robot__head";
      header.innerHTML = `<span class="led ${ledClass(status)}"></span>${name}`;
      robot.appendChild(header);

      const jobsDiv = document.createElement("div");
      jobsDiv.className = "robot__body";
      jobs.forEach(j => jobsDiv.appendChild(makePart(j)));
      robot.appendChild(jobsDiv);

      return robot;
    }

    // Contoh data
    const robotsData = [
      {
        name: "ROBOT 1",
        jobs: [
          {
            job:"T102",
            plan:120,
            actual:118,
            status:"green"},
          {job:"T102", plan:130, actual:125, status:"green"},
          {job:"T102", plan:95, actual:90, status:"yellow"},
          {job:"T102", plan:88, actual:92, status:"green"},
        ]
      },
      {
        name: "ROBOT 2",
        jobs: [
          {job:"T102", plan:149, actual:163, status:"green"},
          {job:"T102", plan:120, actual:127, status:"green"},
          {job:"T102", plan:111, actual:102, status:"yellow"},
          {job:"T102", plan:131, actual:111, status:"yellow"},
        ]
      },
      {
        name: "ROBOT 4",
        jobs: [
          {job:"61307-BZ140", plan:138, actual:127, status:"yellow"},
          {job:"57068-BZ150", plan:101, actual: 89, status:"red"},
          {job:"61308-BZ170", plan:119, actual:112, status:"yellow"},
          {job:"0", plan:0, actual: 0, status:"red"},
        ]
      },
      {
        name: "ROBOT 5",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 6",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 7",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 8",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 9",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 10",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 11",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      },
      {
        name: "ROBOT 12",
        jobs: [
          {job:"T102", plan:138, actual:127, status:"yellow"},
          {job:"T102", plan:101, actual: 89, status:"red"},
          {job:"T102", plan:119, actual:112, status:"yellow"},
          {job:"T102", plan:124, actual: 99, status:"red"},
        ]
      }
    ];

    const container = document.getElementById("robots-container");
    robotsData.forEach(r => container.appendChild(makeRobot(r.name, r.jobs)));
  </script>
</body>
</html>
