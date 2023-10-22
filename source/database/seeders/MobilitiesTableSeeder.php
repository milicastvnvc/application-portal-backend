<?php

namespace Database\Seeders;

use App\Enums\MobilityType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MobilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobilities = [
            [
                'name' => "SMS",
                'description' => "Student mobility for studies",
                'type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "SMP",
                'description' => "Student mobility for traineship",
                'type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "BIP",
                'description' => "Blended-Intensive program",
                'type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "STA",
                'description' => "Staff mobility for teaching",
                'type' => MobilityType::Staff,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "STT",
                'description' => "Staff mobility for training",
                'type' => MobilityType::Staff,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
            ];
        DB::table('mobilities')->insert($mobilities);
    }
}

// SMS (Student mobility for studies)
// SMP (Student mobility for traineship)
// BIP (Blended-Intensive program)
// STA (Staff mobility for teaching)
// STT (Staff mobility for training)
