<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\StudentRegistry;
use App\Models\Canteen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Smkn8SemarangSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::create([
            'name' => 'SMKN 8 Semarang',
            'address' => 'Jl. Pandanaran No. 79, Semarang',
            'status' => 'active',
        ]);

        $students = [
            ['school_id' => $school->id, 'nis' => '50001', 'full_name' => 'Ahmad Zaki', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50002', 'full_name' => 'Siti Nurhaliza', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50003', 'full_name' => 'Budi Santoso', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50004', 'full_name' => 'Rina Kusuma', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50005', 'full_name' => 'Dedi Setiawan', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50006', 'full_name' => 'Lina Marlina', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50007', 'full_name' => 'Eko Prasetyo', 'status' => 'active'],
            ['school_id' => $school->id, 'nis' => '50008', 'full_name' => 'Fitri Handayani', 'status' => 'active'],
        ];

        foreach ($students as $student) {
            StudentRegistry::create($student);
        }

        $kantinBiruOwner = User::create([
            'name' => 'Ibu Sinta',
            'email' => 'sinta@kantinbiru.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'nis' => null,
            'role' => 'seller',
            'status' => 'active',
            'verification_status' => 'verified',
            'courier_status' => 'not_courier',
            'phone' => '081234567901',
        ]);

        Canteen::create([
            'owner_id' => $kantinBiruOwner->id,
            'school_id' => $school->id,
            'name' => 'Kantin Biru',
            'location' => 'Gedung A Lantai 1',
            'description' => 'Kantin dengan menu masakan rumahan dan jajanan tradisional',
            'status' => 'active',
        ]);

        $kantinKuningOwner = User::create([
            'name' => 'Pak Agus',
            'email' => 'agus@kantinkuining.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'nis' => null,
            'role' => 'seller',
            'status' => 'active',
            'verification_status' => 'verified',
            'courier_status' => 'not_courier',
            'phone' => '081234567902',
        ]);

        Canteen::create([
            'owner_id' => $kantinKuningOwner->id,
            'school_id' => $school->id,
            'name' => 'Kantin Kuning',
            'location' => 'Gedung B Lantai 1',
            'description' => 'Kantin dengan menu makanan cepat saji dan minuman segar',
            'status' => 'active',
        ]);

        $kantinPojokOwner = User::create([
            'name' => 'Ibu Yuni',
            'email' => 'yuni@kantinpojok.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'nis' => null,
            'role' => 'seller',
            'status' => 'active',
            'verification_status' => 'verified',
            'courier_status' => 'not_courier',
            'phone' => '081234567903',
        ]);

        Canteen::create([
            'owner_id' => $kantinPojokOwner->id,
            'school_id' => $school->id,
            'name' => 'Kantin Pojok',
            'location' => 'Dekat Lapangan Basket',
            'description' => 'Kantin dengan menu cemilan dan minuman kekinian',
            'status' => 'active',
        ]);
    }
}
