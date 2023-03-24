<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title . ' | ' : '' }} Presensi.ID</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ assets('css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ assets('libs/datatable/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ assets('libs/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ assets('css/styles.css') }}" />
    @routes
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{ route('home') }}" class="text-nowrap logo-img pt-2">
                        <img src="{{ asset('presensi.png') }}" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Beranda</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('home') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Master</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('jabatan.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-award"></i>
                                </span>
                                <span class="hide-menu">Jabatan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('karyawan.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-circle"></i>
                                </span>
                                <span class="hide-menu">Karyawan</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Presensi</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('presensi') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-face-id"></i>
                                </span>
                                <span class="hide-menu">Absensi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/pulang" aria-expanded="false">
                                <span>
                                    <i class="ti ti-report"></i>
                                </span>
                                <span class="hide-menu">Laporan</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-angles-right me-2"></i>
                                {{ $title ?? '' }}
                            </div>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/user.jpg') }}" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Profil Saya</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-key fs-6"></i>
                                            <p class="mb-0 fs-3">Kata Sandi</p>
                                        </a>
                                        <a href="{{ route('signout') }}"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="{{ assets('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ assets('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ assets('js/sidebarmenu.js') }}"></script>
    <script src="{{ assets('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ assets('libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ assets('libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ assets('libs/parsley/parsley.js') }}"></script>
    <script src="{{ assets('libs/parsley/i18n/id.js') }}"></script>
    <script src="{{ assets('libs/axios.min.js') }}"></script>
    <script src="{{ assets('js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
