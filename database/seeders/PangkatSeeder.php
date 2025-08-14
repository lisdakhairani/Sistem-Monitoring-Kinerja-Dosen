<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pangkat = [
            [
                'nama_pangkat' => 'Juru Muda',
                'golongan' => 'I/a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Juru Muda Tingkat I',
                'golongan' => 'I/b',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Juru',
                'golongan' => 'I/c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Juru Tingkat I',
                'golongan' => 'I/d',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pengatur Muda',
                'golongan' => 'II/a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pengatur Muda Tingkat I',
                'golongan' => 'II/b',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pengatur',
                'golongan' => 'II/c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pengatur Tingkat I',
                'golongan' => 'II/d',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Penata Muda',
                'golongan' => 'III/a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Penata Muda Tingkat I',
                'golongan' => 'III/b',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Penata',
                'golongan' => 'III/c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Penata Tingkat I',
                'golongan' => 'III/d',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pembina',
                'golongan' => 'IV/a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pembina Tingkat I',
                'golongan' => 'IV/b',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pembina Utama Muda',
                'golongan' => 'IV/c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pembina Utama Madya',
                'golongan' => 'IV/d',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_pangkat' => 'Pembina Utama',
                'golongan' => 'IV/e',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('pangkat')->insert($pangkat);
        $this->command->info('Data pangkat berhasil ditambahkan!');
    }
}
