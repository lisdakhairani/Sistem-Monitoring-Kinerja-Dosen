<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\IsTrue;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            [
                'nama_semester' => 'Semester Ganjil',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_berakhir' => '2024-12-31',
                'status' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_semester' => 'Semester Genap',
                'tahun_ajaran' => '2024/2025',
                'tanggal_mulai' => '2025-01-01',
                'tanggal_berakhir' => '2025-06-30',
                'status' =>false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_semester' => 'Semester Ganjil',
                'tahun_ajaran' => '2025/2026',
                'tanggal_mulai' => '2025-08-01',
                'tanggal_berakhir' => '2025-12-31',
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('semesters')->insert($semesters);
        $this->command->info('Data semester berhasil ditambahkan!');
    }
}
