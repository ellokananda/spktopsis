@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tahun</title>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Tahun</h4>
                <a href="{{ route('tahun.create') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Tahun</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Akademik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php ($no = 1)
                            @foreach($tahun as $t)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $t->tahun_akademik }}</td>
                                    <td>
                                        <a href="{{ route('tahun.edit', $t) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                        <form action="{{ route('tahun.destroy', $t) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
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
</body>
</html>
@endsection
