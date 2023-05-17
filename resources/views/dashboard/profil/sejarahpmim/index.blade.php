@extends('layouts.admin_template')
@section('title', 'Sejarah')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Data Sejarah /</span> List
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

                                <a href="{{ route('sejarahpmim.create') }}">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            </div>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sejarah as $g)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <article>
                                                {!! $g->body !!}
                                            </article>
                                        </td>
                                        <td>
                                            <a href="{{ route('sejarahpmim.edit', $g->id) }}"
                                                class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

                                            <form action="{{ route('sejarahpmim.destroy', $g->id) }}" method="POST"
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
    </div>
</div>
@endsection
