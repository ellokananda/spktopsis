<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil AHP</title>
</head>
<body>
    <h1>Hasil AHP</h1>

    <h2>Matriks Perbandingan Kriteria</h2>
    <table border="1">
        <thead>
            <tr>
                @foreach($kriteria as $k1)
                    <th>{{ $k1->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($pairwiseMatrix as $i => $row)
                <tr>
                    @foreach($row as $value)
                        <td>{{ number_format($value, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Matriks Normalisasi</h2>
    <table border="1">
        <thead>
            <tr>
                @foreach($kriteria as $k1)
                    <th>{{ $k1->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($normalizedMatrix as $i => $row)
                <tr>
                    @foreach($row as $value)
                        <td>{{ number_format($value, 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Bobot Kriteria</h2>
    <ul>
        @foreach($criteriaWeights as $index => $weight)
            <li>{{ $kriteria[$index]->nama }}: {{ number_format($weight, 2) }}</li>
        @endforeach
    </ul>

    <h2>Konsistensi Rasio</h2>
    <p>{{ number_format($consistencyRatio, 2) }}</p>

    <h2>Ranking Alternatif</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Skor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankingDetails as $detail)
                <tr>
                    <td>{{ $detail['alternatif']->nama }}</td>
                    <td>{{ number_format($detail['totalScore'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($selectedAlternative)
        <h2>Alternatif Terpilih</h2>
        <p>{{ $selectedAlternative->nama }}</p>
    @endif
</body>
</html>
