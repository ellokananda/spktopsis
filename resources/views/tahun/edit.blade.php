@extends('main')
@section('content')
<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Tahun</h4>
            <form action="{{ route('tahun.update', $tahun) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tahun_akademik">Tahun Akademik</label>
                    <input type="text" name="tahun_akademik" class="form-control" value="{{ $tahun->tahun_akademik }}" required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
