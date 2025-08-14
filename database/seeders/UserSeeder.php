<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@unimal.ac.id',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@unimal.ac.id',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);

        $this->command->info('Data dummy users berhasil ditambahkan!');
    }
}
