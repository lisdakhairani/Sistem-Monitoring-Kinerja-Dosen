<footer id="footer" class="footer mt-2">

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-info">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span>PMIM</span>
                </a>
                <p>Program Magister Ilmu Manajemen</p>
                <div class="social-links d-flex mt-4">
                    {{-- <a href="#" class="twitter"><i class="bi bi-tiktok"></i></a> --}}
                    {{-- <a href="#" class="facebook"><i class="bi bi-facebook"></i></a> --}}
                    <a href="https://www.instagram.com/univ.malikussaleh/" target="_black" class="instagram"><i
                            class="bi bi-instagram"></i></a>
                    {{-- <a href="#" class="linkedin"><i class="bi bi-whatsapp"></i></a> --}}
                </div>
                <a href="/" class="mt-2">
                    <img src="/img/logo_unimal.png" alt="" width="100">
                </a>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Profil</h4>
                <ul>
                    <li><a href="https://unimal.ac.id/" target="_black">Universitas Malikussaleh
                        </a></li>
                    <li><a href="https://feb.unimal.ac.id/" target="_black">Fakultas Ekonomi dan Bisnis Unimal</a></li>
                    <li><a href="https://elearning.unimal.ac.id/" target="_black">Elearning</a></li>
                    <li><a href="http://portal.unimal.ac.id/" target="_black">Portal</a></li>
                    <li><a href="https://journal.unimal.ac.id/j-mind" target="_black">Jurnal J-Mind</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li>
                        @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0">
                            @auth
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            @else
                            <a href="{{ route('login') }}">Login
                            </a>
                            {{-- <a href="">|</a> --}}
                            @if (Route::has('register'))
                            {{-- <a href="{{ route('register') }}">Register</a> --}}
                            @endif
                            @endauth
                        </div>
                        @endif
                    </li>
                    <li><a href="{{ url('/blog-posts') }}">Artikel</a></li>
                    <li><a href="{{ url('/produks') }}">Sarana & Prasarana</a></li>
                    <li><a href="{{ url('/visi-misi-tujuan') }}">Visi Misi</a></li>
                    <li><a href="{{ url('/prestasi-mahasiswa') }}">Prestasi Mahasiswa</a></li>
                    {{-- <li><a href="{{ url('/contact') }}">About us</a></li> --}}
                    {{-- <li><a href="{{ url('/cara-pemakaian') }}">Pertanyaan Populer</a></li> --}}
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Contact Us</h4>
                <p>
                    Jl. Tgk Chik Ditiro No. 26, <br>
                    Lancang Garam, Lhokseumawe <br>
                    ACEH - Indonesia <br>
                    <strong>Phone:</strong> +62 645 40210<br>
                    <strong>Fax:</strong> +62 645 40211<br>
                    <strong>Email:</strong> ppim@fe-unimal.org<br>
                    <strong>Website:</strong> http://ppimfe.unimal.ac.id<br>
                </p>

            </div>

        </div>
    </div>

    <div class="container mt-4">
        <div class="copyright">
            &copy; Copyright <strong><span>PMIM</span></strong>. 2015 -
            <script>
                document.write(new Date().getFullYear());
            </script>
        </div>
        <div class="credits">
            Designed by <a href="https://ppimfe.unimal.ac.id/">PMIM</a>
        </div>
    </div>

</footer>