@extends('welcome')

@section('title', 'Panduan Akademik')

@section('content')

<section id="blog" class="blog ">
    <div class="container" data-aos="fade-up">
        <h2 class="fw-semibold">Panduan Akademik</h2>
        <div class="row g-12 mt-2">
            <div class="col-lg-12">
                @foreach ($panduanakademik as $item)
                <article class="blog-details">
                    <div class="content" style="text-align: justify">
                        {!! $item->body !!}

                        <embed class="embed-responsive-item mt-3" async='async'
                            src="{{ asset('storage/' . $item->filedata) }}#toolbar=0" width="100%"
                            height="500px"></embed>

                    </div><!-- End post content -->
                </article><!-- End blog post -->
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection