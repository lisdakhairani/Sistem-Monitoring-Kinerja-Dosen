@extends('layouts.admin_template')
@section('title', 'Akun Admin')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374"> Admin</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('akun-admin.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama, NIP, atau NIDN..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('akun-admin.index') }}" class="btn btn-secondary mx-3">Reset</a>
            </div>
        </div>
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Admin
    </button>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIP</th>
                    <th>NIDN</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>{{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->nip ?? '-' }}</td>
                    <td>{{ $admin->nidn ?? '-' }}</td>
                    <td>{{ $admin->jabatan ?? '-' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $admin->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $admin->id }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $admin->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('akun-admin.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Akun Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email (@unimal.ac.id)</label>
                                        <div class="input-group">
                                            <input type="text" name="email" value="{{ str_replace('@unimal.ac.id', '', $admin->email) }}" class="form-control" required>
                                            <span class="input-group-text">@unimal.ac.id</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIP</label>
                                        <input type="text" name="nip" value="{{ $admin->nip }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIDN</label>
                                        <input type="text" name="nidn" value="{{ $admin->nidn }}" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
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
                <div class="modal fade" id="modalHapus{{ $admin->id }}" tabindex="-1">
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
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus akun admin berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 100px">Nama</span>
                                                    <span class="fw-semibold">{{ $admin->name }}</span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 100px">NIP</span>
                                                    <span class="fw-semibold">{{ $admin->nip }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 100px">Email</span>
                                                    <span class="fw-semibold">{{ $admin->email }}</span>
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
                                <form action="{{ route('akun-admin.destroy', $admin->id) }}" method="POST">
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
                <tr><td colspan="7" class="text-center">Tidak ada data admin</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $admins->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('akun-admin.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Akun Admin</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email (@unimal.ac.id)</label>
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" required>
                            <span class="input-group-text">@unimal.ac.id</span>
                        </div>
                        <small class="text-muted">Masukkan bagian sebelum @unimal.ac.id</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIDN</label>
                        <input type="text" name="nidn" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
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
