@extends('layouts.admin_template')
@section('title', 'Publikasi Nasional')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">        
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Publikasi Nasional /</span> List
        </h4>
        <div class="d-flex justify-content-between">
            <a href="{{ route('categoripublik.index') }}" class="menu-link btn btn-info btn-sm ">
                <div data-i18n="Account Settings">category Publikasi</div>
            </a>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                            <div class="card-body">
                                @include('notif')
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-primary">List Data</h5>

                                    <a href="{{ route('publikasi-nasional.create') }}">
                                        <button class="btn btn-primary">Tambah</button>
                                    </a>
                                </div>

                                <!-- Form untuk memilih kategori -->
                                <form action="{{ route('publikasi-nasional.index') }}" method="GET">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Lihat Tahun </label>
                                        <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @if(request()->get('category') == $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>

                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Program Studi</th>
                                            <th scope="col">Tahun</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Nama Jurnal</th>
                                            <th scope="col">Nama Judul</th>
                                            <th scope="col">Link Judul</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                        
                                        @foreach ($lembaga as $post)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $post->program_studi }}</td>
                                                <td>{{ $post->category->name }}</td>
                                                <td>{{ $post->nama }}</td>
                                                <td>{{ $post->kategori }}</td>
                                                <td>{{ $post->nama_jurnal }}</td>
                                                <td>{{ $post->nama_judul }}</td>
                                                <td>{{ $post->link_jurnal }}</td>
                                                <td>                                                    
                                                    <a href="{{ route('publikasi-nasional.edit', $post->id) }}"
                                                        class="badge bg-warning"><i class="bi bi-pencil-square"></i></a>

                                                    <form action="{{ route('publikasi-nasional.destroy', $post->id) }}" method="POST"
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
            {{ $lembaga->withQueryString()->links() }}
        </div>
    </div>
@endsection
