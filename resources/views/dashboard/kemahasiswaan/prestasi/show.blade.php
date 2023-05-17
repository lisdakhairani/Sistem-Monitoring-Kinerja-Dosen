@extends('layouts.admin_template')
@section('title', 'prestasimahasisswa')
@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-lg-8">
            <h2 class="my-3">{{ $prestasi['title'] }}</h2>

            <a href="{{ route('prestasimahasiswa.index') }}" class="btn btn-success btn-sm"> <i
                    class="bi bi-arrow-left"></i> Back to
                my post</a>
            @if ($prestasi->image)
            <div style="max-height: 350px; overflow:hidden;">
                <img src="{{ asset('storage/' . $prestasi->image) }}" class="card-img-top mt-3" alt=""
                    class="img-fluid ">
            </div>
            @else
            <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar" width="200px">
            @endif

            <article>
                {!! $prestasi->body !!}
            </article>
        </div>
    </div>
</div>
@endsection