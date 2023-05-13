@extends('welcome')

@section('title', 'Truktur Organisasi')

@section('content')

<section id="blog" class="blog ">
    <div class="container" data-aos="fade-up">
        <h4>Truktur Organisasi</h4>
        <div class="row g-12 mt-4">
            <div class="col-lg-12">
                @foreach ($organnis as $item)
                <article class="blog-details mt-3">
                    <div class="content" style="text-align: justify">
                        <h2 class="fw-bold d-flex justify-content-center">{{ $item->title }}</h2>

                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top mt-3" alt=""
                            class="img-fluid ">

                    </div><!-- End post content -->
                </article><!-- End blog post -->
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
