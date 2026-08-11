<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Superkara',
            'email'     => 'karadmin@gmail.com',
            'password'  => Hash::make('Admin123456'),
            'role'      => 'admin',
            
            'provinsi'  => 'JAWA TIMUR',
            'kota'      => 'KOTA SURABAYA',
            'kecamatan' => 'KARANG PILANG',
            'kelurahan' => 'KEBRAON',
        ]);
    }
}