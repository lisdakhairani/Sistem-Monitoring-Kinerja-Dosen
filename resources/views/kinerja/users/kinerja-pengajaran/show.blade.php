@extends('layouts.admin_template')
@section('title', 'Detail Kinerja Pengajaran')

@section('content')
    <div class="row justify-content-center p-4">
        <div class="col-md-12">
            <div class="card research-detail-card">
                <div class="card-header research-detail-header bg-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white"><i class="bi bi-journal-bookmark me-2"></i>Detail Kinerja Pengajaran</h4>
                        <span class="badge research-status-badge">
                            {{ $semesterAktif->nama_semester }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Course Title Section -->
                    <div class="research-title-section text-center mb-4">
                        <h2 class="research-title">{{ $kinerjaPengajaran->nama_matkul }}</h2>
                        <div class="research-meta">
                            <span class="research-code"><i class="bi bi-tag me-1"></i>{{ $kinerjaPengajaran->kode_matkul }}</span>
                            <span class="research-sks"><i class="bi bi-collection me-1"></i>{{ $kinerjaPengajaran->sks }} SKS</span>
                            <span class="research-semester"><i class="bi bi-calendar-range me-1"></i>{{ $kinerjaPengajaran->semester }} - {{ $kinerjaPengajaran->tahun_ajaran }}</span>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="research-info-card mb-4">
                                <div class="info-card-header">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Mata Kuliah
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Kode Mata Kuliah</span>
                                        <span class="info-value">{{ $kinerjaPengajaran->kode_matkul }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jumlah SKS</span>
                                        <span class="info-value">{{ $kinerjaPengajaran->sks }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Semester</span>
                                        <span class="info-value">{{ $kinerjaPengajaran->semester }} - {{ $kinerjaPengajaran->tahun_ajaran }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Skor</span>
                                        <span class="info-value">{{ $kinerjaPengajaran->skor }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="research-info-card mb-4">
                                <div class="info-card-header">
                                    <i class="bi bi-journal-text me-2"></i>Detail Pengajaran
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <span class="info-label">Jumlah Pertemuan</span>
                                        <span class="info-value">{{ $kinerjaPengajaran->jumlah_pertemuan }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jenis Pengajaran</span>
                                        <span class="info-value">{{ $kinerjaPengajaran->jenis_pengajaran }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="research-info-card">
                                <div class="info-card-header">
                                    <i class="bi bi-file-earmark-check me-2"></i>Bukti Pengajaran
                                </div>
                                <div class="info-card-body">
                                    @if($kinerjaPengajaran->bukti_path)
                                        <div class="document-preview">
                                            <div class="document-icon">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </div>
                                            <div class="document-info">
                                                <a href="{{ asset('storage/'.$kinerjaPengajaran->bukti_path) }}" 
                                                   target="_blank" 
                                                   class="document-link">
                                                   Lihat Dokumen Bukti
                                                </a>
                                                <div class="document-meta">
                                                    <small><i class="bi bi-calendar me-1"></i>Uploaded: {{ $kinerjaPengajaran->updated_at->format('d M Y H:i') }}</small>
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
                        <a href="{{ route('kinerja-pengajaran.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        
                        @if ($kinerjaDosenID && $kinerjaDosenID->status_penilaian === 'Menunggu' && $kinerjaDosenID->is_updated == 1)
                            <button class="btn btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit{{ $kinerjaPengajaran->id }}">
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
<div class="modal fade" id="modalEdit{{ $kinerjaPengajaran->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kinerja-pengajaran.update', $kinerjaPengajaran->id) }}" method="POST" enctype="multipart/form-data">
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
                            <select name="nama_matkul" class="form-select" id="matkulSelectEdit{{ $kinerjaPengajaran->id }}" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matkuls as $matkul)
                                    <option value="{{ $matkul->nama_matakuliah }}" 
                                        data-kode="{{ $matkul->kode_matakuliah }}"
                                        data-sks="{{ $matkul->sks }}"
                                        {{ $kinerjaPengajaran->nama_matkul == $matkul->nama_matakuliah ? 'selected' : '' }}>
                                        {{ $matkul->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Mata Kuliah</label>
                            <input type="text" name="kode_matkul" id="kodeMatkulEdit{{ $kinerjaPengajaran->id }}" value="{{ $kinerjaPengajaran->kode_matkul }}" class="form-control" required readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah SKS</label>
                            <input type="number" name="sks" id="sksEdit{{ $kinerjaPengajaran->id }}" value="{{ $kinerjaPengajaran->sks }}" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Semester</span>
                            <input type="text" name="semester" value="{{ $semesterAktif->nama_semester }}" class="form-control mt-2" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ $semesterAktif->tahun_ajaran }}" class="form-control" required readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Pertemuan</label>
                            <input type="number" name="jumlah_pertemuan" value="{{ $kinerjaPengajaran->jumlah_pertemuan }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Pengajaran</label>
                            <select name="jenis_pengajaran" class="form-select" required>
                                <option value="Tim" {{ $kinerjaPengajaran->jenis_pengajaran == 'Tim' ? 'selected' : '' }}>Tim</option>
                                <option value="Mandiri" {{ $kinerjaPengajaran->jenis_pengajaran == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                       
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Bukti</label>
                            <input type="file" name="bukti_path" class="form-control">
                            @if($kinerjaPengajaran->bukti_path)
                                <small class="text-muted">File saat ini:
                                    <a href="{{ asset('storage/'.$kinerjaPengajaran->bukti_path) }}" target="_blank">Lihat Bukti</a>
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

<script>
    // For Edit Modal
    document.getElementById('matkulSelectEdit{{ $kinerjaPengajaran->id }}').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('kodeMatkulEdit{{ $kinerjaPengajaran->id }}').value = selectedOption.getAttribute('data-kode');
        document.getElementById('sksEdit{{ $kinerjaPengajaran->id }}').value = selectedOption.getAttribute('data-sks');
    });
</script>

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
    
    /* Course Title Section */
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