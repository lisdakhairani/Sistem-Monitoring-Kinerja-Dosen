<section id="stats-counter" class="stats-counter">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-6">
                <img src="/img/iklan.jpg" alt="Miti" class="img-fluid rounded">
            </div>
            <div class="col-lg-6">
                <div class="text-center">

                    <h3 class="fw-bold text-success">
                        Penerimaan Mahasiswa Baru Program Magister Ilmu Manajemen
                    </h3>

                    <h5 class="mt-2">
                        Tahun Akademik
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        /
                        <script>
                            let currentYear = new Date().getFullYear();
                            let nextYear = currentYear + 1;
                            document.write(nextYear);
                        </script>
                    </h5>

                    <p class="text-center mt-3">
                        Program Magister Ilmu Manjemen (PMIM) Fakultas Ekonomi dan Bisnis Universitas Malikussaleh
                    </p>
                    <a href="https://pendaftaran.unimal.ac.id/" target="_ black"
                        class="btn btn-success fw-semibold">Daftar Sekarang</a>
                    {{-- menampilkan rekaman pengunjung --}}
                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <div class="stats-item d-flex align-items-center">
                                <h6>Views</h6>
                                <span class="purecounter">{{ $visitorCount }}</span>
                            </div><!-- End Stats Item -->
                        </div>
                        {{-- <div class="col-lg-4">
                            <div class="stats-item d-flex align-items-center">
                                <span data-purecounter-start="0" data-purecounter-end="521"
                                    data-purecounter-duration="0" class="purecounter">521</span>
                            </div><!-- End Stats Item -->
                        </div>
                        <div class="col-lg-4">
                            <div class="stats-item d-flex align-items-center">
                                <span data-purecounter-start="0" data-purecounter-end="453"
                                    data-purecounter-duration="0" class="purecounter">453</span>
                            </div><!-- End Stats Item -->
                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>