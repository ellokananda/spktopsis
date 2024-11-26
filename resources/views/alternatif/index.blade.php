@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alternatif</title>
</head>
<body>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Alternatif</h4>

                <!-- Kondisi untuk tombol Tambah Alternatif hanya tampil jika bukan role siswa -->
                @if(auth()->user()->role !== 'siswa')
                    <a href="{{ route('alternatif.create') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Alternatif</a>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @php ($no = 1)
                            @foreach($alternatif as $a)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>
                                        <!-- Kondisi untuk tombol Edit dan Hapus hanya tampil jika bukan role siswa -->
                                        @if(auth()->user()->role !== 'siswa')
                                            <a href="{{ route('alternatif.edit', $a) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                            <form action="{{ route('alternatif.destroy', $a) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
