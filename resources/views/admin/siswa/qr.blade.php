<!-- resources/views/siswa/qr_pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        .frame {
            display: inline-block;
            border: 1px solid #ccc;
            padding: 10px;
        }

        h2 {
            margin-bottom: 10px;
        }

        img {
            max-width: 150px; /* Ubah ukuran foto siswa sesuai kebutuhan Anda */
            margin-bottom: 10px;
        }

        .qr-code {
            max-width: 200px; /* Ukuran QR Code yang lebih besar */
        }

        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="frame">
        <h2>QR Code - {{ $siswa->nama }}</h2>
        <img src="{{ public_path('assets/images/'.$siswa->foto) }}" alt="Foto Siswa">
        <br>
        <img class="qr-code" src="{{ public_path('qrcodes/' . $siswa->nis . '.png') }}" alt="QR Code">
        <p>NIS: {{ $siswa->nis }}</p>
    </div>
</body>
</html>
