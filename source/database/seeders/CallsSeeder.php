<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CallsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Carbon::now();

        for ($i = 0; $i < 5; $i++) {
            $startDate = $currentDate->subMonth()->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            // Ubacujemo podatke u bazu
            DB::table('calls')->insert([
                'call_name' => 'Call ' . ($i + 1),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
