@extends('welcome')

@section('title', 'Publikasi Nasional')

@section('content')

    <section id="blog" class="blog mt-3">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <article class="entry entry-single">
                        <div class="section-title mt-3">
                            <h2>Publikasi Nasional</h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Form untuk memilih kategori -->
                                <form action="{{ route('publikasiuser') }}" method="GET">
                                    <div class="mb-3">
                                        <select name="category" id="category" class="form-select"
                                            onchange="this.form.submit()">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (request()->get('category') == $category->id) selected @endif>{{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6">
                                {{-- Search --}}
                                <div class="col-12 col-sm-12 col-md-12">
                                    <form action="" method="GET"
                                        class="d-flex justify-content-center justify-items-center">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="keyword"
                                                placeholder="Cari Nama" aria-label="Keyword">
                                            <button class="input-group-text btn btn-success" id="basic-addon1"><i
                                                    class="bi bi-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tahun</th>
                                        <th scope="col">Program Studi</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Nama Jurnal</th>
                                        <th scope="col">Nama Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lembaga as $post)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $post->category->name }}</td>
                                            <td>{{ $post->program_studi }}</td>
                                            <td>{{ $post->nama }}</td>
                                            <td>{{ $post->kategori }}</td>
                                            <td>{{ $post->nama_jurnal }} <br><br> <a href="{{ $post->link_jurnal }}" class="text-success mt-3" target="_black">{{ $post->link_jurnal }}</a></td>
                                            <td>{{ $post->nama_judul }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </article>
                </div>
                {{ $lembaga->withQueryString()->links() }}
            </div>
        </div>
    </section>
@endsection
