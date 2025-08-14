<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kinerja Dosen</title>
    <style>
        @page {
            margin: 3cm;
            size: A4;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20pt;
            padding-bottom: 10pt;
            border-bottom: 2pt solid #2c3e50;
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
        }
        .header .faculty-name {
            font-weight: bold;
            color: #2874a6;
        }
        .filter-info {
            margin-bottom: 15pt;
            padding: 10pt;
            background-color: #f8f9fa;
            border-left: 4pt solid #2c3e50;
        }
        .dosen-section {
            margin-bottom: 20pt;
            page-break-inside: avoid;
        }
        .dosen-header {
            font-size: 12pt;
            background-color: #eaf2f8;
            padding: 8pt;
            margin-bottom: 12pt;
            border-left: 4pt solid #2c3e50;
            color: #2c3e50;
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
            margin-bottom: 15pt;
            page-break-inside: avoid;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }
        table th, table td {
            border: 1pt solid #ddd;
            padding: 6pt;
            vertical-align: top;
            font-size: 10pt;
        }
        .activity-title {
            font-weight: bold;
            margin-bottom: 3pt;
            color: #1a5276;
        }
        .activity-details {
            font-size: 9pt;
            color: #555;
        }
        .score-summary {
            margin-top: 20pt;
            page-break-inside: avoid;
        }
        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15pt;
        }
        .score-table th {
            background-color: #eaf2f8;
            font-weight: bold;
            color: #1a5276;
        }
        .score-table th, .score-table td {
            border: 1pt solid #1a5276;
            padding: 8pt;
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #d4e6f1;
        }
        .signature {
            margin-top: 40pt;
            text-align: right;
            page-break-inside: avoid;
        }
        .signature p {
            margin: 0;
            line-height: 1.5;
        }
         .signature-line {
            width: 120pt;
            margin-top: 30pt;
            margin-left: 300pt;
            padding-top: 5pt;
            text-align: start;
            color: #1a5276;
        }
        .signature-name {
            font-weight: bold;
            margin-top: 5pt;
            border-top: 1pt solid #000;
            padding-top: 5pt;
            display: inline-block;
            width: 100%;
        }
        .page-break {
            page-break-after: always;
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

    <!-- Filter Information -->
    <div class="filter-info">
        <div class="info-grid">
            <div class="info-label">Filter Dosen</div>
            <div>{{ $filterDosen }}</div>

            <div class="info-label">Filter Semester</div>
            <div>{{ $filterSemester }}</div>

            <div class="info-label">Filter Tahun</div>
            <div>{{ $filterTahun }}</div>

            <div class="info-label">Tanggal Cetak</div>
            <div>{{ date('d F Y') }}</div>

            <div class="info-label">Jumlah Data</div>
            <div>{{ count($kinerjaDosen) }} Dosen</div>
        </div>
    </div>

    @foreach($kinerjaDosen as $index => $kinerja)
        <div class="dosen-section">
            <div class="dosen-header">
                DATA KINERJA DOSEN KE-{{ $index + 1 }}
            </div>

            <!-- Dosen Information -->
            <div class="info-grid">
                <div class="info-label">Nama Dosen</div>
                <div>{{ $kinerja->dosen->name }}</div>

                <div class="info-label">NIP/NIDN</div>
                <div>{{ $kinerja->dosen->nip ?? '-' }} / {{ $kinerja->dosen->nidn ?? '-' }}</div>

                <div class="info-label">Jabatan</div>
                <div>{{ $kinerja->dosen->jabatan ?? '-' }}</div>

                <div class="info-label">Pangkat/Golongan</div>
                <div>{{ $kinerja->dosen->pangkat ?? '-' }}</div>

                <div class="info-label">Semester</div>
                <div>{{ $kinerja->semester->nama_semester }} {{ $kinerja->semester->tahun_ajaran }}</div>

                <div class="info-label">Status Penilaian</div>
                <div>{{ $kinerja->status_penilaian }}</div>
            </div>

            <!-- Teaching Performance -->
            <table>
                <thead>
                    <tr>
                        <th colspan="4">1. KINERJA PENGAJARAN</th>
                    </tr>
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Mata Kuliah</th>
                        <th width="30%">Detail</th>
                        <th width="20%">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kinerja->pengajaran as $pengajaran)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengajaran->nama_matkul }}</td>
                        <td>
                            Kode: {{ $pengajaran->kode_matkul }}<br>
                            {{ $pengajaran->sks }} SKS - Semester {{ $pengajaran->semester }}<br>
                            Tahun: {{ $pengajaran->tahun_ajaran }}
                        </td>
                        <td>{{ number_format($pengajaran->skor, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4">Tidak ada data pengajaran</td></tr>
                    @endforelse
                    @if(count($kinerja->pengajaran) > 0)
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold;">Rata-rata Skor Pengajaran</td>
                        <td style="font-weight: bold;">{{ number_format($kinerja->pengajaran->avg('skor'), 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Research Performance -->
            <table>
                <thead>
                    <tr>
                        <th colspan="4">2. KINERJA PENELITIAN</th>
                    </tr>
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Judul Penelitian</th>
                        <th width="30%">Detail</th>
                        <th width="20%">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kinerja->penelitian as $penelitian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penelitian->judul_penelitian }}</td>
                        <td>
                            Jenis: {{ $penelitian->jenis_penelitian }}<br>
                            Tahun: {{ $penelitian->tahun_penelitian }}<br>
                            Dana: Rp{{ number_format($penelitian->jumlah_dana, 0, ',', '.') }}<br>
                            Sumber: {{ $penelitian->sumber_dana }}
                        </td>
                        <td>{{ number_format($penelitian->skor, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4">Tidak ada data penelitian</td></tr>
                    @endforelse
                    @if(count($kinerja->penelitian) > 0)
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold;">Rata-rata Skor Penelitian</td>
                        <td style="font-weight: bold;">{{ number_format($kinerja->penelitian->avg('skor'), 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Community Service Performance -->
            <table>
                <thead>
                    <tr>
                        <th colspan="4">3. KINERJA PENGABDIAN</th>
                    </tr>
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Judul Kegiatan</th>
                        <th width="30%">Detail</th>
                        <th width="20%">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kinerja->pengabdian as $pengabdian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengabdian->judul_kegiatan }}</td>
                        <td>
                            Jenis: {{ $pengabdian->jenis_kegiatan }}<br>
                            Lokasi: {{ $pengabdian->lokasi }}<br>
                            Tahun: {{ $pengabdian->tahun_kegiatan }}<br>
                            Sumber Dana: {{ $pengabdian->sumber_dana }}
                        </td>
                        <td>{{ number_format($pengabdian->skor, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4">Tidak ada data pengabdian</td></tr>
                    @endforelse
                    @if(count($kinerja->pengabdian) > 0)
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold;">Rata-rata Skor Pengabdian</td>
                        <td style="font-weight: bold;">{{ number_format($kinerja->pengabdian->avg('skor'), 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Supporting Activities Performance -->
            <table>
                <thead>
                    <tr>
                        <th colspan="4">4. KINERJA PENUNJANG</th>
                    </tr>
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Nama Kegiatan</th>
                        <th width="30%">Detail</th>
                        <th width="20%">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kinerja->penunjang as $penunjang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penunjang->nama_kegiatan }}</td>
                        <td>
                            Jenis: {{ $penunjang->jenis_kegiatan }}<br>
                            Tanggal: {{ $penunjang->tanggal_kegiatan->format('d F Y') }}<br>
                            Penyelenggara: {{ $penunjang->institusi_penyelenggara }}
                        </td>
                        <td>{{ number_format($penunjang->skor, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4">Tidak ada data penunjang</td></tr>
                    @endforelse
                    @if(count($kinerja->penunjang) > 0)
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold;">Rata-rata Skor Penunjang</td>
                        <td style="font-weight: bold;">{{ number_format($kinerja->penunjang->avg('skor'), 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Score Recap -->
            <div class="score-summary">
                <h3 style="text-align: center; margin-bottom: 10pt; color: #1a5276;">REKAPITULASI SKOR KINERJA</h3>
                <table class="score-table">
                    <thead>
                        <tr>
                            <th width="40%">Komponen Kinerja</th>
                            <th width="20%">Rata-rata Skor</th>
                            <th width="20%">Bobot (%)</th>
                            <th width="20%">Skor Tertimbang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1. Pengajaran</td>
                            <td>{{ number_format($kinerja->pengajaran->avg('skor') ?? 0, 2) }}</td>
                            <td>20%</td>
                            <td>{{ number_format(($kinerja->pengajaran->avg('skor') ?? 0) * 0.2, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2. Penelitian</td>
                            <td>{{ number_format($kinerja->penelitian->avg('skor') ?? 0, 2) }}</td>
                            <td>40%</td>
                            <td>{{ number_format(($kinerja->penelitian->avg('skor') ?? 0) * 0.4, 2) }}</td>
                        </tr>
                        <tr>
                            <td>3. Pengabdian</td>
                            <td>{{ number_format($kinerja->pengabdian->avg('skor') ?? 0, 2) }}</td>
                            <td>20%</td>
                            <td>{{ number_format(($kinerja->pengabdian->avg('skor') ?? 0) * 0.2, 2) }}</td>
                        </tr>
                        <tr>
                            <td>4. Penunjang</td>
                            <td>{{ number_format($kinerja->penunjang->avg('skor') ?? 0, 2) }}</td>
                            <td>20%</td>
                            <td>{{ number_format(($kinerja->penunjang->avg('skor') ?? 0) * 0.2, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3"><strong>TOTAL SKOR KINERJA</strong></td>
                            <td>
                                <strong>
                                    {{ number_format(
                                        floatval(($kinerja->pengajaran->avg('skor') ?? 0) * 0.2) +
                                        floatval(($kinerja->penelitian->avg('skor') ?? 0) * 0.4) +
                                        floatval(($kinerja->pengabdian->avg('skor') ?? 0) * 0.2) +
                                        floatval(($kinerja->penunjang->avg('skor') ?? 0) * 0.2),
                                        2
                                    ) }}
                                </strong>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Signature Section -->
            <div class="signature">
                <p>Lhokseumawe, {{ date('d F Y') }}</p>
                <p>Mengetahui,</p>
                <p>Validator Fakultas Ekonomi</p>

                <div class="signature-line">
                    <div style="height: 30pt;"></div>
                    <div class="signature-name">{{ $kinerja->validator->name }}</div>
                    <div>NIP. {{ $kinerja->validator->nip ?? '-' }}</div>
                </div>
            </div>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
