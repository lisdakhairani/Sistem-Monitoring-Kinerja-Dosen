<?php

namespace App\Exports;

use App\Models\KinerjaDosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KinerjaDosenFilteredExport implements WithMultipleSheets
{
    protected $dosenId;
    protected $semesterId;
    protected $tahun;

    public function __construct($dosenId, $semesterId, $tahun)
    {
        $this->dosenId = $dosenId;
        $this->semesterId = $semesterId;
        $this->tahun = $tahun;
    }

    public function sheets(): array
    {
        $kinerjaDosen = KinerjaDosen::with(['dosen', 'semester', 'pengajaran', 'penelitian', 'pengabdian', 'penunjang'])
            ->when($this->dosenId, function($query) {
                return $query->where('id_dosen', $this->dosenId);
            })
            ->when($this->semesterId, function($query) {
                return $query->where('id_semester', $this->semesterId);
            })
            ->when($this->tahun, function($query) {
                return $query->whereYear('tanggal_pengisian', $this->tahun);
            })
            ->get();

        $sheets = [];

        // Sheet Rekapitulasi
        $sheets[] = new RekapitulasiSheet($kinerjaDosen);

        // Sheet per Dosen
        foreach ($kinerjaDosen as $index => $kinerja) {
            $sheets[] = new KinerjaDosenSingleSheet($kinerja, $index + 1);
        }

        return $sheets;
    }
}

class RekapitulasiSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $kinerjaDosen;

    public function __construct($kinerjaDosen)
    {
        $this->kinerjaDosen = $kinerjaDosen;
    }

    public function title(): string
    {
        return 'Rekapitulasi';
    }

    public function headings(): array
    {
        return [
            ['REKAPITULASI KINERJA DOSEN'],
            ['Universitas Malikussaleh - Fakultas Ekonomi'],
            [''],
            ['No', 'Nama Dosen', 'NIP/NIDN', 'Semester', 'Total Skor', 'Status']
        ];
    }

    public function collection()
    {
        $data = collect();

        foreach ($this->kinerjaDosen as $index => $kinerja) {
            $data->push([
                $index + 1,
                $kinerja->dosen->name,
                ($kinerja->dosen->nip ?? '-') . ' / ' . ($kinerja->dosen->nidn ?? '-'),
                $kinerja->semester->nama_semester . ' ' . $kinerja->semester->tahun_ajaran,
                $kinerja->total_skor ?? 0,
                $kinerja->status_penilaian
            ]);
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        $sheet->getStyle('A1:F3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EAF2F8'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Data style
        $sheet->getStyle('A5:F' . (4 + $this->kinerjaDosen->count()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
    }
}

class KinerjaDosenSingleSheet implements FromCollection, WithTitle, WithStyles, ShouldAutoSize
{
    protected $kinerja;
    protected $sheetNumber;

    public function __construct($kinerja, $sheetNumber)
    {
        $this->kinerja = $kinerja;
        $this->sheetNumber = $sheetNumber;
    }

    public function title(): string
    {
        return 'Dosen ' . $this->sheetNumber;
    }

    public function collection()
    {
        $data = collect();

        // Header
        $data->push(['LAPORAN KINERJA DOSEN']);
        $data->push(['Universitas Malikussaleh - Fakultas Ekonomi']);
        $data->push(['']);
        $data->push(['Informasi Dosen']);
        $data->push(['']);

        // Dosen info
        $data->push(['Nama Dosen', $this->kinerja->dosen->name]);
        $data->push(['NIP/NIDN', ($this->kinerja->dosen->nip ?? '-') . ' / ' . ($this->kinerja->dosen->nidn ?? '-')]);
        $data->push(['Semester', $this->kinerja->semester->nama_semester]);
        $data->push(['Tahun Akademik', $this->kinerja->semester->tahun_ajaran]);
        $data->push(['Tanggal Pengisian', $this->kinerja->tanggal_pengisian->format('d F Y')]);
        $data->push(['Status Penilaian', $this->kinerja->status_penilaian]);
        $data->push(['']);

        // Pengajaran
        $data->push(['KINERJA PENGAJARAN']);
        $data->push(['No', 'Mata Kuliah', 'Kode', 'SKS', 'Semester', 'Tahun Ajaran', 'Skor']);

        foreach ($this->kinerja->pengajaran as $index => $pengajaran) {
            $data->push([
                $index + 1,
                $pengajaran->nama_matkul,
                $pengajaran->kode_matkul,
                $pengajaran->sks,
                $pengajaran->semester,
                $pengajaran->tahun_ajaran,
                $pengajaran->skor ?? 0
            ]);
        }
        $data->push(['Total Skor Pengajaran', '', '', '', '', '', $this->kinerja->pengajaran->avg('skor') ?? 0]);
        $data->push(['']);

        // Penelitian
        $data->push(['KINERJA PENELITIAN']);
        $data->push(['No', 'Judul Penelitian', 'Jenis', 'Tahun', 'Dana', 'Sumber Dana', 'Skor']);

        foreach ($this->kinerja->penelitian as $index => $penelitian) {
            $data->push([
                $index + 1,
                $penelitian->judul_penelitian,
                $penelitian->jenis_penelitian,
                $penelitian->tahun_penelitian,
                $penelitian->jumlah_dana,
                $penelitian->sumber_dana,
                $penelitian->skor ?? 0
            ]);
        }
        $data->push(['Total Skor Penelitian', '', '', '', '', '', $this->kinerja->penelitian->avg('skor') ?? 0]);
        $data->push(['']);

        // Pengabdian
        $data->push(['KINERJA PENGABDIAN']);
        $data->push(['No', 'Judul Kegiatan', 'Jenis', 'Lokasi', 'Tahun', 'Sumber Dana', 'Skor']);

        foreach ($this->kinerja->pengabdian as $index => $pengabdian) {
            $data->push([
                $index + 1,
                $pengabdian->judul_kegiatan,
                $pengabdian->jenis_kegiatan,
                $pengabdian->lokasi,
                $pengabdian->tahun_kegiatan,
                $pengabdian->sumber_dana,
                $pengabdian->skor ?? 0
            ]);
        }
        $data->push(['Total Skor Pengabdian', '', '', '', '', '', $this->kinerja->pengabdian->avg('skor') ?? 0]);
        $data->push(['']);

        // Penunjang
        $data->push(['KINERJA PENUNJANG']);
        $data->push(['No', 'Nama Kegiatan', 'Jenis', 'Tanggal', 'Penyelenggara', 'Skor']);

        foreach ($this->kinerja->penunjang as $index => $penunjang) {
            $data->push([
                $index + 1,
                $penunjang->nama_kegiatan,
                $penunjang->jenis_kegiatan,
                $penunjang->tanggal_kegiatan->format('d F Y'),
                $penunjang->institusi_penyelenggara,
                $penunjang->skor ?? 0
            ]);
        }
        $data->push(['Total Skor Penunjang', '', '', '', '', $this->kinerja->penunjang->avg('skor') ?? 0]);
        $data->push(['']);

        // Rekapitulasi
        $data->push(['REKAPITULASI SKOR']);
        $data->push(['Komponen', 'Rata-rata Skor', 'Bobot', 'Skor Tertimbang']);
        $data->push(['Pengajaran', $this->kinerja->pengajaran->avg('skor') ?? 0, '20%', ($this->kinerja->pengajaran->avg('skor') ?? 0) * 0.2]);
        $data->push(['Penelitian', $this->kinerja->penelitian->avg('skor') ?? 0, '40%', ($this->kinerja->penelitian->avg('skor') ?? 0) * 0.4]);
        $data->push(['Pengabdian', $this->kinerja->pengabdian->avg('skor') ?? 0, '20%', ($this->kinerja->pengabdian->avg('skor') ?? 0) * 0.2]);
        $data->push(['Penunjang', $this->kinerja->penunjang->avg('skor') ?? 0, '20%', ($this->kinerja->penunjang->avg('skor') ?? 0) * 0.2]);
        $data->push(['TOTAL SKOR', '', '', $this->kinerja->total_skor ?? 0]);

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for headers
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A4:G4');

        // Style for main headers
        $sheet->getStyle('A1:G2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style for section headers
        $sectionHeaders = ['A4', 'A10', 'A' . (12 + $this->kinerja->pengajaran->count()),
                          'A' . (14 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count()),
                          'A' . (16 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count()),
                          'A' . (18 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count() + $this->kinerja->penunjang->count())];

        foreach ($sectionHeaders as $header) {
            $sheet->getStyle($header)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'color' => ['rgb' => '1A5276'],
                ],
            ]);
        }

        // Style for table headers
        $tableHeaders = ['A6:G6',
                        'A11:G11',
                        'A' . (13 + $this->kinerja->pengajaran->count()) . ':G' . (13 + $this->kinerja->pengajaran->count()),
                        'A' . (15 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count()) . ':G' . (15 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count()),
                        'A' . (17 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count()) . ':G' . (17 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count()),
                        'A' . (19 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count() + $this->kinerja->penunjang->count()) . ':D' . (19 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count() + $this->kinerja->penunjang->count())];

        foreach ($tableHeaders as $header) {
            $sheet->getStyle($header)->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EAF2F8'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        // Style for total rows
        $totalRows = [9 + $this->kinerja->pengajaran->count(),
                      12 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count(),
                      15 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count(),
                      18 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count() + $this->kinerja->penunjang->count(),
                      24 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count() + $this->kinerja->penunjang->count()];

        foreach ($totalRows as $row) {
            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
            ]);
        }

        // Style for recap table
        $lastRow = 24 + $this->kinerja->pengajaran->count() + $this->kinerja->penelitian->count() + $this->kinerja->pengabdian->count() + $this->kinerja->penunjang->count();
        $sheet->getStyle('A' . ($lastRow - 5) . ':D' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Style for total score
        $sheet->getStyle('D' . $lastRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
        ]);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(10);
    }
}
