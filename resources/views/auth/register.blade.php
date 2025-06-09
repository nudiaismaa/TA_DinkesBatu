<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    @include('include.style')
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/smartwizard.css') }}">
    <style>
        body {
            background-image: url("{{ asset('assets/images/bg-auth.svg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
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
                <h5 class="card-title text-center fw-semibold">Daftar Dulu Yuk</h5>
                <div id="smartwizard">
                    <ul class="nav nav-progress my-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#step-1">
                                <div class="num">1</div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-2">
                                <span class="num">2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-3">
                                <span class="num">3</span>
                            </a>
                        </li>
                    </ul>
                    <form action="{{ route('auth.register') }}" method="POST" class="form" id="form-register"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content">
                            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                <div class="mb-3">
                                    <label for="roleInput" class="form-label fw-semibold">Role</label>
                                    <select class="form-select" name="roles" id="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="name"
                                        placeholder="Masukkan Nama Anda">
                                </div>
                                <div class="mb-3">
                                    <label for="emailInput" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" id="emailInput" name="email"
                                        placeholder="email@gmail.com">
                                </div>
                            </div>
                            <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                <div class="mb-2">
                                    <label for="passwordInput" class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control" name="password" id="passwordInput"
                                        placeholder="********">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary-color w-100 d-none" id="btn-submit">Daftar</button>
                    </form>
                    <button class="btn btn-primary-color w-100" id="btn-next">Lanjut</button>
                </div>
                <div class="p-3 text-center">
                    <label>Sudah Punya Akun? <a href="{{ route('login') }}"
                            class="primary-color text-decoration-none">Masuk</a></label>
                </div>
            </div>
        </div>
    </div>
    @include('include.script')
    <script>
        $("#btn-next").on("click", function() {
            $("#smartwizard").smartWizard("next");
        });
        $("#smartwizard").on(
            "showStep",
            function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
                $(".sw-btn-next, .sw-btn-prev").hide();
                if (stepPosition === "last") {
                    $("#btn-next").hide(); // Sembunyikan tombol Next
                    $("#btn-submit").removeClass("d-none"); // Tampilkan tombol Submit
                } else {
                    $("#btn-next").show(); // Tampilkan tombol Next
                    $("#btn-submit").addClass("d-none"); // Sembunyikan tombol Submit
                }
            }
        );
        $(function() {
            // SmartWizard initialize
            $("#smartwizard").smartWizard({
                theme: "dots",
                justified: true,
                lang: {
                    next: "Lanjut",
                    previous: "Sebelumnya",
                },
            });
        });
    </script>
</body>

</html>
