@extends('welcome')

@section('title', 'Gallery')

@section('content')

<section id="portfolio" class="portfolio sections-bg">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2>
                Sarana & Prasarana</h2>
        </div>

        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
            data-portfolio-sort="original-order" data-aos="fade-up" data-aos-delay="100">

            <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
                data-portfolio-sort="original-order" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <ul class="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-product">Ruang Dosen</li>
                        <li data-filter=".filter-branding">Ruang Kelas</li>
                        <li data-filter=".filter-books">Ruang Rapat</li>
                        <li data-filter=".filter-adm">Ruang ADM</li>
                        <li data-filter=".filter-perpus">Ruang Perpustakaan</li>
                        <li data-filter=".filter-alumni">Seuramoe Alumni</li>
                    </ul><!-- End Portfolio Filters -->
                </div>

                <div class="row gy-4 portfolio-container">
                    @foreach ($dataProduk as $item)
                    @if ($item->category_produk_id == '1')
                    <div class="col-xl-4 col-md-6 portfolio-item filter-product">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                            <div class="portfolio-info">
                                <h4>
                                    <a href="{{ route('produks.show', $item->id) }}" title="More Details">{{
                                        $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    @elseif ($item->category_produk_id == '2')
                    <div class="col-xl-4 col-md-6 portfolio-item filter-branding">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                            <div class="portfolio-info">
                                <h4>
                                    <a href="{{ route('produks.show', $item->id) }}" title="More Details">{{
                                        $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    @elseif ($item->category_produk_id == '3')
                    <div class="col-xl-4 col-md-6 portfolio-item filter-books">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                            <div class="portfolio-info">
                                <h4>
                                    <a href="{{ route('produks.show', $item->id) }}" title="More Details">{{
                                        $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    @elseif ($item->category_produk_id == '4')
                    <div class="col-xl-4 col-md-6 portfolio-item filter-adm">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                            <div class="portfolio-info">
                                <h4>
                                    <a href="{{ route('produks.show', $item->id) }}" title="More Details">{{
                                        $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    @elseif ($item->category_produk_id == '5')
                    <div class="col-xl-4 col-md-6 portfolio-item filter-perpus">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                            <div class="portfolio-info">
                                <h4>
                                    <a href="{{ route('produks.show', $item->id) }}" title="More Details">{{
                                        $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    @elseif ($item->category_produk_id == '6')
                    <div class="col-xl-4 col-md-6 portfolio-item filter-alumni">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                            <div class="portfolio-info">
                                <h4>
                                    <a href="{{ route('produks.show', $item->id) }}" title="More Details">{{
                                        $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div><!-- End Portfolio Container -->

            </div>

            <!-- End Portfolio Container -->
        </div>
    </div>
</section>
@endsection