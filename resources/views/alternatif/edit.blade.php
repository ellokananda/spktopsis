@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alternatif</title>
</head>
<body>
<div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">  
                  <h4 class="card-title">Edit Alternatif</h4>
                  <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST" class="forms-sample">
                    @csrf
@method('PUT')
                    <div class="form-group row">
                      <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama"  value="{{ old('nama', $alternatif->nama) }}" required>
                      </div>
                    </div>
                        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Update</button>
                        <a href="{{ route('alternatif.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                  </form>
                </div>
              </div>
            </div>
</body>
</html>
@endsection
