@extends('main')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sub Alternatif</title>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Sub Alternatif</h4>
                
                <div class="table-responsive">
                    
                    @foreach($alternatifs as $alternatif)
                        <h2>{{ $alternatif->nama }}</h2>

                        <!-- Kondisi untuk menampilkan tombol tambah hanya jika bukan siswa -->
                        @if(auth()->user()->role !== 'siswa')
                            <a href="{{ route('sub_alternatif.create', $alternatif->id) }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Sub Alternatif</a>
                        @endif
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sub Alternatif</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($alternatif->subalternatifs->isNotEmpty())
                                    @php ($no = 1)
                                    @foreach($alternatif->subalternatifs as $sub)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $sub->nama }}</td>
                                            <td>
                                                <!-- Kondisi untuk menampilkan tombol Edit dan Hapus hanya jika bukan siswa -->
                                                @if(auth()->user()->role !== 'siswa')
                                                    <a href="{{ route('sub_alternatif.edit', $sub->id) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                                    <form action="{{ route('sub_alternatif.destroy', $sub->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">Tidak ada sub-alternatif untuk alternatif ini.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    <br><br>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection
