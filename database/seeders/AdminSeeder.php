<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'nama_lengkap' => 'Admin BanyuGrowth',
            'email'        => 'admin@banyugrowth.com',
            'no_hp'        => '-',
            'username'     => 'adminbanyu',
            'password'     => Hash::make('admin123'),
            'role'         => 'admin',
        ]);
    }
}
