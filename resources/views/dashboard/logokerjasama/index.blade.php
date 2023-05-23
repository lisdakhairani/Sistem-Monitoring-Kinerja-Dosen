@extends('layouts.admin_template')
@section('title', 'Logo Kerja sama')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Logo Kerja Sama /</span> List
    </h4>
    <div class="row mt-3">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            @include('notif')
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title text-primary">List Data</h5>

                                <a href="{{ route('logokerjasama.create') }}">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            </div>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Galeri</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logokerja as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="image" width="100">
                                        </td>
                                        <td>
                                            <a href="{{ route('logokerjasama.show', $item->id) }}"
                                                class="badge bg-info"><i class="bi bi-eye-fill"></i></a>

                                            <a href="{{ route('logokerjasama.edit', $item->id) }}"
                                                class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

                                            <form action="{{ route('logokerjasama.destroy', $item->id) }}" method="POST"
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
        {{ $logokerja->withQueryString()->links() }}
    </div>
</div>
@endsection