@extends('layouts.app')
@section('title')
Absen Siswa
@endsection
@section('judul')
Absen Siswa
@endsection
@section('content')

    <div class="container col-lg-4 py-5">
        {{-- Scanner--}}
        <div class="card bg-white shadow rounded-3 p-3 border-0">

            {{--Pesan --}}
            @if (session()->has('gagal'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{session()->get('gagal')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{session()->get('success')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif



            @if (session()->has('tidakAda'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{session()->get('tidakAda')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <video id="preview"></video>
            {{-- FORM --}}
            <form action="{{ route('scan.masuk')}}" method="POST" id="form">
                @csrf
                <input type="text" name="id_siswa" id="id_siswa">
            </form>
        </div>
    </div>


    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        scanner.addListener('scan', function (content) {
            console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });

        scanner.addListener('scan', function (c) {
            document.getElementById('id_siswa').value = c;
            document.getElementById('form').submit();
        })

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
@endsection
