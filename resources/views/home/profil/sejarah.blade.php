@extends('welcome')

@section('title', 'Sejarah PMIM')

@section('content')

<section id="blog" class="blog ">
    <div class="container" data-aos="fade-up">
        <div class="row g-12">
            <div class="col-lg-12">
                @foreach ($sejarah as $item)
                <article class="blog-details">
                    <div class="content" style="text-align: justify">
                        {!! $item->body !!}
                    </div><!-- End post content -->
                </article><!-- End blog post -->
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
