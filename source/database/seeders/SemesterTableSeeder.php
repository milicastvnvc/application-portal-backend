<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemesterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            [
                'name' => 'Winter',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'Summer',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
        ];

        DB::table('semesters')->insert($semesters);
    }
}
