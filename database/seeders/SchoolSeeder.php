<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'name' => 'SMK Negeri 1 Jakarta',
                'address' => 'Jl. Pendidikan No. 1, Jakarta Pusat',
                'status' => 'active',
            ],
            [
                'name' => 'SMK Negeri 2 Bandung',
                'address' => 'Jl. Sekolah No. 45, Bandung',
                'status' => 'active',
            ],
            [
                'name' => 'SMK Negeri 5 Surabaya',
                'address' => 'Jl. Pelajar No. 12, Surabaya',
                'status' => 'active',
            ],
            [
                'name' => 'SMA Negeri 3 Yogyakarta',
                'address' => 'Jl. Gajah Mada No. 88, Yogyakarta',
                'status' => 'active',
            ],
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}
