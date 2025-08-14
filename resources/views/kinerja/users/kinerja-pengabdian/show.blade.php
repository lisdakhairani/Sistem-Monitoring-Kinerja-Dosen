@extends('layouts.admin_template')
@section('title', 'Detail Kinerja Pengabdian')

@section('content')

    <div class="row justify-content-center p-4">
        <div class="col-md-12">
            <div class="card research-detail-card">
                <div class="card-header research-detail-header bg-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white"><i class="bi bi-people-fill me-2"></i>Detail Kinerja Pengabdian</h4>
                        <span class="badge research-status-badge">
                            {{ $kinerjaPengabdian->tingkat_kegiatan }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Activity Title Section -->
                    <div class="research-title-section text-center mb-4">
                        <h2 class="research-title">{{ $kinerjaPengabdian->judul_kegiatan }}</h2>
                        <div class="research-meta">
                            <span class="research-year"><i class="bi bi-calendar me-1"></i>{{ $kinerjaPengabdian->tahun_kegiatan }}</span>
                            <span class="research-type"><i class="bi bi-geo-alt me-1"></i>{{ $kinerjaPengabdian->lokasi }}</span>
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
                                        <span class="info-label">Jenis Kegiatan</span>
                                        <span class="info-value">{{ $kinerjaPengabdian->jenis_kegiatan }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Peran dalam Pengabdian</span>
                                        <span class="info-value">{{ $kinerjaPengabdian->peran_pengabdian }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Tingkat Kegiatan</span>
                                        <span class="info-value">
                                            <span class="status-badge status-{{ strtolower($kinerjaPengabdian->tingkat_kegiatan) }}">
                                                {{ $kinerjaPengabdian->tingkat_kegiatan }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Skor</span>
                                        <span class="info-value">{{ $kinerjaPengabdian->skor }}</span>
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
                                        <span class="info-value">{{ $kinerjaPengabdian->sumber_dana }}</span>
                                    </div>
                                    <div class="info-item highlight-item">
                                        <span class="info-label">Jumlah Dana</span>
                                        <span class="info-value">Rp {{ number_format($kinerjaPengabdian->jumlah_dana, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="research-info-card">
                                <div class="info-card-header">
                                    <i class="bi bi-file-earmark-check me-2"></i>Bukti Pengabdian
                                </div>
                                <div class="info-card-body">
                                    @if($kinerjaPengabdian->bukti_path)
                                        <div class="document-preview">
                                            <div class="document-icon">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </div>
                                            <div class="document-info">
                                                <a href="{{ asset('storage/'.$kinerjaPengabdian->bukti_path) }}" 
                                                   target="_blank" 
                                                   class="document-link">
                                                   Lihat Dokumen Bukti
                                                </a>
                                                <div class="document-meta">
                                                    <small><i class="bi bi-calendar me-1"></i>Uploaded: {{ $kinerjaPengabdian->updated_at->format('d M Y H:i') }}</small>
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

                    <!-- Additional Info Section -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="research-info-card">
                                <div class="info-card-header">
                                    <i class="bi bi-box-seam me-2"></i>Detail Output
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Output</span>
                                        <span class="info-value">{{ $kinerjaPengabdian->output }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Bidang Keahlian/Divisi</span>
                                        <span class="info-value">{{ $kinerjaPengabdian->bidang_keahlian }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="research-actions mt-4">
                        <a href="{{ route('kinerja-pengabdian.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        
                        @if ($kinerjaDosenID && $kinerjaDosenID->status_penilaian === 'Menunggu' && $kinerjaDosenID->is_updated == 1)
                            <button class="btn btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit{{ $kinerjaPengabdian->id }}">
                                <i class="bi bi-pencil-square me-2"></i>Edit Data
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $kinerjaPengabdian->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kinerja-pengabdian.update', $kinerjaPengabdian->id) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="judul_kegiatan" value="{{ $kinerjaPengabdian->judul_kegiatan }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kegiatan</label>
                            <input type="text" name="jenis_kegiatan" value="{{ $kinerjaPengabdian->jenis_kegiatan }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Peran dalam Pengabdian</label>
                            <select name="peran_pengabdian" class="form-select" required>
                                <option value="Ketua" {{ $kinerjaPengabdian->peran_pengabdian == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                                <option value="Anggota" {{ $kinerjaPengabdian->peran_pengabdian == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ $kinerjaPengabdian->lokasi }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Kegiatan</label>
                            <input type="number" name="tahun_kegiatan" value="{{ $kinerjaPengabdian->tahun_kegiatan }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sumber Dana</label>
                            <input type="text" name="sumber_dana" value="{{ $kinerjaPengabdian->sumber_dana }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Dana</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="number" name="jumlah_dana" value="{{ $kinerjaPengabdian->jumlah_dana }}" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Output</label>
                            <input type="text" name="output" value="{{ $kinerjaPengabdian->output }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tingkat Kegiatan</label>
                            <select name="tingkat_kegiatan" class="form-select" required>
                                <option value="Lokal" {{ $kinerjaPengabdian->tingkat_kegiatan == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                <option value="Nasional" {{ $kinerjaPengabdian->tingkat_kegiatan == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ $kinerjaPengabdian->tingkat_kegiatan == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Bidang Keahlian/Divisi</label>
                            <input type="text" name="bidang_keahlian" value="{{ $kinerjaPengabdian->bidang_keahlian }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Bukti</label>
                        <input type="file" name="bukti_path" class="form-control">
                        @if($kinerjaPengabdian->bukti_path)
                            <small class="text-muted">File saat ini:
                                <a href="{{ asset('storage/'.$kinerjaPengabdian->bukti_path) }}" target="_blank">Lihat Bukti</a>
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
        background: linear-gradient(135deg, #007bff 0%, #00b4ff 100%);
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
    
    /* Activity Title Section */
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
        color: #007bff;
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
    
    .status-internasional {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .status-nasional {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .status-lokal {
        background-color: #e2e3e5;
        color: #383d41;
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
        color: #007bff;
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