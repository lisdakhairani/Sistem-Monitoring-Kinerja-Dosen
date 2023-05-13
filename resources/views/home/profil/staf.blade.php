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

            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                    <img src="assets_user/img/team/team-1.jpg" class="img-fluid" alt="">
                    <h4>Walter White</h4>
                    <span>Nik/NIPK : 200180020</span>
                    <span>Jabatan : Operator</span>

                </div>
            </div><!-- End Team Member -->

            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                <div class="member">
                    <img src="assets_user/img/team/team-2.jpg" class="img-fluid" alt="">
                    <h4>Sarah Jhinson</h4>
                    <span>Nik/NIPK : 200180020</span>
                    <span>Jabatan : Operator</span>

                </div>
            </div><!-- End Team Member -->

            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                <div class="member">
                    <img src="assets_user/img/team/team-3.jpg" class="img-fluid" alt="">
                    <h4>William Anderson</h4>
                    <span>Nik/NIPK : 200180020</span>
                    <span>Jabatan : Operator</span>

                </div>
            </div><!-- End Team Member -->

            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                <div class="member">
                    <img src="assets_user/img/team/team-4.jpg" class="img-fluid" alt="">
                    <h4>Amanda Jepson</h4>
                    <span>Nik/NIPK : 200180020</span>
                    <span>Jabatan : Operator</span>

                </div>
            </div><!-- End Team Member -->

        </div>

    </div>
</section>

@endsection
