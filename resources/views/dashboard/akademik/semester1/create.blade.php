@extends('layouts.admin_template')
@section('title', 'semester')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">semesterI /</span> Add
    </h4>
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <div class="col-lg-8">
                                <form method="POST" action="{{ route('semestersatu.store') }}"
                                    enctype="multipart/form-data" class="mt-5">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="kodemk" class="form-label">Kode MK</label>
                                        <input type="text" class="form-control @error('kodemk') is-invalid @enderror"
                                            id="kodemk" name="kodemk" autofocus value="{{ old('kodemk') }}"
                                            placeholder="Masukkan Kode MK">
                                        @error('kodemk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="matakuliah" class="form-label">Mata Kuliah</label>
                                        <input type="text"
                                            class="form-control @error('matakuliah') is-invalid @enderror"
                                            id="matakuliah" name="matakuliah" autofocus value="{{ old('matakuliah') }}"
                                            placeholder="Masukkan Mata Kuliah">
                                        @error('matakuliah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="sks" class="form-label">SKS</label>
                                        <input type="text" class="form-control @error('sks') is-invalid @enderror"
                                            id="sks" name="sks" autofocus value="{{ old('sks') }}"
                                            placeholder="Masukkan SKS">
                                        @error('sks')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="filedata" class="form-label">Upload RPS</label>
                                        <img class="img-preview img-fluid my-3 col-md-3">
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