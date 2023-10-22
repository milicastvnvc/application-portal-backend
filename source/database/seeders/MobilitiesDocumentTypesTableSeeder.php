<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilitiesDocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobilitiesDocumentTypes = [
            [
                'document_type_id' => 1,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 1,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 1,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 1,
                'mobility_type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 2,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 2,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 2,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 2,
                'mobility_type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 3,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 3,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 3,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 3,
                'mobility_type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 4,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 5,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 6,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 7,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 8,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 9,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 10,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 10,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 11,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 11,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 12,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 12,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 12,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 12,
                'mobility_type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 13,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 13,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 13,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 13,
                'mobility_type' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 14,
                'mobility_type' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 14,
                'mobility_type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 15,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => 16,
                'mobility_type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
        ];

        DB::table('mobilities_document_types')->insert($mobilitiesDocumentTypes);
    }
}
