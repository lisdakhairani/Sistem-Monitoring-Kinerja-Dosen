@extends('welcome')

@section('content')

    {{-- <style>
        .video-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            /* Atur lebar maksimum video */
            margin: 0 auto;
            /* Membuat video menjadi tengah secara horizontal */
            /* overflow: hidden; */
        }

        video {
            width: 100%;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style> --}}

    <section id="hero" class="hero">
        <div class="container position-relative">
            <div class="row gy-5">
                <div
                    class="mt-5 col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
                    <h2>Program Magister Ilmu Manajemen</h2>
                    <p>
                        Menjadi Program Studi Magister yang Berdaya Saing dalam Pengembangan Ilmu Manajemen Berbasis Potensi
                        Lokal Di Asia.
                    </p>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        @if (Route::has('login'))
                            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                @auth
                                    <a href="{{ route('dashboard') }}"
                                        class="text-sm text-gray-700 dark:text-gray-500">Dashboard</a>
                                @else
                                    {{-- <a href="{{ route('login') }}"
                            class="text-sm text-gray-700 dark:text-gray-500 underline btn-get-started btn-sm">Login</a>
                        --}}
                                    @if (Route::has('register'))
                                        <a href="{{ url('/visi-misi-tujuan') }}"
                                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline btn-get-started fw-bold">Read
                                            More</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    {{-- <img src="/img/selamat-datang.png" class="img-fluid rounded" alt=""> --}}
                    {{-- <div class="video-container mt-5"> --}}
                    <video id="intro-video" controls autoplay
                        style="max-width: 100%;
                        height: auto;
                        width: 100%;
                        display: block;
                        margin: 0 auto;">
                        <source src="{{ asset('img/intro.mp4') }}" type="video/mp4">
                        <source src="{{ asset('img/intro.mp4') }}" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>

                    {{-- </div> --}}

                </div>
            </div>
        </div>
    </section>

    {{-- logo kerja sama --}}
    @include('home.Clients-Section')

    {{-- Iklan --}}
    @include('home.StatsCounterSection')


    {{-- Artikel --}}
    <section id="recent-posts" class="recent-posts sections-bg">
        <div class="container">
            <div class="section-header d-flex justify-end">
                <h2>Informasi Baru</h2>

            </div>
            <div class="row gy-4">
                @forelse ($dataList as $item)
                    <div class="col-xl-4 col-md-6">
                        <article>
                            <div class="post-img">
                                @if ($item->image)
                                    <div style="max-height: 350px; overflow:hidden;">
                                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                            alt="{{ $item->category->name }}" class="img-fluid " width="100%">
                                    </div>
                                @else
                                    <img src="{{ asset('/img/blog-bg.jpg') }}" alt="Avatar" width="100%">
                                @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="post-category text-success fw-semibold">{{ $item->category->name }}</p>
                                <p class="post-date">
                                    <time datetime="{{ $item->created_at->format('Y-m-d') }}"><i class="bi bi-clock"></i>
                                        {{ $item->created_at->format('M j, Y') }}</time>
                                </p>
                            </div>
                            <h5 class="title">
                                <a href="{{ route('post.show', $item->id) }}">{{ $item->title }}</a>
                                </h2>
                            </h5>
                            <a href="{{ route('post.show', $item->id) }}">Baca Selengkapnya
                            </a>
                        </article>
                    </div><!-- End post list item -->
                @empty
                    <div class="page-wrap d-flex flex-row align-items-center">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div><!-- End recent posts list -->

            <div class="d-flex justify-content-center mt-4">
                <a href="{{ url('/blog-posts') }}" class=" btn btn-outline-success rounded">All</a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById("intro-video");
            video.muted = false; // Hapus atribut muted agar ada suara saat autoplay
        });
    </script>
@endsection
