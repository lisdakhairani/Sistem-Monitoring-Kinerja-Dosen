@extends('layouts.admin_template')
@section('title', 'Detail Kinerja Dosen')

@section('content')
<div class="container py-4">
    <div class="card performance-card">
        <div class="card-header performance-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white"><i class="bi bi-file-earmark-bar-graph me-2"></i> Kinerja Dosen</h4>
                <span class="badge performance-status-badge bg-{{
                    $arsip->status_penilaian == 'Selesai' ? 'success' :
                    ($arsip->status_penilaian == 'Sedang Dinilai' ? 'warning' : 'secondary')
                }}">
                    {{ $arsip->status_penilaian }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <!-- Header Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="lecturer-info-card mb-4">
                        <div class="info-card-header">
                            <i class="bi bi-person-badge me-2"></i>Informasi Dosen
                        </div>
                        <div class="info-card-body">
                            <div class="info-item">
                                <span class="info-label">Nama Dosen</span>
                                <span class="info-value">{{ $arsip->dosen->name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">NIP/NIDN</span>
                                <span class="info-value">{{ $arsip->dosen->nip ?? '-' }} / {{  $arsip->dosen->nidn ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Jabatan</span>
                                <span class="info-value">{{ $arsip->dosen->jabatan ?? '-' }} </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Pangkat</span>
                                <span class="info-value">{{ $arsip->dosen->pangkat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="lecturer-info-card mb-4">
                        <div class="info-card-header">
                            <i class="bi bi-calendar-check me-2"></i>Informasi Periode
                        </div>
                        <div class="info-card-body">
                            <div class="info-item">
                                <span class="info-label">Semester</span>
                                <span class="info-value">{{ $arsip->semester->nama_semester }}  {{ $arsip->semester->tahun_ajaran }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal Pengisian</span>
                                <span class="info-value">{{ optional($arsip->tanggal_pengisian)->format('d F Y') ?? '-' }}</span>
                            </div>
                              <div class="info-item">
                                <span class="info-label">Tanggal Validasi</span>
                                <span class="info-value">{{ optional($arsip->tanggal_validasi)->format('d F Y') ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Validator</span>
                                <span class="info-value">{{ $arsip->validator->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Sections -->
            <div class="performance-section mb-5">
                <div class="section-header">
                    <i class="bi bi-mortarboard me-2"></i>
                    <h5>1. Kinerja Pengajaran</h5>
                </div>
                <div class="table-responsive">
                    <table class="table performance-table">
                        <thead>
                            <tr>
                                <th width="60%">Detail Pengajaran</th>
                                <th width="20%" class="text-center">Bukti</th>
                                <th width="20%" class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip->pengajaran as $pengajaran)
                            <tr>
                                <td>
                                    <div class="activity-title">{{ $pengajaran->nama_matkul }}</div>
                                    <div class="activity-details">
                                        <span><i class="bi bi-tag"></i> {{ $pengajaran->kode_matkul }}</span>
                                        <span><i class="bi bi-collection"></i> {{ $pengajaran->sks }} SKS</span>
                                        <span><i class="bi bi-calendar-range"></i> {{ $pengajaran->semester }} - {{ $pengajaran->tahun_ajaran }}</span>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    @if($pengajaran->bukti_path)
                                    <a href="{{ asset('storage/' . $pengajaran->bukti_path) }}" target="_blank" class="btn btn-view">
                                        <i class="bi bi-file-earmark-text"></i> Lihat
                                    </a>
                                    @else
                                    <span class="no-evidence">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle score-value">{{ number_format($pengajaran->skor, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center no-data">Tidak ada data pengajaran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="performance-section mb-5">
                <div class="section-header">
                    <i class="bi bi-clipboard-data me-2"></i>
                    <h5>2. Kinerja Penelitian</h5>
                </div>
                <div class="table-responsive">
                    <table class="table performance-table">
                        <thead>
                            <tr>
                                <th width="60%">Detail Penelitian</th>
                                <th width="20%" class="text-center">Bukti</th>
                                <th width="20%" class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip->penelitian as $penelitian)
                            <tr>
                                <td>
                                    <div class="activity-title">{{ $penelitian->judul_penelitian }}</div>
                                    <div class="activity-details">
                                        <span><i class="bi bi-tag"></i> {{ $penelitian->jenis_penelitian }}</span>
                                        <span><i class="bi bi-calendar"></i> {{ $penelitian->tahun_penelitian }}</span>
                                        <span><i class="bi bi-cash-coin"></i> Rp{{ number_format($penelitian->jumlah_dana, 0, ',', '.') }}</span>
                                        <span><i class="bi bi-building"></i> {{ $penelitian->sumber_dana }}</span>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    @if($penelitian->bukti_path)
                                    <a href="{{ asset('storage/' . $penelitian->bukti_path) }}" target="_blank" class="btn btn-view">
                                        <i class="bi bi-file-earmark-text"></i> Lihat
                                    </a>
                                    @else
                                    <span class="no-evidence">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle score-value">{{ number_format($penelitian->skor, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center no-data">Tidak ada data penelitian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="performance-section mb-5">
                <div class="section-header">
                    <i class="bi bi-people me-2"></i>
                    <h5>3. Kinerja Pengabdian</h5>
                </div>
                <div class="table-responsive">
                    <table class="table performance-table">
                        <thead>
                            <tr>
                                <th width="60%">Detail Pengabdian</th>
                                <th width="20%" class="text-center">Bukti</th>
                                <th width="20%" class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip->pengabdian as $pengabdian)
                            <tr>
                                <td>
                                    <div class="activity-title">{{ $pengabdian->judul_kegiatan }}</div>
                                    <div class="activity-details">
                                        <span><i class="bi bi-tag"></i> {{ $pengabdian->jenis_kegiatan }}</span>
                                        <span><i class="bi bi-geo-alt"></i> {{ $pengabdian->lokasi }}</span>
                                        <span><i class="bi bi-calendar"></i> {{ $pengabdian->tahun_kegiatan }}</span>
                                        <span><i class="bi bi-building"></i> {{ $pengabdian->sumber_dana }}</span>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    @if($pengabdian->bukti_path)
                                    <a href="{{ asset('storage/' . $pengabdian->bukti_path) }}" target="_blank" class="btn btn-view">
                                        <i class="bi bi-file-earmark-text"></i> Lihat
                                    </a>
                                    @else
                                    <span class="no-evidence">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle score-value">{{ number_format($pengabdian->skor, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center no-data">Tidak ada data pengabdian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="performance-section mb-5">
                <div class="section-header">
                    <i class="bi bi-award me-2"></i>
                    <h5>4. Kinerja Penunjang</h5>
                </div>
                <div class="table-responsive">
                    <table class="table performance-table">
                        <thead>
                            <tr>
                                <th width="60%">Detail Kegiatan Penunjang</th>
                                <th width="20%" class="text-center">Bukti</th>
                                <th width="20%" class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip->penunjang as $penunjang)
                            <tr>
                                <td>
                                    <div class="activity-title">{{ $penunjang->nama_kegiatan }}</div>
                                    <div class="activity-details">
                                        <span><i class="bi bi-tag"></i> {{ $penunjang->jenis_kegiatan }}</span>
                                        <span><i class="bi bi-calendar-event"></i> {{ $penunjang->tanggal_kegiatan->format('d F Y') }}</span>
                                        <span><i class="bi bi-building"></i> {{ $penunjang->institusi_penyelenggara }}</span>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    @if($penunjang->bukti_path)
                                    <a href="{{ asset('storage/' . $penunjang->bukti_path) }}" target="_blank" class="btn btn-view">
                                        <i class="bi bi-file-earmark-text"></i> Lihat
                                    </a>
                                    @else
                                    <span class="no-evidence">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle score-value">{{ number_format($penunjang->skor, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center no-data">Tidak ada data penunjang</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Score Calculation -->
            <div class="score-section mt-5">
                <div class="section-header">
                    <i class="bi bi-calculator me-2"></i>
                    <h5>Perhitungan Skor Kinerja</h5>
                </div>
                <div class="table-responsive">
                    <table class="table score-table">
                        <thead>
                            <tr>
                                <th>Komponen Kinerja</th>
                                <th class="text-center">Rata-rata Skor</th>
                                <th class="text-center">Bobot</th>
                                <th class="text-center">Skor Tertimbang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-mortarboard me-2"></i>Pengajaran</td>
                                <td class="text-center">{{ number_format($avgPengajaran, 2) }}</td>
                                <td class="text-center">20%</td>
                                <td class="text-center">{{ number_format($weightedPengajaran, 2) }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-clipboard-data me-2"></i>Penelitian</td>
                                <td class="text-center">{{ number_format($avgPenelitian, 2) }}</td>
                                <td class="text-center">40%</td>
                                <td class="text-center">{{ number_format($weightedPenelitian, 2) }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-people me-2"></i>Pengabdian</td>
                                <td class="text-center">{{ number_format($avgPengabdian, 2) }}</td>
                                <td class="text-center">20%</td>
                                <td class="text-center">{{ number_format($weightedPengabdian, 2) }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-award me-2"></i>Penunjang</td>
                                <td class="text-center">{{ number_format($avgPenunjang, 2) }}</td>
                                <td class="text-center">20%</td>
                                <td class="text-center">{{ number_format($weightedPenunjang, 2) }}</td>
                            </tr>
                            <tr class="total-row">
                                <th>Total Skor Kinerja</th>
                                <th colspan="3" class="text-center">{{ number_format($totalScore, 2) }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="action-buttons mt-4 text-center">
                <a href="{{ route('arsip.index') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>

                <!-- Tambahkan tombol ekspor di sini -->
                <a href="{{ route('arsip.export.excel', $arsip->id) }}" class="btn btn-export-excel">
                    <i class="bi bi-file-earmark-excel me-2"></i>Excel
                </a>

                <a href="{{ route('arsip.export.pdf', $arsip->id) }}" class="btn btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf me-2"></i>PDF
                </a>

            </div>
        </div>
    </div>
</div>

<style>
    .btn-export-excel {
        background-color: #1d6f42;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-export-excel:hover {
        background-color: #166534;
        color: white;
        transform: translateY(-2px);
    }

    .btn-export-pdf {
        background-color: #b91c1c;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-export-pdf:hover {
        background-color: #991b1b;
        color: white;
        transform: translateY(-2px);
    }

    /* Main Card Styling */
    .performance-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .performance-header {
        background: linear-gradient(135deg, #007bff 0%, #00b4ff 100%);
        padding: 1.5rem;
        border-bottom: none;
    }

    .performance-status-badge {
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.35rem 0.8rem;
        border-radius: 50px;
    }

    /* Info Card Styling */
    .lecturer-info-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: 100%;
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

    /* Section Styling */
    .performance-section {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f1f1;
    }

    .section-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .section-header i {
        font-size: 1.5rem;
        color: #007bff;
        margin-right: 10px;
    }

    /* Table Styling */
    .performance-table {
        border-radius: 8px;
        overflow: hidden;
    }

    .performance-table thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .performance-table th {
        font-weight: 600;
        color: #495057;
        border-bottom-width: 2px;
    }

    .performance-table td {
        vertical-align: middle;
    }

    .activity-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .activity-details {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .activity-details span {
        display: flex;
        align-items: center;
    }

    .activity-details i {
        margin-right: 3px;
        font-size: 0.9rem;
    }

    /* Button Styling */
    .btn-view {
        background-color: #0dcaf0;
        color: white;
        border: none;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background-color: #0bb6d9;
        color: white;
        transform: translateY(-1px);
    }

    .no-evidence {
        color: #6c757d;
        font-style: italic;
    }

    .no-data {
        color: #6c757d;
        padding: 1.5rem !important;
    }

    /* Score Table Styling */
    .score-table {
        border-radius: 8px;
    }

    .score-table thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .score-table th {
        font-weight: 600;
    }

    .score-table td {
        vertical-align: middle;
    }

    .score-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .total-row {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .total-row th {
        color: #007bff;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
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

    .btn-complete {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-complete:hover {
        background-color: #218838;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .activity-details {
            flex-direction: column;
            gap: 5px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 10px;
        }

        .btn-back, .btn-complete {
            width: 100%;
        }
    }
</style>
@endsection
