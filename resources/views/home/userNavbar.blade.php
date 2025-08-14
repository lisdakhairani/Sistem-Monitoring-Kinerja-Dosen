@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    $user = Auth::user();
    $photoExists = $user->photos && Storage::disk('public')->exists('avatars/' . $user->photos);

    // Buat inisial nama
    $nameParts = explode(' ', trim($user->name));
    if (count($nameParts) === 1) {
        // Satu kata → ambil huruf pertama & terakhir
        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[0], -1));
    } else {
        // Lebih dari satu kata → ambil maksimal 2 huruf awal dari 2 kata pertama
        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
    }
@endphp

<li class="nav-item navbar-dropdown dropdown-user dropdown @if(isset($adminPenelitian)) {{ $adminPenelitian }} @endif">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        @if ($photoExists)
            <img src="{{ asset('storage/avatars/' . $user->photos) }}"
                 alt="Foto Profil"
                 class="rounded-circle"
                style="width: 40px; height: 40px; font-weight: bold; font-size: 16px;">
        @else
            <div class="avatar avatar-online">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width: 40px; height: 40px; font-weight: bold; font-size: 16px;">
                    {{ $initials }}
                </div>
            </div>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="bx bx-user me-2"></i>
                <span class="align-middle">Profil Saya</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="button" class="dropdown-item" onclick="confirmLogout()">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                </button>
            </form>

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

        </li>
    </ul>
</li>
