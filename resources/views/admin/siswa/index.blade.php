@extends('layouts.app')
@section('title')
    Siswa
@endsection
@section('judul')
    Siswa
@endsection
@section('content')
    <!-- Simple Datatable start -->
    @include('alert')
    <div class="container">
        <div class="row">
            <!-- Bagian Kiri -->
            <div class="col-md text-left">
                <div class="pb-20">
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#small-modal">Tambah</button>
                </div>
            </div>
    
            <!-- Bagian Kanan -->
            <div class="col-md-6 text-left">
                <div class="pb-20">
                    <!-- Form Import -->
                    <form action="{{ route('siswa.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group d-flex">
                            <label>Pilih File Excel(.xlsx)</label>
                            <input type="file" name="file"  class="form-control" accept=".xlsx"> <p></p><p>
                            <button type="submit" class="btn btn-success ">Impor</button></p>
                        </div>
    
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">No</th>
                    <th>Nis</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Foto</th>
                    <th>QR</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $item)
                    <tr>
                        <td class="table-plus">{{ $loop->iteration }}</td>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jurusan->nama_jurusan }}</td>
                        <td><img src="{{asset('assets/images/'.$item->foto)}}" width="100px" alt=""></td>
                        <td>
                            @if (file_exists(public_path('qrcodes/' . $item->nis . '.png')))
                                <img src="{{ asset('qrcodes/' . $item->nis . '.png') }}" alt="QR Code"
                                    style="max-width: 50px; max-height: 50px;">
                                
                            @else
                                <!-- Tidak ada gambar, tombol disembunyikan -->
                                <a class="btn btn-dark" data-toggle="modal" data-target="#edit1-{{ $item->id }}"
                                    type="button" href="#"><i class="icon-copy fa fa-barcode" aria-hidden="true"></i></a>
                                    
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{ route('siswa.print.pdf', $item->id) }}" target="_blank">
                                <i class="dw dw-print"></i>
                            </a>
                            <a class="btn btn-warning" data-toggle="modal" data-target="#edit-{{ $item->id }}"
                                type="button" href="#"><i class="dw dw-edit2"></i></a>
                            <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" class="d-inline-flex">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('yakin dihapus?')"><i
                                        class="dw dw-delete-3"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!-- Simple Datatable End -->
@endsection

<!-- Modal Tambah -->
<div class="modal fade" id="small-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah Siswa
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="nis" placeholder="NIS" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="nama" placeholder="Nama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <select class="custom-select col-12" name="id_jurusan" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusan as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="file" name="foto" placeholder="Foto" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach ($siswa as $item)
    <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Ubah siswa
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form action="{{ route('siswa.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <input class="form-control" type="text" name="nis"
                                    value="{{ $item->nis }}" placeholder="NIS" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <input class="form-control" type="text" name="nama"
                                    value="{{ $item->nama }}" placeholder="Nama" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <select class="custom-select col-12" name="id_jurusan" required>
                                    <option hidden selected>Pilih Jurusan</option>
                                    @foreach ($jurusan1 as $jurusan)
                                        <option value="{{ $jurusan->id }}"
                                            {{ $item->id_jurusan == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <img src="{{asset('assets/images/'.$item->foto)}}" width="100px" alt="">
                            <input type="file" name="foto" value="{{ $item->foto }}"  id="nameWithTitle" class="form-control"
                                placeholder="Enter Name" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach


<!-- Modal qr -->
@foreach ($siswa as $item)
    <div class="modal fade" id="edit1-{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Buat QR {{ $item->nama }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form action="{{ route('siswa.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <input class="form-control" type="text" name="nis"
                                    value="{{ $item->nis }}" placeholder="NIS" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <input class="form-control" type="text" name="nama"
                                    value="{{ $item->nama }}" placeholder="Nama" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-md-12">
                                <select class="custom-select col-12" name="id_jurusan" readonly>
                                    <option hidden selected>Pilih Jurusan</option>
                                    @foreach ($jurusan1 as $jurusan)
                                        <option value="{{ $jurusan->id }}"
                                            {{ $item->id_jurusan == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Buat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
