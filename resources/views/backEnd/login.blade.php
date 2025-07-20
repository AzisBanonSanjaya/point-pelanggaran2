<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - SMAN 1 Banjaran</title>
  <meta content="Sman 1 Banjaran" name="description">
  <meta content="Sman 1 Banjaran" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/sman 1.png') }}" rel="icon">
  <link href="{{ asset('assets/img/sman 1.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  <!-- Custom Style -->
  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(to right, #f5f7fa, #c3cfe2);
    }

    .logo-container {
      text-align: center;
      margin-bottom: 1rem;
    }

    .logo-img {
      max-width: 100px;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .logo-img:hover {
      transform: scale(1.05);
    }

    .school-name {
      font-weight: bold;
      color: #2c3e50;
      margin-top: 0.5rem;
      font-size: 1.1rem;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .input-group-text {
      background-color: #f8f9fa;
      border: none;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #4154f1;
    }

    .toggle-password {
      cursor: pointer;
    }

    .login-title {
      font-weight: 700;
      color: #4154f1;
    }

    .btn-primary {
      background-color: #4154f1;
      border: none;
    }

    .btn-primary:hover {
      background-color: #364fc7;
    }

    .forgot-password {
      font-size: 0.875rem;
    }

    .alert {
      font-size: 0.875rem;
    }
  </style>
</head>

<body>

  <main>
    <section class="min-vh-100 d-flex flex-column align-items-center justify-content-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">

            <!-- Logo -->
            <div class="logo-container">
              <a href="{{ route('login') }}">
                <img src="{{ asset('assets/img/sman-1.png') }}" alt="SMAN 1 Banjaran" class="logo-img">
                <div class="school-name">SMAN 1 Banjaran</div>
              </a>
            </div>

            <!-- Card -->
            <div class="card">
              <div class="card-body p-4">

                <!-- Alert Messages -->
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ $message }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $message }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Title -->
                <h5 class="text-center login-title mb-3">Login ke Akun Anda</h5>
                <p class="text-center text-muted small mb-4">Masukkan email dan password anda</p>

                <!-- Login Form -->
                <form action="{{ route('authenticate') }}" method="POST" class="needs-validation" novalidate>
                  @csrf

                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" placeholder="Email anda">
                    </div>
                    @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                      <span class="input-group-text toggle-password"><i class="fas fa-eye-slash"></i></span>
                      <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off" placeholder="Password anda">
                    </div>
                    @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                  </div>

                  <div class="text-end">
                    <a href="{{ route('forgot.password') }}" class="forgot-password text-decoration-none">Lupa password?</a>
                  </div>
                </form>

              </div>
            </div><!-- End Card -->

          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Back to Top -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  @include('backEnd.layouts.script')

  <script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function (element) {
      element.addEventListener('click', function () {
        const icon = this.querySelector('i');
        const input = document.querySelector('#password');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    });
  </script>

</body>

</html>
