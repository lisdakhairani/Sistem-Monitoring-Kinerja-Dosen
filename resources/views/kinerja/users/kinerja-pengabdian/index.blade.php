@extends('layouts.admin_template')
@section('title', 'Kinerja Pengabdian')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Kinerja Pengabdian</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('kinerja-pengabdian.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari Judul Kegiatan..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('kinerja-pengabdian.index') }}" class="btn btn-secondary mx-3">Reset</a>
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
                    <th>Judul Kegiatan</th>
                    <th>Jenis</th>
                    <th>Lokasi</th>
                    <th>Tahun</th>
                    <th>Tingkat</th>
                    <th>Skor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kinerjaPengabdian as $item)
                <tr>
                    <td>
                        <button class="btn btn-warning btn-sm" title="Lihat" onclick="window.location.href='{{ route('kinerja-pengabdian.show', $item->id) }}'">
                            <i class="bi bi-eye"></i> Lihat
                        </button>
                    </td>
                    <td>{{ ($kinerjaPengabdian->currentPage() - 1) * $kinerjaPengabdian->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->judul_kegiatan }}</td>
                    <td>{{ $item->jenis_kegiatan }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->tahun_kegiatan }}</td>
                    <td>
                        <span class="badge bg-{{ $item->tingkat_kegiatan == 'Internasional' ? 'primary' : ($item->tingkat_kegiatan == 'Nasional' ? 'info' : 'secondary') }}">
                            {{ $item->tingkat_kegiatan }}
                        </span>
                    </td>
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
                        <form action="{{ route('kinerja-pengabdian.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kinerja Pengabdian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Judul Kegiatan</label>
                                            <input type="text" name="judul_kegiatan" value="{{ $item->judul_kegiatan }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Kegiatan</label>
                                            <input type="text" name="jenis_kegiatan" value="{{ $item->jenis_kegiatan }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Peran dalam Pengabdian</label>
                                            <select name="peran_pengabdian" class="form-select" required>
                                                <option value="Ketua" {{ $item->peran_pengabdian == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                                <option value="Anggota" {{ $item->peran_pengabdian == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" name="lokasi" value="{{ $item->lokasi }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tahun Kegiatan</label>
                                            <input type="number" name="tahun_kegiatan" value="{{ $item->tahun_kegiatan }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sumber Dana</label>
                                            <input type="text" name="sumber_dana" value="{{ $item->sumber_dana }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jumlah Dana</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number" name="jumlah_dana" value="{{ $item->jumlah_dana }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Output</label>
                                            <input type="text" name="output" value="{{ $item->output }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tingkat Kegiatan</label>
                                            <select name="tingkat_kegiatan" class="form-select" required>
                                                <option value="Lokal" {{ $item->tingkat_kegiatan == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                                <option value="Nasional" {{ $item->tingkat_kegiatan == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                <option value="Internasional" {{ $item->tingkat_kegiatan == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Bidang Keahlian/Divisi</label>
                                            <input type="text" name="bidang_keahlian" value="{{ $item->bidang_keahlian }}" class="form-control" required>
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
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus data pengabdian berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Judul</span>
                                                    <span class="fw-semibold">{{ $item->judul_kegiatan }}</span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Tahun</span>
                                                    <span class="fw-semibold">{{ $item->tahun_kegiatan }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 120px">Tingkat</span>
                                                    <span class="fw-semibold">{{ $item->tingkat_kegiatan }}</span>
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
                                <form action="{{ route('kinerja-pengabdian.destroy', $item->id) }}" method="POST">
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
                <tr><td colspan="9" class="text-center">Tidak ada data kinerja pengabdian</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $kinerjaPengabdian->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kinerja-pengabdian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kinerja Pengabdian</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Judul Kegiatan</label>
                            <input type="text" name="judul_kegiatan" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kegiatan</label>
                            <input type="text" name="jenis_kegiatan" class="form-control" placeholder="Pelatihan, Penyuluhan, Sosialisasi, dll" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Peran dalam Pengabdian</label>
                            <select name="peran_pengabdian" class="form-select" required>
                                <option value="Ketua">Ketua</option>
                                <option value="Anggota">Anggota</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Kegiatan</label>
                            <input type="number" name="tahun_kegiatan" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Dana</label>
                            <input type="text" name="sumber_dana" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Dana</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" name="jumlah_dana" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Output</label>
                            <input type="text" name="output" class="form-control" placeholder="Laporan, Dokumentasi, Sertifikat" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tingkat Kegiatan</label>
                            <select name="tingkat_kegiatan" class="form-select" required>
                                <option value="Lokal">Lokal</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col-md-12 mb-3">
                            <label class="form-label">Bidang Keahlian/Divisi</label>
                            <input type="text" name="bidang_keahlian" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Bukti</label>
                        <input type="file" name="bukti_path" class="form-control">
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
