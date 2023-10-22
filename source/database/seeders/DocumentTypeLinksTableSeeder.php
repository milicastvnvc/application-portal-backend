<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeLinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            [
                'label' => 'Europass',
                'link' => 'https://europa.eu/europass/en/create-europass-cv',
                'document_type_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'label' => 'LINK',
                'link' => 'https://kg.ac.rs/doc/Ugovor_o_Ucenju_Primer.pdf',
                'document_type_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'label' => 'HERE',
                'link' => '#',
                'document_type_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'label' => 'LINK',
                'link' => '#',
                'document_type_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'label' => 'LINK',
                'link' => '#',
                'document_type_id' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'label' => 'LINK',
                'link' => 'https://kg.ac.rs/doc/Uni_Kragujevac_Language_Assessment_Sheet_2.pdf',
                'document_type_id' => 13,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'label' => 'TEACHING STAFF FORM / ADMINISTRATIVE STAFF FORM',
                'link' => '#',
                'document_type_id' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
        ];

        DB::table('document_type_links')->insert($links);
    }
}
