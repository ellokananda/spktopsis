{{-- resources/views/topsisminat/best_alternatives.blade.php --}}
@extends('main')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Alternatif dan Sub Alternatif Terbaik</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Alternatif dan Sub Alternatif Terbaik</h1>

        @if (isset($bestAlternative) && $bestAlternative->isNotEmpty())
            <h2>Alternatif Terbaik:</h2>
            <ul>
                @foreach ($bestAlternative as $alternative)
                    <li>{{ $alternative->nama }}</li> {{-- Pastikan nama kolom ini sesuai --}}
                @endforeach
            </ul>
        @else
            <p>Tidak ada alternatif terbaik yang ditemukan.</p>
        @endif

        @if (isset($bestSubAlternatives) && $bestSubAlternatives->isNotEmpty())
            <h2>Sub Alternatif Terbaik:</h2>
            <ul>
                @foreach ($bestSubAlternatives as $subAlternative)
                    <li>{{ $subAlternative->nama }}</li>
                @endforeach
            </ul>
        @else
            <p>Tidak ada sub alternatif terbaik yang ditemukan.</p>
        @endif
    </div>
</body>
</html>
@endsection