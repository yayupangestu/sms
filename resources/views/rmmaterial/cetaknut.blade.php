<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Label</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .kanban {
            /* width: 40mm;
            height: 20mm; */
            /* border: 1px solid black; */
            padding: 1mm;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qrcode {
    width: 60%;
    /* height: auto;
    margin-left: a; Geser ke kanan */
}

    </style>
</head>
<body>

<div class="kanban">
    <img src="data:image/png;base64,{{ $qrcode }}" class="qrcode">
    <div class="text-center" style="font-size: 50%" class="highlight">{{ $part_nut }}</div>
</div>

</body>
</html>
