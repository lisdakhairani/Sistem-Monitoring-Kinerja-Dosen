<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="'/assets/'"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>SMKD PMIM | @yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-unimal.png') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('img/unimal_ppim.png') }}" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS untuk z-index tinggi pada toast */
        .swal2-container {
            z-index: 99999 !important;
        }

        /* Pastikan konten utama memiliki z-index lebih rendah */
        .main-content {
            position: relative;
            z-index: 1;
        }

        /* Untuk navbar/fixed elements yang perlu di bawah toast */
        .navbar, .fixed-top {
            z-index: 100 !important;
        }

        /* Modal backdrop harus di bawah toast */
        .modal-backdrop {
            z-index: 9999 !important;
        }

        /* Modal content harus di bawah toast tapi di atas backdrop */
        .modal {
            z-index: 10000 !important;
        }
    </style>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

        <!-- Bootstrap CSS (di head) -->

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
    {{-- trix --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/trix.css') }}">
    <script type="text/javascript" src="{{ asset('assets/js/trix.js') }}"></script>
    <!-- Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">

                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('img/unimal_ppim.png') }}" alt="ppimfe" width="200" class="rounded">
                        </span>
                        {{-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Miti</span> --}}
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">

                    @if (Auth::user()->is_admin == 1)
                    <li class="menu-item mt-4 @if (isset($menuDashbordAdmin)) {{ $menuDashbordAdmin }} @endif">
                        <a href="{{ route('dashboard.admin') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item  @if (isset($menuSemester)) {{ $menuSemester }} @endif">
                        <a href="{{ route('semester.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div data-i18n="Semester">Semester</div>
                        </a>
                    </li>
                    <li class="menu-item @if (isset($menuMataKuliah)) {{ $menuMataKuliah }} @endif">
                        <a href="{{ route('mata-kuliah.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-book-open"></i>
                            <div data-i18n="Mata Kuliah">Mata Kuliah</div>
                        </a>
                    </li>
                    <li class="menu-item @if (isset($menuJabatanAkademik)) {{ $menuJabatanAkademik }} @endif">
                        <a href="{{ route('jabatan-akademik.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-certification"></i>
                            <div data-i18n="Jabatan Akademik">Jabatan Akademik</div>
                        </a>
                    </li>
                    <li class="menu-item @if (isset($menuPangkat)) {{ $menuPangkat }} @endif">
                        <a href="{{ route('pangkat.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-medal"></i>
                            <div data-i18n="Pangkat">Pangkat</div>
                        </a>
                    </li>
                    <li class="menu-item @if (isset($menuKinerja)) {{ $menuKinerja }} @endif">
                        <a href="{{ route('kinerja.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Kinerja Dosen">Kinerja Dosen</div>
                        </a>
                    </li>

                    <li class="menu-item  @if (request()->routeIs('akun-dosen.index') || request()->routeIs('akun-admin.index'))
                            open
                        @endif
                        " style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user-circle"></i>
                            <div data-i18n="Menu Akun">Akun</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item @if (isset($menuAdmin)) {{ $menuAdmin }} @endif">
                                <a href="{{ route('akun-admin.index') }}" class="menu-link">
                                    <div data-i18n="Admin">Data Admin</div>
                                </a>
                            </li>
                            <li class="menu-item @if (isset($menuDosen)) {{ $menuDosen }} @endif">
                                <a href="{{ route('akun-dosen.index') }}" class="menu-link">
                                    <div data-i18n="Dosen">Data Dosen</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif


                   {{-- Cek apakah user adalah non-admin --}}
                {{-- Cek apakah user adalah non-admin --}}
                    @if (Auth::user()->is_admin == 0)
                        <li class="menu-item mt-4  @if (isset($menuDashbordUser)) {{ $menuDashbordUser }} @endif">
                        <a href="{{ route('dashboard.user') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                        </li>

                       <li class="menu-item @if (
                            request()->routeIs('data-kinerja.*') ||
                            request()->routeIs('kinerja-penelitian.*') ||
                            request()->routeIs('kinerja-pengabdian.*') ||
                            request()->routeIs('kinerja-penunjang.*') ||
                            request()->routeIs('kinerja-pengajaran.*')
                        ) open @endif">

                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                                <div data-i18n="Kinerja">Kinerja</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item @if (isset($menuDataKinerja)) {{ $menuDataKinerja }} @endif">
                                    <a href="{{ route('data-kinerja.index') }}" class="menu-link">
                                        <div data-i18n="Form Kinerja (Awal)">Form Kinerja (Awal)</div>
                                    </a>
                                </li>
                                <li class="menu-item @if (isset($menuKinerjaPenelitian)) {{ $menuKinerjaPenelitian }} @endif">
                                    <a href="{{ route('kinerja-penelitian.index') }}" class="menu-link">
                                        <div data-i18n="Penelitian">Penelitian</div>
                                    </a>
                                </li>
                                <li class="menu-item @if (isset($menuKinerjaPengajaran)) {{ $menuKinerjaPengajaran }} @endif">
                                    <a href="{{ route('kinerja-pengajaran.index') }}" class="menu-link">
                                        <div data-i18n="Pengajaran">Pengajaran</div>
                                    </a>
                                </li>
                                <li class="menu-item @if (isset($menuKinerjaPengabdian)) {{ $menuKinerjaPengabdian }} @endif">
                                    <a href="{{ route('kinerja-pengabdian.index') }}" class="menu-link">
                                        <div data-i18n="Pengabdian">Pengabdian</div>
                                    </a>
                                </li>
                                <li class="menu-item @if (isset($menuKinerjaPenunjang)) {{ $menuKinerjaPenunjang }} @endif">
                                    <a href="{{ route('kinerja-penunjang.index') }}" class="menu-link">
                                        <div data-i18n="Penunjang Lainnya">Penunjang Lainnya</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item @if (isset($menuArsip)) {{ $menuArsip }} @endif">
                            <a href="{{ route('arsip.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-folder-open"></i>
                                <div data-i18n="Arsip Kinerja">Arsip Kinerja</div>
                            </a>
                        </li>
                    @endif


                    <li class="menu-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="button" class="menu-link btn btn-link text-start p-0" style="border: none; background: none; width: 100%;" onclick="confirmLogout()">
                                <i class="menu-icon tf-icons bx bx-log-out"></i>
                                <div data-i18n="Logout">Logout</div>
                            </button>
                        </form>
                    </li>

                    <!-- Tambahkan script SweetAlert2 di bagian head atau sebelum penutup body -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        function confirmLogout() {
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: "Apakah Anda yakin ingin keluar dari sistem?",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#008080', // Warna teal
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Keluar',
                                cancelButtonText: 'Batal',
                                background: 'rgba(255, 255, 255, 0.15)', // Transparan tipis
                                color: '#fff', // Warna teks putih
                                backdrop: `
                                    rgba(0,0,0,0.4)
                                    url("https://sweetalert2.github.io/images/nyan-cat.gif")
                                    left top
                                    no-repeat
                                `,
                                customClass: {
                                    popup: 'swal-glass'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('logout-form').submit();
                                }
                            });
                        }
                    </script>

                    <style>
                        /* Efek Glassmorphism */
                        .swal-glass {
                            backdrop-filter: blur(10px);
                            -webkit-backdrop-filter: blur(10px);
                            border-radius: 12px;
                            border: 1px solid rgba(255, 255, 255, 0.3);
                        }
                    </style>



                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
               <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        {{--Semester, tahun, tanggal, dan jam--}}
                        @php
                            $semester = \App\Models\Semester::where('status', 1)->first();
                        @endphp

                        <div class="d-flex flex-column me-3">
                            @if($semester)
                                <p class="fw-bold text-success mb-0" style="font-size: 12pt;">{{ $semester->nama_semester }}  {{ $semester->tahun_ajaran }}</p>
                            @endif
                            <div class="d-flex align-items-center">
                                <p class="fw-bold mb-0" id="tanggal"></p>
                                <p class="text-primary mx-2 mb-0" id="jam"></p>
                            </div>
                        </div>

                        <script>
                            function updateClock() {
                                var now = new Date();

                                var jam = now.getHours();
                                var menit = now.getMinutes();
                                var detik = now.getSeconds();

                                var tanggal = now.getDate();
                                var bulan = now.getMonth() + 1; // Ingat, bulan dimulai dari 0 (Januari = 0)
                                var tahun = now.getFullYear();

                                // Mengatur format waktu
                                jam = (jam < 10) ? "0" + jam : jam;
                                menit = (menit < 10) ? "0" + menit : menit;
                                detik = (detik < 10) ? "0" + detik : detik;

                                // Mengatur format tanggal
                                bulan = (bulan < 10) ? "0" + bulan : bulan;
                                tanggal = (tanggal < 10) ? "0" + tanggal : tanggal;

                                var waktu = jam + ":" + menit + ":" + detik;
                                var tanggalFormat = tanggal + "/" + bulan + "/" + tahun;

                                // Memperbarui elemen HTML dengan waktu dan tanggal
                                document.getElementById("jam").innerHTML = waktu;
                                document.getElementById("tanggal").innerHTML = tanggalFormat;

                                // Memperbarui setiap detik
                                setTimeout(updateClock, 1000);
                            }

                            // Memanggil fungsi updateClock saat halaman dimuat
                            window.onload = updateClock;
                        </script>

                        @auth
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->

                            <li class="nav-item lh-1 me-3">
                                <strong>
                                    Welcome, {{ auth()->user()->name }}
                                </strong>
                            </li>

                            <!-- User -->
                            @include('home.userNavbar')
                            <!--/ User -->
                        </ul>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        @endauth
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                SMKD PPIM 2025 -
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        {{-- <div class="layout-overlay layout-menu-toggle"></div>
        <div class="buy-now">
            <a href="https://wa.me/082267429797?text=Assalamualaikum%20wr.wb%20saya%20anggota%20Miti%20Community"
                target="_blank" class="btn btn-primary btn-buy-now"> Chats Admin <i class="bi bi-whatsapp"></i></a>
        </div> --}}
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- Bootstrap JS (di bawah sebelum </body>) -->


    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @foreach(['success', 'error', 'info', 'warning'] as $type)
    @if(session($type))
        <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: {{ $type == 'error' ? 5000 : ($type == 'warning' ? 4000 : 3000) }},
                    timerProgressBar: true,
                    customClass: {
                        popup: 'high-zindex-toast'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                        // Force higher z-index
                        toast.style.zIndex = '999999';
                    }
                });

                Toast.fire({
                    icon: '{{ $type }}',
                    title: '{{ session($type) }}',
                    background: '{{ $type == 'error' ? '#fff6f6' : ($type == 'warning' ? '#fff9f0' : ($type == 'info' ? '#f0f9ff' : '#f8fff0')) }}',
                    color: '#333'
                });
            </script>
        @endif
    @endforeach
</body>

</html>
