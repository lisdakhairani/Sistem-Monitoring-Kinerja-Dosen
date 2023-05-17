@extends('layouts.admin_template')
@section('title', 'semester')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Data</h4>

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
                <h5 class="card-header">Edit Post</h5>
                <div class="card-body">
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('semesterempat.update', $semester4->id) }}" class="mt-5"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="mb-3">
                                <label for="matakuliah" class="form-label">Mata Kuliah</label>
                                <input type="text" class="form-control" id="matakuliah" name="matakuliah"
                                    placeholder="Input Mata Kuliah" aria-describedby="defaultFormControlHelp"
                                    value="{{ $semester4->matakuliah }}">
                                @error('matakuliah')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sks" class="form-label">SKS</label>
                                <input type="text" class="form-control" id="sks" name="sks" placeholder="Input SKS"
                                    aria-describedby="defaultFormControlHelp" value="{{ $semester4->sks }}">
                                @error('sks')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="filedata" class="form-label">Post File</label>
                                <input type="hidden" name="oldImage" value="{{ $semester4->filedata }}">
                                @if ($semester4->filedata)
                                <img src="{{ asset('storage/' . $semester4->filedata) }}"
                                    class="img-preview img-fluid my-3 col-md-3 d-block">
                                @else
                                <img class="img-preview img-fluid my-3 col-md-3">
                                @endif
                                <input class="form-control  @error('filedata') is-invalid @enderror" type="file"
                                    id="filedata" name="filedata" value="{{ old('filedata') }}"
                                    onchange="proviewImage()">
                                @error('filedata')
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
