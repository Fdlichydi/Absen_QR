<!-- resources/views/admin/absen/monthlyReport.blade.php -->

@extends('layouts.app') <!-- Sesuaikan dengan layout yang Anda gunakan -->

@section('content')
    <div class="container">
        <h2>Laporan Absen Bulanan</h2>
        <!-- Formulir Filter -->
        <form action="{{ route('monthlyReport') }}" method="get" id="filterFormMon">
            <div class="form-group">
                <label for="bulan">Pilih Bulan:</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
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
            <button type="button" class="btn btn-danger" onclick="printPDFMon()">Print PDF</button>
        </form>
        <br>
        <!-- Tampilkan data laporan bulanan di sini -->
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
                @foreach ($monthlyReport as $absen)
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
    function printPDFMon() {
        // Mengambil data filter
        var filterForm = document.getElementById('filterFormMon');
        var formData = new FormData(filterForm);

        // Mengirim data filter ke URL print PDF
        var printPdfUrl = '{{ route("printPdfMonthlyReport") }}?' + new URLSearchParams(formData).toString();

        // Membuka halaman print PDF di tab baru
        window.open(printPdfUrl, '_blank');
    }
</script>