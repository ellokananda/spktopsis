@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subalternatif Penilaian</title>
</head>
<body>
<div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penelusuran Peminatan</h4>
                
                <div class="table-responsive">
    @if($subAlternatifs->isEmpty())
        <p>Lakukan penelusuran jenjang terlebih dahulu!.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Alternatif Peminatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subAlternatifs as $subAlternatif)
                    <tr>
                        <td>{{ $subAlternatif->nama }}</td>
                        <!-- <td>
                            <a href="{{ route('penilaianminat.create', $subAlternatif->id) }}">
                                Tambah Penilaian
                            </a>
                        </td> -->
                        <td>
                        @php
                            $hasPenilaian = $subAlternatif->penilaians->isNotEmpty();
                        @endphp

                        @if($hasPenilaian)
                        <a href="{{ route('penilaianminat.create', $subAlternatif) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit Penilaian</a>
                        @else
                        <a href="{{ route('penilaianminat.create', $subAlternatif) }}" class="btn btn-inverse-danger btn-fw btn-sm">Tambah Penilaian</a>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        @endif

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
</div>
<a href="{{ route('topsisminat.calculate') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tentukan</a>
</div>
</div>
</div>
    
   
</body>
</html>
@endsection