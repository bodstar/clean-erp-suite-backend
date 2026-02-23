<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::firstOrCreate(['name' => 'magvlyn_hq', 'display_name'=>'Magvlyn HQ']);
        Team::firstOrCreate(['name' => 'franchise_demo', 'display_name' => 'Franchise Demo']);
    }
}
