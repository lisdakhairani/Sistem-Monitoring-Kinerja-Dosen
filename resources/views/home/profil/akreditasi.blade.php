@extends('welcome')

@section('title', 'akreditas')

@section('content')
<section id="call-to-action" class="call-to-action">
    @foreach ($akreditas as $akreditas)
    <div class="container text-center aos-init aos-animate" data-aos="zoom-out">
        <img src="{{ asset('storage/' . $akreditas->image) }}" class="card-img-top" alt="" class="img-fluid ">
    </div>
    @endforeach
</section>
@endsection