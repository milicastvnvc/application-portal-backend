<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_roles = [
            [
                'role_id' => 1,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
        ];

        DB::table('role_user')->insert($user_roles);
    }
}
