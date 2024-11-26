@extends('main')
@section('content')
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Alternatif</h4>
            <form action="{{ route('sub_alternatif.update', $subalternatif->id) }}" method="POST" class="forms-sample">
                @csrf
                @method('PUT') <!-- Menggunakan method PUT untuk update data -->
                
                <!-- Input Hidden untuk Alternatif ID -->
                <input type="hidden" name="alternatif_id" value="{{ $subalternatif->alternatif_id }}">

                <!-- Form Group untuk Nama -->
                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $subalternatif->nama) }}" required>
                    </div>
                </div>

                <!-- Tombol Simpan dan Kembali -->
                <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Simpan</button>
                <a href="{{ route('sub_alternatif.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
