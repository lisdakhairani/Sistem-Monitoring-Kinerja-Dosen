<footer id="footer" class="footer mt-2">

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-info">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span>PMIM</span>
                </a>
                <p>Program Magister Ilmu Manajemen</p>
                <div class="social-links d-flex mt-4">
                    <a href="#" class="twitter"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Profil</h4>
                <ul>
                    <li><a href="https://unimal.ac.id/" target="_black">UNIMAL</a></li>
                    <li><a href="https://taiwanhalal.com/" target="_black">Taiwan Halal</a></li>
                    <li><a href="https://sisteminformasi.unimal.ac.id/" target="_black">Sistem Informasi</a></li>
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
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ url('/contact') }}">About us</a></li>
                    <li><a href="{{ url('/blog-posts') }}">Artikel</a></li>
                    <li><a href="{{ url('/produks') }}">Gallery</a></li>
                    <li><a href="{{ url('/cara-pemakaian') }}">Pertanyaan Populer</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Contact Us</h4>
                <p>
                    A108 Adam Street <br>
                    New York, NY 535022<br>
                    United States <br><br>
                    <strong>Phone:</strong> +1 5589 55488 55<br>
                    <strong>Email:</strong> info@example.com<br>
                </p>

            </div>

        </div>
    </div>

    <div class="container mt-4">
        <div class="copyright">
            &copy; Copyright <strong><span>ppimfe</span></strong>. 2022 -
            <script>
                document.write(new Date().getFullYear());
            </script>
        </div>
        <div class="credits">
            Designed by <a href="https://ppimfe.unimal.ac.id/">ppimfe</a>
        </div>
    </div>

</footer>