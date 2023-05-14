@extends('layouts.admin_template')
@section('title', 'daftar dosen')
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
                                <form method="POST" action="{{ route('daftardosen.store') }}"
                                    enctype="multipart/form-data" class="mt-5">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" autofocus value="{{ old('title') }}"
                                            placeholder="Masukkan nama">
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
                                            placeholder="Maukkan Jabatan">
                                        @error('jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="sinta" class="form-label">Link Sinta</label>
                                        <input type="text" class="form-control @error('sinta') is-invalid @enderror"
                                            id="sinta" name="sinta" autofocus value="{{ old('sinta') }}"
                                            placeholder="Masukkan Link Sinta">
                                        @error('sinta')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="scopus" class="form-label">Link Scopus</label>
                                        <input type="text" class="form-control @error('scopus') is-invalid @enderror"
                                            id="scopus" name="scopus" autofocus value="{{ old('scopus') }}"
                                            placeholder="Masukkan Link Scopus">
                                        @error('scopus')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="scholar" class="form-label">Link Google Scholar</label>
                                        <input type="text" class="form-control @error('scholar') is-invalid @enderror"
                                            id="scholar" name="scholar" autofocus value="{{ old('scholar') }}"
                                            placeholder="Masukkan Link Google Scholar">
                                        @error('scholar')
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