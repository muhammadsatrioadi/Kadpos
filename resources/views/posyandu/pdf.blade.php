<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Posyandu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .badge-primary { background-color: #007bff; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #17a2b8; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA POSYANDU</h1>
        <p>Sistem Pencatatan Data Kesehatan Masyarakat</p>
    </div>

    <div class="info">
        <p><strong>Total Data:</strong> {{ $totalData }} record</p>
        <p><strong>Tanggal Cetak:</strong> {{ $generatedAt }}</p>
    </div>

    @if($data->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="15%">Nama</th>
                    <th width="8%">Kategori</th>
                    <th width="10%">Dusun</th>
                    <th width="5%">JK</th>
                    <th width="5%">Umur</th>
                    <th width="8%">BB/TB</th>
                    <th width="6%">IMT</th>
                    <th width="10%">Tekanan Darah</th>
                    <th width="15%">Alamat</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->dusun }}</td>
                        <td>{{ $item->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                        <td class="text-center">{{ $item->umur }}</td>
                        <td class="text-center">{{ $item->berat_badan }}/{{ $item->tinggi_badan }}</td>
                        <td class="text-center">{{ $item->imt ?: '-' }}</td>
                        <td>{{ $item->tekanan_darah ?: '-' }}</td>
                        <td>{{ Str::limit($item->alamat, 50) }}</td>
                        <td>{{ Str::limit($item->keterangan, 50) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Tidak ada data untuk ditampilkan.</p>
    @endif

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Posyandu</p>
        <p>Dicetak pada: {{ $generatedAt }}</p>
    </div>
</body>
</html>
