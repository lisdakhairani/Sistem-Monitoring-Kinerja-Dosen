@extends('welcome')

@section('title', 'Truktur Kurikulum')
@section('content')

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 my-3 ">
            <h2>
                Kurikulum Program Magister Ilmu Manajemen
            </h2>
            <p style="text-align: justify">
                Program Pascasarjana Ilmu Manajemen Universitas Malikussaleh berkomitmen untuk menciptakan lulusan yang
                profesional. Ini dilakukan dengan mendesain kurikulum yang berbasis komptensi dan penyediaan fasilitas
                penunjang sebagai upaya peningkatan kualitas yang berkelanjutan. Penyusunan kurikulum selalu
                memperhatikan relevansi dengan dunia kerja. Beban studi pada PPIM adalah sebanyak 42 SKS yang akan
                ditempuh dalam waktu 4(empat) semester, selain itu mahasiswa juga harus mengikuti mata kuliah
                Matrikulasi yang non-SKS.
            </p>
            <br>

            <a href="{{url('/kurikulum-semesterI')}}" class="btn btn-success">Semester I</a>
            <a href="{{url('/kurikulum-semesterII')}}" class="btn btn-success">Semester II</a>
            <a href="{{url('/kurikulum-semesterIII')}}" class="btn btn-success">Semester III</a>
            <a href="{{url('/kurikulum-semesterIV')}}" class="btn btn-success">Semester IV</a>
        </div>
    </div>
</div>
<br><br><br><br><br><br>

@endsection