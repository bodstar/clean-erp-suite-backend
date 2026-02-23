<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'hq@clean.local'],
            [
                'name' => 'HQ Superadmin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'two_factor_secret' => Str::random(10),
                'two_factor_recovery_codes' => Str::random(10),
                'two_factor_confirmed_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'franchise@clean.local'],
            [
                'name' => 'Franchise Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'two_factor_secret' => Str::random(10),
                'two_factor_recovery_codes' => Str::random(10),
                'two_factor_confirmed_at' => now(),
            ]
        );
    }
}
