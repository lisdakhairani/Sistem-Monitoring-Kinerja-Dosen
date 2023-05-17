@extends('layouts.admin_template')
@section('title', 'Staf')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Staf /</span> Add
    </h4>
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <div class="col-lg-8">
                                <form method="POST" action="{{ route('staf.store') }}" enctype="multipart/form-data"
                                    class="mt-5">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" autofocus value="{{ old('title') }}"
                                            placeholder="Masukkan Nama">
                                        @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP/NIPK</label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                            id="nip" name="nip" autofocus value="{{ old('nip') }}"
                                            placeholder="Masukkan Nip / Nipk">
                                        @error('nip')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                            id="jabatan" name="jabatan" autofocus value="{{ old('jabatan') }}"
                                            placeholder="Masukkan Jabatan">
                                        @error('jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Post Image</label>
                                        <img class="img-preview img-fluid my-3 col-md-3">
                                        <input class="form-control  @error('image') is-invalid @enderror" type="file"
                                            id="image" name="image" value="{{ old('image') }}"
                                            onchange="proviewImage()">
                                        @error('image')
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
