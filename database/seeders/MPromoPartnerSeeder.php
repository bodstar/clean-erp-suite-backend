<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MPromoPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hqTeam = Team::where('name', 'magvlyn_hq')
            ->orWhere('name', 'Magvlyn HQ')
            ->first();

        if (!$hqTeam) {
            // If your seeder creates a different name, update this.
            return;
        }

        $active = 1;    // ACTIVE
        $suspended = 2; // SUSPENDED

        $chiller = 1;          // CHILLER
        $iceWaterSeller = 2;   // ICE_WATER_SELLER

        $rows = [
            [
                'team_id' => $hqTeam->id,
                'partner_type_id' => $chiller,
                'status_id' => $active,
                'name' => 'Kantamanto Chiller A',
                'phone' => '0240000001',
                'location_text' => 'Kantamanto Market',
                'latitude' => null,
                'longitude' => null,
                'geolocation_captured_at' => null,
                'last_activity_at' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_id' => $hqTeam->id,
                'partner_type_id' => $iceWaterSeller,
                'status_id' => $active,
                'name' => 'Ama (Ice Water)',
                'phone' => '0240000002',
                'location_text' => 'Makola',
                'latitude' => 5.5560200,
                'longitude' => -0.2056900,
                'geolocation_captured_at' => now()->subDays(2),
                'last_activity_at' => now()->subHours(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_id' => $hqTeam->id,
                'partner_type_id' => $chiller,
                'status_id' => $suspended,
                'name' => 'Abossey Okai Chiller B',
                'phone' => '0240000003',
                'location_text' => 'Abossey Okai',
                'latitude' => null,
                'longitude' => null,
                'geolocation_captured_at' => null,
                'last_activity_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mpromo_partners')->insert($rows);
    }
}
