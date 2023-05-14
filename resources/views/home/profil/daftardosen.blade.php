@extends('welcome')

@section('title', 'Daftar Dosen')

@section('content')

<section id="team" class="team">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-header">
            <h2>Daftar Dosen</h2>
            <p>Program Magister Ilmu Manajemen</p>
        </div>

        <div class="row gy-4">
            @foreach ($dosen as $d)
            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                    <img src="{{ asset('storage/' . $d->image) }}" class="img-fluid" alt="{{ $d->title }}">
                    <h4>{{ $d->title }}</h4>
                    <span>NIK/NIPK : {{ $d->nip }}</span>
                    <span>Jabatan : {{ $d->jabatan }}</span>
                    <div class="social">
                        <a href="{{ $d->sinta }}" target="_black"><img src="/img/logo-sinta.png" alt=""></a>
                        <a href="{{ $d->scopus }}" target="_black"><img src="/img/scopus.jpg" alt=""></a>
                        <a href="{{ $d->scholar }}" target="_black"><img src="/img/google-scholer.png" alt=""></a>
                    </div>
                </div>
            </div><!-- End Team Member -->
            @endforeach
        </div>

    </div>
</section>

@endsection