@extends('welcome')

@section('title', 'akreditasi')

@section('content')

<section id="blog" class="blog ">
    <div class="container" data-aos="fade-up">
        <h2 class="fw-semibold">Documen Akreditasi</h2>
        <div class="row g-12 mt-3">
            <div class="col-lg-12">
                @foreach ($UserAkreditasi as $item)
                <article class="blog-details mt-3">
                    <div class="content" style="text-align: justify">
                        {!! $item->body !!}
                        <embed class="embed-responsive-item mt-3" async='async'
                            src="{{ asset('storage/' . $item->filedata) }}#toolbar=0" download="{{ $item->body }}"
                            width="100%" height="450px"></embed>

                    </div><!-- End post content -->
                </article><!-- End blog post -->
                @endforeach
            </div>
            <div class="mt-3">
                {{ $UserAkreditasi->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
