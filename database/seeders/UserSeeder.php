<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ebrahem Ahmed',
                'email' => 'ebrahem@example.com',
                'phone' => '01234567890',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'area' => 'Nasr City',
                'lat' => '30.0444',
                'lon' => '31.2357',
                'address' => '123 Main Street',
                'otp' => null,
                'lang' => 'ar',
                'status' => 'active',
            ],
            [
                'name' => 'Sara Ali',
                'email' => 'sara@example.com',
                'phone' => '01234567891',
                'country' => 'Egypt',
                'city' => 'Giza',
                'area' => 'Dokki',
                'lat' => '30.0131',
                'lon' => '31.2089',
                'address' => '45 Tahrir Street',
                'otp' => null,
                'lang' => 'ar',
                'status' => 'active',
            ],
            [
                'name' => 'Mohamed Hassan',
                'email' => 'mohamed@example.com',
                'phone' => '01234567892',
                'country' => 'Egypt',
                'city' => 'Alexandria',
                'area' => 'Stanley',
                'lat' => '31.2001',
                'lon' => '29.9187',
                'address' => '10 Alexandria Road',
                'otp' => null,
                'lang' => 'ar',
                'status' => 'active',
            ],
            [
                'name' => 'Nour Karim',
                'email' => 'nour@example.com',
                'phone' => '01234567893',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'area' => 'Maadi',
                'lat' => '29.9644',
                'lon' => '31.2731',
                'address' => '88 Nile Street',
                'otp' => null,
                'lang' => 'ar',
                'status' => 'active',
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'Omar Salah',
                'email' => 'omar@example.com',
                'phone' => '01234567894',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'area' => 'Heliopolis',
                'lat' => '30.1234',
                'lon' => '31.2789',
                'address' => '7 Airport Road',
                'otp' => null,
                'lang' => 'ar',
                'status' => 'active',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
