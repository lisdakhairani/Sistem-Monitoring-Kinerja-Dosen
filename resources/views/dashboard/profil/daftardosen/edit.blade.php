@extends('layouts.admin_template')
@section('title', 'daftar dosen')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit daftar dosen</h4>

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
                <h5 class="card-header">Edit Data daftar dosen</h5>
                <div class="card-body">
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('daftardosen.update', $daftardosen->id) }}" class="mt-5"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Input Nama"
                                    aria-describedby="defaultFormControlHelp" value="{{ $daftardosen->title }}">
                                @error('title')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP/NIPK</label>
                                <input type="text" class="form-control" id="nip" name="nip" placeholder="Input NIP/NIPK"
                                    aria-describedby="defaultFormControlHelp" value="{{ $daftardosen->nip }}">
                                @error('nip')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    placeholder="Input Jabatan" aria-describedby="defaultFormControlHelp"
                                    value="{{ $daftardosen->jabatan }}">
                                @error('jabatan')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sinta" class="form-label">Link Sinta</label>
                                <input type="text" class="form-control" id="sinta" name="sinta"
                                    placeholder="Input Link Sinta" aria-describedby="defaultFormControlHelp"
                                    value="{{ $daftardosen->sinta }}">
                                @error('sinta')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="scopus" class="form-label">Link Scopus</label>
                                <input type="text" class="form-control" id="scopus" name="scopus"
                                    placeholder="Input Link scopus" aria-describedby="defaultFormControlHelp"
                                    value="{{ $daftardosen->scopus }}">
                                @error('scopus')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="scholar" class="form-label">Link Scholar</label>
                                <input type="text" class="form-control" id="scholar" name="scholar"
                                    placeholder="Input Link scholar" aria-describedby="defaultFormControlHelp"
                                    value="{{ $daftardosen->scholar }}">
                                @error('scholar')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Post Image</label>
                                <input type="hidden" name="oldImage" value="{{ $daftardosen->image }}">
                                @if ($daftardosen->image)
                                <img src="{{ asset('storage/' . $daftardosen->image) }}"
                                    class="img-preview img-fluid my-3 col-md-3 d-block">
                                @else
                                <img class="img-preview img-fluid my-3 col-md-3">
                                @endif
                                <input class="form-control  @error('image') is-invalid @enderror" type="file" id="image"
                                    name="image" value="{{ old('image') }}" onchange="proviewImage()">
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <input type="submit" value="Update" id="save" name="save" class="btn btn-primary">
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