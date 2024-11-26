@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Subalternatif - {{ $subAlternatif->nama }}</title>
</head>
<body>
<div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penilaian Alternatif Peminatan - {{ $subAlternatif->nama }}</h4>
                <form action="{{ route('penilaianminat.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <input type="hidden" name="sub_alternatif_id" value="{{ $subAlternatif->id }}">

                    @foreach($kriteriaMinat as $kriteria)
            <h2>{{ $kriteria->nama }}</h2>

            <!-- Tampilkan deskripsi kriteria jika ada -->
            @if(!empty($kriteria->deskripsi))
                <p>{{ $kriteria->deskripsi }}</p>
            @endif

            @foreach($kriteria->pilihans as $pilihan)
    <div class="form-check">
        <!-- Radio button dan label dengan style sesuai contoh -->
        <label class="form-check-label">
            <input type="radio" class="form-check-input" 
                   name="penilaians[{{ $kriteria->id }}]" 
                   value="{{ $pilihan->id }}" 
                   {{ isset($penilaians[$kriteria->id]) && $penilaians[$kriteria->id] == $pilihan->id ? 'checked' : '' }}>
            {{ $pilihan->nama }}
        </label>
    </div>
@endforeach
<br>
                    @endforeach

                    <!-- Tombol aksi -->
                    <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Simpan</button>
                    <a href="{{ route('penilaianminat.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
@endsection