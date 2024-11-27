@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pertanyaan</title>
</head>
<body>
<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Pertanyaan Jenjang</h4>
                  <form action="{{ route('pertanyaan.store') }}" method="POST" class="forms-sample">
                    @csrf

        <div class="form-group row">
                      <label for="kriteria_id" class="col-sm-3 col-form-label">Kriteria</label>
                      <div class="col-sm-9">
        <select class="form-control" name="kriteria_id" id="kriteria_id" required>
            @foreach ($kriterias as $kriteria)
                <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
                      <label for="alternatif_id" class="col-sm-3 col-form-label">Alternatif</label>
                      <div class="col-sm-9">
        <select class="form-control" name="alternatif_id" id="alternatif_id" required>
            @foreach ($alternatifs as $alternatif)
                <option value="{{ $alternatif->id }}">{{ $alternatif->nama }}</option>
            @endforeach
        </select>
    </div>
</div>

    <div class="form-group row">
                      <label for="pertanyaan" class="col-sm-3 col-form-label">Pertanyaan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="pertanyaan" id="pertanyaan"  placeholder="Pertanyaan" required>
                      </div>
                    </div>
        <br>
        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Simpan</button>
                    <a href="{{ route('pertanyaan.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
    </form>
</body>
</html>
@endsection