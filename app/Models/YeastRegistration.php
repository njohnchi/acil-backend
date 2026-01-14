<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YeastRegistration extends Model
{
    /** @use HasFactory<\Database\Factories\YeastRegistrationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // A. Personal Information
        'surname',
        'first_name',
        'other_name',
        'gender',
        'date_of_birth',
        'marital_status',
        'nationality',
        'state_of_origin',
        'lga',
        'residential_address',
        'phone_number',
        'email',
        'identification_type',
        'identification_number',
        'identification_document_path',

        // B. Education & Qualifications
        'highest_education_level',
        'institution_attended',
        'course_of_study',
        'year_of_graduation',
        'professional_certifications',
        'certificates_path',

        // C. Employment & Work History
        'employment_status',
        'years_of_experience',
        'previous_job_titles',
        'previous_employers',
        'key_responsibilities',
        'reason_for_leaving',

        // D. Job Preference & Availability
        'job_category',
        'preferred_job_role',
        'preferred_work_location',
        'preferred_work_type',
        'expected_salary_range',
        'availability',

        // E. Skills & Competence
        'key_skills',
        'languages_spoken',
        'computer_literacy_level',
        'special_skills',

        // F. References
        'referee_name',
        'referee_relationship',
        'referee_phone_number',
        'referee_address',

        // G. Health & Background
        'has_medical_condition',
        'medical_condition_details',
        'has_criminal_record',
        'background_check_consent',

        // H. Uploads
        'passport_photograph_path',
        'cv_path',
        'supporting_documents_path',

        // I. Declaration & Consent
        'declaration_consent',
        'declaration_date',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'years_of_experience' => 'integer',
            'key_skills' => 'array',
            'languages_spoken' => 'array',
            'has_medical_condition' => 'boolean',
            'has_criminal_record' => 'boolean',
            'background_check_consent' => 'boolean',
            'declaration_consent' => 'boolean',
            'declaration_date' => 'datetime',
        ];
    }
}
