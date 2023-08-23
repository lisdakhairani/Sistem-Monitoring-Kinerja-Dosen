@extends('layouts.admin_template')
@section('title', 'Publikasi Nasional')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Categori Publikasi Nasional /</span> List
        </h4>
        <div class="d-flex justify-content-between">
            <a href="{{ route('publikasi-nasional.index') }}" class="menu-link btn btn-info btn-sm ">
                <div data-i18n="Account Settings">Kembali</div>
            </a>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                            <div class="card-body">
                                @include('notif')
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-primary">Halaman Categori</h5>

                                    <a href="{{ route('categoripublik.create') }}">
                                        <button class="btn btn-primary">Tambah</button>
                                    </a>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Slug</th>                                            
                                            <th>Aktion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($goripublik as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->slug }}</td>                                                
                                                <td>
                                                    <div class="d-flex">                                                        
                                                        <a href="{{ route('categoripublik.edit', $row->id) }}"
                                                            class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

                                                        <form action="{{ route('categoripublik.destroy', $row->id) }}"
                                                            method="POST" class="d-inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="badge bg-danger border-0"
                                                                onclick="return confirm('Are you sure?')"><i
                                                                    class="bi bi-x-circle-fill"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
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
