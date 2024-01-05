@extends('layouts.app')
@section('title')
    Absen
@endsection
@section('judul')
    Absen
@endsection
@section('content')
    
    <!-- Tabel untuk menampilkan data absensi -->
    <table class="data-table table stripe hover nowrap" id="tabelData">
        <thead>
            <tr>
                <th>nis</th>
                <th>Nama Siswa</th>
                <th>Jurusan</th>
                <th>Hari/Tanggal</th>
                <th>Status</th>
                <th hidden>Date</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($absensis as $absensi)
                <tr data-jurusan-id="{{ $absensi->siswa->jurusan->id }}">
                    <td>{{ $absensi->siswa->nis }}</td>
                    <td>{{ $absensi->siswa->nama }}</td>
                    <td class="jurusan-cell">{{ $absensi->siswa->jurusan->nama_jurusan }}</td>
                    <td>{{ $absensi->hari }} <br> {{ $absensi->tanggal }}</td>
                    <td>
                        @if ($absensi->status == 'Terlambat')
                            <span class="badge badge-danger">{{ $absensi->status }}</span>
                        @else
                            <span class="badge badge-success">{{ $absensi->status }}</span>
                        @endif
                    </td>
                    <td hidden>{{ $absensi->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
