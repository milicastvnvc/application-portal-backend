<?php

namespace Database\Seeders;

use App\Enums\MobilityType;
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

        $passport_id = DB::table('document_types')->where('name', '=', 'passport')->first('id')->id;
        $europass_id = DB::table('document_types')->where('name', '=', 'europass')->first('id')->id;
        $europass_cv_id = DB::table('document_types')->where('name', '=', 'europass_cv')->first('id')->id;
        $learning_agreement_id = DB::table('document_types')->where('name', '=', 'learning_agreement')->first('id')->id;
        $internship_agreement_id = DB::table('document_types')->where('name', '=', 'internship_agreement')->first('id')->id;
        $mobility_agreement_academic_id = DB::table('document_types')->where('name', '=', 'mobility_agreement_academic')->first('id')->id;
        $mobility_agreement_non_academic_id = DB::table('document_types')->where('name', '=', 'mobility_agreement_non_academic')->first('id')->id;
        $acceptance_letter_id = DB::table('document_types')->where('name', '=', 'acceptance_letter')->first('id')->id;
        $invitation_letter_sms_id =  DB::table('document_types')->where('name', '=', 'invitation_letter_sms')->first('id')->id;
        $active_student_id = DB::table('document_types')->where('name', '=', 'active_student')->first('id')->id;
        $employment_confirmation_id = DB::table('document_types')->where('name', '=', 'employment_confirmation')->first('id')->id;
        $passed_exams_id = DB::table('document_types')->where('name', '=', 'passed_exams')->first('id')->id;
        $previous_diplomas_id = DB::table('document_types')->where('name', '=', 'previous_diplomas')->first('id')->id;
        $foreign_language_proficiency_id = DB::table('document_types')->where('name', '=', 'foreign_language_proficiency')->first('id')->id;
        $foreign_language_proficiency_b1_id = DB::table('document_types')->where('name', '=', 'foreign_language_proficiency_b1')->first('id')->id;
        $foreign_language_proficiency_b2_id = DB::table('document_types')->where('name', '=', 'foreign_language_proficiency_b2')->first('id')->id;
        $video_id = DB::table('document_types')->where('name', '=', 'video')->first('id')->id;
        $internationalization_academic_id = DB::table('document_types')->where('name', '=', 'internationalization_academic')->first('id')->id;
        $internationalization_non_academic_id = DB::table('document_types')->where('name', '=', 'internationalization_non_academic')->first('id')->id;
        $invitation_letter_id = DB::table('document_types')->where('name', '=', 'invitation_letter')->first('id')->id;
        $invitation_letter_second_id = DB::table('document_types')->where('name', '=', 'invitation_letter_second')->first('id')->id;
        $additional_documents_id = DB::table('document_types')->where('name','=','additional_documents')->first('id')->id;

        $mobilitiesDocumentTypes = [
            // PASSPORT
            [
                'document_type_id' => $passport_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $passport_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $passport_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $passport_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $passport_id,
                'mobility_type' => MobilityType::Other,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // EUROPASS OR CV
            [
                'document_type_id' => $europass_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $europass_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $europass_cv_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $europass_cv_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $europass_id,
                'mobility_type' => MobilityType::Other,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // LEARNING AGREEMENT
            [
                'document_type_id' => $learning_agreement_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // INTERNSHIP AGREEMENT
            [
                'document_type_id' => $internship_agreement_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // MOBILITY AGREEMENT ACADEMIC
            [
                'document_type_id' => $mobility_agreement_academic_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // MOBILITY AGREEMENT NON ACADEMIC
            [
                'document_type_id' => $mobility_agreement_non_academic_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // Invitation/Acceptance letter
            [
                'document_type_id' => $acceptance_letter_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // Invitation Letter for short term doctoral mobility
            [
                'document_type_id' => $invitation_letter_sms_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // ACTIVE STUDENT
            [
                'document_type_id' => $active_student_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $active_student_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // EMPLOYMENT CONFIRMATION
            [
                'document_type_id' => $employment_confirmation_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $employment_confirmation_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // PASSED EXAMS
            [
                'document_type_id' => $passed_exams_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $passed_exams_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // PREVIOUS DIPLOMAS
            [
                'document_type_id' => $previous_diplomas_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $previous_diplomas_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $previous_diplomas_id,
                'mobility_type' => MobilityType::Other,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // FOREIGN LANGUAGE PROFICIENCY
            [
                'document_type_id' => $foreign_language_proficiency_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $foreign_language_proficiency_b1_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $foreign_language_proficiency_b2_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $foreign_language_proficiency_b2_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $foreign_language_proficiency_id,
                'mobility_type' => MobilityType::Other,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // VIDEO
            [
                'document_type_id' => $video_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $video_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // Internationalization (STA/STT)
            [
                'document_type_id' => $internationalization_academic_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $internationalization_non_academic_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // Invitation letter (STA/STT)
            [
                'document_type_id' => $invitation_letter_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $invitation_letter_second_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $invitation_letter_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $invitation_letter_second_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            // Additional documents
            [
                'document_type_id' => $additional_documents_id,
                'mobility_type' => MobilityType::Student,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $additional_documents_id,
                'mobility_type' => MobilityType::Traineeship,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $additional_documents_id,
                'mobility_type' => MobilityType::StaffAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $additional_documents_id,
                'mobility_type' => MobilityType::StaffNonAcademic,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ],
            [
                'document_type_id' => $additional_documents_id,
                'mobility_type' => MobilityType::Other,
                'created_at' => Carbon::now(),
                'updated_at' => null
            ]
        ];

        DB::table('mobilities_document_types')->insert($mobilitiesDocumentTypes);
    }
}
