@extends('main')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
</head>
<body>
    <div class="container">
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
                    <h4 class="card-title">Tambah Siswa</h4>
                    <form action="{{ route('siswah.store') }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="form-group row">
                            <label for="nis" class="col-sm-3 col-form-label">NIS</label>
                            <div class="col-sm-9">
                                <input type="text" name="nis" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tahun_akademik" class="col-sm-3 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-9">
                                <input type="text" name="tahun_akademik" class="form-control" value="{{ $selectedTahunAkademik }}" readonly required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rata" class="col-sm-3 col-form-label">Rata-rata Rapor</label>
                            <div class="col-sm-9">
                                <input type="number" name="rata" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="iq" class="col-sm-3 col-form-label">Prestasi</label>
                            <div class="col-sm-9">
                                <input type="text" name="prestasi" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
    <label for="rekomendasi_jenjang" class="col-sm-3 col-form-label">Rekomendasi Jenjang</label>
    <div class="col-sm-9">
        <input type="text" name="rekomendasi_jenjang" class="form-control" readonly >
    </div>
</div>

<div class="form-group row">
    <label for="rekomendasi_peminatan" class="col-sm-3 col-form-label">Rekomendasi Peminatan</label>
    <div class="col-sm-9">
        <input type="text" name="rekomendasi_peminatan" class="form-control" readonly>
    </div>
</div>


                        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Simpan</button>
                        <a href="{{ route('siswah.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
