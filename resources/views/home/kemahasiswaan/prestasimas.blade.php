@extends('welcome')
@section('title', 'Prestasi Mahasiswa')
@section('content')

<section id="recent-posts" class="recent-posts sections-bg">
    <div class="container">

        <div class="section-header d-flex justify-end">
            <h2>Prestasi Mahasiswa</h2>
        </div>

        <div class="row gy-4">
            @forelse ($prestasimhs as $item)
            <div class="col-xl-4 col-md-6">
                <article>
                    <div class="post-img">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="" class="img-fluid">
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
                {{--
            </div><!-- End post list item --> --}}
            @empty
            <div class="page-wrap d-flex flex-row align-items-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            {{-- <span class="display-1 d-block">404</span>
                            <div class="mb-4 lead">not found.</div> --}}
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div><!-- End recent posts list -->
    </div>
</section>

@endsection