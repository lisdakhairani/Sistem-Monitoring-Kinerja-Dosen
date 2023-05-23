<!-- ======= Clients Section ======= -->
<section id="clients" class="clients">
    <div class="container">
        <div class="clients-slider swiper">
            <div class="swiper-wrapper align-items-center">
                @foreach ($logo as $itemlogo)
                <div class="swiper-slide">
                    <a href="{{ $itemlogo->title }}" target="_black">
                        <img src="{{ asset('storage/' . $itemlogo->image) }}" class="img-fluid" alt="">
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section><!-- End Clients Section -->