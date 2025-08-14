@extends('layouts.admin_template')
@section('title', 'Kinerja Penunjang')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Kinerja Penunjang</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('kinerja-penunjang.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama Kegiatan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('kinerja-penunjang.index') }}" class="btn btn-secondary mx-3">Reset</a>
            </div>
        </div>
    </form>

    @if ($kinerjaDosenID && $kinerjaDosenID->status_penilaian === 'Menunggu')
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i> Tambah Data
        </button>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th></th>
                    <th>No</th>
                    <th>Jenis Kegiatan</th>
                    <th>Nama Kegiatan</th>
                    <th>Tingkat</th>
                    <th>Tanggal</th>
                    <th>Skor</th>
                    <th width="200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kinerjaPenunjang as $item)
                <tr>
                    <td>
                        <button class="btn btn-warning btn-sm" title="Lihat" onclick="window.location.href='{{ route('kinerja-penunjang.show', $item->id) }}'">
                            <i class="bi bi-eye"></i> Lihat
                        </button>
                    </td>
                    <td>{{ ($kinerjaPenunjang->currentPage() - 1) * $kinerjaPenunjang->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->jenis_kegiatan }}</td>
                    <td>{{ $item->nama_kegiatan }}</td>
                    <td>
                        <span class="badge bg-{{ $item->tingkat_kegiatan == 'Internasional' ? 'primary' : ($item->tingkat_kegiatan == 'Nasional' ? 'info' : 'secondary') }}">
                            {{ $item->tingkat_kegiatan }}
                        </span>
                    </td>
                    <td>{{ $item->tanggal_kegiatan->format('d/m/Y') }}</td>
                    <td>{{ $item->skor }}</td>
                    <td>
                        @if ($kinerjaDosenID)
                            {{-- Status Menunggu --}}
                            @if ($kinerjaDosenID->status_penilaian === 'Menunggu')
                                @if ($kinerjaDosenID->is_updated == 0)
                                    <div class="alert alert-warning mb-2">
                                        <strong>Perhatian!</strong> Lakukan perbarui di menu <em>Form Kinerja (Awal)</em>.
                                    </div>
                                @elseif ($kinerjaDosenID->is_updated == 1)
                                    <!-- Tombol Edit & Hapus -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $item->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                @endif
                            @endif

                            {{-- Status Selesai Diperiksa --}}
                            @if ($kinerjaDosenID->is_updated == 2)
                                <div class="alert alert-success mb-2">
                                    <strong>Selesai!</strong> Data sudah selesai diperiksa.
                                </div>
                            @endif
                        @endif
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('kinerja-penunjang.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kinerja Penunjang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Kegiatan</label>
                                            <select name="jenis_kegiatan" class="form-select" required>
                                                <option value="Reviewer Jurnal" {{ $item->jenis_kegiatan == 'Reviewer Jurnal' ? 'selected' : '' }}>Reviewer Jurnal</option>
                                                <option value="Narasumber / Moderator" {{ $item->jenis_kegiatan == 'Narasumber / Moderator' ? 'selected' : '' }}>Narasumber / Moderator</option>
                                                <option value="Panitia Kegiatan Ilmiah" {{ $item->jenis_kegiatan == 'Panitia Kegiatan Ilmiah' ? 'selected' : '' }}>Panitia Kegiatan Ilmiah</option>
                                                <option value="Pembicara Seminar" {{ $item->jenis_kegiatan == 'Pembicara Seminar' ? 'selected' : '' }}>Pembicara Seminar</option>
                                                <option value="Anggota Organisasi Profesi" {{ $item->jenis_kegiatan == 'Anggota Organisasi Profesi' ? 'selected' : '' }}>Anggota Organisasi Profesi</option>
                                                <option value="Sertifikasi Kompetensi" {{ $item->jenis_kegiatan == 'Sertifikasi Kompetensi' ? 'selected' : '' }}>Sertifikasi Kompetensi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Kegiatan</label>
                                            <input type="text" name="nama_kegiatan" value="{{ $item->nama_kegiatan }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tingkat Kegiatan</label>
                                            <select name="tingkat_kegiatan" class="form-select" required>
                                                <option value="Lokal" {{ $item->tingkat_kegiatan == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                                <option value="Nasional" {{ $item->tingkat_kegiatan == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                <option value="Internasional" {{ $item->tingkat_kegiatan == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tanggal Kegiatan</label>
                                            <input type="date" name="tanggal_kegiatan" value="{{ $item->tanggal_kegiatan->format('Y-m-d') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Institusi Penyelenggara</label>
                                            <input type="text" name="institusi_penyelenggara" value="{{ $item->institusi_penyelenggara }}" class="form-control" required>
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Upload Bukti</label>
                                        <input type="file" name="bukti_path" class="form-control">
                                        @if($item->bukti_path)
                                            <small class="text-muted">File saat ini:
                                                <a href="{{ asset('storage/'.$item->bukti_path) }}" target="_blank">Lihat Bukti</a>
                                            </small>
                                        @endif
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
                <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
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
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus data penunjang berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Kegiatan</span>
                                                    <span class="fw-semibold">{{ $item->nama_kegiatan }}</span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Jenis</span>
                                                    <span class="fw-semibold">{{ $item->jenis_kegiatan }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 120px">Tanggal</span>
                                                    <span class="fw-semibold">{{ $item->tanggal_kegiatan->format('d/m/Y') }}</span>
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
                                <form action="{{ route('kinerja-penunjang.destroy', $item->id) }}" method="POST">
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
                <tr><td colspan="8" class="text-center">Tidak ada data kinerja penunjang</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $kinerjaPenunjang->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kinerja-penunjang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kinerja Penunjang</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kegiatan</label>
                            <select name="jenis_kegiatan" class="form-select" required>
                                <option value="">Pilih Jenis Kegiatan</option>
                                <option value="Reviewer Jurnal">Reviewer Jurnal</option>
                                <option value="Narasumber / Moderator">Narasumber / Moderator</option>
                                <option value="Panitia Kegiatan Ilmiah">Panitia Kegiatan Ilmiah</option>
                                <option value="Pembicara Seminar">Pembicara Seminar</option>
                                <option value="Anggota Organisasi Profesi">Anggota Organisasi Profesi</option>
                                <option value="Sertifikasi Kompetensi">Sertifikasi Kompetensi</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tingkat Kegiatan</label>
                            <select name="tingkat_kegiatan" class="form-select" required>
                                <option value="Lokal">Lokal</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal_kegiatan" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Institusi Penyelenggara</label>
                            <input type="text" name="institusi_penyelenggara" class="form-control" required>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Bukti</label>
                        <input type="file" name="bukti_path" class="form-control" required>
                        <small class="text-muted">Format: PDF, DOC, JPG, PNG (Max 2MB)</small>
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
