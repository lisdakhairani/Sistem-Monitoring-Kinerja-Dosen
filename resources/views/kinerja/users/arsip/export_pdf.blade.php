<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kinerja Dosen - {{ $arsip->dosen->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 3cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5; /* 2 spasi = 1.5 line-height in Times New Roman */
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20pt;
            padding-bottom: 10pt;
            border-bottom: 2pt solid #2c3e50;
        }
        .header img {
            height: 80pt;
            margin-bottom: 10pt;
        }
        .header h1 {
            font-size: 14pt;
            margin: 5pt 0;
            font-weight: bold;
            color: #2c3e50;
        }
        .header p {
            margin: 3pt 0;
            font-size: 12pt;
        }
        .header .univ-name {
            font-size: 13pt;
            font-weight: bold;
            color: #1a5276;
            letter-spacing: 1pt;
        }
        .header .faculty-name {
            font-weight: bold;
            color: #2874a6;
        }
        .info-section {
            margin-bottom: 20pt;
            page-break-inside: avoid;
        }
        .info-section h2 {
            font-size: 12pt;
            background-color: #f8f9fa;
            padding: 8pt;
            margin-bottom: 12pt;
            border-left: 4pt solid #2c3e50;
            color: #2c3e50;
            page-break-after: avoid;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 120pt 1fr;
            gap: 5pt;
            margin-bottom: 10pt;
        }
        .info-label {
            font-weight: bold;
            color: #1a5276;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20pt;
            page-break-inside: avoid;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }
        table th, table td {
            border: 1pt solid #ddd;
            padding: 8pt;
            vertical-align: top;
        }
        .activity-title {
            font-weight: bold;
            margin-bottom: 3pt;
            color: #1a5276;
        }
        .activity-details {
            font-size: 11pt;
            color: #555;
        }
        .score-table {
            margin-top: 20pt;
        }
        .score-table th, .score-table td {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #eaf2f8;
            color: #1a5276;
        }
        .signature {
            margin-top: 40pt;
            text-align: right;
        }
        .signature p {
            margin: 0;
            line-height: 1.5;
        }
        .signature-line {
            border-top: 1pt solid #2c3e50;
            width: 120pt;
            margin-top: 40pt;
            margin-left: 300pt;
            padding-top: 5pt;
            text-align: start;
            color: #1a5276;
        }
        .page-break {
            page-break-after: always;
        }
        .highlight {
            background-color: #eaf2f8;
            padding: 2pt 4pt;
            border-radius: 3pt;
        }
    </style>
</head>
<body>
    <div class="header">

        <p class="univ-name">UNIVERSITAS MALIKUSSALEH</p>
        <p class="faculty-name">FAKULTAS EKONOMI</p>
        <p>PROGRAM PASCA SARJANA ILMU MANAJEMEN</p>
        <h1>LAPORAN KINERJA DOSEN</h1>
        <p>Tahun Akademik {{ date('Y') }}/{{ date('Y')+1 }}</p>
    </div>

    <!-- Informasi Dosen -->
    <div class="info-section">
        <h2>INFORMASI DOSEN</h2>
        <div class="info-grid">
            <div class="info-label">Nama Dosen</div>
            <div class="highlight">{{ $arsip->dosen->name }}</div>

            <div class="info-label">NIP/NIDN</div>
            <div>{{ $arsip->dosen->nip ?? '-' }} / {{ $arsip->dosen->nidn ?? '-' }}</div>

            <div class="info-label">Jabatan</div>
            <div>{{ $arsip->dosen->jabatan ?? '-' }}</div>

            <div class="info-label">Pangkat/Golongan</div>
            <div>{{ $arsip->dosen->pangkat ?? '-' }}</div>
        </div>
    </div>

    <!-- Informasi Periode -->
    <div class="info-section">
        <h2>INFORMASI PERIODE</h2>
        <div class="info-grid">
            <div class="info-label">Semester</div>
            <div class="highlight">{{ $arsip->semester->nama_semester }} {{ $arsip->semester->tahun_ajaran }}</div>

            <div class="info-label">Tanggal Pengisian</div>
            <div>{{ optional($arsip->tanggal_pengisian)->format('d F Y') ?? '-' }}</div>

            <div class="info-label">Tanggal Validasi</div>
            <div>{{ optional($arsip->tanggal_validasi)->format('d F Y') ?? '-' }}</div>

            <div class="info-label">Validator</div>
            <div>{{ $arsip->validator->name }}</div>

            <div class="info-label">Status Penilaian</div>
            <div>{{ $arsip->status_penilaian }}</div>
        </div>
    </div>

    <!-- Kinerja Pengajaran -->
    <div class="info-section">
        <h2>1. KINERJA PENGAJARAN</h2>
        <table>
            <thead>
                <tr>
                    <th width="70%">Detail Pengajaran</th>
                    <th width="30%">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip->pengajaran as $pengajaran)
                <tr>
                    <td>
                        <div class="activity-title">{{ $pengajaran->nama_matkul }}</div>
                        <div class="activity-details">
                            <span>Kode: {{ $pengajaran->kode_matkul }}</span> |
                            <span>{{ $pengajaran->sks }} SKS</span> |
                            <span>Semester {{ $pengajaran->semester }} - {{ $pengajaran->tahun_ajaran }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($pengajaran->skor, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Tidak ada data pengajaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Kinerja Penelitian -->
    <div class="info-section">
        <h2>2. KINERJA PENELITIAN</h2>
        <table>
            <thead>
                <tr>
                    <th width="70%">Detail Penelitian</th>
                    <th width="30%">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip->penelitian as $penelitian)
                <tr>
                    <td>
                        <div class="activity-title">{{ $penelitian->judul_penelitian }}</div>
                        <div class="activity-details">
                            <span>{{ $penelitian->jenis_penelitian }}</span> |
                            <span>Tahun {{ $penelitian->tahun_penelitian }}</span> |
                            <span>Rp{{ number_format($penelitian->jumlah_dana, 0, ',', '.') }}</span> |
                            <span>{{ $penelitian->sumber_dana }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($penelitian->skor, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Tidak ada data penelitian</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Kinerja Pengabdian -->
    <div class="info-section">
        <h2>3. KINERJA PENGABDIAN</h2>
        <table>
            <thead>
                <tr>
                    <th width="70%">Detail Pengabdian</th>
                    <th width="30%">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip->pengabdian as $pengabdian)
                <tr>
                    <td>
                        <div class="activity-title">{{ $pengabdian->judul_kegiatan }}</div>
                        <div class="activity-details">
                            <span>{{ $pengabdian->jenis_kegiatan }}</span> |
                            <span>{{ $pengabdian->lokasi }}</span> |
                            <span>Tahun {{ $pengabdian->tahun_kegiatan }}</span> |
                            <span>{{ $pengabdian->sumber_dana }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($pengabdian->skor, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Tidak ada data pengabdian</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Kinerja Penunjang -->
    <div class="info-section">
        <h2>4. KINERJA PENUNJANG</h2>
        <table>
            <thead>
                <tr>
                    <th width="70%">Detail Kegiatan Penunjang</th>
                    <th width="30%">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip->penunjang as $penunjang)
                <tr>
                    <td>
                        <div class="activity-title">{{ $penunjang->nama_kegiatan }}</div>
                        <div class="activity-details">
                            <span>{{ $penunjang->jenis_kegiatan }}</span> |
                            <span>{{ $penunjang->tanggal_kegiatan->format('d F Y') }}</span> |
                            <span>{{ $penunjang->institusi_penyelenggara }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($penunjang->skor, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">Tidak ada data penunjang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Rekapitulasi Skor -->
    <div class="info-section">
        <h2>REKAPITULASI SKOR KINERJA</h2>
        <table class="score-table">
            <thead>
                <tr>
                    <th>Komponen Kinerja</th>
                    <th>Rata-rata Skor</th>
                    <th>Bobot</th>
                    <th>Skor Tertimbang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pengajaran</td>
                    <td>{{ number_format($avgPengajaran, 2) }}</td>
                    <td>20%</td>
                    <td>{{ number_format($weightedPengajaran, 2) }}</td>
                </tr>
                <tr>
                    <td>Penelitian</td>
                    <td>{{ number_format($avgPenelitian, 2) }}</td>
                    <td>40%</td>
                    <td>{{ number_format($weightedPenelitian, 2) }}</td>
                </tr>
                <tr>
                    <td>Pengabdian</td>
                    <td>{{ number_format($avgPengabdian, 2) }}</td>
                    <td>20%</td>
                    <td>{{ number_format($weightedPengabdian, 2) }}</td>
                </tr>
                <tr>
                    <td>Penunjang</td>
                    <td>{{ number_format($avgPenunjang, 2) }}</td>
                    <td>20%</td>
                    <td>{{ number_format($weightedPenunjang, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3">TOTAL SKOR KINERJA</td>
                    <td>{{ number_format($totalScore, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="signature">
        <p>Lhokseumawe, {{ date('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p>Validator Fakultas Ekonomi</p>

        <div style="height: 30pt;"></div>

        <div class="signature-line">
            {{ $arsip->validator->name }}
            <p>NIP. {{ $arsip->validator->nip ?? '-' }}</p>

        </div>
    </div>
</body>
</html>
