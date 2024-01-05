<!-- resources/views/admin/absen/dailyReport.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center; /* Rata Tengah */
        }

        .school-info {
            margin-bottom: 10px; /* Mengurangi jarak antara nama sekolah dan alamat */
        }

        .school-info h1 {
            font-size: 12px; /* Ukuran font untuk nama sekolah */
            margin-bottom: 3px; /* Mengurangi jarak antara nama sekolah dan alamat */
        }

        .school-info p {
            font-size: 10px; /* Ukuran font untuk alamat */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; /* Mengurangi jarak antara informasi sekolah dan tabel */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px; /* Ukuran font untuk data tabel */
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Informasi Sekolah -->
        <div class="school-info">
            <h1>Nama Sekolah</h1>
            <p>Alamat Sekolah</p>
            <p>Rekap Absen Bulanan</p>
        </div>

        <!-- Tabel Absen -->
        <table>
            <!-- Tabel Header -->
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Jurusan</th>
                    <th>Tanggal Absen</th>
                    <th>Status</th>
                </tr>
            </thead>

            <!-- Tabel Body -->
            <tbody>
                @foreach ($data as $absen)
                    <tr>
                        <td>{{ $absen->siswa->nis }}</td>
                        <td>{{ $absen->siswa->nama }}</td>
                        <td>{{ $absen->siswa->jurusan->nama_jurusan }}</td>
                        <td>{{ $absen->tanggal }}</td>
                        <td>{{ $absen->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
