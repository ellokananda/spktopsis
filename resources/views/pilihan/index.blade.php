@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pilihan</title>
</head>
<body>

<!-- Row untuk menampilkan Data Pilihan Kriteria Jenjang dan Minat secara bersebelahan -->
<div class="row">
    <!-- Bagian Data Pilihan Kriteria Jenjang -->
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Data Pilihan Kriteria Jenjang</h3>
                <div class="table-responsive">
               
                    @foreach($kriterias as $kriteria)
                        <h5>{{ $kriteria->nama }}</h5>
                        <!-- Button to add choice for this Kriteria -->
                        <a href="{{ route('pilihan.create', ['type' => 'kriteria', 'id' => $kriteria->id]) }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Pilihan</a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    
                                    <th>Nama Pilihan</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kriteria->pilihans as $pilihan)
                                    <tr>
                                    
                                        <td>{{ $pilihan->nama }}</td>
                                        <td>{{ $pilihan->nilai }}</td>
                                        <td>
                                            <a href="{{ route('pilihan.edit', ['type' => 'kriteria', 'id' => $pilihan->id]) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                            <form action="{{ route('pilihan.destroy', $pilihan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Belum ada pilihan untuk kriteria ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <br>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Data Pilihan Kriteria Minat -->
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Data Pilihan Kriteria Minat</h3>
                <div class="table-responsive">
               
                    @foreach($kriteriaMinats as $kriteriaMinat)
                        <h5>{{ $kriteriaMinat->nama }}</h5>
                        <!-- Button to add choice for this Kriteria Minat -->
                        <a href="{{ route('pilihan.create', ['type' => 'kriteria_minat', 'id' => $kriteriaMinat->id]) }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Pilihan</a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    
                                    <th>Nama Pilihan</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kriteriaMinat->pilihans as $pilihan)
                                    <tr>
                                   
                                        <td>{{ $pilihan->nama }}</td>
                                        <td>{{ $pilihan->nilai }}</td>
                                        <td>
                                            <a href="{{ route('pilihan.edit', ['type' => 'kriteria_minat', 'id' => $pilihan->id]) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                            <form action="{{ route('pilihan.destroy', $pilihan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Belum ada pilihan untuk kriteria minat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <br>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
@endsection
