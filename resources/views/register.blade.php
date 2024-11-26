<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistem Rekomendasi Jenjang dan Peminatan Sekolah Lanjutan Tingkat Atas</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('style/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('style/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('style/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('style/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('style/images/iconr.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
              <center>
        <img src="{{ asset('style/images/iconr.png') }}" alt="logo" width="200" height="auto">
    </center>
              </div>
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>

              <!-- Menampilkan pesan error jika ada -->
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form class="pt-3" method="POST" action="{{ route('register') }}">
                @csrf
                <!-- Input nomor identitas -->
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="nomor_identitas" name="nomor_identitas" placeholder="Nomor Identitas (NIP/NIS)" value="{{ old('nomor_identitas') }}" required>
                </div>

                <!-- Input nama -->
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
                </div>

                <!-- Input username -->
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>
                </div>

                <!-- Input password -->
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                </div>

                <!-- Input role -->
                <div class="form-group">
                  <select name="role" class="form-control form-control-lg" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="koordinator" {{ old('role') == 'koordinator' ? 'selected' : '' }}>Koordinator</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                  </select>
                </div>

                <!-- Tombol submit -->
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{ asset('style/js/off-canvas.js') }}"></script>
  <script src="{{ asset('style/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('style/js/template.js') }}"></script>
  <script src="{{ asset('style/js/settings.js') }}"></script>
  <script src="{{ asset('style/js/todolist.js') }}"></script>
  <!-- endinject -->
  </body>

</html>
