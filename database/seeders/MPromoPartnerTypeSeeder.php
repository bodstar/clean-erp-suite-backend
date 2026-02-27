<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MPromoPartnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mpromo_partner_types')->upsert([
            ['id' => 1, 'code' => 'CHILLER',          'label' => 'Chiller',          'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'ICE_WATER_SELLER', 'label' => 'Ice Water Seller', 'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['code', 'label', 'updated_at']);
    }
}
