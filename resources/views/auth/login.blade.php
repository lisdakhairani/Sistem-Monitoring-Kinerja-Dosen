{{-- <x-guest-layout> --}}

    <html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
        data-assets-path="../assets/" data-template="vertical-menu-template-free">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Login</title>

        <meta name="description" content="" />
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

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/img/logo-unimal.png" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="../assets/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
        <!-- Helpers -->
        <script src="../assets/vendor/js/helpers.js"></script>

        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="../assets/js/config.js"></script>
    </head>

    <body>
        <!-- Content -->

        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Register -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center">
                                <a href="/" class="app-brand-link gap-2">
                                    <img src="{{ asset('img/unimal_ppim.png') }}" alt="" width="100">
                                </a>
                            </div>
                            <!-- /Logo -->

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="form-label" />
                                    <x-text-input id="email" class="block mt-1 w-full form-control" type="email"
                                        name="email" :value="old('email')" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Password')" class="form-label" />

                                    <x-text-input id="password" class="block mt-1 w-full form-control" type="password"
                                        name="password" required autocomplete="current-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Remember Me -->
                                <div class="block mt-4">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox"
                                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                            name="remember">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me')
                                            }}</span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="btn btn-success d-grid w-100">
                                        {{ __('Log in') }}
                                    </x-primary-button>
                                </div>
                                {{-- <div class="flex items-center justify-between mt-4">
                                    @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                    <br>
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="{{ route('register') }}">
                                        {{ __('Don’t have an account? Register Now') }}
                                    </a>
                                    @endif
                                </div> --}}
                            </form>
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
        </div>

        {{--
</x-guest-layout> --}}
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="../assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="../assets/js/main.js"></script>
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

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
