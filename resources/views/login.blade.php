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

              <h4>Hello! Let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>

              <form action="{{ route('login') }}" method="POST" class="pt-3">
                @csrf
                <div class="form-group">
                  <input type="text" name="username" class="form-control form-control-lg" id="username" placeholder="Username" value="{{ old('username') }}" required>
                  @error('username')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group position-relative">
  <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password" required>
  <span class="position-absolute" 
        style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" 
        onclick="togglePasswordVisibility()">
    <i id="togglePasswordIcon" class="ti-eye"></i>
  </span>
  @error('password')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror
</div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="{{ route('register')}}" class="text-primary">Create</a>
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

  <script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePasswordIcon');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text'; // Ubah tipe menjadi text
      toggleIcon.classList.replace('ti-eye', 'ti-eye-off'); // Ganti ikon menjadi "mata tertutup"
    } else {
      passwordInput.type = 'password'; // Kembalikan ke tipe password
      toggleIcon.classList.replace('ti-eye-off', 'ti-eye'); // Ganti ikon menjadi "mata terbuka"
    }
  }
</script>


  <!-- endinject -->
</body>

</html>
