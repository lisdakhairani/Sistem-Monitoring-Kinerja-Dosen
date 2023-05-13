@extends('welcome')

@section('title', 'akreditas')

@section('content')

<section id="blog" class="blog ">
    <div class="container" data-aos="fade-up">
        <div class="d-flex justify-content-center">
            <h2>Visi Misi <span style="color: #008374">Program Magister Ilmu Manajemen</span></h2>
        </div>
        <div class="row g-12">
            <div class="col-lg-12">
                @foreach ($visimisi as $item)
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
