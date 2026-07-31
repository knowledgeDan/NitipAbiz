<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin System',
                'email' => 'admin@nitipabiz.com',
                'password' => Hash::make('password'),
                'school_id' => null,
                'nis' => null,
                'role' => 'system_manager',
                'status' => 'active',
                'verification_status' => 'verified',
                'courier_status' => 'not_courier',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@student.com',
                'password' => Hash::make('password'),
                'school_id' => 1,
                'nis' => '10001',
                'role' => 'customer',
                'status' => 'active',
                'verification_status' => 'verified',
                'courier_status' => 'not_courier',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@student.com',
                'password' => Hash::make('password'),
                'school_id' => 1,
                'nis' => '10002',
                'role' => 'courier',
                'status' => 'active',
                'verification_status' => 'verified',
                'courier_status' => 'courier_verified',
                'phone' => '081234567892',
                'courier_available' => true,
            ],
            [
                'name' => 'Ibu Sari',
                'email' => 'sari@seller.com',
                'password' => Hash::make('password'),
                'school_id' => 1,
                'nis' => null,
                'role' => 'seller',
                'status' => 'active',
                'verification_status' => 'verified',
                'courier_status' => 'not_courier',
                'phone' => '081234567893',
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra@student.com',
                'password' => Hash::make('password'),
                'school_id' => 1,
                'nis' => '10003',
                'role' => 'customer',
                'status' => 'active',
                'verification_status' => 'verified',
                'courier_status' => 'not_courier',
                'phone' => '081234567894',
            ],
            [
                'name' => 'Pak Budi',
                'email' => 'pakbudi@seller.com',
                'password' => Hash::make('password'),
                'school_id' => 1,
                'nis' => null,
                'role' => 'seller',
                'status' => 'active',
                'verification_status' => 'verified',
                'courier_status' => 'not_courier',
                'phone' => '081234567895',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
