@extends('main')
@section('content')
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
                  <h4 class="card-title">Edit Koordinator</h4>
                  <form action="{{ route('koordinator.update', $koordinator->id) }}" method="POST" class="forms-sample">
                    @csrf
@method('PUT')
                    <div class="form-group row">
                      <label for="nip" class="col-sm-3 col-form-label">NIP</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nip" id="nip"  value="{{ $koordinator->nip }}" required>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama"  value="{{ $koordinator->nama }}" required>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="jeniskelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="jeniskelamin" name="jeniskelamin" required>
                <option value="L" {{ $koordinator->jeniskelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $koordinator->jeniskelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
                      </div>
                    </div>


<div class="form-group row">
                      <label for="notelp" class="col-sm-3 col-form-label">No. Telpon</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="notelp" id="notelp"  value="{{ $koordinator->notelp }}" required>
                      </div>
                    </div>

<div class="form-group row">
                      <label for="nama" class="col-sm-3 col-form-label">Alamat</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" name="alamat" id="alamat"   required>{{ $koordinator->alamat }}</textarea>
                      </div>
                    </div>

                        <button type="submit" class="btn btn-inverse-success btn-fw btn-sm">Update</button>
                        <a href="{{ route('alternatif.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
                  </form>
                </div>
              </div>
            </div>
</div>
@endsection
