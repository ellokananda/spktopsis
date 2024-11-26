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
    <h1>Hasil TOPSIS</h1>

    <h2>Matriks Keputusan Terbobot</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($weightedMatrix as $altId => $values)
                <tr>
                    <td>{{ $altId }}</td>
                    @foreach($kriteria as $k)
                        <td>{{ number_format($values[$k->id] ?? 0, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Matriks Normalisasi</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Alternatif</th>
                @foreach($kriteria as $k)
                    <th>{{ $k->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($normalizedMatrix as $altId => $values)
                <tr>
                    <td>{{ $altId }}</td>
                    @foreach($kriteria as $k)
                        <td>{{ number_format($values[$k->id] ?? 0, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Jarak Ideal Positif dan Negatif</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Ideal Positif</th>
                <th>Ideal Negatif</th>
            </tr>
        </thead>
        <tbody>
            @foreach($idealPositive as $kriteriaId => $value)
                <tr>
                    <td>{{ $kriteria->find($kriteriaId)->nama }}</td>
                    <td>{{ number_format($value, 2) }}</td>
                    <td>{{ number_format($idealNegative[$kriteriaId] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Skor Preferensi</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Skor Preferensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preferenceScores as $altId => $score)
                <tr>
                    <td>{{ $altId }}</td>
                    <td>{{ number_format($score, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
@endsection