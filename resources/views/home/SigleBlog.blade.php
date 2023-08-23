@extends('welcome')

@section('title', 'Posts')

@section('content')
<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="blog-details">
                    <div class="post-img">
                        @if ($post->image != '')
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="" class="img-fluid">
                        </div>
                        @else
                        <div class="mb-2">
                            <img src="{{ asset('images/avatar.jpg') }}" alt="" width="200px">
                        </div>
                        @endif
                    </div>
                    <input type="text" id="linkBerita" value="{{ route('post.show', $post->id) }}" readonly hidden>
                    <button class="copy-button btn btn-success" onclick="copyLink()"><i
                            class="bi bi-share"></i></button>

                    <script>
                        function copyLink() {
                            var linkBerita = document.getElementById("linkBerita");
                            linkBerita.removeAttribute('hidden'); // Menghapus atribut hidden
                            linkBerita.select();
                            linkBerita.setSelectionRange(0, 99999);
                            document.execCommand("copy");
                            linkBerita.setAttribute('hidden', 'true'); // Menambahkan kembali atribut hidden
                            alert("Link berita telah disalin: " + linkBerita.value);
                        }
                    </script>



                    <h2 class="title">{{ $post->title }}
                    </h2>

                    <div class="meta-top">
                        <ul>
                            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                                    href="{{ url('/blog-posts') }}">{{ $post->author->name }}</a></li>

                            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                                    href="{{ url('/blog-posts') }}">{{ $post->category->name }}</a></li>

                            <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time
                                        datetime="{{ $post->created_at->format('Y-m-d') }}">{{
                                        $post->created_at->format('M j, Y') }}</time></a>
                            </li>
                        </ul>
                    </div><!-- End meta top -->
                    <div class="content">
                        {{-- <article class="my-3 fs-5"> --}}
                            {!! $post->body !!}
                            {{-- </article> --}}
                    </div><!-- End post content -->
                </article><!-- End blog post -->
            </div>

            <div class="col-lg-4">

                <div class="sidebar">
                    <div class="sidebar-item recent-posts">
                        <h3 class="sidebar-title">Recent Posts</h3>
                        @foreach ($silderpost as $g)
                        <div class="mt-3">
                            <div class="post-item mt-3">
                                <img src="{{ asset('storage/' . $g->image) }}" alt="">
                                <div>
                                    <h4><a href="{{ route('post.show', $g->id) }}">{{ htmlspecialchars($g->title)
                                            }}</a>
                                    </h4>
                                    <time datetime="{{ $g->created_at->format('Y-m-d') }}">{{
                                        $g->created_at->format('M j, Y') }}</time>
                                </div>
                            </div><!-- End recent post item-->
                        </div>
                        @endforeach
                    </div><!-- End sidebar recent posts-->
                </div><!-- End Blog Sidebar -->
            </div>
        </div>
    </div>
</section>
@endsection