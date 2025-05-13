<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Today's date
        $startDate1 = date('Y-m-d');
        $endDate1 = date('Y-m-d', strtotime('+30 days'));

        // Expired membership (2 months ago)
        $startDate2 = date('Y-m-d', strtotime('-2 months'));
        $endDate2 = date('Y-m-d', strtotime('-1 month'));

        Membership::create([
            'userid' => 1,
            'typeId' => 1,
            'startDate' => $startDate1,
            'endDate' => $endDate1,
            'status' => 'Active',
        ]);

        Membership::create([
            'userid' => 2,
            'typeId' => 2,
            'startDate' => $startDate2,
            'endDate' => $endDate2,
            'status' => 'Expired',
        ]);
    }
}
