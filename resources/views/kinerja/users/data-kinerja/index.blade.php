@extends('layouts.admin_template')
@section('title', 'Data Kinerja Dosen')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="mb-0">Data <span>Kinerja Dosen</span></h3>
        <p class="text-muted">Form penilaian kinerja dosen semester aktif</p>
    </div>

    @if($kinerjaDosen)
        <!-- Form Edit -->
        <div class="card kinerja-card">
            <div class="card-header kinerja-card-header text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-file-earmark-text me-2"></i>Form Kinerja Dosen</h5>
            </div>
            <div class="card-body">
                @if($kinerjaDosen->status_penilaian == 'Menunggu' && $kinerjaDosen->is_updated == '0')
                    <form action="{{ route('data-kinerja.update', $kinerjaDosen->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                @endif

                @if($kinerjaDosen->status_penilaian == 'Menunggu' && $kinerjaDosen->is_updated == '1')
                    <form action="{{ route('data-kinerja.updateStored', $kinerjaDosen->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                @endif

                <div class="row">
                    <!-- Data Dosen -->
                    <div class="col-md-12 mb-3 mt-3">
                        <div class="info-box">
                            <label class="form-label">Dosen</label>
                            <input type="hidden" name="id_dosen" value="{{ $user->id }}">
                            <div class="info-content">{{ $user->name }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <label class="form-label">NIP/NIDN</label>
                            <div class="info-content">{{ $user->nip ?? '-' }} / {{ $user->nidn ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <label class="form-label">Jabatan</label>
                            <div class="info-content">{{ $user->jabatan ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <label class="form-label">Pangkat</label>
                            <div class="info-content">{{ $user->pangkat ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <label class="form-label">Semester</label>
                            <input type="hidden" name="id_semester" value="{{ $semesterAktif->id }}">
                            <div class="info-content">{{ $semesterAktif->nama_semester }} {{ $semesterAktif->tahun_ajaran }}</div>
                        </div>
                    </div>

                    <!-- Status Info -->
                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <label class="form-label">Status Penilaian</label> <br>
                            <div class="info-content status-badge status-{{ strtolower(str_replace(' ', '-', $kinerjaDosen->status_penilaian)) }}">
                                {{ $kinerjaDosen->status_penilaian }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box">
                            <label class="form-label">Tanggal Pengisian Terakhir</label>
                            <div class="info-content">
                                {{ $kinerjaDosen->tanggal_pengisian ? \Carbon\Carbon::parse($kinerjaDosen->tanggal_pengisian)->translatedFormat('d F Y') : '-' }}
                            </div>
                        </div>
                    </div>

                    @if($kinerjaDosen->status_penilaian == 'Selesai')
                        <!-- Hasil Penilaian -->
                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <label class="form-label">Total Skor</label>
                                <div class="info-content score-display">
                                    {{ $kinerjaDosen->total_skor ?? '0' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <label class="form-label">Validator</label>
                                <div class="info-content">
                                    {{ $kinerjaDosen->validator->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="info-box">
                                <label class="form-label">Tanggal Validasi</label>
                                <div class="info-content">
                                    {{ $kinerjaDosen->tanggal_validasi ? \Carbon\Carbon::parse($kinerjaDosen->tanggal_validasi)->translatedFormat('d F Y') : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="info-box">
                                <label class="form-label">Catatan Validator</label>
                                <div class="info-content notes-box">
                                    {{ $kinerjaDosen->catatan ?? 'Tidak ada catatan' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Tombol Aksi -->
                @if($kinerjaDosen->status_penilaian == 'Menunggu')
                    <div class="form-footer text-end mt-4">
                        @if($kinerjaDosen->is_updated == '0')
                            <button type="submit" class="btn btn-update">
                                <i class="bi bi-pencil-square me-2"></i>Perbarui
                            </button>
                        @else
                            <button type="submit" class="btn btn-subupdate">
                                <i class="bi bi-save me-2"></i>Simpan Terbaru
                            </button>
                        @endif
                    </div>
                @endif
                </form>
            </div>
        </div>
    @else
        <!-- Form Tambah -->
        <div class="card kinerja-card">
            <div class="card-header kinerja-card-header text-white">
                <h5 class="mb-0 text-white"><i class="bi bi-file-earmark-plus me-2"></i>Form Kinerja Dosen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('data-kinerja.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3 mt-3">
                            <div class="info-box">
                                <label class="form-label">Dosen</label>
                                <input type="hidden" name="id_dosen" value="{{ $user->id }}">
                                <div class="info-content">{{ $user->name }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <label class="form-label">NIP/NIDN</label>
                                <div class="info-content">{{ $user->nip ?? '-' }} / {{ $user->nidn ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <label class="form-label">Jabatan</label>
                                <div class="info-content">{{ $user->jabatan ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <label class="form-label">Pangkat</label>
                                <div class="info-content">{{ $user->pangkat ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <label class="form-label">Semester</label>
                                <input type="hidden" name="id_semester" value="{{ $semesterAktif->id }}">
                                <div class="info-content">{{ $semesterAktif->nama_semester }} {{ $semesterAktif->tahun_ajaran }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer text-end mt-4">
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<style>
    .kinerja-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .kinerja-card-header {
        background-color: #008374;
        border-bottom: none;
    }

    .info-box {
        margin-bottom: 1rem;
    }

    .info-box label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .info-content {
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        border-left: 4px solid #008374;
    }

    .status-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-weight: 500;
    }

    .status-menunggu {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-selesai {
        background-color: #d4edda;
        color: #155724;
    }

    .score-display {
        font-size: 1.5rem;
        font-weight: 600;
        color: #008374;
    }

    .notes-box {
        white-space: pre-line;
        min-height: 100px;
    }

    .form-footer {
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }

    .btn-submit {
        background-color: #008374;
        color: white;
    }

    .btn-update {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-subupdate {
        background-color: #0322cc;
        color: #ffffff;
    }

    .btn-submit:hover {
        background-color: #006a5d;
    }

    .btn-update:hover {
        background-color: #e0a800;
    }
</style>
@endsection
