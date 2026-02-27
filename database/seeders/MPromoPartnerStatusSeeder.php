<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MPromoPartnerStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mpromo_partner_statuses')->upsert([
            ['id' => 1, 'code' => 'ACTIVE',    'label' => 'Active',    'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'SUSPENDED', 'label' => 'Suspended', 'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['code', 'label', 'updated_at']);
    }
}
