<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            'user_id' => 3,
            'name' => 'Muhammad Fitra Fajar Rusamsi',
            'username' => 'fajar17',
            'nisn' => "123123",
            'gender' => 'Laki - Laki',
            'phone' => '6281385931773',
            'point' => 100,
            'created_at' => now(),
            'updated_at' => now(),
            'divisi' => 'DG'
        ]);
    }
}
