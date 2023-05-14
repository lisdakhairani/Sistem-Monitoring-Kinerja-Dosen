@extends('welcome')

@section('title', 'Kelender Akademik')
@section('content')

<section id="faq" class="faq">
    <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="content px-xl-5">
                    <h3>Program Magister Ilmu Manajemen</h3>
                    <p>
                        Kelender Akademik
                    </p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="accordion accordion-flush aos-init aos-animate" id="faqlist" data-aos="fade-up"
                    data-aos-delay="100">
                    @foreach ($kelenderakademik as $item)
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq-content-{{ $item->id }}">
                                <span class="num">{{ $loop->iteration }}.</span>
                                <article>
                                    {!! $item->body !!}
                                </article>
                            </button>
                        </h3>
                        <div id="faq-content-{{ $item->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#faqlist">
                            <div class="accordion-body">
                                <embed class="embed-responsive-item mt-3" async='async'
                                    src="{{ asset('storage/' . $item->filedata) }}" width="100%" height="500px"></embed>
                            </div>
                        </div>
                    </div><!-- # Faq item-->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection