<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YeastRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // A. Personal Information
            'personal_information' => [
                'surname' => $this->surname,
                'first_name' => $this->first_name,
                'other_name' => $this->other_name,
                'full_name' => trim("{$this->surname} {$this->first_name} {$this->other_name}"),
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
                'marital_status' => $this->marital_status,
                'nationality' => $this->nationality,
                'state_of_origin' => $this->state_of_origin,
                'lga' => $this->lga,
                'residential_address' => $this->residential_address,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'identification' => [
                    'type' => $this->identification_type,
                    'number' => $this->identification_number,
                    'document_url' => $this->identification_document_path
                        ? asset('storage/'.$this->identification_document_path)
                        : null,
                ],
            ],

            // B. Education & Qualifications
            'education' => [
                'highest_level' => $this->highest_education_level,
                'institution' => $this->institution_attended,
                'course_of_study' => $this->course_of_study,
                'year_of_graduation' => $this->year_of_graduation,
                'professional_certifications' => $this->professional_certifications,
                'certificates_url' => $this->certificates_path
                    ? asset('storage/'.$this->certificates_path)
                    : null,
            ],

            // C. Employment & Work History
            'employment_history' => [
                'status' => $this->employment_status,
                'years_of_experience' => $this->years_of_experience,
                'previous_job_titles' => $this->previous_job_titles,
                'previous_employers' => $this->previous_employers,
                'key_responsibilities' => $this->key_responsibilities,
                'reason_for_leaving' => $this->reason_for_leaving,
            ],

            // D. Job Preference & Availability
            'job_preferences' => [
                'category' => $this->job_category,
                'preferred_role' => $this->preferred_job_role,
                'preferred_location' => $this->preferred_work_location,
                'preferred_work_type' => $this->preferred_work_type,
                'expected_salary_range' => $this->expected_salary_range,
                'availability' => $this->availability,
            ],

            // E. Skills & Competence
            'skills' => [
                'key_skills' => $this->key_skills,
                'languages_spoken' => $this->languages_spoken,
                'computer_literacy_level' => $this->computer_literacy_level,
                'special_skills' => $this->special_skills,
            ],

            // F. References
            'reference' => [
                'name' => $this->referee_name,
                'relationship' => $this->referee_relationship,
                'phone_number' => $this->referee_phone_number,
                'address' => $this->referee_address,
            ],

            // G. Health & Background
            'background' => [
                'has_medical_condition' => $this->has_medical_condition,
                'medical_condition_details' => $this->medical_condition_details,
                'has_criminal_record' => $this->has_criminal_record,
                'background_check_consent' => $this->background_check_consent,
            ],

            // H. Uploads
            'documents' => [
                'passport_photograph_url' => $this->passport_photograph_path
                    ? asset('storage/'.$this->passport_photograph_path)
                    : null,
                'cv_url' => $this->cv_path
                    ? asset('storage/'.$this->cv_path)
                    : null,
                'supporting_documents_url' => $this->supporting_documents_path
                    ? asset('storage/'.$this->supporting_documents_path)
                    : null,
            ],

            // I. Declaration & Consent
            'declaration' => [
                'consent' => $this->declaration_consent,
                'date' => $this->declaration_date?->format('Y-m-d H:i:s'),
            ],

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
