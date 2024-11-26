<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Rekomendasi Jenjang dan Peminatan</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('style/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('style/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('style/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('style/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('style/images/iconr.png') }}" />
    <style>
        .sidebar {
            position: fixed; /* Membuat sidebar tetap di tempat */
            top: 70px; /* Posisi dari bagian atas halaman */
            left: 0; /* Posisi dari sisi kiri halaman */
            width: 250px; /* Atur lebar sidebar */
            height: 100vh; /* Pastikan sidebar setinggi viewport */
            overflow-y: auto; /* Tambahkan scroll jika konten sidebar lebih tinggi dari viewport */
            z-index: 1000; /* Pastikan sidebar berada di atas konten lainnya */
        }

        .main-panel {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px; /* Tambahkan padding untuk konten */
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none; /* Sembunyikan sidebar pada perangkat kecil */
            }

            .main-panel {
                margin-left: 0; /* Hilangkan margin kiri untuk perangkat kecil */
                padding: 10px; /* Kurangi padding untuk perangkat kecil */
            }

            .navbar {
                flex-direction: column; /* Ubah arah navbar menjadi kolom */
                align-items: flex-start; /* Rata kiri untuk item navbar */
            }
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-1" >
                <img src="{{ asset('style/images/iconr.png') }}" alt="logo" >
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="live-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" id="profileDropdown">
                            <i class="fas fa-user text-primary ml-2"></i> <!-- Menambahkan ikon profil -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{route('login')}}">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
    @if(Auth::user()->role == 'admin')
        <!-- Menu untuk admin -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswah.index') }}">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Data Siswa</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('koordinator.index') }}">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Data Koordinator</span>
            </a>
        </li>
        <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengguna.index') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Data Pengguna</span>
                        </a>
                    </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tahun.index') }}">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Data Tahun Akademik</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#kriteria-menu" aria-expanded="false" aria-controls="kriteria-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Kriteria</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="kriteria-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteria.index') }}">Data Kriteria Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteriaminat.index') }}">Data Kriteria Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#alternatif-menu" aria-expanded="false" aria-controls="alternatif-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Alternatif</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="alternatif-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alternatif.index') }}">Data Alternatif Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sub_alternatif.index') }}">Data Alternatif Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#pertanyaan-menu" aria-expanded="false" aria-controls="pertanyaan-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Pertanyaan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pertanyaan-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pertanyaan.index') }}">Pertanyaan Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pertanyaanminat.index') }}">Pertanyaan Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#penelusuran-menu" aria-expanded="false" aria-controls="penelusuran-menu">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Penelusuran</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="penelusuran-menu">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('penelusuran-jenjang.index') }}">Penelusuran Jenjang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('penelusuran-minat.index') }}">Penelusuran Peminatan</a>
                                </li>
                            </ul>
                        </div>
                    </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('rekomendasi.index') }}">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Hasil Rekomendasi</span>
            </a>
        </li>
    @elseif(Auth::user()->role == 'koordinator')
        <!-- Menu untuk koordinator -->
        <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('siswah.index') }}">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Data Siswa</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#kriteria-menu" aria-expanded="false" aria-controls="kriteria-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Kriteria</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="kriteria-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteria.index') }}">Data Kriteria Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteriaminat.index') }}">Data Kriteria Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#alternatif-menu" aria-expanded="false" aria-controls="alternatif-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Alternatif</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="alternatif-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alternatif.index') }}">Data Alternatif Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sub_alternatif.index') }}">Data Alternatif Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#pertanyaan-menu" aria-expanded="false" aria-controls="pertanyaan-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Pertanyaan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pertanyaan-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pertanyaan.index') }}">Pertanyaan Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pertanyaanminat.index') }}">Pertanyaan Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
    @elseif(Auth::user()->role == 'siswa')
        <!-- Menu untuk siswa -->
        <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#kriteria-menu" aria-expanded="false" aria-controls="kriteria-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Kriteria</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="kriteria-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteria.index') }}">Data Kriteria Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kriteriaminat.index') }}">Data Kriteria Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#alternatif-menu" aria-expanded="false" aria-controls="alternatif-menu">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Alternatif</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="alternatif-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alternatif.index') }}">Data Alternatif Jenjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sub_alternatif.index') }}">Data Alternatif Peminatan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#penelusuran-menu" aria-expanded="false" aria-controls="penelusuran-menu">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Penelusuran</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="penelusuran-menu">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('penelusuran-jenjang.index') }}">Penelusuran Jenjang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('penelusuran-minat.index') }}">Penelusuran Peminatan</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rekomendasi.index') }}">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Hasil Rekomendasi</span>
                        </a>
                    </li>
    @endif
</ul>

            </nav>

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- <footer class="footer justify-content-center">
                    <div class="container-fluid clearfix ">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">© 2024 Rekomendasi Peminatan.</span>
                    </div>
                </footer> -->
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="{{ asset('style/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('style/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('style/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('style/js/dataTables.select.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('style/js/off-canvas.js') }}"></script>
    <script src="{{ asset('style/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('style/js/template.js') }}"></script>
    <script src="{{ asset('style/js/settings.js') }}"></script>
    <script src="{{ asset('style/js/todolist.js') }}"></script>
    <!-- endinject -->
    <script>
    document.getElementById('live-search-input').addEventListener('input', function() {
        const query = this.value;

        if (query.length > 2) {
            fetch(`/search?query=${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('search-results').innerHTML = data;
                });
        } else {
            document.getElementById('search-results').innerHTML = '';
        }
    });
</script>

</body>

</html>
