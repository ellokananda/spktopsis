@extends('main')
@section('content')

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <center>

        <img src="{{ asset('style/images/iconr.png') }}" alt="logo" width="200" height="auto">

                <p class="card-title">Sistem Rekomendasi Jenjang dan Peminatan Sekolah Lanjutan Tingkat Atas Menggunakan Metode TOPSIS</p>
            </center>
            <h3 class="font-weight-bold">Welcome {{ auth()->user()->nama }}</h3>
            
            <p class="font-weight-500">
                Sistem ini bertujuan membantu siswa kelas 9 dalam memilih jenjang pendidikan (SMA atau SMK) dan peminatan yang paling sesuai dengan potensi dan minat mereka. Dalam konteks ini, banyak faktor yang dipertimbangkan, seperti dukungan orang tua, minat akademik, dan kesesuaian siswa.
                Penelitian ini mengembangkan sistem rekomendasi berbasis web yang memanfaatkan metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution). TOPSIS dipilih karena kemampuannya dalam menangani masalah pemilihan keputusan multi-kriteria, sehingga dapat memberikan rekomendasi terbaik berdasarkan kriteria yang ada.
                Hasil dari sistem ini berupa rekomendasi jenjang pendidikan dan peminatan yang disarankan untuk masing-masing siswa. Sistem diharapkan mampu menjadi solusi yang objektif dan membantu siswa serta pihak sekolah dalam memfasilitasi proses penentuan pilihan jenjang pendidikan lanjutan serta peminatan yang optimal.
            </p>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card card-tale">
            <div class="card-body">
                <p class="mb-4">Jumlah Siswa</p>
                <p class="fs-30 mb-2">{{ $totalSiswa }}</p>
                
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card card-dark-blue">
            <div class="card-body">
                <p class="mb-4">Siswa yang direkomendasikan ke SMA</p>
                <p class="fs-30 mb-2">{{ $siswaSMA }}</p>
                
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 stretch-card transparent">
        <div class="card card-light-blue">
            <div class="card-body">
                <p class="mb-4">Siswa yang direkomendasikan ke SMk</p>
                <p class="fs-30 mb-2">{{ $siswaSMK }}</p>
                
            </div>
        </div>
    </div>
</div>


@endsection
