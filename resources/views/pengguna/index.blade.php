<!-- resources/views/pengguna/index.blade.php -->
@extends('main')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
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
                <h4 class="card-title">Daftar Pengguna</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Identitas</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengguna as $user)
                                <tr>
                                    <td>{{ $user->nomor_identitas }}</td>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role }}</td>
                                    <!-- Aksi dihapus dari template ini sesuai permintaan -->
                                     <td><form action="{{ route('pengguna.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
                                            </form></td>
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
