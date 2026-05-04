<!DOCTYPE html>
<html>
<head>
    <title>Rekap Order ADM PLANT KAP 1 & 2</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; color: #245a7e; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #245a7e; color: white; padding: 8px; border: 1px solid #dee2e6; }
        td { padding: 6px; border: 1px solid #dee2e6; text-align: center; }
        .text-left { text-align: left; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8px; color: #999; }
        .cycle-cell { font-weight: bold; }
        .box-pallet { background-color: #e3f2fd; }
        .besi-pallet { background-color: #212121; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAP ORDER ADM PLANT 5</h2>
        <p>Tanggal Import: {{ $created_at }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>NO DN</th>
                <th>PART NAME</th>
                <th>PART NO</th>
                <th>JOB NO</th>
                <th>QTY KB</th>
                <th>CYCLE 1</th>
                <th>CYCLE 2</th>
                <th>CYCLE 3</th>
                <th>CYCLE 4</th>
                <th>CYCLE 5</th>
                <th>CYCLE 6</th>
                <th>CYCLE 7</th>
                <th>CYCLE 8</th>
                <th>CYCLE 9</th>
                <th>PALLET</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($data as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="text-left">{{ $row->doc_dn }}</td>
                    <td class="text-left">{{ $row->part_name }}</td>
                    <td>{{ $row->part_no }}</td>
                    <td>{{ $row->job_no }}</td>
                    <td>{{ $row->qty_kanban }}</td>
                    @for($i = 1; $i <= 9; $i++)
                        @php
                            $isCycle = ($row->cycle == $i);
                            $palletClass = '';
                            if ($isCycle) {
                                if (strtoupper($row->type_pallet) == 'BOX') $palletClass = 'box-pallet';
                                elseif (strtoupper($row->type_pallet) == 'BESI') $palletClass = 'besi-pallet';
                            }
                        @endphp
                        <td class="{{ $palletClass }}">
                            @if($isCycle)
                                {{ $row->qty_order }}
                                <br>
                                <small style="font-size: 8px;">{{ $row->createdby }}</small>
                            @endif
                        </td>
                    @endfor
                    <td>{{ $row->type_pallet }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Printed on: {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>
