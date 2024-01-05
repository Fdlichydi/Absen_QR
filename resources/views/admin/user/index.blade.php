@extends('layouts.app')
@section('title')
User
@endsection
@section('judul')
User
@endsection
@section('content')
<!-- Simple Datatable start -->
    @include('alert')
    <div class="pd-20">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#small-modal" type="button">
            Tambah
        </a>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">No</th>
                    <th>nama</th>
                    <th>email</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                <tr>
                    <td class="table-plus">{{ $loop->iteration }}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                        <a class="btn btn-warning" data-toggle="modal" data-target="#edit-{{$item->id}}" type="button" href="#"><i class="dw dw-edit2"></i></a>
                        <form action="{{route('user.destroy', $item->id)}}" method="POST" class="d-inline-flex">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" onclick="return confirm('yakin dihapus?')"><i class="dw dw-delete-3"></i></button>
                        </form>
                        {{-- <a class="btn btn-danger" href="/hapus-user/{{$item->id}}" onclick="return confirm('yakin dihapus?')"><i class="dw dw-delete-3"></i></a> --}}
                        
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
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah user
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="/simpan-user" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="name" placeholder="Masukan Nama user">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="email" placeholder="Masukan Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="password" placeholder="Masukan Password">
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
@foreach ($user as $item)
<div class="modal fade" id="edit-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Ubah user
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <form action="{{route('edit-user.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
            <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="name" value="{{$item->name}}" placeholder="Masukan Nama user">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="email" value="{{$item->email}}" placeholder="Masukan Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                            <input class="form-control" type="text" name="password" value="{{$item->password}}" placeholder="Masukan Password">
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
