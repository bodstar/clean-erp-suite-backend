<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hqTeam = Team::where('name', 'magvlyn_hq')->firstOrFail();
        $franchiseTeam = Team::where('name', 'franchise_demo')->firstOrFail();

        $hq = User::where('email', 'hq@clean.local')->firstOrFail();
        $franchise = User::where('email', 'franchise@clean.local')->firstOrFail();

        // Explicit membership
        $hq->teams()->syncWithoutDetaching([$hqTeam->id, $franchiseTeam->id]);
        $franchise->teams()->syncWithoutDetaching([$franchiseTeam->id]);

        // Optional: HQ belongs to franchise too (for support/impersonation style workflows)
        // $hq->teams()->syncWithoutDetaching([$franchiseTeam->id]);
    }
}
