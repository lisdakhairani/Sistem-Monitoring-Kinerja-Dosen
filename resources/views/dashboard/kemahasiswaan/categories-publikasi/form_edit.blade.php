@extends('layouts.admin_template')
@section('title', 'Categori Nasional')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Categori Publikasi Nasional</h4>

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
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Edit User</h5>
                    <div class="card-body">
                        <form action="{{ route('categoripublik.update', $goripublik->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Input Usrname" aria-describedby="defaultFormControlHelp"
                                    value="{{ $goripublik->name }}">
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="Input slug" aria-describedby="defaultFormControlHelp"
                                    value="{{ $goripublik->slug }}">
                                    <p class="text-danger">contoh : cara-slug</p>
                                @error('slug')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>                                                            

                            <div class="mt-3">
                                <input type="submit" value="Update" id="save" name="save" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
