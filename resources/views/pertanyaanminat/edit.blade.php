@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pertanyaan</title>
</head>
<body>
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">  
            <h4 class="card-title">Edit Pertanyaan Peminatan</h4>
            <form action="{{ route('pertanyaanminat.update', $pertanyaan->id) }}" method="POST" class="forms-sample">
                @csrf
                @method('PUT')

                <!-- Kriteria Selection -->
                <div class="form-group row">
                    <label for="kriteria_minat_id" class="col-sm-3 col-form-label">Kriteria</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="kriteria_minat_id" name="kriteria_minat_id" required>
                            @foreach ($kriteriaminats as $kriteria)
                                <option value="{{ $kriteria->id }}" {{ $pertanyaan->kriteria_minat_id == $kriteria->id ? 'selected' : '' }}>{{ $kriteria->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Alternatif Selection -->
                <div class="form-group row">
                    <label for="sub_alternatif_id" class="col-sm-3 col-form-label">Alternatif</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="sub_alternatif_id" name="sub_alternatif_id" required>
                            @foreach ($subalternatifs as $alternatif)
                                <option value="{{ $alternatif->id }}" {{ $pertanyaan->sub_alternatif_id == $alternatif->id ? 'selected' : '' }}>{{ $alternatif->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Pertanyaan Input -->
                <div class="form-group row">
                    <label for="pertanyaan" class="col-sm-3 col-form-label">Pertanyaan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="pertanyaan" id="pertanyaan" value="{{ $pertanyaan->pertanyaan }}" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Update</button>
                <a href="{{ route('pertanyaanminat.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
@endsection
