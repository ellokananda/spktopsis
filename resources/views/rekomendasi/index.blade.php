@extends('main')
@section('content')
<div class="col-lg-15 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-center">Hasil Rekomendasi Penelusuran Jenjang dan Peminatan</h4>
            <p class="text-center">
    Berdasarkan data yang anda inputkan serta hasil analisis perhitungan,<br>
    Siswa dengan nama <strong>{{ auth()->user()->nama }}</strong> NISN <strong>{{ auth()->user()->nomor_identitas }}</strong> direkomendasikan untuk melanjutkan ke jenjang dan peminatan:
</p>

            <div class="result-section">
                <h5>Jenjang yang direkomendasikan</h5>
                @if(count($bestAlternatives) > 0)
                    <div class="alternative-item">
                        <!-- Menampilkan nama dari alternatif terbaik hanya satu kali -->
                        <h4>{{ session('jenjang_terbaik')['nama'] }}</h4>
                    </div>
                @else
                    <p class="text-center">Belum ada hasil alternatif terbaik.</p>
                @endif
            </div>

            <div class="result-section">
    <h5>Peminatan yang Direkomendasikan</h5>
    @if(count($bestSubAlternatives) > 0)
        <div class="alternative-list">
            @foreach($bestSubAlternatives as $index => $subAlternative)
                @if($index < 3) <!-- Batasi hanya untuk 3 subalternatif terbaik -->
                    <div class="alternative-item">
                        <h4>{{ $subAlternative['nama'] }}</h4>
                        <!-- <p>Skor: {{ number_format($subAlternative['skor'], 2) }}</p> -->
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-center">Belum ada hasil subalternatif terbaik.</p>
    @endif
</div>


            <div class="text-center mt-4">
                <a href="{{ route('rekomendasi.cetakPdf') }}" class="btn btn-inverse-primary btn-fw btn-sm">Cetak PDF</a>
            </div>
        </div>
    </div>
</div>

<style>
    .result-section {
        margin-top: 20px;
    }
    .result-section h5 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .alternative-item {
        background-color: #f4f4f4;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        min-width: 150px;
    }
    .alternative-item p {
        margin: 0;
        font-size: 16px;
        font-weight: 500;
    }
</style>
@endsection
