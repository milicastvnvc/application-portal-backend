<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'applicant',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
