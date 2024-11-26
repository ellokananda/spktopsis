@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pilihan</title>
</head>
<body>
<div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  @if ($kriteria)
        <h4 class="card-title">Tambah Pilihan untuk Kriteria: {{ $kriteria->nama }}</h4>
        <input type="hidden" name="kriteria_id" value="{{ $kriteria->id }}">
    @elseif ($kriteriaMinat)
        <h4 class="card-title">Tambah Pilihan untuk Kriteria Minat: {{ $kriteriaMinat->nama }}</h4>
        <input type="hidden" name="kriteria_minat_id" value="{{ $kriteriaMinat->id }}">
    @else
        <h1>Tambah Pilihan</h1>
    @endif
                  <form action="{{ route('pilihan.store') }}" method="POST" class="forms-sample">
                    @csrf
                    
                    <div class="form-group row">
                      <label for="nama" class="col-sm-3 col-form-label">Nama Pilihan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama"  placeholder="Nama Pilihan">
                      </div>
                    </div>

<div class="form-group row">
                      <label for="nilai" class="col-sm-3 col-form-label">Nilai</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="nilai" id="nilai"  placeholder="Nilai">
                      </div>
                    </div>
<input type="hidden" name="kriteria_id" value="{{ $kriteria ? $kriteria->id : '' }}">
        <input type="hidden" name="kriteria_minat_id" value="{{ $kriteriaMinat ? $kriteriaMinat->id : '' }}">
                    <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Simpan</button>
                    <a href="{{ route('pilihan.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                  </form>
                </div>
              </div>
            </div>
</body>
</html>
@endsection