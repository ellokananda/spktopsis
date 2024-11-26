@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Alternatif Jenjang</title>
</head>
<body>
<div class="col-lg-15 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Penelusuran Jenjang</h4>

            <!-- Alert jika ada alternatif tanpa penilaian -->
            @php
                $alternatifTanpaPenilaian = $alternatifs->filter(function($alternatif) {
                    return $alternatif->penilaians->isEmpty();
                });
            @endphp

            @if($alternatifTanpaPenilaian->isNotEmpty())
                <div class="alert alert-warning">
                    <strong>Peringatan!</strong> Beberapa alternatif belum diberikan penilaian. Silakan tambahkan penilaian.
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Alternatif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatifs as $alternatif)
                            <tr>
                                <td>{{ $alternatif->nama }}</td>
                                <td>
                                    @php
                                        $hasPenilaian = $alternatif->penilaians->isNotEmpty();
                                    @endphp

                                    @if($hasPenilaian)
                                        <a href="{{ route('penilaian.create', $alternatif) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit Penilaian</a>
                                    @else
                                        <a href="{{ route('penilaian.create', $alternatif) }}" class="btn btn-inverse-danger btn-fw btn-sm">Tambah Penilaian</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <a href="{{ route('topsis.calculate') }}" class="btn btn-inverse-primary btn-fw btn-sm">Tentukan</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection
