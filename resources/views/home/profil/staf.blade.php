@extends('welcome')

@section('title', 'Staf')

@section('content')

<section id="team" class="team">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-header">
            <h2>Staf</h2>
            <p>Program Magister Ilmu Manajemen</p>
        </div>

        <div class="row gy-4">
            @foreach ($datastaf as $staf)
            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                    <img src="{{ asset('storage/' . $staf->image) }}" class="img-fluid" alt="{{ $staf->title }}">
                    <h4>{{ $staf->title }}</h4>
                    <span>Nik/NIPK : {{ $staf->nip }}</span>
                    <span>Jabatan : {{ $staf->jabatan }}</span>

                </div>
            </div><!-- End Team Member -->
            @endforeach

        </div>

    </div>
</section>

@endsection