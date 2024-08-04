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
            [ //1
                'name' => 'passport',
                'description' => 'Scanned first page of passport',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //2
                'name' => 'europass',
                'description' => 'Candidate\'s biography in English: Europass',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //3
                'name' => 'europass_cv',
                'description' => 'Candidate’s biography in English: We recommend that you use Europass, however any other form of CV is also eligible',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //4
                'name' => 'learning_agreement',
                'description' => 'Learning agreement (The preliminary Learning Agreement can be found HERE). Please note that the Faculty coordinator needs to sign it for it to be valid',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //5
                'name' => 'internship_agreement',
                'description' => 'Internship Agreement (You can download the draft version of the Agreement HERE. Instructions for filling it out can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //6
                'name' => 'mobility_agreement_academic',
                'description' => 'Mobility Agreement (The form that is necessary for you to fill out is on the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //7
                'name' => 'mobility_agreement_non_academic',
                'description' => 'Mobility Agreement (The form that is necessary for you to fill out is on the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //8
                'name' => 'acceptance_letter',
                'description' => 'Invitation/Acceptance letter (Email correspondence with the employer is acceptable)',
                'is_required' => true,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //9
                'name' => 'invitation_letter_sms',
                'description' => 'Invitation Letter for short term doctoral mobility',
                'is_required' => false,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //10
                'name' => 'active_student',
                'description' => 'Confirmation from the faculty that you are a student in active status',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //11
                'name' => 'employment_confirmation',
                'description' => 'Confirmation that you are employed at UNIKG (Employment Proof)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //12
                'name' => 'passed_exams',
                'description' => 'List of passed exams for the current and all previous study levels',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //13
                'name' => 'previous_diplomas',
                'description' => 'Scanned previously obtained diplomas or graduation certificates (for master\'s and doctoral students)',
                'is_required' => false,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //14
                'name' => 'foreign_language_proficiency',
                'description' => 'Proof of foreign language proficiency for the language of mobility, clearly indicating the level (The language assessment sheet can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //15 - SMP (1)
                'name' => 'foreign_language_proficiency_b1',
                'description' => 'Proof of foreign language proficiency for the language of mobility (Minimum B1), clearly indicating the level (The language assessment sheet can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //16 - STA/STT (2)
                'name' => 'foreign_language_proficiency_b2',
                'description' => 'Proof of foreign language proficiency for the language of mobility (English, B2 minimum), clearly indicating the level (The language assessment sheet can be found at the following LINK)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //17
                'name' => 'video',
                'description' => 'Video (Short introduction of the candidate (2 minutes max.))',
                'is_required' => false,
                'file_formats' => 'mp4|mov|wmv|avi|flv|mkv',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //18
                'name' => 'internationalization_academic',
                'description' => 'Contribution to the internationalization of the University of Kragujevac. Each of the listed contributions to internationalization must be accomanied with supporting proof. Please download the form: TEMPLATE - ACADEMIC STAFF. You may merge all the documents by using https://www.ilovepdf.com/',
                'is_required' => false,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //19
                'name' => 'internationalization_non_academic',
                'description' => 'Contribution to the internationalization of the University of Kragujevac. Each of the listed contributions to internationalization must be accomanied with supporting proof. Please download the form: TEMPLATE - NON-ACADEMIC STAFF. You may merge all the documents by using https://www.ilovepdf.com/',
                'is_required' => false,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //20 - STA/STT (2)
                'name' => 'invitation_letter',
                'description' => 'Invitation letter from the desired institution (First Choice)',
                'is_required' => true,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //21 - STA/STT (2)
                'name' => 'invitation_letter_second',
                'description' => 'Invitation letter from the desired institution (Second Choice)',
                'is_required' => false,
                'file_formats' => 'pdf|jpg|jpeg|png',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [ //22
                'name' => 'additional_documents',
                'description' => 'Additional documents',
                'is_required' => false,
                'file_formats' => 'pdf',
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
        ];
        DB::table('document_types')->insert($document_types);
    }
}
