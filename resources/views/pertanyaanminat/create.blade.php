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
                  <h4 class="card-title">Tambah Pertanyaan Peminatan</h4>
                  <form action="{{ route('pertanyaanminat.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group row">
                      <label for="kriteria_minat_id" class="col-sm-3 col-form-label">Kriteria</label>
                      <div class="col-sm-9">
        <select class="form-control" name="kriteria_minat_id" id="kriteria_minat_id" required>
            @foreach ($kriteriaminats as $kriteria)
                <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
                      <label for="sub_alternatif_id" class="col-sm-3 col-form-label">Alternatif</label>
                      <div class="col-sm-9">
        <select class="form-control" name="sub_alternatif_id" id="sub_alternatif_id" required>
            @foreach ($subalternatifs as $alternatif)
                <option value="{{ $alternatif->id }}">{{ $alternatif->nama }}</option>
            @endforeach
        </select>
    </div>
</div>

    <div class="form-group row">
                      <label for="pertanyaan" class="col-sm-3 col-form-label">Pertanyaan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="pertanyaan" id="pertanyaan"  placeholder="Deskripsi" required>
                      </div>
                    </div>
        <br>
        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Simpan</button>
                    <a href="{{ route('pertanyaanminat.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
    </form>
</body>
</html>
@endsection