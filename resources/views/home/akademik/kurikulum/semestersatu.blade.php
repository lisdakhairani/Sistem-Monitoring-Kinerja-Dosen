@extends('welcome')

@section('title', 'Kurikulum Semester I')
@section('content')

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 my-3">
            <a class="btn btn-outline-success" href="{{ url('/truktur-kurikulum') }}">Kembali</a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-eye"></i> Lihat RPS
            </button>
            <h2 class="mt-3">
                Matakuliah Wajib Program Magister Ilmu Manajemen
            </h2>
            <br>
            <div class="table-responsive">
                <table class="table table-hover mt-2">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">KODE MK</th>
                            <th scope="col">MATA KULIAH</th>
                            <th scope="col">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semester1 as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kodemk }}</td>
                            <td>{{ $item->matakuliah }}</td>
                            <td>{{ $item->sks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Rencana Pembelajaran Semester (RPS)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($semester1 as $item)
                        <h3>{{ $item->matakuliah }}</h1>
                            <embed class="embed-responsive-item mt-3" async="async"
                                src="{{ asset('storage/' . $item->filedata) }}#toolbar=0" width="100%"
                                height="500"></embed>
                            @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection