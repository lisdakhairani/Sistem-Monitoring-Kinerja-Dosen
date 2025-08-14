@extends('layouts.admin_template')
@section('title', 'Semester')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Semester</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('semester.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Nama Semester</label>
                <select name="filter_semester" class="form-select">
                    @foreach($semesterOptions as $value => $label)
                        <option value="{{ $value }}" {{ $selectedSemester == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Tahun Ajaran</label>
                <select name="filter_tahun" class="form-select">
                    @foreach($tahunOptions as $value => $label)
                        <option value="{{ $value }}" {{ $selectedTahun == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('semester.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Semester
    </button>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Semester</th>
                    <th>Tahun Ajaran</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semesters as $semester)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $semester->nama_semester }}</td>
                    <td>{{ $semester->tahun_ajaran }}</td>
                    <td>{{ $semester->tanggal_mulai->format('d/m/Y') }}</td>
                    <td>{{ $semester->tanggal_berakhir->format('d/m/Y') }}</td>
                    <td>
                        @if($semester->status)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $semester->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $semester->id }}" >
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $semester->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('semester.update', $semester->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Semester</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Semester</label>
                                        <select name="nama_semester" class="form-select" required>
                                            <option value="Semester Ganjil" {{ $semester->nama_semester == 'Semester Ganjil' ? 'selected' : '' }}>Semester Ganjil</option>
                                            <option value="Semester Genap" {{ $semester->nama_semester == 'Semester Genap' ? 'selected' : '' }}>Semester Genap</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tahun Ajaran</label>
                                        <input type="text" name="tahun_ajaran" value="{{ $semester->tahun_ajaran }}" class="form-control" required pattern="\d{4}/\d{4}" title="Format: 2023/2024">
                                        <small class="text-muted">Format: Tahun/Tahun+1 (contoh: 2023/2024)</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <input type="date" name="tanggal_mulai" value="{{ $semester->tanggal_mulai->format('Y-m-d') }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Berakhir</label>
                                        <input type="date" name="tanggal_berakhir" value="{{ $semester->tanggal_berakhir->format('Y-m-d') }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="status" class="form-check-input" id="status{{ $semester->id }}" value="1" {{ $semester->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status{{ $semester->id }}">Aktifkan Semester</label>
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
                <div class="modal fade" id="modalHapus{{ $semester->id }}" tabindex="-1">
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
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus semester berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Nama Semester</span>
                                                    <span class="fw-semibold">{{ $semester->nama_semester }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 120px">Tahun Ajaran</span>
                                                    <span class="fw-semibold">{{ $semester->tahun_ajaran }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        @if($semester->status)
                                        <div class="alert alert-warning d-flex align-items-center mt-2">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            <div>
                                                Semester ini sedang aktif. Nonaktifkan terlebih dahulu untuk dapat menghapus.
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </button>
                                @unless($semester->status)
                                <form action="{{ route('semester.destroy', $semester->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash me-1"></i> Ya, Hapus
                                    </button>
                                </form>
                                @endunless
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr><td colspan="7" class="text-center">Tidak ada data semester</td></tr>
                @endforelse
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-end mt-4">
            {{ $semesters->appends([
                'filter_semester' => request('filter_semester'),
                'filter_tahun' => request('filter_tahun')
            ])->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('semester.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Semester Baru</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Semester</label>
                        <select name="nama_semester" class="form-select" required>
                            <option value="">Pilih Semester</option>
                            <option value="Semester Ganjil">Semester Ganjil</option>
                            <option value="Semester Genap">Semester Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" placeholder="2023/2024" required pattern="\d{4}/\d{4}" title="Format: 2023/2024">
                        <small class="text-muted">Format: Tahun/Tahun+1 (contoh: 2023/2024)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Berakhir</label>
                        <input type="date" name="tanggal_berakhir" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1">
                        <label class="form-check-label" for="status">Aktifkan Semester</label>
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
