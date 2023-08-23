@extends('layouts.admin_template')
@section('title', 'Publikasi Nasional')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Data Publikasi Nasional</h4>

        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($message = Session::get('failed'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Edit Publikasi Nasional</h5>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <form method="POST" action="{{ route('publikasi-nasional.update', $lembaga->id) }}" class="mt-5"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="mb-3">
                                    <label for="program_studi" class="form-label">Program Studi</label>
                                    <input type="text" class="form-control" id="program_studi" name="program_studi"
                                        placeholder="Input Nama" aria-describedby="defaultFormControlHelp"
                                        value="{{ $lembaga->program_studi }}">
                                    @error('program_studi')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Pilih Tahun</label>
                                    <select name="category_id" class="form-select">
                                        @foreach ($categories as $category)
                                            @if (old('category_id', $lembaga->category_id) == $category->id)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Input nama" aria-describedby="defaultFormControlHelp"
                                        value="{{ $lembaga->nama }}">
                                    @error('nama')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" aria-describedby="defaultFormControlHelp">
                                        <option value="Nasional Terakreditasi" @if ($lembaga->kategori == 'Nasional Terakreditasi') selected @endif>Nasional Terakreditasi</option>
                                        <option value="Nasional Terakreditasi & Lokal" @if ($lembaga->kategori == 'Nasional Terakreditasi & Lokal') selected @endif>Nasional Terakreditasi & Lokal</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                

                                <div class="mb-3">
                                    <label for="nama_jurnal" class="form-label">Nama Jurnal</label>
                                    <input type="text" class="form-control" id="nama_jurnal" name="nama_jurnal"
                                        placeholder="Input nama_jurnal" aria-describedby="defaultFormControlHelp"
                                        value="{{ $lembaga->nama_jurnal }}">
                                    @error('nama_jurnal')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_judul" class="form-label">Nama Judul</label>
                                    <input type="text" class="form-control" id="nama_judul" name="nama_judul"
                                        placeholder="Input nama_judul" aria-describedby="defaultFormControlHelp"
                                        value="{{ $lembaga->nama_judul }}">
                                    @error('nama_judul')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="link_jurnal" class="form-label">Link Judul</label>
                                    <input type="text" class="form-control" id="link_jurnal" name="link_jurnal"
                                        placeholder="Input link_jurnal" aria-describedby="defaultFormControlHelp"
                                        value="{{ $lembaga->link_jurnal }}">
                                    @error('link_jurnal')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <input type="submit" value="Update" id="save" name="save"
                                        class="btn btn-primary">
                                </div>

                            </form>
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
