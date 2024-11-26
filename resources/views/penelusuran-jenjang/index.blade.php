@extends('main')

@section('content')
    <!-- Judul Halaman -->
    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Penelusuran Jenjang</h4>
<!-- Pesan Sukses -->
@if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                <!-- Form untuk Penilaian -->
                <form action="{{ route('penelusuran-jenjang.store') }}" method="POST">
                    @csrf
                    
                    <!-- Input Nilai Rata-rata -->
                    <div class="form-group">
                        <label for="rata">Nilai Rata-rata</label>
                        <input type="number" step="0.01" name="rata" id="rata" class="form-control" placeholder="Masukkan nilai rata-rata" required>
                    </div>

                    <!-- Input Prestasi -->
                    <div class="form-group">
                        <label>Prestasi</label><br>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 1 Kejuaraan Internasional"> Juara 1 Kejuaraan Internasional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 1 Kejuaraan Nasional"> Juara 1 Kejuaraan Nasional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 1 Kejuaraan Regional"> Juara 1 Kejuaraan Regional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 1 Kejuaraan Local"> Juara 1 Kejuaraan Local
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 2 Kejuaraan Internasional"> Juara 2 Kejuaraan Internasional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 2 Kejuaraan Nasional"> Juara 2 Kejuaraan Nasional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 2 Kejuaraan Regional"> Juara 2 Kejuaraan Regional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 2 Kejuaraan Local"> Juara 2 Kejuaraan Local
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 3 Kejuaraan Internasional"> Juara 3 Kejuaraan Internasional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 3 Kejuaraan Nasional"> Juara 3 Kejuaraan Nasional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 3 Kejuaraan Regional"> Juara 3 Kejuaraan Regional
                        </label>
                        <label class="d-block">
                            <input type="checkbox" name="prestasi[]" value="Juara 3 Kejuaraan Local"> Juara 3 Kejuaraan Local
                        </label>
                    </div>
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
                <input type="radio" name="penilaian[{{ $pertanyaan->id }}]" value="1" required> 1
            </label>
            <label>
                <input type="radio" name="penilaian[{{ $pertanyaan->id }}]" value="2" required> 2
            </label>
            <label>
                <input type="radio" name="penilaian[{{ $pertanyaan->id }}]" value="3" required> 3
            </label>
            <label>
                <input type="radio" name="penilaian[{{ $pertanyaan->id }}]" value="4" required> 4
            </label>
            <label>
                <input type="radio" name="penilaian[{{ $pertanyaan->id }}]" value="5" required> 5
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
                    <!-- Tombol Simpan Penilaian dan Lihat Hasil -->
                    <button type="submit" class="btn btn-inverse-primary btn-fw btn-sm">Simpan Penilaian</button>
                    <a href="{{ route('penelusuran-jenjang.hasil') }}" class="btn btn-inverse-info btn-fw btn-sm">Lihat Hasil</a>
                </form>

                
            </div>
        </div>
    </div>
@endsection
