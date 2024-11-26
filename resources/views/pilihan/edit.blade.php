@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pilihan</title>
</head>
<body>
    

    <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">  
                @if(isset($kriteria))
    <h4 class="card-title">Edit Pilihan Kriteria Jenjang : {{ $kriteria->nama }}</h4>
    @elseif(isset($kriteriaMinat))
    <h4 class="card-title">Edit Pilihan Kriteria Peminatan : {{ $kriteriaMinat->nama }}</h4>
    @endif
                  <form action="{{ route('pilihan.update', $pilihan->id) }}" method="POST" class="forms-sample">
                    @csrf
@method('PUT')
                    
<div class="form-group row">
                      <label for="nama" class="col-sm-3 col-form-label">Nama Pilihan</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama"  value="{{ $pilihan->nama }}" required>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="nilai" class="col-sm-3 col-form-label">Nilai</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="nilai" id="deskripsi"  value="{{ $pilihan->nilai }}" required>
                      </div>
                    </div>

                        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Update</button>
                        <a href="{{ route('pilihan.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                  </form>
                </div>
              </div>
            </div>
</body>
</html>
@endsection