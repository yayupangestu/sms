<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Kerja Harian Tool Service</title>
  </head>
  <style>
    @page {
    margin: 15mm;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
    color: #000;
}

.page-container {
    width: 100%;
}

/* ================= HEADER ================= */
.main-header {
    border: 1px solid #000;
    padding: 8px;
    margin-bottom: 6px;
}

.main-header h1 {
    text-align: center;
    font-size: 16px;
    margin: 0 0 6px 0;
    font-weight: bold;
}

.header-info {
    width: 100%;
    display: table;
}

.info-left,
.info-right {
    display: table-cell;
    vertical-align: top;
}

.info-left {
    width: 50%;
}

.info-right {
    width: 50%;
    border-left: 1px solid #000;
    padding-left: 8px;
}

.form-group {
    margin-bottom: 4px;
}

.form-group label {
    display: inline-block;
    width: 70px;
    font-weight: bold;
}

.data-line {
    display: inline-block;
    width: 200px;
    border-bottom: 1px dotted #000;
}

.data-line-full {
    display: inline-block;
    width: 250px;
    border-bottom: 1px dotted #000;
}

.data-line-sm {
    display: inline-block;
    width: 160px;
    border-bottom: 1px dotted #000;
}

/* ================= ATTENDANCE ================= */
.att-row {
    margin-bottom: 4px;
}

.numbered-input {
    margin-bottom: 2px;
}

/* ================= MAIN CONTENT ================= */
.main-content {
    display: table;
    width: 100%;
    margin-bottom: 6px;
}

.left-sidebar {
    display: table-cell;
    width: 22%;
    vertical-align: top;
    padding-right: 6px;
}

.legend-box,
.note-box {
    border: 1px solid #000;
    padding: 6px;
    margin-bottom: 6px;
}

.legend-box ul {
    padding-left: 15px;
    margin: 4px 0;
}

.legend-box li {
    list-style: none;
}

.note-box p {
    margin: 3px 0;
    font-size: 10px;
}

/* ================= TABLE ================= */
.table-container {
    display: table-cell;
    width: 78%;
}
.main-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.main-table th,
.main-table td {
    border: 1px solid #000;
    padding: 3px;
    font-size: 10px;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}


.main-table th {
    font-weight: bold;
}

/* ================= FOOTER ================= */
.footer-section {
    width: 100%;
    margin-top: 6px;
}

.downtime-table-wrapper {
    width: 100%;
    margin-bottom: 6px;
}

.downtime-table-wrapper h4 {
    margin: 0 0 2px 0;
    font-size: 11px;
}

.downtime-table {
    width: 100%;
    border-collapse: collapse;
}

.downtime-table th,
.downtime-table td {
    border: 1px solid #000;
    padding: 3px;
    text-align: center;
    font-size: 10px;
}

/* ================= APPROVAL ================= */
.approval-table-wrapper {
    width: 100%;
}

.approval-table {
    width: 100%;
    border-collapse: collapse;
}

.approval-table th,
.approval-table td {
    border: 1px solid #000;
    text-align: center;
    font-size: 10px;
    vertical-align: top;
}

.approval-col {
    height: 110px;
}

.sign-box {
    border-bottom: 1px solid #000;
    padding: 4px;
}

.sign-box:last-child {
    border-bottom: none;
}

.sign-title {
    font-weight: bold;
    font-size: 10px;
}

.sign-area {
    height: 25px;
}

.bottom-note-wrapper {
    width: 100%;
    margin-top: 6px;
    display: table;
}

.keterangan-box,
.note-box {
    display: table-cell;
    vertical-align: top;
    border: 1px solid #000;
    padding: 6px;
    font-size: 10px;
}

.keterangan-box {
    width: 30%;
}

.note-box {
    width: 70%;
}

.keterangan-box ul {
    margin: 4px 0 0 14px;
    padding: 0;
}

.note-box ol {
    margin: 4px 0 0 16px;
    padding: 0;
}

