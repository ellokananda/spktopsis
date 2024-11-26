@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil TOPSIS</title>
</head>
<body>
    <!-- <h1>Hasil TOPSIS</h1> -->

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
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($decisionMatrix as $subAltId => $values)
                <tr>
                    <td>{{ $subAlternatifs->where('id', $subAltId)->first()->nama }}</td>
                    @foreach($kriteria as $k)
                        <td>{{ number_format($values[$k->id] ?? 0, 2) }}</td>
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
                <th>Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kriteria as $k)
                <tr>
                    <td>{{ $k->nama }}</td>
                    <td>{{ number_format($k->bobot, 2) }}</td>
                </tr>
            @endforeach
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
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($normalizedMatrix as $subAltId => $values)
                <tr>
                    <td>{{ $subAlternatifs->find($subAltId)->nama }}</td>
                    @foreach($values as $kriteriaId => $value)
                        <td>{{ number_format($value, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Matriks Terbobot -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Matriks Normalisasi Terbobot</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($weightedMatrix as $subAltId => $values)
                <tr>
                    <td>{{ $subAlternatifs->find($subAltId)->nama }}</td>
                    @foreach($values as $kriteriaId => $value)
                        <td>{{ number_format($value, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Solusi Ideal Positif -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Solusi Ideal Positif</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kriteria</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ideal Positif</td>
                @foreach($kriteria as $k)
                    <td>{{ number_format($idealPositive[$k->id] ?? 0, 2) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <!-- Solusi Ideal Negatif -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Solusi Ideal Negatif</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kriteria</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ideal Negatif</td>
                @foreach($kriteria as $k)
                    <td>{{ number_format($idealNegative[$k->id] ?? 0, 2) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Jarak Dari Solusi Ideal Positif (D+)</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>D+</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preferenceScores as $subAltId => $score)
                <tr>
                    <td>{{ $subAlternatifs->where('id', $subAltId)->first()->nama }}</td>
                    <td>{{ number_format($score['dPos'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>

    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Jarak Dari Solusi Ideal Negatif (D-)</h4>
                <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>D-</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preferenceScores as $subAltId => $score)
                <tr>
                    <td>{{ $subAlternatifs->where('id', $subAltId)->first()->nama }}</td>
                    <td>{{ number_format($score['dNeg'], 2) }}</td>
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
            @foreach($preferenceScores as $subAltId => $score)
                <tr>
                    <td>{{ $subAlternatifs->where('id', $subAltId)->first()->nama }}</td>
                    <td>{{ number_format($score['score'], 2) }}</td>
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
@if($bestAlternative->count() > 1)
    <p>Alternatif terbaik dengan skor {{ number_format($preferenceScores[$bestAlternative->first()->id]['score'], 2) }} adalah:</p>
    <ul>
        @foreach($bestAlternative as $alternative)
            <li>{{ $alternative->nama }}</li>
        @endforeach
    </ul>
@else
    <p>Alternatif terbaik adalah {{ $bestAlternative->first()->nama }} dengan skor {{ number_format($preferenceScores[$bestAlternative->first()->id]['score'], 2) }}.</p>
@endif
<a href="{{ route('penilaian.index') }}" class="btn btn-inverse-secondary btn-fw btn-sm">Kembali</a>
</div>
</div>
</div>
</div>

</body>
</html>
@endsection