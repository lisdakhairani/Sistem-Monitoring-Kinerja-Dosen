<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            [
                'nama_jabatan' => 'Asisten Ahli',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_jabatan' => 'Lektor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_jabatan' => 'Lektor Kepala',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_jabatan' => 'Profesor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_jabatan' => 'Tenaga Pengajar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('jabatan_akademik')->insert($jabatan);
        $this->command->info('Data jabatan akademik berhasil ditambahkan!');
    }
}
