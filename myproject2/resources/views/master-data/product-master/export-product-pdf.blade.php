<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Produk</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 40px;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Data Produk</h2>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Prodcut Name</th>
                <th>Unit</th>
                <th>Type</th>
                <th>Information</th>
                <th>Qty</th>
                <th>Producer</th>
                <th>Updatet at</th>
                <th>Created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->information }}</td>
                <td>{{ $product->qty }}</td>
                <td>{{ $product->producer }}</td>
                <td>{{ $product->updated_at }}</td>
                <td>{{ $product->created_at }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <div class="footer">
        Dicetak oleh sistem pada {{ now()->format('d F Y, H:i') }}
    </div>

</body>

</html>