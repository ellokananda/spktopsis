@extends('main')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Kriteria Jenjang</title>
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
                <h4 class="card-title">Data Kriteria Jenjang</h4>
                
                <!-- Hanya tampilkan tombol "Tambah Kriteria" jika bukan role siswa -->
                @if(auth()->user()->role != 'siswa')
                    <a href="{{ route('kriteria.create') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Kriteria</a>
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
                            @foreach ($kriteria as $kri)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kri->nama }}</td>
                                    <td>{{ \Illuminate\Support\Str::words($kri->deskripsi, 7, '...') }}</td>
                                    <td>{{ $kri->atribut }}</td>
                                    <td>{{ $kri->bobot }}</td> <!-- Menampilkan bobot dengan 6 desimal -->
                                    
                                    <!-- Aksi edit dan hapus hanya tampil jika role bukan siswa -->
                                    <td>
                                        @if(auth()->user()->role != 'siswa')
                                            <a href="{{ route('kriteria.edit', $kri) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                            
                                            <!-- Tombol Hapus dengan Form -->
                                            <form action="{{ route('kriteria.destroy', $kri) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
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
