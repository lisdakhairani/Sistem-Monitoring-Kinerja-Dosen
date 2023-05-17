@extends('layouts.admin_template')
@section('title', 'Semester')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Data semester3 /</span> List
    </h4>
    <a href="{{ route('semestersatu.index') }}" class="btn btn-success">Semester I</a>
    <a href="{{ route('semesterdua.index') }}" class="btn btn-success">Semester II</a>
    <a href="{{ route('semestertiga.index') }}" class="btn btn-success">Semester III</a>
    <a href="{{ route('semesterempat.index') }}" class="btn btn-success">Semester IV</a>

    <div class="row mt-3">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            @include('notif')
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title text-primary">List Data</h5>

                                <a href="{{ route('semestertiga.create') }}">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            </div>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode MK</th>
                                        <th scope="col">mata kuliah</th>
                                        <th scope="col">sks</th>
                                        <th scope="col">Kontrensasi</th>
                                        <th scope="col">RPS</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semester3 as $post)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $post->kodemk }}</td>
                                        <td>{{ $post->matakuliah }}</td>
                                        <td>{{ $post->sks }}</td>
                                        <td>{{ $post->kontrensasi }}</td>
                                        <td>{{ $post->filedata }}</td>

                                        <td>
                                            <a href="{{ route('semestertiga.edit', $post->id) }}"
                                                class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

                                            <form action="{{ route('semestertiga.destroy', $post->id) }}" method="POST"
                                                class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button class="badge bg-danger border-0"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="bi bi-x-circle-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $semester3->withQueryString()->links() }}
    </div>
</div>
@endsection
