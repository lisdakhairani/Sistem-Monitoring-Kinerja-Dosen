<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matakuliah = [
            [
                'kode_matakuliah' => 'MM5101',
                'nama_matakuliah' => 'Teori Organisasi',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5102',
                'nama_matakuliah' => 'Manajemen Strategik',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5103',
                'nama_matakuliah' => 'Perilaku Organisasi',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5104',
                'nama_matakuliah' => 'Metodologi Penelitian',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5105',
                'nama_matakuliah' => 'Manajemen Sumber Daya Manusia',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5201',
                'nama_matakuliah' => 'Manajemen Keuangan',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5202',
                'nama_matakuliah' => 'Manajemen Pemasaran',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5203',
                'nama_matakuliah' => 'Manajemen Operasi',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM5204',
                'nama_matakuliah' => 'Sistem Informasi Manajemen',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM6101',
                'nama_matakuliah' => 'Manajemen Perubahan',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM6102',
                'nama_matakuliah' => 'Kewirausahaan',
                'sks' => 3,
            ],
            [
                'kode_matakuliah' => 'MM6103',
                'nama_matakuliah' => 'Etika Bisnis',
                'sks' => 2,
            ],
            [
                'kode_matakuliah' => 'MM7101',
                'nama_matakuliah' => 'Tesis',
                'sks' => 6,
            ],
        ];

        foreach ($matakuliah as $data) {
            MataKuliah::create($data);
        }

        $this->command->info('Data mata kuliah pascasarjana ilmu manajemen berhasil ditambahkan!');
    }
}
