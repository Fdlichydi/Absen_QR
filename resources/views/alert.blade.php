@if(session()->has('tambah'))
    <div class="alert alert-success alert-dismissible fade show" role="alert"> Berhasil Ditambah
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->has('ubah'))
<div class="alert alert-warning alert-dismissible fade show" role="alert"> Berhasil Diubah
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session()->has('hapus'))
<div class="alert alert-danger alert-dismissible fade show" role="alert"> Berhasil Dihapus
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


@if(session()->has('login'))
<div class="alert alert-danger" role="alert">
    {{session('login')}}
</div>
@endif

@if(session()->has('isi'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{session('isi')}}
</div>
@endif
