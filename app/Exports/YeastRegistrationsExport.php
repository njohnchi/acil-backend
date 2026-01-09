<?php

namespace App\Exports;

use App\Models\YeastRegistration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class YeastRegistrationsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function query()
    {
        return YeastRegistration::query()->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Surname',
            'First Name',
            'Other Name',
            'Full Name',
            'Gender',
            'Date of Birth',
            'Marital Status',
            'Nationality',
            'State of Origin',
            'LGA',
            'Residential Address',
            'Phone Number',
            'Email',
            'Identification Type',
            'Identification Number',
            'Highest Education Level',
            'Institution Attended',
            'Course of Study',
            'Year of Graduation',
            'Professional Certifications',
            'Employment Status',
            'Years of Experience',
            'Previous Job Titles',
            'Previous Employers',
            'Key Responsibilities',
            'Reason for Leaving',
            'Job Category',
            'Preferred Job Role',
            'Preferred Work Location',
            'Preferred Work Type',
            'Expected Salary Range',
            'Availability',
            'Key Skills',
            'Languages Spoken',
            'Computer Literacy Level',
            'Special Skills',
            'Referee Name',
            'Referee Relationship',
            'Referee Phone Number',
            'Referee Address',
            'Has Medical Condition',
            'Medical Condition Details',
            'Has Criminal Record',
            'Background Check Consent',
            'Declaration Consent',
            'Declaration Date',
            'Created At',
            'Updated At',
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->id,
            $registration->surname,
            $registration->first_name,
            $registration->other_name,
            trim("{$registration->surname} {$registration->first_name} {$registration->other_name}"),
            $registration->gender,
            $registration->date_of_birth?->format('Y-m-d'),
            $registration->marital_status,
            $registration->nationality,
            $registration->state_of_origin,
            $registration->lga,
            $registration->residential_address,
            $registration->phone_number,
            $registration->email,
            $registration->identification_type,
            $registration->identification_number,
            $registration->highest_education_level,
            $registration->institution_attended,
            $registration->course_of_study,
            $registration->year_of_graduation,
            $registration->professional_certifications,
            $registration->employment_status,
            $registration->years_of_experience,
            $registration->previous_job_titles,
            $registration->previous_employers,
            $registration->key_responsibilities,
            $registration->reason_for_leaving,
            $registration->job_category,
            $registration->preferred_job_role,
            $registration->preferred_work_location,
            $registration->preferred_work_type,
            $registration->expected_salary_range,
            $registration->availability,
            is_array($registration->key_skills) ? implode(', ', $registration->key_skills) : $registration->key_skills,
            is_array($registration->languages_spoken) ? implode(', ', $registration->languages_spoken) : $registration->languages_spoken,
            $registration->computer_literacy_level,
            $registration->special_skills,
            $registration->referee_name,
            $registration->referee_relationship,
            $registration->referee_phone_number,
            $registration->referee_address,
            $registration->has_medical_condition ? 'Yes' : 'No',
            $registration->medical_condition_details,
            $registration->has_criminal_record ? 'Yes' : 'No',
            $registration->background_check_consent ? 'Yes' : 'No',
            $registration->declaration_consent ? 'Yes' : 'No',
            $registration->declaration_date?->format('Y-m-d H:i:s'),
            $registration->created_at?->format('Y-m-d H:i:s'),
            $registration->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
