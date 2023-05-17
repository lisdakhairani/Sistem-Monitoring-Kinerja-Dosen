<section id="topbar" class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">

            <div id="google_translate_element" style="float: right; margin-top: 5px">
                <div class="skiptranslate goog-te-gadget" dir="ltr" style="">
                    <div id=":0.targetLanguage" class="goog-te-gadget-simple" style="white-space: nowrap">
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                function googleTranslateElementInit() {
                                new google.translate.TranslateElement({
                                        pageLanguage: "ID",
                                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                    },
                                    "google_translate_element"
                                );
                            }
            </script>

            <script type="text/javascript"
                src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
            </script>

        </div>
        <div class="social-links d-none d-md-flex align-items-center">
            <a class="fw-semibold" href="https://unimal.ac.id/" target="_black">Universitas Malikussaleh</a>
            <a class="fw-semibold" href="https://feb.unimal.ac.id/" target="_black">Fakultas Ekonomi</a>
        </div>
    </div>
</section>
<!-- End Top Bar -->
{{-- header --}}
<header id="header" class="header d-flex align-items-center">

    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('/img/unimal_ppim.png') }}" alt="Miti" class="rounded">
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                {{-- <li><a href="{{ url('/produks') }}">Gallery</a></li> --}}
                <li class="dropdown"><a href="#"><span>Profil</span> <i
                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="{{ url('/blog-posts') }}">Berita</a></li>
                        <li><a href="{{ url('/sejarah-pmim') }}">Sejarah PMIM</a></li>
                        <li><a href="{{ url('/produks') }}">Sarana dan prasarana</a></li>
                        <li><a href="{{ url('/visi-misi-tujuan') }}">Visi, Misi, Tujuan</a></li>
                        <li><a href="{{ url('/profil-lulusan') }}">Profil Lulusan</a></li>
                        <li><a href="{{ url('/kerja-sama-aliansi') }}">Kerja Sama & Aliansi</a></li>
                        <li><a href="{{ url('/rencana-strategi') }}">Rencana Strategi</a></li>
                        <li><a href="{{url('/truktur-organisasi')}}">Struktur Organisasi</a></li>
                        <li><a href="{{ url('/page-staf') }}">Staf</a></li>
                        <li><a href="{{ url('/daftar-dosen') }}">Daftar Dosen</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Akademik</span> <i
                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="https://elearning.unimal.ac.id/" target="_balck">E-Learning</a></li>
                        <li><a href="http://portal.unimal.ac.id/" target="_black">Portal Akademik</a></li>
                        <li><a href="{{ url('/akreditas-ppimfe') }}">Akreditasi</a></li>
                        <li><a href="{{ url('/truktur-kurikulum') }}">Struktur Kurikulum</a></li>
                        <li><a href="{{ url('/kelender-akademik') }}">Kalender Akademik</a></li>
                        <li><a href="{{ url('/panduan-akademik') }}">Panduan Akademik</a></li>
                        <li><a href="{{ url('/galeri-akademik') }}">Galeri</a></li>
                        <li><a href="{{ url('/download-akademik') }}">Download</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Kemahasiswaan</span> <i
                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul>
                        <li><a href="{{ url('/prestasi-mahasiswa') }}">Prestasi Mahasiswa</a></li>
                        <li><a href="{{url('/tracer-study')}}">Tracer Study</a></li>
                        <li><a href="{{url('/publikasiuser')}}">Publikasi</a></li>
                    </ul>
                </li>
                <li><a href="https://ojs.unimal.ac.id/jmi" target="_black">J-MIND</a></li>

                <li class="dropdown"><a href="#"><span>Download</span> <i
                            class="bi bi-chevron-down dropdown-indicator"></i></a>
                    <ul class="dropdown-active">
                        <li><a href="{{ url('/akreditasi-akademik') }}">Dokumen Akreditasi`</a></li>
                        <li><a href="{{ url('/download-adminis') }}">Dokumen Administrasi</a></li>
                        <li><a href="{{ url('/download-penjaminan-mutu') }}">Dokumen Penjaminan <br> Mutu</a></li>
                        </a>
                    </ul>
                </li>
                {{-- <li><a href="{{ url('/contact') }}">Contact</a></li> --}}
            </ul>
        </nav><!-- .navbar -->

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
</header>