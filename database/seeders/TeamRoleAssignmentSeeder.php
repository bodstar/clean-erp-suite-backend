<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamRoleAssignmentSeeder extends Seeder
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

        // Team-scoped roles
        $hq->addRole('superadministrator', $hqTeam);
        $hq->addRole('superadministrator', $franchiseTeam);
        $franchise->addRole('administrator', $franchiseTeam);

        // Optional: HQ can be admin inside franchise too
        // $hq->addRole('administrator', $franchiseTeam);
    }
}
