<!-- resources/views/admin/absen/periodReport.blade.php -->

@extends('layouts.app') <!-- Sesuaikan dengan layout yang Anda gunakan -->

@section('content')
    <div class="container">
        <h2>Laporan Absen Per Periode</h2>
        <!-- Formulir Filter -->
        <form action="{{ route('periodReport') }}" method="get" id="filterFormPer">
            <div class="form-group">
                <label for="start_date">Pilih Tanggal Mulai:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date">Pilih Tanggal Selesai:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
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
            <button type="button" class="btn btn-danger" onclick="printPDFPer()">Print PDF</button>
        </form>
        <br>
        <!-- Tampilkan data laporan per priode di sini -->
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
                @foreach ($periodReport as $absen)
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
    function printPDFPer() {
        // Mengambil data filter
        var filterForm = document.getElementById('filterFormPer');
        var formData = new FormData(filterForm);

        // Mengirim data filter ke URL print PDF
        var printPdfUrl = '{{ route("printPdfPeriodeReport") }}?' + new URLSearchParams(formData).toString();

        // Membuka halaman print PDF di tab baru
        window.open(printPdfUrl, '_blank');
    }
</script>