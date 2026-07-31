<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentRegistry;

class StudentRegistrySeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['school_id' => 1, 'nis' => '10001', 'full_name' => 'Andi Pratama', 'status' => 'active'],
            ['school_id' => 1, 'nis' => '10002', 'full_name' => 'Budi Santoso', 'status' => 'active'],
            ['school_id' => 1, 'nis' => '10003', 'full_name' => 'Citra Dewi', 'status' => 'active'],
            ['school_id' => 1, 'nis' => '10004', 'full_name' => 'Doni Firmansyah', 'status' => 'active'],
            ['school_id' => 1, 'nis' => '10005', 'full_name' => 'Eka Putri', 'status' => 'active'],
            
            ['school_id' => 2, 'nis' => '20001', 'full_name' => 'Fajar Nugroho', 'status' => 'active'],
            ['school_id' => 2, 'nis' => '20002', 'full_name' => 'Gita Saraswati', 'status' => 'active'],
            ['school_id' => 2, 'nis' => '20003', 'full_name' => 'Hendra Wijaya', 'status' => 'active'],
            
            ['school_id' => 3, 'nis' => '30001', 'full_name' => 'Indah Permata', 'status' => 'active'],
            ['school_id' => 3, 'nis' => '30002', 'full_name' => 'Joko Susilo', 'status' => 'active'],
            
            ['school_id' => 4, 'nis' => '40001', 'full_name' => 'Karina Sari', 'status' => 'active'],
            ['school_id' => 4, 'nis' => '40002', 'full_name' => 'Luthfi Rahman', 'status' => 'active'],
        ];

        foreach ($students as $student) {
            StudentRegistry::create($student);
        }
    }
}
