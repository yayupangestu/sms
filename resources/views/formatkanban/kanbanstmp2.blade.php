<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kanban Layout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .kanban {
    width: 150mm;
    height: auto;
    /* border: 1px solid black; */
    margin-left: -40; /* Geser ke kiri */
    padding: 6mm;
    box-sizing: border-box;
}


        .kanban-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .kanban-table td {
            border: 1mm solid black;
            padding: 1mm;
            text-align: center;
        }

        .header {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .large-text {
            font-size: 14px;
            font-weight: bold;
        }

        .highlight {
            background-color: #79ff6776;
            color: rgb(0, 0, 0);
            font-size: 16px;
            font-weight: bold;
        }

        .qrcode {
            width: 20mm;
            height: auto;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

@foreach($listdetail as $index => $detail)
<div class="kanban">
    <table class="kanban-table">
        <tr>
            <td rowspan="2" colspan="2">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <img src="dist/img/Gambaradw2.png" alt="Logo" style="width: 20mm; height: auto;">
                    <b style="margin-left: 2mm;">PT Adyawinsa Stamping Industries</b>
                </div>
            </td>
            <td class="header" style="font-size: 80%">LINE</td>
            <td class="large-text" style="font-size: 80%">STAMPING</td>
        </tr>
        <tr>
            <td style="font-size: 80%">ROUTE</td>
            <td style="font-size: 80%;
                @if($detail->tujuan === 'PC-STORE')
                    background-color: #87CEEB; color: black;
                @elseif($detail->tujuan === 'LINE STORE')
                    background-color: yellow; color: black;
                @endif">
                {{ $detail->tujuan }}
            </td>
        </tr>
        <tr>
            <td class="large-text" style="font-size: 80%">PART NAME</td>
            <td style="font-size: 80%"><b>{{ $detail->part_name }}</b></td>
            <td class="header" style="font-size: 80%">SHIFT</td>
            <td class="large-text" style="font-size: 80%">{{ $detail->shift }}</td>
        </tr>
        <tr>
            <td class="header" style="font-size: 80%">JOB NO / PART NO / MODEL</td>
            <td style="font-size: 100%"><b>{{ $detail->job_no }} / {{ $detail->part_no}} / {{ $detail->model }}</b></td>
            <td class="header" style="font-size: 80%">DATE</td>
            <td class="large-text" style="font-size: 100%">{{ \Carbon\Carbon::parse($detail->date_plan)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="header" style="font-size: 80%">UNIQ NO</td>
            <td class="highlight" style="font-size: 100%">{{ $detail->uniqNo }}</td>
            <td class="header" style="font-size: 90%">QTY / PALLET</td>
            <td style="font-size: 110%"><strong>{{ $detail->qty_ok }}</strong></td>
        </tr>
        <tr>
            <td class="header" style="font-size: 80%">CREATED</td>
            <td style="font-size: 80%">{{ $detail->createdby }}</td>
            <td class="header" style="font-size: 100%">PLAN</td>
            <td style="font-size: 80%">{{ $detail->part_no_rm }}</td>
        </tr>
        <tr>
            <td colspan="2" class="header" style="font-size: 150%">{{ $detail->line_id }} B3 --> {{ $detail->tujuan }}</td>
            <td class="header">
                <img src="data:image/png;base64,{{ $qrcodes[$index] ?? '' }}" class="qrcode">
            </td>
            <td class="header">Quality Check</td>
        </tr>
    </table>
</div>

@if(!$loop->last)
<div class="page-break"></div>
@endif
@endforeach

</body>
</html>
