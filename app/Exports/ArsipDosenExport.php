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
use Carbon\Carbon;

class ArsipDosenExport implements WithMultipleSheets, ShouldAutoSize
{
    protected $arsip;
    protected $scores;

    public function __construct(KinerjaDosen $arsip, array $scores)
    {
        $this->arsip = $arsip;
        $this->scores = $scores;
    }

    public function sheets(): array
    {
        return [
            'Informasi' => new KinerjaInfoSheet($this->arsip),
            'Pengajaran' => new KinerjaDetailSheet($this->arsip->pengajaran, 'Pengajaran'),
            'Penelitian' => new KinerjaDetailSheet($this->arsip->penelitian, 'Penelitian'),
            'Pengabdian' => new KinerjaDetailSheet($this->arsip->pengabdian, 'Pengabdian'),
            'Penunjang' => new KinerjaDetailSheet($this->arsip->penunjang, 'Penunjang'),
            'Rekapitulasi' => new KinerjaRecapSheet($this->scores),
        ];
    }
}

class KinerjaInfoSheet implements WithTitle, WithHeadings, WithMapping, FromCollection, WithStyles, ShouldAutoSize
{
    protected $arsip;

    public function __construct(KinerjaDosen $arsip)
    {
        $this->arsip = $arsip;
    }

    public function title(): string
    {
        return 'Informasi';
    }

    public function headings(): array
    {
        return [
            ['INFORMASI KINERJA DOSEN'],
            ['Universitas Malikussaleh - Fakultas Ekonomi'],
            [],
            ['Informasi Dosen & Periode'],
        ];
    }

    public function map($arsip): array
    {
        return [
            ['Nama Dosen', $arsip->dosen->name ?? '-'],
            ['NIP/NIDN', ($arsip->dosen->nip ?? '-') . ' / ' . ($arsip->dosen->nidn ?? '-')],
            ['Jabatan', $arsip->dosen->jabatan ?? '-'],
            ['Pangkat', $arsip->dosen->pangkat ?? '-'],
            [],
            ['Semester', $arsip->semester->nama_semester ?? '-', $arsip->semester->tahun_ajaran ?? '-'],
            ['Tanggal Pengisian', optional($arsip->tanggal_pengisian)->format('d F Y') ?? '-'],
            ['Tanggal Validasi', optional($arsip->tanggal_validasi)->format('d F Y') ?? '-'],
            ['Validator', $arsip->validator->name ?? '-'],
            [],
            ['Status Penilaian', $arsip->status_penilaian],
        ];
    }

    public function collection()
    {
        return collect([$this->arsip]);
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('A4:B4');

        $sheet->getStyle('A1:B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A4:B4')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '1A5276'],
            ],
        ]);

        // Data style
        $lastRow = 14; // Adjust based on your actual data rows
        $sheet->getStyle('A5:B'.$lastRow)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(40);
    }
}

