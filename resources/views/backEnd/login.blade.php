<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login - SMAN 1 Banjaran</title>

  <link href="{{ asset('assets/img/sman 1.png') }}" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(120deg, #4154f1, #6a82fb);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-size: 300% 300%;
      animation: gradientAnimation 8s ease infinite;
    }

    @keyframes gradientAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .card {
      border: none;
      border-radius: 1rem;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      color: #fff;
      padding: 2rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .logo-img {
      max-width: 100px;
      border-radius: 50%;
      margin-bottom: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .logo-img:hover { transform: scale(1.1); }

    .login-title {
      font-weight: 700;
      font-size: 1.5rem;
      color: #fff;
      text-align: center;
      position: relative;
      margin-bottom: 1rem;
    }

    .login-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: #fff;
      margin: 8px auto;
      border-radius: 5px;
    }

    .form-control {
      border-radius: 8px;
      border: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
      outline: none;
      border: 1px solid #fff;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    .btn-primary {
      background: linear-gradient(to right, #6a82fb, #4154f1);
      border: none;
      padding: 10px;
      border-radius: 8px;
      transition: 0.3s;
      font-weight: 600;
    }

    .btn-primary:hover {
      background: linear-gradient(to right, #4154f1, #6a82fb);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .forgot-password {
      color: #fff;
      font-size: 0.9rem;
    }

    .forgot-password:hover { text-decoration: underline; }
  </style>
</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="text-center">
          <img src="{{ asset('assets/img/sman-1.png') }}" class="logo-img" alt="Logo SMAN 1 Banjaran">
          <h5 class="text-white fw-bold">SMAN 1 Banjaran</h5>
        </div>

        <div class="card mt-3">
          <h4 class="login-title">Login ke Akun Anda</h4>

          <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="text-white">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
            </div>

            <div class="mb-3">
              <label class="text-white">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="text-end mt-2">
              <a href="{{ route('forgot.password') }}" class="forgot-password">Lupa password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
