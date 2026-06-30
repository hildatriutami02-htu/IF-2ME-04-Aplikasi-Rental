<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan LensCamp</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
            margin: 30px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #2F5249;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            color: #2F5249;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
            color: #64748b;
        }

        .summary {
            border: 1px solid #dfe7df;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .summary h2 {
            margin: 0;
            color: #2F5249;
            font-size: 18px;
        }

        .summary p {
            margin: 8px 0 0;
            font-size: 16px;
            font-weight: bold;
        }

        h3 {
            color: #2F5249;
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th {
            background: #2F5249;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        td {
            border: 1px solid #dfe7df;
            padding: 9px;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background: #F8FAF7;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            color: #64748b;
            font-size: 11px;
        }

        .print-btn {
    margin-bottom: 20px;
    padding: 10px 18px;
    background: #2F5249;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .25s ease;
    }

    .print-btn:hover {
        background: #437057;
    }

        @media print {
            .print-btn {
                display: none;
            }

            body {
                margin: 20px;
            }
        }
    </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">Download / Print PDF</button>

<div class="header">
    <h1>Laporan LensCamp</h1>
    <p>Ringkasan transaksi rental dan pendapatan</p>
    <p>Tanggal cetak: {{ now()->format('d/m/Y H:i') }}</p>
</div>

<div class="summary">
    <h2>Total Pendapatan</h2>
    <p>Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
</div>

<h3>Laporan Bulanan</h3>
<table>
    <thead>
        <tr>
            <th>Bulan</th>
            <th class="text-right">Pendapatan</th>
            <th class="text-right">Transaksi</th>
            <th class="text-right">Produk Disewa</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reportRows as $report)
            <tr>
                <td>{{ $report['bulan'] }}</td>
                <td class="text-right">Rp {{ number_format($report['pendapatan'], 0, ',', '.') }}</td>
                <td class="text-right">{{ $report['transaksi'] }}</td>
                <td class="text-right">{{ $report['produk'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">Belum ada data laporan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<h3>Laporan Per Item Barang</h3>
<table>
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th class="text-right">Qty Disewa</th>
            <th class="text-right">Jumlah Transaksi</th>
            <th class="text-right">Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reportItems as $item)
            <tr>
                <td>{{ $item['nama_barang'] }}</td>
                <td class="text-right">{{ $item['qty'] }}</td>
                <td class="text-right">{{ $item['transaksi'] }}</td>
                <td class="text-right">Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">Belum ada data item barang.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <p>Dicetak oleh Admin LensCamp</p>
</div>

</body>
</html>