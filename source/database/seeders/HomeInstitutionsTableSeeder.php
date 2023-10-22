<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeInstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $home_institutions = [
            [
                'name' => "Agronomski fakultet, Čačak",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Ekonomski fakultet, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Fakultet inženjerskih nauka, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Fakultet za mašinstvo i građevinarstvo, Kraljevo",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Fakultet medicinskih nauka, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Fakultet pedagoških nauka, Jagodina",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Pravni fakultet, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Prirodno-matematički fakultet, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Fakultet tehničkih nauka, Čačak",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Pedagoški fakultet, Užice",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Filološko-umetnički fakultet, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Fakultet za hotelijerstvo i turizam, Vrnjačka Banja",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Institut za informacione tehnologije, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Univerzitetska biblioteka, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],

        ];
        DB::table('home_institutions')->insert($home_institutions);
    }
}
