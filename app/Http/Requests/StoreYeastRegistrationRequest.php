<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreYeastRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // A. Personal Information
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'other_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'marital_status' => ['required', 'string', 'in:Single,Married,Divorced,Widowed'],
            'nationality' => ['required', 'string', 'max:255'],
            'state_of_origin' => ['required', 'string', 'max:255'],
            'lga' => ['required', 'string', 'max:255'],
            'residential_address' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'identification_type' => ['required', 'string', 'in:NIN,International Passport,Voter\'s Card'],
            'identification_number' => ['required', 'string', 'max:255'],
            'identification_document' => ['nullable', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:5120'],

            // B. Education & Qualifications
            'highest_education_level' => ['required', 'string', 'max:255'],
            'institution_attended' => ['required', 'string', 'max:255'],
            'course_of_study' => ['required', 'string', 'max:255'],
            'year_of_graduation' => ['required', 'string', 'max:4'],
            'professional_certifications' => ['nullable', 'string'],
            'certificates' => ['nullable', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:10240'],

            // C. Employment & Work History
            'employment_status' => ['required', 'string', 'in:Employed,Unemployed,Self-Employed'],
            'years_of_experience' => ['required', 'integer', 'min:0', 'max:100'],
            'previous_job_titles' => ['nullable', 'string'],
            'previous_employers' => ['nullable', 'string'],
            'key_responsibilities' => ['nullable', 'string'],
            'reason_for_leaving' => ['nullable', 'string'],

            // D. Job Preference & Availability
            'job_category' => ['required', 'string', 'max:255'],
            'preferred_job_role' => ['required', 'string', 'max:255'],
            'preferred_work_location' => ['required', 'string', 'max:255'],
            'preferred_work_type' => ['required', 'string', 'in:Full-time,Part-time,Contract,Live-in'],
            'expected_salary_range' => ['required', 'string', 'max:255'],
            'availability' => ['required', 'string', 'in:Immediate,1-2 weeks,1 month'],

            // E. Skills & Competence
            'key_skills' => ['nullable', 'array'],
            'key_skills.*' => ['string', 'max:255'],
            'languages_spoken' => ['nullable', 'array'],
            'languages_spoken.*' => ['string', 'max:255'],
            'computer_literacy_level' => ['required', 'string', 'in:Beginner,Intermediate,Advanced,Expert'],
            'special_skills' => ['nullable', 'string'],

            // F. References
            'referee_name' => ['required', 'string', 'max:255'],
            'referee_relationship' => ['required', 'string', 'max:255'],
            'referee_phone_number' => ['required', 'string', 'max:20'],
            'referee_address' => ['nullable', 'string'],

            // G. Health & Background
            'has_medical_condition' => ['required', 'boolean'],
            'medical_condition_details' => ['nullable', 'required_if:has_medical_condition,true', 'string'],
            'has_criminal_record' => ['required', 'boolean'],
            'background_check_consent' => ['required', 'accepted'],

            // H. Uploads
            'passport_photograph' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:2048'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'supporting_documents' => ['nullable', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:10240'],

            // I. Declaration & Consent
            'declaration_consent' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'surname.required' => 'Surname is required.',
            'first_name.required' => 'First name is required.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be Male, Female, or Other.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone_number.required' => 'Phone number is required.',
            'identification_type.required' => 'Means of identification is required.',
            'identification_type.in' => 'Invalid identification type selected.',
            'identification_number.required' => 'Identification number is required.',
            'identification_document.mimes' => 'Identification document must be PDF, JPEG, JPG, or PNG.',
            'identification_document.max' => 'Identification document must not exceed 5MB.',
            'employment_status.in' => 'Employment status must be Employed, Unemployed, or Self-Employed.',
            'preferred_work_type.in' => 'Work type must be Full-time, Part-time, Contract, or Live-in.',
            'computer_literacy_level.in' => 'Computer literacy level must be Beginner, Intermediate, Advanced, or Expert.',
            'background_check_consent.accepted' => 'You must consent to a background check.',
            'declaration_consent.accepted' => 'You must accept the declaration and consent to proceed.',
            'passport_photograph.mimes' => 'Passport photograph must be JPEG, JPG, or PNG.',
            'passport_photograph.max' => 'Passport photograph must not exceed 2MB.',
            'cv.mimes' => 'CV must be a PDF file.',
            'cv.max' => 'CV must not exceed 5MB.',
        ];
    }
}
