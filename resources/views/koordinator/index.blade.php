@extends('main')

@section('content')
<div class="container">
    

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Koordinator</h4>
                <a href="{{ route('koordinator.create') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Koordinator</a>
                <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No. Telp</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @php ($no = 1)
            @foreach($koordinators as $koordinator)
            <tr>
            <td>{{ $no++ }}</td>
                <td>{{ $koordinator->nip }}</td>
                <td>{{ $koordinator->nama }}</td>
                <td>{{ $koordinator->jeniskelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $koordinator->notelp }}</td>
                <td>{{ $koordinator->alamat }}</td>
                <td>
                    <a href="{{ route('koordinator.edit', $koordinator->id) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                    <form action="{{ route('koordinator.destroy', $koordinator->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</div>
@endsection
