@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Alternatif</title>
</head>
<body>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Penilaian Alternatif - {{ $alternatif->nama }}</h3>
                <form action="{{ route('penilaian.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <input type="hidden" name="alternatif_id" value="{{ $alternatif->id }}">

                    @foreach($kriterias as $kriteria)
                        <h4>{{ $kriteria->nama }}</h4>

                        <!-- Tampilkan deskripsi kriteria jika ada -->
                        @if(!empty($kriteria->deskripsi))
                            <p>{{ $kriteria->deskripsi }}</p>
                        @endif

                        @foreach($kriteria->pilihans as $pilihan)
    <div class="form-check">
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
                    <a href="{{ route('penilaian.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
