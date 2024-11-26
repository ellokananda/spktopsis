@extends('main')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Kriteria Peminatan</title>
    <!-- Include your stylesheets here -->
</head>
<body>
    
    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Kriteria Peminatan</h4>
                
                <!-- Cek jika role bukan siswa -->
                @if(Auth::user()->role != 'siswa')
                    <a href="{{ route('kriteriaminat.create') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Kriteria</a>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Atribut</th>
                                <th>Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php ($no = 1)
                            @foreach ($kriteriaminat as $kri)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kri->nama }}</td>
                                    <td>{{ \Illuminate\Support\Str::words($kri->deskripsi, 7, '...') }}</td>
                                    <td>{{ $kri->atribut }}</td>
                                    <td>{{ $kri->bobot }}</td> <!-- Menampilkan bobot dengan 6 desimal -->
                                    <td>
                                        <!-- Cek jika role bukan siswa -->
                                        @if(Auth::user()->role != 'siswa')
                                            <a href="{{ route('kriteriaminat.edit', $kri) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                            
                                            <!-- Tombol Hapus dengan Form -->
                                            <form action="{{ route('kriteriaminat.destroy', $kri) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
                                            </form>
                                        @endif
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
