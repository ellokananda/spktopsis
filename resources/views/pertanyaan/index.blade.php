@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertanyaan</title>
</head>
<body>
@if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pertanyaan Jenjang</h4>
                <a href="{{ route('pertanyaan.create') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Pertanyaan</a>
                <div class="table-responsive">
                    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Alternatif</th>
                <th>Pertanyaan</th>
                <th>Aksi</th> <!-- Kolom untuk aksi -->
            </tr>
        </thead>
        <tbody>
            @foreach ($pertanyaans as $pertanyaan)
                <tr>
                    <td>{{ $pertanyaan->kriteria->nama }}</td>
                    <td>{{ $pertanyaan->alternatif->nama }}</td>
                    <td>{{ \Illuminate\Support\Str::words($pertanyaan->pertanyaan, 7, '...') }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('pertanyaan.edit', $pertanyaan->id) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>

                        <!-- Form untuk Hapus -->
                        <form action="{{ route('pertanyaan.destroy', $pertanyaan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
</form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between">
            <div>
                Showing {{ $pertanyaans->firstItem() }} to {{ $pertanyaans->lastItem() }} of {{ $pertanyaans->total() }} entries
            </div>
            <div>
                {{ $pertanyaans->links('pagination::bootstrap-4') }} <!-- Menampilkan pagination dengan Bootstrap -->
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection