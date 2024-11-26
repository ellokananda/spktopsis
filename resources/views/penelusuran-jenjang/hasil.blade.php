@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi Jenjang</title>
</head>
<body>
   

    <!-- Matriks Keputusan -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Matriks Keputusan</h4>
                <div class="table-responsive">
                <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach ($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($decisionMatrix as $alternatifId => $kriteriaValues)
                <tr>
                    <td>{{ $alternatifNames[$alternatifId] ?? 'Alternatif Tidak Ditemukan' }}</td>
                    @foreach ($kriteriaValues as $kriteriaId => $nilai)
                        <td>{{ number_format($nilai, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Bobot Kriteria -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bobot Kriteria</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach ($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($kriteria as $k)
                    <td>{{ number_format($k->bobot, 2) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Matriks Normalisasi -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Matriks Normalisasi</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach ($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($normalizedMatrix as $alternatifId => $kriteriaValues)
                <tr>
                    <td>{{ $alternatifNames[$alternatifId] ?? 'Alternatif Tidak Ditemukan' }}</td>
                    @foreach ($kriteriaValues as $nilai)
                        <td>{{ number_format($nilai, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Matriks Berbobot -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Matriks Normalisasi Terbobot</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach ($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($weightedMatrix as $alternatifId => $kriteriaValues)
                <tr>
                    <td>{{ $alternatifNames[$alternatifId] ?? 'Alternatif Tidak Ditemukan' }}</td>
                    @foreach ($kriteriaValues as $nilai)
                        <td>{{ number_format($nilai, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Solusi Ideal Positif dan Negatif -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Solusi Ideal Positif & Negatif</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Solusi</th>
                @foreach ($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Positif</td>
                @foreach ($idealPositive as $nilai)
                    <td>{{ number_format($nilai, 2) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>Negatif</td>
                @foreach ($idealNegative as $nilai)
                    <td>{{ number_format($nilai, 2) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Jarak ke Solusi Ideal Positif dan Negatif -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Jarak Ke Solusi Ideal Positif (D+) dan Negatif (D-)</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Jarak Positif</th>
                <th>Jarak Negatif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($positiveDistances as $alternatifId => $positiveDistance)
                <tr>
                    <td>{{ $alternatifNames[$alternatifId] ?? 'Alternatif Tidak Ditemukan' }}</td>
                    <td>{{ number_format($positiveDistance, 2) }}</td>
                    <td>{{ number_format($negativeDistances[$alternatifId], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Skor Preferensi -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Skor Preferensi</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Skor Preferensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preferenceScores as $alternatifId => $score)
                <tr>
                    <td>{{ $alternatifNames[$alternatifId] ?? 'Alternatif Tidak Ditemukan' }}</td>
                    <td>{{ number_format($score, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>
<!-- Alternatif Terbaik -->
<div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Alternatif Terbaik</h4>
                <div class="table-responsive">
<p>
    Alternatif terbaik berdasarkan perhitungan adalah: <strong>{{ session('jenjang_terbaik')['nama'] }}</strong> dengan skor preferensi <strong>{{ number_format(session('jenjang_terbaik')['skor'], 2) }}</strong>.
</p>
<a href="{{ route('penelusuran-jenjang.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
</div>
</div>
</div>
</div>
</body>
</html>
@endsection