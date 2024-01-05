<!-- resources/views/admin/absen/dailyReport.blade.php -->

@extends('layouts.app') <!-- Sesuaikan dengan layout yang Anda gunakan -->

@section('content')
    <div class="container">
        <h2>Laporan Absen Harian</h2>
        <!-- Formulir Filter -->
        <form action="{{ route('dailyReport') }}" method="get" id="filterForm">
            <div class="form-group">
                <label for="masuk">Pilih Tanggal:</label>
                <input type="date" name="masuk" class="form-control" value="{{ request('masuk') }}">
            </div>
            <div class="form-group">
                <label for="jurusan">Pilih Jurusan:</label>
                <!-- Tambahkan dropdown untuk memilih jurusan -->
                <select name="jurusan" class="form-control">
                    <option value="">Pilih</option>
                    @foreach ($jurusan as $j)
                        <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jurusan }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <!-- Tombol Print PDF -->
            <button type="button" class="btn btn-danger" onclick="printPDF()">Print PDF</button>
        </form>
        <br>
        <!-- Tampilkan data laporan harian di sini -->
        <table class="data-table table stripe hover nowrap">
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
@endsection

<script>
    function printPDF() {
        // Mengambil data filter
        var filterForm = document.getElementById('filterForm');
        var formData = new FormData(filterForm);

        // Mengirim data filter ke URL print PDF
        var printPdfUrl = '{{ route("printPdfDailyReport") }}?' + new URLSearchParams(formData).toString();

        // Membuka halaman print PDF di tab baru
        window.open(printPdfUrl, '_blank');
    }
</script>