<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .text-center { text-align: center; }
        .section { margin-top: 20px; }
        .section h5 { font-size: 18px; font-weight: bold; }
        .alternative-item {
            padding: 8px;
            border: 1px solid #ddd;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="text-center">
    <h2>Hasil Rekomendasi Penelusuran Jenjang dan Peminatan</h2>
    <p>Berdasarkan data yang anda inputkan serta hasil analisis perhitungan, siswa <strong>{{ auth()->user()->nama }}</strong> NISN <strong>{{ auth()->user()->nomor_identitas }}</strong> direkomendasikan untuk melanjutkan ke jenjang sekolah serta peminatan berikut:</p>
</div>

<div class="section">
    <h5>Alternatif Terbaik</h5>
   
        <div class="alternative-item">{{ session('jenjang_terbaik')['nama'] }}</div>
    
</div>

<div class="section">
    <h5>Subalternatif Terbaik</h5>
   
    @foreach($bestSubAlternatives as $index => $subAlternative)
                @if($index < 3) <!-- Batasi hanya untuk 3 subalternatif terbaik -->
                    <div class="alternative-item">
                        <h4>{{ $subAlternative['nama'] }}</h4>
                        <!-- <p>Skor: {{ number_format($subAlternative['skor'], 2) }}</p> -->
                    </div>
                @endif
            @endforeach
  
</div>

</body>
</html>
