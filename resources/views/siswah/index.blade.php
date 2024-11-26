@extends('main')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col-lg-15 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Siswa</h4>
                
                <!-- Dropdown Tahun Akademik -->
                <div class="mb-3">
                    <form action="{{ route('siswah.index') }}" method="GET" id="filterForm">
                        <label for="filter-tahun" class="form-label">Pilih Tahun Akademik:</label>
                        <select id="filter-tahun" name="tahun_akademik" class="form-control" onchange="document.getElementById('filterForm').submit();">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunAkademik as $tahun)
                                <option value="{{ $tahun->tahun_akademik }}" {{ request('tahun_akademik') == $tahun->tahun_akademik ? 'selected' : '' }}>
                                    {{ $tahun->tahun_akademik }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Tombol Upload Excel dan Tambah Siswa -->
                <div class="mb-3">
                    <button type="button" class="btn btn-inverse-info btn-fw btn-sm" data-toggle="modal" data-target="#uploadModal">Upload Excel</button>
                    <a href="{{ route('siswah.create', ['tahun_akademik' => request('tahun_akademik')]) }}" class="btn btn-inverse-primary btn-fw btn-sm">Tambah Siswa</a>
                    <a href="{{ route('siswah.cetakPdf', ['tahun_akademik' => request('tahun_akademik')]) }}" class="btn btn-inverse-success btn-fw btn-sm" >Cetak PDF</a>
                </div>
                
                <!-- Tabel Data Siswa -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Tahun Akademik</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Rata-rata Rapor</th>
                                <th>Prestasi</th>
                                <th>Rekomendasi Jenjang</th>
                                <th>Rekomendasi Peminatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data-siswa-body">
                            @foreach($siswahs as $index => $siswah)
                                <tr>
                                    <td>{{ $loop->iteration + $siswahs->firstItem() - 1 }}</td>
                                    <td>{{ $siswah->nis }}</td>
                                    <td>{{ $siswah->tahun_akademik }}</td>
                                    <td>{{ $siswah->nama }}</td>
                                    <td>{{ $siswah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $siswah->rata }}</td>
                                    <td>{{ $siswah->prestasi }}</td>
                                    <td>{{ $siswah->rekomendasi_jenjang }}</td>
                                    <td>{{ $siswah->rekomendasi_peminatan }}</td>
                                    <td>
                                        <a href="{{ route('siswah.edit', $siswah->id) }}" class="btn btn-inverse-info btn-fw btn-sm">Edit</a>
                                        <form action="{{ route('siswah.destroy', $siswah->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-danger btn-fw btn-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- {{ $siswahs->appends(request()->except('page'))->links() }} -->

                    <div class="d-flex justify-content-between">
            <div>
                Showing {{ $siswahs->firstItem() }} to {{ $siswahs->lastItem() }} of {{ $siswahs->total() }} entries
            </div>
            <div>
                {{ $siswahs->links('pagination::bootstrap-4') }} <!-- Menampilkan pagination dengan Bootstrap -->
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Excel -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('siswah.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload File Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="file" accept=".xlsx, .xls" required class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-secondary btn-fw btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-inverse-primary btn-fw btn-sm">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection
