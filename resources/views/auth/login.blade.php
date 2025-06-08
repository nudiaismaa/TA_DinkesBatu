<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    @include('include.style')
    <style>
        body {
            background-image: url("{{ asset('assets/images/bg-auth.svg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
            </a>
        </div>
    </nav>
    <div class="container-fluid d-flex flex-grow-1 justify-content-center align-items-start">
        <div class="col-lg-4 col-md-6 col-sm-8 col-10">
            <h1 class="m-5 text-center text-white fw-bold">Selamat Datang</h1>
            <div class="card p-3 shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title text-center fw-semibold">Silahkan Masuk Dulu</h5>
                    <form class="form" method="POST" action="{{ route('auth.login') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="emailInput" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="emailInput" value="{{ old('email') }}" placeholder="email@mail.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror @if(session('loginError')) is-invalid @endif"
                                id="passwordInput" placeholder="********">

                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if(session('loginError'))
                            <div class="invalid-feedback">{{ session('loginError') }}</div>
                            @endif
                        </div>
                        <button class="btn btn-primary-color w-100">Masuk</button>
                    </form>
                </div>
                <div class="p-3">
                    <label>Belum Punya Akun? <a href="{{ route('register') }}" class="primary-color text-decoration-none">Daftar
                            Dulu</a></label>
                </div>
            </div>
        </div>
    </div>

    @include('include.script')
</body>

</html>