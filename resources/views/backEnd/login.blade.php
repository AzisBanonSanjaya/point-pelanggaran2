<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Login - Log In Megastore</title>
        <meta content="Log In Megastore" name="description">
        <meta content="Log In Megastore" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('assets/img/icon-login.png')}}" rel="icon">
        <link href="{{ asset('assets/img/icon-login.png')}}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
        <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
        <style>
            .img-logo {
                padding: 0.25rem;
                background-color: transparent;
                border: transparent;
                border-radius: 0.25rem;
                max-width: 80%;
                height: auto;
                margin: 0 auto;
            }
        </style>
      </head>
	<body>
    <main>
        <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="{{route('login')}}" class="d-flex align-items-center w-auto">
                    <img src="{{ asset('assets/img/login.png')}}" alt="Log In Megastore" class="img-logo">
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">
                    <div class="card-body">
                    <div class="pt-4 pb-2">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                        <p class="text-center small">Enter your Email & Password to login</p>
                    </div>

                    <form action="{{route('authenticate')}}" method="post" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Email</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" autocomplate="off" id="email" placeholder="Enter your Email Address">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text toggle-password" toggle="#password-field" id="inputGroupPrepend">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" autocomplate="off" id="password" placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </div>
                        <div class="col-12">
                            <p class="mb-0 text-end"><a href="{{route('forgot.password')}}">Lupa Password ?</a></p>
                          </div>
                    </form>

                    </div>
                </div>

                </div>
            </div>
            </div>

        </section>

        </div>
    </main><!-- End #main -->
     <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    @include('backEnd.layouts.script')
    <script>
        $("body").on('click', '.toggle-password', function() {
            $(this).find("i").toggleClass("fa-eye-slash fa-eye");
            var passInput=$("#password");
            if(passInput.attr('type')==='password')
            {
                passInput.attr('type','text');
            }else{
                passInput.attr('type','password');
            }
        })
    </script>
</body>

</html>
