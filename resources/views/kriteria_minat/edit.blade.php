<!-- resources/views/kriteria/edit.blade.php -->

@extends('main')
@section('content')<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kriteria Minat</title>
</head>
<body>


    <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">  
                  <h4 class="card-title">Edit Kriteria Peminatan</h4>
                  <form action="{{ route('kriteriaminat.update', $kriteriaminat->id) }}" method="POST" class="forms-sample">
                    @csrf
@method('PUT')
                    
<div class="form-group row">
                      <label for="nama" class="col-sm-3 col-form-label">Nama Kriteria</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama"  value="{{ $kriteriaminat->nama }}" required>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi"  value="{{ $kriteriaminat->deskripsi }}" required>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="atribut" class="col-sm-3 col-form-label">Atribut</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="atribut" name="atribut" required>
                <option value="cost" {{ $kriteriaminat->atribut == 'cost' ? 'selected' : '' }}>Cost</option>
                <option value="benefit" {{ $kriteriaminat->atribut == 'benefit' ? 'selected' : '' }}>Benefit</option>
            </select>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="bobot" class="col-sm-3 col-form-label">Bobot</label>
                      <div class="col-sm-9">
                       <input type="number" class="form-control" name="bobot" id="notelp"  value="{{ $kriteriaminat->bobot }}" required>
                      </div>
                    </div>

                        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Update</button>
                        <a href="{{ route('kriteriaminat.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                  </form>
                </div>
              </div>
            </div>
</body>
</html>
@endsection