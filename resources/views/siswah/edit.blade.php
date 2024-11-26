@extends('main')

@section('content')
<div class="container">

    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Edit Siswa</h4>
                <!-- Form edit siswa -->
                <form action="{{ route('siswah.update', $siswah->id) }}" method="POST" class="forms-sample">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="nis" class="col-sm-3 col-form-label">NIS</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nis" id="nis" value="{{ $siswah->nis }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tahun_akademik" class="col-sm-3 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tahun_akademik" id="tahun_akademik" value="{{ $siswah->tahun_akademik }}" readonly required>
                        </div>
                    </div>

                    <!-- Input nama siswa -->
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $siswah->nama }}" required>
                        </div>
                    </div>

                    <!-- Input jenis kelamin siswa -->
                    <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L" {{ $siswah->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $siswah->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="rata" class="col-sm-3 col-form-label">Rata-rata Rapor</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="rata" id="rata" value="{{ $siswah->rata }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="iq" class="col-sm-3 col-form-label">Prestasi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="prestasi" id="prestasi" value="{{ $siswah->prestasi }}" readonly>
                        </div>
                    </div>

                    <!-- Input rekomendasi jenjang siswa -->
                    <div class="form-group row">
                        <label for="rekomendasi_jenjang" class="col-sm-3 col-form-label">Rekomendasi Jenjang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="rekomendasi_jenjang" id="rekomendasi_jenjang" value="{{ $siswah->rekomendasi_jenjang }}" readonly>
                        </div>
                    </div>

                    <!-- Input rekomendasi peminatan siswa -->
                    <div class="form-group row">
                        <label for="rekomendasi_peminatan" class="col-sm-3 col-form-label">Rekomendasi Peminatan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="rekomendasi_peminatan" id="rekomendasi_peminatan" value="{{ $siswah->rekomendasi_peminatan }}" readonly>
                        </div>
                    </div>

                    <!-- Tombol submit dan kembali -->
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Update</button>
                            <a href="{{ route('siswah.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
