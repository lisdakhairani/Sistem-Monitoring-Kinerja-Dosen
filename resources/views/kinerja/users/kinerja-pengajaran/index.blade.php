@extends('layouts.admin_template')
@section('title', 'Kinerja Pengajaran')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Data <span style="color: #008374">Kinerja Pengajaran</span></h3>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('kinerja-pengajaran.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cari Mata Kuliah..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('kinerja-pengajaran.index') }}" class="btn btn-secondary mx-3">Reset</a>
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
                    <th>Mata Kuliah</th>
                    <th>Kode</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Jenis</th>
                    <th>Skor</th>
                    <th width="200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kinerjaPengajaran as $item)
                <tr>
                    <td>
                        <button class="btn btn-warning btn-sm" title="Lihat" onclick="window.location.href='{{ route('kinerja-pengajaran.show', $item->id) }}'">
                            <i class="bi bi-eye"></i> Lihat
                        </button>
                    </td>
                    <td>{{ ($kinerjaPengajaran->currentPage() - 1) * $kinerjaPengajaran->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->nama_matkul }}</td>
                    <td>{{ $item->kode_matkul }}</td>
                    <td>{{ $item->sks }}</td>
                    <td>{{ $item->semester }} - {{ $item->tahun_ajaran }}</td>
                    <td>{{ $item->jenis_pengajaran }}</td>
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
                        <form action="{{ route('kinerja-pengajaran.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kinerja Pengajaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Mata Kuliah</label>
                                            <select name="nama_matkul" class="form-select" id="matkulSelectEdit{{ $item->id }}" required>
                                                <option value="">Pilih Mata Kuliah</option>
                                                @foreach($matkuls as $matkul)
                                                    <option value="{{ $matkul->nama_matakuliah }}"
                                                        data-kode="{{ $matkul->kode_matakuliah }}"
                                                        data-sks="{{ $matkul->sks }}"
                                                        {{ $item->nama_matkul == $matkul->nama_matakuliah ? 'selected' : '' }}>
                                                        {{ $matkul->nama_matakuliah }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kode Mata Kuliah</label>
                                            <input type="text" name="kode_matkul" id="kodeMatkulEdit{{ $item->id }}" value="{{ $item->kode_matkul }}" class="form-control" required readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Jumlah SKS</label>
                                            <input type="number" name="sks" id="sksEdit{{ $item->id }}" value="{{ $item->sks }}" class="form-control" required readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Semester</label>
                                            <input type="text" name="semester" value="{{ $semesterAktif->nama_semester }}" class="form-control" required readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Tahun Ajaran</label>
                                            <input type="text" name="tahun_ajaran" value="{{ $semesterAktif->tahun_ajaran }}" class="form-control" required readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jumlah Pertemuan</label>
                                            <input type="number" name="jumlah_pertemuan" value="{{ $item->jumlah_pertemuan }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Pengajaran</label>
                                            <select name="jenis_pengajaran" class="form-select" required>
                                                <option value="Tim" {{ $item->jenis_pengajaran == 'Tim' ? 'selected' : '' }}>Tim</option>
                                                <option value="Mandiri" {{ $item->jenis_pengajaran == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Upload Bukti</label>
                                            <input type="file" name="bukti_path" class="form-control">
                                            @if($item->bukti_path)
                                                <small class="text-muted">File saat ini:
                                                    <a href="{{ asset('storage/'.$item->bukti_path) }}" target="_blank">Lihat Bukti</a>
                                                </small>
                                            @endif
                                        </div>
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
                                        <p class="mb-3">Apakah Anda yakin ingin menghapus data pengajaran berikut?</p>
                                        <div class="card border-0 bg-light mb-3">
                                            <div class="card-body p-3">
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Mata Kuliah</span>
                                                    <span class="fw-semibold">{{ $item->nama_matkul }}</span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <span class="text-muted" style="width: 120px">Kode</span>
                                                    <span class="fw-semibold">{{ $item->kode_matkul }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <span class="text-muted" style="width: 120px">Semester</span>
                                                    <span class="fw-semibold">{{ $item->semester }} - {{ $item->tahun_ajaran }}</span>
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
                                <form action="{{ route('kinerja-pengajaran.destroy', $item->id) }}" method="POST">
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
                <tr><td colspan="9" class="text-center">Tidak ada data kinerja pengajaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $kinerjaPengajaran->appends(['search' => request('search')])->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kinerja-pengajaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kinerja Pengajaran</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Mata Kuliah</label>
                            <select name="nama_matkul" id="matkulSelect" class="form-select" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matkuls as $matkul)
                                    <option value="{{ $matkul->nama_matakuliah }}"
                                        data-kode="{{ $matkul->kode_matakuliah }}"
                                        data-sks="{{ $matkul->sks }}">
                                        {{ $matkul->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Mata Kuliah</label>
                            <input type="text" name="kode_matkul" id="kodeMatkul" class="form-control" required readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah SKS</label>
                            <input type="number" name="sks" id="sks" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Semester</label>
                            <input type="text" name="semester" class="form-control" value="{{ $semesterAktif->nama_semester }}" readonly required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control" value="{{ $semesterAktif->tahun_ajaran }}" readonly required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Pertemuan</label>
                            <input type="number" name="jumlah_pertemuan" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Pengajaran</label>
                            <select name="jenis_pengajaran" class="form-select" required>
                                <option value="Tim">Tim</option>
                                <option value="Mandiri">Mandiri</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Bukti</label>
                            <input type="file" name="bukti_path" class="form-control" required>
                            <small class="text-muted">Format: PDF, DOC, JPG, PNG, ZIP (Max 5MB)</small>
                        </div>
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

<script>
    // For Add Modal
    document.getElementById('matkulSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('kodeMatkul').value = selectedOption.getAttribute('data-kode');
        document.getElementById('sks').value = selectedOption.getAttribute('data-sks');
    });

    // For Edit Modals
    @foreach($kinerjaPengajaran as $item)
    document.getElementById('matkulSelectEdit{{ $item->id }}').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('kodeMatkulEdit{{ $item->id }}').value = selectedOption.getAttribute('data-kode');
        document.getElementById('sksEdit{{ $item->id }}').value = selectedOption.getAttribute('data-sks');
    });
    @endforeach
</script>

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
