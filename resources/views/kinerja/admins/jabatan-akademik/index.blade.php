@extends('layouts.admin_template')
@section('title', 'Jabatan Akademik')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Jabatan Akademik</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('jabatan-akademik.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama Jabatan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('jabatan-akademik.index') }}" class="btn btn-secondary mx-3">Reset</a>
            </div>
        </div>
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Jabatan
    </button>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jabatan Akademik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatanAkademiks as $jabatan)
                <tr>
                    <td>{{ ($jabatanAkademiks->currentPage() - 1) * $jabatanAkademiks->perPage() + $loop->iteration }}</td>
                    <td>{{ $jabatan->nama_jabatan }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $jabatan->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $jabatan->id }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $jabatan->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('jabatan-akademik.update', $jabatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Jabatan Akademik</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Jabatan Akademik</label>
                                        <input type="text" name="nama_jabatan" value="{{ $jabatan->nama_jabatan }}" class="form-control" required maxlength="50">
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
                <div class="modal fade" id="modalHapus{{ $jabatan->id }}" tabindex="-1">
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
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus jabatan akademik berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 120px">Nama Jabatan</span>
                                                    <span class="fw-semibold">{{ $jabatan->nama_jabatan }}</span>
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
                                <form action="{{ route('jabatan-akademik.destroy', $jabatan->id) }}" method="POST">
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
                <tr><td colspan="3" class="text-center">Tidak ada data jabatan akademik</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $jabatanAkademiks->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('jabatan-akademik.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jabatan Akademik</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jabatan Akademik</label>
                        <input type="text" name="nama_jabatan" class="form-control" required maxlength="50">
                        <small class="text-muted">Contoh: Guru Besar, Lektor Kepala, Lektor, Asisten Ahli, dll.</small>
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
