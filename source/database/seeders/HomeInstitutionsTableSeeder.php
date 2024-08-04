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
            [ //afi
                'name' => "Faculty of Agronomy, Čačak",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //ekfak
                'name' => "Faculty of Economics, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //fin
                'name' => "Faculty of Engineering, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ // fmg
                'name' => "Faculty of Mechanical and Civil Engineering, Kraljevo",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //mef
                'name' => "Faculty of Medical Sciences, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //fpn
                'name' => "Faculty of Education, Jagodina",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ // prafak
                'name' => "Faculty of Law, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //pmf
                'name' => "Faculty of Science, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //ftn
                'name' => "Faculty of Technical Sciences, Čačak",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //pef
                'name' => "Faculty of Education, Užice",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //filum
                'name' => "Faculty of Philology and Art, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //hit
                'name' => "Faculty of Hotel Management and Tourism, Vrnjačka Banja",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //iict
                'name' => "Institute for Information Technologies, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //ubk
                'name' => "University library, Kragujevac",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //rec
                'name' => "University Rectorate",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => "Master's program at the University Rectorate",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //psih
                'name' => "Joint Study Program: Psychology",
                'country' => "Serbia",
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]

        ];
        DB::table('home_institutions')->insert($home_institutions);
    }
}
