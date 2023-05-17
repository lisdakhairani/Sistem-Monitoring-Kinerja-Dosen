@extends('welcome')

@section('title', 'Blog Post')

<style>
    .pagination .page-item.active .page-link {
        background-color: #008374;
        border-color: #008374;
        color: #008374;
    }
</style>
@section('content')
<!-- ======= Blog Section ======= -->
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4 posts-list">
            @foreach ($dataitem as $item)
            <div class="col-xl-4 col-md-6">
                <article>
                    <div class="post-img">
                        @if ($item->image)
                        <div style="max-height: 350px; overflow:hidden;">
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top mt-3"
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
                    </h5>
                    <a href="{{ route('post.show', $item->id) }}">Baca Selengkapnya
                    </a>
                </article>
            </div><!-- End post list item -->
            @endforeach
        </div><!-- End blog posts list -->
        <div class="mt-3">
            {{ $dataitem->links() }}
        </div>
    </div>
</section>
<!-- End Blog Section -->
@endsection