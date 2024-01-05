@extends('layouts.app')
@section('title')
Home
@endsection
@section('judul')
Home
@endsection
@section('content')
<div class="row pb-10">
    <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">{{$siswa->count()}}</div>
                    <div class="font-14 text-secondary weight-500">
                        Siswa
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf">
                        <i class="icon-copy fa fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">{{$jurusan->count()}}</div>
                    <div class="font-14 text-secondary weight-500">Jurusan</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#09cc06">
                        <i class="icon-copy fa fa-sun-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
