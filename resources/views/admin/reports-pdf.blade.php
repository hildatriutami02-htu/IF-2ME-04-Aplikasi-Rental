<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan LensCamp</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #1e293b;
        }

        h1 {
            margin-bottom: 4px;
            color: #2F5249;
        }

        h2 {
            margin-top: 24px;
            margin-bottom: 10px;
            font-size: 16px;
            color: #2F5249;
        }

        .muted {
            color: #64748b;
            margin-bottom: 20px;
        }

        .summary {
            padding: 12px;
            border: 1px solid #dfe7df;
            background: #F8FAF7;
            margin-bottom: 18px;
        }

        .summary strong {
            color: #2F5249;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        th {
            background: #DDE8DF;
            color: #2F5249;
            text-align: left;
        }

        th, td {
            border: 1px solid #dfe7df;
            padding: 8px;
        }

        tr:nth-child(even) td {
            background: #F8FAF7;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <h1>Laporan LensCamp</h1>
    <p class="muted">Ringkasan data transaksi rental LensCamp</p>

    <div class="summary">
        <strong>Total Pendapatan:</strong>
        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
    </div>

    <h2>Laporan Bulanan</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pendapatan</th>
                <th>Transaksi</th>
                <th>Produk Disewa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportRows as $report)
                <tr>
                    <td>{{ $report['bulan'] }}</td>
                    <td>Rp {{ number_format($report['pendapatan'], 0, ',', '.') }}</td>
                    <td>{{ $report['transaksi'] }}</td>
                    <td>{{ $report['produk'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Laporan Per Item Barang</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Qty Disewa</th>
                <th>Jumlah Transaksi</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportItems as $item)
                <tr>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ $item['transaksi'] }}</td>
                    <td>Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data item barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh sistem LensCamp.
    </div>

</body>
</html>