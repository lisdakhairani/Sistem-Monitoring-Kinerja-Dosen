@extends('layouts.admin_template')
@section('title', 'Pangkat')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Pangkat</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('pangkat.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama Pangkat atau Golongan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('pangkat.index') }}" class="btn btn-secondary mx-3">Reset</a>
            </div>
        </div>
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Pangkat
    </button>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pangkat</th>
                    <th>Golongan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pangkats as $pangkat)
                <tr>
                    <td>{{ ($pangkats->currentPage() - 1) * $pangkats->perPage() + $loop->iteration }}</td>
                    <td>{{ $pangkat->nama_pangkat }}</td>
                    <td>{{ $pangkat->golongan }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pangkat->id_pangkat }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $pangkat->id_pangkat }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $pangkat->id_pangkat }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('pangkat.update', $pangkat->id_pangkat) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pangkat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pangkat</label>
                                        <input type="text" name="nama_pangkat" value="{{ $pangkat->nama_pangkat }}" class="form-control" required maxlength="50">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Golongan</label>
                                        <input type="text" name="golongan" value="{{ $pangkat->golongan }}" class="form-control" required maxlength="5">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus{{ $pangkat->id_pangkat }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title text-danger">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex align-items-start">
                                    <div class="me-3 text-warning">
                                        <i class="bi bi-exclamation-octagon-fill fs-3"></i>
                                    </div>
                                    <div>
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus pangkat berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 130px">Nama Pangkat</span>
                                                    <span class="fw-semibold">{{ $pangkat->nama_pangkat }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 130px">Golongan</span>
                                                    <span class="fw-semibold">{{ $pangkat->golongan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                                <form action="{{ route('pangkat.destroy', $pangkat->id_pangkat) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash me-1"></i> Ya, Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="4" class="text-center">Tidak ada data pangkat</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $pangkats->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pangkat.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pangkat</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Pangkat</label>
                        <input type="text" name="nama_pangkat" class="form-control" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Golongan</label>
                        <input type="text" name="golongan" class="form-control" required maxlength="5">
                        <small class="text-muted">Contoh: IV/a, III/b, dst.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .pagination {
        flex-wrap: wrap;
        font-size: 12pt;
    }
    .pagination .page-item .page-link {
        color: #008374;
    }
    .pagination .page-item.active .page-link {
        background-color: #008374;
        border-color: #008374;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }
</style>
@endsection