.keterangan-box li,
.note-box li {
    margin-bottom: 2px;
}


  </style>
  <body>
    <div class="page-container">
      <!-- Main Header -->
      <header class="main-header">
        <h1>LAPORAN KERJA HARIAN DIE MAINTENANCE</h1>
        <div class="header-info">
                <div class="info-left">
                    <div class="form-group">
                        <label>TANGGAL :</label>
                        <span class="data-line">
                            {{ \Carbon\Carbon::parse($data->date_plan)->format('d-m-Y') }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label>DOC LKH :</label>
                        <span class="data-line">
                            {{ $data->doc_job ?? '' }}
                        </span>
                    </div>


                    <div class="form-group">
                        <label>SHIFT :</label>
                        <span class="data-line"></span>
                    </div>
                    <div class="form-group">
                        <label>GROUP :</label>
                        <span class="data-line"></span>
                    </div>
                </div>
                <div class="info-right">
                    <div class="attendance-box">
                        <div class="att-row">
                            <label>HADIR :</label>
                            <span class="data-line-full"></span>
                        </div>
                        <div class="att-row">
                            <div class="label-col">
                                <label>YANG TIDAK HADIR :</label>
                            </div>
                            <div class="input-col">
                                <div class="numbered-input">1. <span class="data-line-sm"></span></div>
                                <div class="numbered-input">2. <span class="data-line-sm"></span></div>
                                <div class="numbered-input">3. <span class="data-line-sm"></span></div>
                                <div class="numbered-input">4. <span class="data-line-sm"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar / Legend -->


            <!-- Main Table -->
            <div class="table-container">
                <table class="main-table">
                    <colgroup>
                        <col style="width: 4%">
                        <col style="width: 12%">
                        <col style="width: 6%">
                        <col style="width: 6%">
                        <col style="width: 12%">
                        <col style="width: 14%">
                        <col style="width: 12%">
                        <col style="width: 6%">
                        <col style="width: 6%">
                        <col style="width: 6%">
                        <col style="width: 6%">
                    </colgroup>

                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>JOB NO<hr>PART NO</th>
                            <th>PROSES</th>
                            <th>LINE</th>
                            <th>PROBLEM</th>
                            <th>PENANGGULANGAN</th>
                            <th>STANDART PART YANG<br>DI PAKAI</th>
                            <th>START</th>
                            <th>FINISH</th>
                            <th>PIC</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 3%">1</td>
                            <td>
                                {{ $data->job_no ?? '' }}<hr>
                                {{ $data->part_no ?? '' }}
                            </td>
                            <td style="width: 6%">{{ $data->proses ?? '' }}</td>
                            <td style="width: 6%" >{{ $data->line_id ?? '' }}</td>
                            <td>{{ $data->problem ?? '' }}</td>
                            <td style="width: 25%">{{ $data->tindakan ?? '' }}</td>
                            <td style="width: 15%">{{ $data->standar_part ?? '' }}</td>
                            <td style="width: 7%">{{ $data->dt_start ?? '' }}</td>
                            <td style="width: 7%">{{ $data->dt_finish ?? '' }}</td>
                            <td  style="width: 7%">{{ $data->pic ?? '' }}</td>
                            <td>{{ $data->remarks ?? '' }}</td>
                        </tr>

                        @for ($i = 2; $i <= 9; $i++)
                        <tr>
                            <td>{{ $i }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endfor
                        </tbody>

                </table>
            </div>
        </div>

        <div class="bottom-note-wrapper">

            <div class="keterangan-box">
                <strong>KETERANGAN</strong>
                <ul>
                    <li>
                        [{{ $data->category === 'CORRECTIVE' ? 'X' : ' ' }}]
                        CORRECTIVE
                    </li>
                    <li>
                        [{{ $data->category === 'PREVENTIVE' ? 'X' : ' ' }}]
                        PREVENTIVE
                    </li>
                    <li>
                        [{{ $data->category === 'IMPROVEMENT' ? 'X' : ' ' }}]
                        IMPROVEMENT
                    </li>
                </ul>
            </div>



            <div class="note-box">
                <strong>NOTE :</strong>
                <ol>
                    <li>Pengisian JOB NO & PART NO diisi dengan lengkap sesuai dies yang dikerjakan.</li>
                    <li>Kolom standar Wajib diisi setiap repair atau preventive dies.</li>
                    <li>Stock part yang tersedia tidak boleh delay karena stock tidak ada.</li>
                </ol>
            </div>

        </div>

        <!-- Footer -->

 <footer class="footer-section">
            <div class="downtime-table-wrapper">
                <h4>DOWNTIME (MENIT)</h4>
                <table class="downtime-table">
                    <thead>
                        <tr>
                            <th>LINE</th>
                             <th>AREA</th>
                            <th>LINE A1</th>
                            <th>LINE A2</th>
                            <th>LINE A3</th>
                            <th>LINE B1</th>
                            <th>LINE B2</th>
                            <th>LINE B3</th>
                            <th>LINE C1</th>
                            <th>LINE C2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TOTAL</td>
                            <td>{{ $downtime['AREA'] }}</td>
                            <td>{{ $downtime['LINE A1'] }}</td>
                            <td>{{ $downtime['LINE A2'] }}</td>
                            <td>{{ $downtime['LINE A3'] }}</td>
                            <td>{{ $downtime['LINE B1'] }}</td>
                            <td>{{ $downtime['LINE B2'] }}</td>
                            <td>{{ $downtime['LINE B3'] }}</td>
                            <td>{{ $downtime['LINE C1'] }}</td>
                            <td>{{ $downtime['LINE C2'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="approval-table-wrapper">
                <table class="approval-table">
                    <thead>
                        <tr>
                            <th>REPAIR</th>
                            <th>PREVENTIVE</th>
                            <th>IMPROVEMENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="approval-col">
                                <div class="sign-box">
                                    <div class="sign-title">LEADER</div><hr>
                                    <div class="sign-area">{{ $data->createdby ?? '' }}</div>
                                </div>
                                <div class="sign-box">
                                    <div class="sign-title">SECT HEAD</div><hr>
                                    <div class="sign-area">Anggi</div>
                                </div>
                            </td>
                            <td class="approval-col">
                                <div class="sign-box">
                                    <div class="sign-title">LEADER</div><hr>
                                    <div class="sign-area"></div>
                                </div>
                                <div class="sign-box">
                                    <div class="sign-title">SECT HEAD</div><hr>
                                    <div class="sign-area">Anggi</div>
                                </div>
                            </td>
                            <td class="approval-col">
                                <div class="sign-box">
                                    <div class="sign-title">LEADER</div><hr>
                                    <div class="sign-area"></div>
                                </div>
                                <div class="sign-box">
                                    <div class="sign-title">SECT HEAD</div><hr>
                                    <div class="sign-area">Anggi</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </footer>
    </div>

    </div>
  </body>
</html>
