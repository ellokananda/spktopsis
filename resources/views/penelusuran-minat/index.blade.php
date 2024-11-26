@extends('main')

@section('content')
<div class="col-lg-15 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Penelusuran Minat</h4>
            
            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('penelusuran-minat.store') }}" method="POST">
                @csrf
                <hr>
                    <h5>Petunjuk : Jawablah pernyataan ini dengan memberikan nilai pada skala 1–5 untuk setiap pertanyaan</h5>
                    <p>5 = Sangat Setuju</p>
                    <p>4 = Setuju</p>
                    <p>3 = Netral</p>
                    <p>2 = Tidak Setuju</p>
                    <p>1 = Sangat Tidak Setuju</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Skala Likert (1-5)</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php ($no = 1)
                    @forelse ($pertanyaans as $pertanyaan)
    <tr>
    <td>{{ $no++ }}</td>
        <td style="word-wrap: break-word; white-space: normal;">{{ $pertanyaan->pertanyaan }}</td>
        <td>
            <label>
                <input type="radio" name="penilaianminat[{{ $pertanyaan->id }}]" value="1" required> 1
            </label>
            <label>
                <input type="radio" name="penilaianminat[{{ $pertanyaan->id }}]" value="2" required> 2
            </label>
            <label>
                <input type="radio" name="penilaianminat[{{ $pertanyaan->id }}]" value="3" required> 3
            </label>
            <label>
                <input type="radio" name="penilaianminat[{{ $pertanyaan->id }}]" value="4" required> 4
            </label>
            <label>
                <input type="radio" name="penilaianminat[{{ $pertanyaan->id }}]" value="5" required> 5
            </label>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="2">Tidak ada pertanyaan untuk ditampilkan.</td>
    </tr>
@endforelse

                    </tbody>
                </table>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-inverse-primary btn-fw btn-sm">Simpan Penilaian</button>
                    <a href="{{ route('penelusuran-minat.hasil') }}" class="btn btn-inverse-info btn-fw btn-sm ml-3">Lihat Hasil</a>
                </div>
            </form>

            
        </div>
    </div>
</div>
@endsection
