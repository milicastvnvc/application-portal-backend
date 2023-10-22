<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $document_types = [
            [
                'name' => 'passport',
                'description' => 'Scanned first page of passport',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'candidate_photograph',
                'description' => 'Candidate\'s photograph',
                'is_required' => true,
                'file_formats' => 'jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'europass',
                'description' => 'Candidate\'s biography in English: Europass',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'learning_agreement',
                'description' => 'Learning agreement (Instructions can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'internship_agreement',
                'description' => 'Internship Agreement (You can download the draft version of the Agreement HERE. Instructions for filling it out can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'mobility_agreement',
                'description' => 'Mobility Agreement (Instructions can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'invitation_letter',
                'description' => 'Invitation letter/email from the relevant contact person or administrative unit/department at the partner institution',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'employment_confirmation',
                'description' => 'Employment confirmation from the home institution',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'acceptance_letter',
                'description' => 'Invitation/Acceptance letter (Email correspondence with the employer is acceptable)',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'active_student',
                'description' => 'Confirmation from the faculty that you are a student in active status',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'passed_exams',
                'description' => 'List of passed exams for the current and all previous study levels',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'previous_diplomas',
                'description' => 'Scanned previously obtained diplomas or graduation certificates (for master\'s and doctoral students)',
                'is_required' => false,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'foreign_language_proficiency',
                'description' => 'Proof of foreign language proficiency for the language of mobility, clearly indicating the level (The language assessment sheet can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'video',
                'description' => 'Video (Short introduction of the candidate (2 minutes max.))',
                'is_required' => false,
                'file_formats' => 'mp4|mov|wmv|avi|flv|mkv',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'internationalization',
                'description' => 'Contribution to the internationalization of the University of Kragujevac. The form must be filled out electronically. Handwritten documents will not be considered. Please download the form: TEACHING STAFF FORM / ADMINISTRATIVE STAFF FORM',
                'is_required' => false,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'name' => 'additional_document',
                'description' => 'Additional document(s) required by the partner institution to which the candidate is applying',
                'is_required' => false,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
        ];
        DB::table('document_types')->insert($document_types);
    }
}
