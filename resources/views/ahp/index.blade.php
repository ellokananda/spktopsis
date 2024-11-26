<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input AHP</title>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Form Input AHP</h1>

    <form action="{{ route('ahp.store') }}" method="POST">
        @csrf
        <h2>Perbandingan Kriteria</h2>

        <table>
            <thead>
                <tr>
                    <th>Kriteria 1</th>
                    <th>Skala Perbandingan</th>
                    <th>Kriteria 2</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $i => $k1)
                    @foreach($kriteria as $j => $k2)
                        @if($i < $j) <!-- Menampilkan hanya jika $i < $j untuk menghindari duplikasi -->
                            <tr>
                                <td>
                                    <input type="text" name="perbandingan[{{ $k1->id }}][{{ $k2->id }}][kriteria1]" value="{{ $k1->nama }}" readonly>
                                </td>
                                <td>
                                    <select name="perbandingan[{{ $k1->id }}][{{ $k2->id }}][nilai]">
                                        <option value="1">1 - Sama Pentingnya</option>
                                        <option value="3">3 - Sedikit Lebih Penting</option>
                                        <option value="5">5 - Lebih Penting</option>
                                        <option value="7">7 - Jauh Lebih Penting</option>
                                        <option value="9">9 - Mutlak Lebih Penting</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="perbandingan[{{ $k1->id }}][{{ $k2->id }}][kriteria2]" value="{{ $k2->nama }}" readonly>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <button type="submit">Simpan Perbandingan</button>
    </form>
</body>
</html>
