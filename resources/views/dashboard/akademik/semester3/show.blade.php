@extends('layouts.admin_template')
@section('title', 'rencana strategi')
@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-lg-11">

            <a href="{{ route('rencanastrategi.index') }}" class="btn btn-success btn-sm"> <i
                    class="bi bi-arrow-left"></i> Back to
                my post</a>

            <article>
                {!! $rencana->body !!}
            </article>

            <embed class="embed-responsive-item mt-3" async='async' src="{{ asset('storage/' . $rencana->filedata) }}"
                width="100%" height="500px"></embed>


        </div>
    </div>
</div>
@endsection
