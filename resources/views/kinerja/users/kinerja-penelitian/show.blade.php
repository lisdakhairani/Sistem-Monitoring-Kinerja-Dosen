@extends('layouts.admin_template')
@section('title', 'Detail Kinerja Penelitian')

@section('content')

    <div class="row justify-content-center p-4">
        <div class="col-md-12">
            <div class="card research-detail-card">
                <div class="card-header research-detail-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white"><i class="bi bi-clipboard2-data me-2"></i>Detail Kinerja Penelitian</h4>
                        <span class="badge research-status-badge">
                            {{ $kinerjaPenelitian->status_penelitian }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Research Title Section -->
                    <div class="research-title-section text-center mb-4">
                        <h2 class="research-title">{{ $kinerjaPenelitian->judul_penelitian }}</h2>
                        <div class="research-meta">
                            <span class="research-year"><i class="bi bi-calendar me-1"></i>{{ $kinerjaPenelitian->tahun_penelitian }}</span>
                            <span class="research-type"><i class="bi bi-tag me-1"></i>{{ $kinerjaPenelitian->bentuk_penelitian }}</span>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="research-info-card mb-4">
                                <div class="info-card-header">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Dasar
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Jenis Penelitian</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->jenis_penelitian }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Peran Penelitian</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->peran_penelitian }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Status Penelitian</span>
                                        <span class="info-value">
                                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $kinerjaPenelitian->status_penelitian)) }}">
                                                {{ $kinerjaPenelitian->status_penelitian }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Skor</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->skor }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="research-info-card mb-4">
                                <div class="info-card-header">
                                    <i class="bi bi-journal-text me-2"></i>Detail Publikasi
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Nomor/Volume/ISBN</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->nomor_volume_isbn ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jumlah Halaman</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->jumlah_halaman ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Penerbit</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->penerbit ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="research-info-card mb-4">
                                <div class="info-card-header">
                                    <i class="bi bi-cash-stack me-2"></i>Informasi Pendanaan
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Sumber Dana</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->sumber_dana }}</span>
                                    </div>
                                    <div class="info-item highlight-item">
                                        <span class="info-label">Jumlah Dana</span>
                                        <span class="info-value">Rp {{ number_format($kinerjaPenelitian->jumlah_dana, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="research-info-card mb-4">
                                <div class="info-card-header">
                                    <i class="bi bi-box-seam me-2"></i>Output Penelitian
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Output/Luaran</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->output_luaran }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Bentuk Penelitian</span>
                                        <span class="info-value">{{ $kinerjaPenelitian->bentuk_penelitian }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="research-info-card">
                                <div class="info-card-header">
                                    <i class="bi bi-file-earmark-check me-2"></i>Bukti Penelitian
                                </div>
                                <div class="info-card-body">
                                    @if($kinerjaPenelitian->bukti_path)
                                        <div class="document-preview">
                                            <div class="document-icon">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </div>
                                            <div class="document-info">
                                                <a href="{{ asset('storage/'.$kinerjaPenelitian->bukti_path) }}" 
                                                   target="_blank" 
                                                   class="document-link">
                                                   Lihat Dokumen Bukti
                                                </a>
                                                <div class="document-meta">
                                                    <small><i class="bi bi-calendar me-1"></i>Uploaded: {{ $kinerjaPenelitian->updated_at->format('d M Y H:i') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning alert-document">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Tidak ada dokumen bukti yang diupload
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="research-actions mt-4">
                        <a href="{{ route('kinerja-penelitian.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        
                        @if ($kinerjaDosenID && $kinerjaDosenID->status_penilaian === 'Menunggu' && $kinerjaDosenID->is_updated == 1)
                            <button class="btn btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit{{ $kinerjaPenelitian->id }}">
                                <i class="bi bi-pencil-square me-2"></i>Edit Data
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit (copied from index.blade.php) -->
<div class="modal fade" id="modalEdit{{ $kinerjaPenelitian->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kinerja-penelitian.update', $kinerjaPenelitian->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kinerja Penelitian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="kinerja_dosen_id" value="{{ $kinerjaDosenID->id }}">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Judul Penelitian</label>
                            <input type="text" name="judul_penelitian" value="{{ $kinerjaPenelitian->judul_penelitian }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Penelitian</label>
                            <select name="jenis_penelitian" class="form-select" required>
                                <option value="Tim" {{ $kinerjaPenelitian->jenis_penelitian == 'Tim' ? 'selected' : '' }}>Tim</option>
                                <option value="Mandiri" {{ $kinerjaPenelitian->jenis_penelitian == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Peran Penelitian</label>
                            <select name="peran_penelitian" class="form-select" required>
                                <option value="Ketua" {{ $kinerjaPenelitian->peran_penelitian == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                <option value="Anggota" {{ $kinerjaPenelitian->peran_penelitian == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Dana</label>
                            <input type="text" name="sumber_dana" value="{{ $kinerjaPenelitian->sumber_dana }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Dana</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" name="jumlah_dana" class="form-control" value="{{ $kinerjaPenelitian->jumlah_dana }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Penelitian</label>
                            <input type="number" name="tahun_penelitian" value="{{ $kinerjaPenelitian->tahun_penelitian }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Penelitian</label>
                            <select name="status_penelitian" class="form-select" required>
                                <option value="Sedang Berjalan" {{ $kinerjaPenelitian->status_penelitian == 'Sedang Berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                                <option value="Selesai" {{ $kinerjaPenelitian->status_penelitian == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Output/Luaran</label>
                            <input type="text" name="output_luaran" value="{{ $kinerjaPenelitian->output_luaran }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bentuk Penelitian</label>
                            <select name="bentuk_penelitian" class="form-select" required>
                                <option value="Buku" {{ $kinerjaPenelitian->bentuk_penelitian == 'Buku' ? 'selected' : '' }}>Buku</option>
                                <option value="Monograf" {{ $kinerjaPenelitian->bentuk_penelitian == 'Monograf' ? 'selected' : '' }}>Monograf</option>
                                <option value="Jurnal Internasional" {{ $kinerjaPenelitian->bentuk_penelitian == 'Jurnal Internasional' ? 'selected' : '' }}>Jurnal Internasional</option>
                                <option value="Jurnal Nasional" {{ $kinerjaPenelitian->bentuk_penelitian == 'Jurnal Nasional' ? 'selected' : '' }}>Jurnal Nasional</option>
                                <option value="Prosiding" {{ $kinerjaPenelitian->bentuk_penelitian == 'Prosiding' ? 'selected' : '' }}>Prosiding</option>
                                <option value="Penelitian Non-Publikasi" {{ $kinerjaPenelitian->bentuk_penelitian == 'Penelitian Non-Publikasi' ? 'selected' : '' }}>Penelitian Non-Publikasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor/Volume/ISBN</label>
                            <input type="text" name="nomor_volume_isbn" value="{{ $kinerjaPenelitian->nomor_volume_isbn }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Halaman</label>
                            <input type="number" name="jumlah_halaman" value="{{ $kinerjaPenelitian->jumlah_halaman }}" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" value="{{ $kinerjaPenelitian->penerbit }}" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Bukti</label>
                            <input type="file" name="bukti_path" class="form-control">
                            @if($kinerjaPenelitian->bukti_path)
                                <small class="text-muted">File saat ini:
                                    <a href="{{ asset('storage/'.$kinerjaPenelitian->bukti_path) }}" target="_blank">Lihat Bukti</a>
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


<style>
    /* Main Card Styling */
    .research-detail-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .research-detail-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        padding: 1.5rem;
        border-bottom: none;
    }
    
    .research-status-badge {
        background-color: rgba(255, 255, 255, 0.2);
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.35rem 0.8rem;
        border-radius: 50px;
    }
    
    /* Research Title Section */
    .research-title-section {
        padding: 1.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .research-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .research-meta {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        color: #6c757d;
        font-size: 0.95rem;
    }
    
    /* Info Card Styling */
    .research-info-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        
    }
    
    .info-card-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        color: #495057;
        display: flex;
        align-items: center;
    }
    
    .info-card-body {
        padding: 1.25rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem 0;
        border-bottom: 1px dashed #e9ecef;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 500;
        color: #6c757d;
    }
    
    .info-value {
        font-weight: 500;
        color: #495057;
        text-align: right;
    }
    
    .highlight-item .info-value {
        color: #28a745;
        font-weight: 600;
    }
    
    /* Status Badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-selesai {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-sedang-berjalan {
        background-color: #fff3cd;
        color: #856404;
    }
    
    /* Document Preview */
    .document-preview {
        display: flex;
        align-items: center;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .document-icon {
        font-size: 2rem;
        color: #dc3545;
        margin-right: 1rem;
    }
    
    .document-info {
        flex: 1;
    }
    
    .document-link {
        font-weight: 500;
        color: #2c3e50;
        text-decoration: none;
        display: block;
        margin-bottom: 0.25rem;
    }
    
    .document-link:hover {
        color: #28a745;
    }
    
    .document-meta {
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    .alert-document {
        border-radius: 8px;
        display: flex;
        align-items: center;
    }
    
    /* Action Buttons */
    .research-actions {
        display: flex;
        justify-content: space-between;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background-color: #5a6268;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-edit {
        background-color: #ffc107;
        color: #212529;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-edit:hover {
        background-color: #e0a800;
        color: #212529;
        transform: translateY(-2px);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .research-title {
            font-size: 1.5rem;
        }
        
        .research-meta {
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }
        
        .info-item {
            flex-direction: column;
        }
        
        .info-label, .info-value {
            text-align: left;
            width: 100%;
        }
        
        .info-value {
            margin-top: 0.25rem;
        }
    }
</style>
@endsection