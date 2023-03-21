<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Presensiku</title>
    <link rel="stylesheet" href="{{ assets('css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ assets('css/styles.css') }}" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{ url('/') }}"
                                    class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ assets('logo.png') }}" width="180" alt="">
                                </a>
                                <form action="{{ route('login.post') }}" autocomplete="on" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Email</label>
                                        <input type="text" class="form-control @error('email')is-invalid @enderror"
                                            name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Kata Sandi</label>
                                        <input type="password"
                                            class="form-control @error('password')is-invalid @enderror" name="password">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value="1"
                                                name="remender" id="remender">
                                            <label class="form-check-label text-dark" for="remender">
                                                Ingatkan saya
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-pill">Sign In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ assets('libs/jquery/dist/jquery.js') }}"></script>
    <script src="{{ assets('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
