@extends('welcome')

@section('title', 'Galeri Akademik')
@section('content')

<section id="portfolio" class="portfolio sections-bg">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2>
                Galery Program Magister Manajemen</h2>
        </div>

        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
            data-portfolio-sort="original-order" data-aos="fade-up" data-aos-delay="100">

            <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
                data-portfolio-sort="original-order" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 portfolio-container">
                    @foreach ( $galeriaka as $item)
                    <div class="col-xl-4 col-md-6 portfolio-item filter-product">
                        <div class="portfolio-wrap">
                            <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                                class="glightbox">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $galeriaka->withQueryString()->links() }}
                </div>

                <!-- End Portfolio Container -->
            </div>
            <!-- End Portfolio Container -->
        </div>
    </div>
</section>
@endsection
