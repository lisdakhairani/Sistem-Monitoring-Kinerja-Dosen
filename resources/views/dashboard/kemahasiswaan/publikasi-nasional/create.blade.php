@extends('layouts.admin_template')
@section('title', 'Publikasi Nasional')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Publikasi Nasional /</span> Add
        </h4>
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                            <div class="card-body">
                                <div class="col-lg-8">
                                    <form method="POST" action="{{ route('publikasi-nasional.store') }}"
                                        enctype="multipart/form-data" class="mt-5">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="program_studi" class="form-label">Program Studi</label>
                                            <input type="text" class="form-control @error('program_studi') is-invalid @enderror"
                                                id="program_studi" name="program_studi" required autofocus
                                                value="{{ old('program_studi') }}">
                                            @error('program_studi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="category" class="form-label">Pilih Tahun</label>
                                            <select name="category_id" class="form-select">
                                                @foreach ($categories as $category)
                                                    @if (old('category_id') == $category->id)
                                                        <option value="{{ $category->id }}" selected>{{ $category->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text"
                                                class="form-control @error('nama') is-invalid @enderror" id="nama"
                                                name="nama" required autofocus value="{{ old('nama') }}">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="kategori" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" id="kategori" name="kategori"
                                                aria-describedby="defaultFormControlHelp">
                                                <option value="Nasional Terakreditasi" == 'Nasional Terakreditasi' selected >
                                                    Nasional Terakreditasi</option>
                                                <option value="Nasional Terakreditasi & Lokal" == 'Nasional Terakreditasi & Lokal' selected >
                                                    Nasional Terakreditasi & Lokal</option>
                                            </select>
                                            @error('kategori')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label for="nama_jurnal" class="form-label">Nama Jurnal</label>
                                            <input type="text" class="form-control @error('nama_jurnal') is-invalid @enderror"
                                                id="nama_jurnal" name="nama_jurnal" required autofocus
                                                value="{{ old('nama_jurnal') }}">
                                            @error('nama_jurnal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="nama_judul" class="form-label">Nama Judul</label>
                                            <input type="text" class="form-control @error('nama_judul') is-invalid @enderror"
                                                id="nama_judul" name="nama_judul" required autofocus
                                                value="{{ old('nama_judul') }}">
                                            @error('nama_judul')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="link_jurnal" class="form-label">Link Judul</label>
                                            <input type="text" class="form-control @error('link_jurnal') is-invalid @enderror"
                                                id="link_jurnal" name="link_jurnal" required autofocus
                                                value="{{ old('link_jurnal') }}">
                                            @error('link_jurnal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <input type="submit" value="Tambah" id="save" name="save"
                                                class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        title.addEventListener('change', () => {
            fetch('/dashboard/posts/checkSlug?title=' + title.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug);
        });

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        });


        function proviewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
@endsection
