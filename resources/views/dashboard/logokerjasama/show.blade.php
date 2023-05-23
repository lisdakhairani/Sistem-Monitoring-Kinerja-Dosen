@extends('layouts.admin_template')
@section('title', 'Logo Kerja Sama')
@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-lg-8">

            <a href="{{ route('logokerjasama.index') }}" class="btn btn-success btn-sm"> <i
                    class="bi bi-arrow-left"></i> Back
                to
                my post</a>

            <h3 class="my-5 fw-semibold">{{ $logokerja->title }}</h3>

            @if ($logokerja->image)
            <div style="max-height: 350px; overflow:hidden;">
                <img src="{{ asset('storage/' . $logokerja->image) }}" class="card-img-top mt-3" alt=""
                    class="img-fluid ">
            </div>
            @else
            <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar" width="200px">
            @endif
        </div>
    </div>
</div>
@endsection