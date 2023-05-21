@extends('welcome')
@section('title', 'Prestasi Mahasiswa')
@section('content')

<section id="recent-posts" class="recent-posts sections-bg">
    <div class="container">

        <div class="section-header d-flex justify-end">
            <h2>Prestasi Mahasiswa</h2>
        </div>

        <div class="row gy-4">
            @foreach ($prestasimhs as $item)
            <div class="col-xl-4 col-md-6">
                <article>
                    <div class="post-img">
                        <a href="{{ asset('storage/' . $item->image) }}" data-gallery="portfolio-gallery-app"
                            class="glightbox">
                            <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                        </a>
                        {{-- <img src="{{ asset('storage/' . $item->image) }}" alt="" class="img-fluid"> --}}
                    </div>
                    <div class="d-flex justify-content-between">
                        {{-- <p class="post-category text-success fw-semibold">{{ $item->category->name }}</p> --}}
                    </div>
                    <h5 class="title">
                        {{ $item->title }}
                        {{-- <a href="{{ route('post.show', $item->id) }}">{{ $item->title }}</a> --}}
                        {{-- <a href="{{ route('post.show', ['name' => $item->name]) }}">{{ $item->title }}</a> --}}

                        </h2>
                    </h5>
                </article>
            </div><!-- End post list item -->
            @endforeach
        </div><!-- End recent posts list -->
    </div>
</section>

@endsection