class KinerjaDetailSheet implements WithTitle, WithHeadings, WithMapping, FromCollection, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $title;

    public function __construct($data, $title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        $headings = [
            ['KINERJA ' . strtoupper($this->title)],
            ['Universitas Malikussaleh - Fakultas Ekonomi'],
            [],
        ];

        $columnHeadings = ['No.'];

        switch ($this->title) {
            case 'Pengajaran':
                $columnHeadings = array_merge($columnHeadings, [
                    'Nama Mata Kuliah',
                    'Kode Mata Kuliah',
                    'SKS',
                    'Semester',
                    'Tahun Ajaran',
                    'Skor'
                ]);
                break;
            case 'Penelitian':
                $columnHeadings = array_merge($columnHeadings, [
                    'Judul Penelitian',
                    'Jenis Penelitian',
                    'Tahun Penelitian',
                    'Jumlah Dana',
                    'Sumber Dana',
                    'Skor'
                ]);
                break;
            case 'Pengabdian':
                $columnHeadings = array_merge($columnHeadings, [
                    'Judul Kegiatan',
                    'Jenis Kegiatan',
                    'Lokasi',
                    'Tahun Kegiatan',
                    'Sumber Dana',
                    'Skor'
                ]);
                break;
            default: // Penunjang
                $columnHeadings = array_merge($columnHeadings, [
                    'Nama Kegiatan',
                    'Jenis Kegiatan',
                    'Tanggal Kegiatan',
                    'Institusi Penyelenggara',
                    'Skor'
                ]);
        }

        $headings[] = $columnHeadings;
        return $headings;
    }

    public function map($item): array
    {
        $base = [$item->id ?? $item->getKey()];

        switch ($this->title) {
            case 'Pengajaran':
                return array_merge($base, [
                    $item->nama_matkul,
                    $item->kode_matkul,
                    $item->sks,
                    $item->semester,
                    $item->tahun_ajaran,
                    $item->skor ?? 0
                ]);
            case 'Penelitian':
                return array_merge($base, [
                    $item->judul_penelitian,
                    $item->jenis_penelitian,
                    $item->tahun_penelitian,
                    $item->jumlah_dana,
                    $item->sumber_dana,
                    $item->skor ?? 0
                ]);
            case 'Pengabdian':
                return array_merge($base, [
                    $item->judul_kegiatan,
                    $item->jenis_kegiatan,
                    $item->lokasi,
                    $item->tahun_kegiatan,
                    $item->sumber_dana,
                    $item->skor ?? 0
                ]);
            default: // Penunjang
                return array_merge($base, [
                    $item->nama_kegiatan,
                    $item->jenis_kegiatan,
                    optional($item->tanggal_kegiatan)->format('d F Y') ?? '-',
                    $item->institusi_penyelenggara,
                    $item->skor ?? 0
                ]);
        }
    }

    public function collection()
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $headerRow = $this->title === 'Penunjang' ? 4 : 4;
        $lastColumn = $this->title === 'Penunjang' ? 'F' : 'G';

        $sheet->mergeCells('A1:'.$lastColumn.'1');
        $sheet->mergeCells('A2:'.$lastColumn.'2');

        $sheet->getStyle('A1:'.$lastColumn.'2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Table header style
        $sheet->getStyle('A'.$headerRow.':'.$lastColumn.$headerRow)->applyFromArray([
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
        $dataStartRow = $headerRow + 1;
        $dataEndRow = $headerRow + $this->data->count();

        $sheet->getStyle('A'.$dataStartRow.':'.$lastColumn.$dataEndRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Total row style if needed
        if ($this->data->count() > 0) {
            $totalRow = $dataEndRow + 1;
            $sheet->setCellValue('A'.$totalRow, 'Total Skor');
            $sheet->mergeCells('A'.$totalRow.':'.chr(ord($lastColumn)-1).$totalRow);
            $sheet->setCellValue($lastColumn.$totalRow, $this->data->avg('skor') ?? 0);

            $sheet->getStyle('A'.$totalRow.':'.$lastColumn.$totalRow)->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(30);
    }
}

class KinerjaRecapSheet implements WithTitle, WithHeadings, WithMapping, FromCollection, WithStyles, ShouldAutoSize
{
    protected $scores;

    public function __construct(array $scores)
    {
        $this->scores = $scores;
    }

    public function title(): string
    {
        return 'Rekapitulasi';
    }

    public function headings(): array
    {
        return [
            ['REKAPITULASI SKOR KINERJA DOSEN'],
            ['Universitas Malikussaleh - Fakultas Ekonomi'],
            [],
            ['No.', 'Komponen Kinerja', 'Rata-rata Skor', 'Bobot', 'Skor Tertimbang']
        ];
    }

    public function map($row): array
    {
        return [];
    }

    public function collection()
    {
        $data = collect([
            [
                'No.' => 1,
                'Komponen Kinerja' => 'Pengajaran',
                'Rata-rata Skor' => $this->scores['avgPengajaran'],
                'Bobot' => '20%',
                'Skor Tertimbang' => $this->scores['weightedPengajaran']
            ],
            [
                'No.' => 2,
                'Komponen Kinerja' => 'Penelitian',
                'Rata-rata Skor' => $this->scores['avgPenelitian'],
                'Bobot' => '40%',
                'Skor Tertimbang' => $this->scores['weightedPenelitian']
            ],
            [
                'No.' => 3,
                'Komponen Kinerja' => 'Pengabdian',
                'Rata-rata Skor' => $this->scores['avgPengabdian'],
                'Bobot' => '20%',
                'Skor Tertimbang' => $this->scores['weightedPengabdian']
            ],
            [
                'No.' => 4,
                'Komponen Kinerja' => 'Penunjang',
                'Rata-rata Skor' => $this->scores['avgPenunjang'],
                'Bobot' => '20%',
                'Skor Tertimbang' => $this->scores['weightedPenunjang']
            ],
            [
                'No.' => '',
                'Komponen Kinerja' => 'TOTAL SKOR KINERJA',
                'Rata-rata Skor' => '',
                'Bobot' => '',
                'Skor Tertimbang' => $this->scores['totalScore']
            ]
        ]);

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        $sheet->getStyle('A1:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Table header style
        $sheet->getStyle('A4:E4')->applyFromArray([
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
        $dataStartRow = 5;
        $dataEndRow = 9;

        $sheet->getStyle('A'.$dataStartRow.':E'.$dataEndRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Total row style
        $sheet->getStyle('A'.$dataEndRow.':E'.$dataEndRow)->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('E'.$dataEndRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
        ]);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(15);
    }
}
