<!DOCTYPE html>
<html>
<head>
    <title>Detail Report</title>
</head>
<body>
    <h1>Detail Report for {{ $query[0]->date_plan }}</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Supplier</th>
                <th>Category</th>
                <th>Model</th>
                <th>No</th>
            </tr>
        </thead>
        <tbody>
            @foreach($query as $detail)
            <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->material_id }}</td>
                <td>{{ $detail->qty_in }}</td>
                <td>{{ $detail->suplai_id }}</td>
                <td>{{ $detail->category_id }}</td>
                <td>{{ $detail->model }}</td>
                <td>{{ $detail->no }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
