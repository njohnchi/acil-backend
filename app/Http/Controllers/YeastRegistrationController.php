<?php

namespace App\Http\Controllers;

use App\Exports\YeastRegistrationsExport;
use App\Models\YeastRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class YeastRegistrationController extends Controller
{
    /**
     * Display a listing of the registrations.
     */
    public function index(): Response
    {
        return Inertia::render('YeastRegistrations/Index', [
            'registrations' => function () {
                return YeastRegistration::query()
                    ->latest()
                    ->paginate(20)
                    ->through(fn ($registration) => [
                        'id' => $registration->id,
                        'full_name' => trim("{$registration->surname} {$registration->first_name} {$registration->other_name}"),
                        'email' => $registration->email,
                        'phone_number' => $registration->phone_number,
                        'job_category' => $registration->job_category,
                        'preferred_job_role' => $registration->preferred_job_role,
                        'employment_status' => $registration->employment_status,
                        'created_at' => $registration->created_at?->format('M d, Y'),
                    ]);
            },
        ]);
    }

    /**
     * Display the specified registration.
     */
    public function show(YeastRegistration $yeastRegistration): Response
    {
        return Inertia::render('YeastRegistrations/Show', [
            'registration' => [
                'id' => $yeastRegistration->id,

                // A. Personal Information
                'personal_information' => [
                    'surname' => $yeastRegistration->surname,
                    'first_name' => $yeastRegistration->first_name,
                    'other_name' => $yeastRegistration->other_name,
                    'full_name' => trim("{$yeastRegistration->surname} {$yeastRegistration->first_name} {$yeastRegistration->other_name}"),
                    'gender' => $yeastRegistration->gender,
                    'date_of_birth' => $yeastRegistration->date_of_birth?->format('M d, Y'),
                    'marital_status' => $yeastRegistration->marital_status,
                    'nationality' => $yeastRegistration->nationality,
                    'state_of_origin' => $yeastRegistration->state_of_origin,
                    'lga' => $yeastRegistration->lga,
                    'residential_address' => $yeastRegistration->residential_address,
                    'phone_number' => $yeastRegistration->phone_number,
                    'email' => $yeastRegistration->email,
                    'identification' => [
                        'type' => $yeastRegistration->identification_type,
                        'number' => $yeastRegistration->identification_number,
                        'has_document' => (bool) $yeastRegistration->identification_document_path,
                    ],
                ],

                // B. Education & Qualifications
                'education' => [
                    'highest_level' => $yeastRegistration->highest_education_level,
                    'institution' => $yeastRegistration->institution_attended,
                    'course_of_study' => $yeastRegistration->course_of_study,
                    'year_of_graduation' => $yeastRegistration->year_of_graduation,
                    'professional_certifications' => $yeastRegistration->professional_certifications,
                    'has_certificates' => (bool) $yeastRegistration->certificates_path,
                ],

                // C. Employment & Work History
                'employment_history' => [
                    'status' => $yeastRegistration->employment_status,
                    'years_of_experience' => $yeastRegistration->years_of_experience,
                    'previous_job_titles' => $yeastRegistration->previous_job_titles,
                    'previous_employers' => $yeastRegistration->previous_employers,
                    'key_responsibilities' => $yeastRegistration->key_responsibilities,
                    'reason_for_leaving' => $yeastRegistration->reason_for_leaving,
                ],

                // D. Job Preference & Availability
                'job_preferences' => [
                    'category' => $yeastRegistration->job_category,
                    'preferred_role' => $yeastRegistration->preferred_job_role,
                    'preferred_location' => $yeastRegistration->preferred_work_location,
                    'preferred_work_type' => $yeastRegistration->preferred_work_type,
                    'expected_salary_range' => $yeastRegistration->expected_salary_range,
                    'availability' => $yeastRegistration->availability,
                ],

                // E. Skills & Competence
                'skills' => [
                    'key_skills' => $yeastRegistration->key_skills,
                    'languages_spoken' => $yeastRegistration->languages_spoken,
                    'computer_literacy_level' => $yeastRegistration->computer_literacy_level,
                    'special_skills' => $yeastRegistration->special_skills,
                ],

                // F. References
                'reference' => [
                    'name' => $yeastRegistration->referee_name,
                    'relationship' => $yeastRegistration->referee_relationship,
                    'phone_number' => $yeastRegistration->referee_phone_number,
                    'address' => $yeastRegistration->referee_address,
                ],

                // G. Health & Background
                'background' => [
                    'has_medical_condition' => $yeastRegistration->has_medical_condition,
                    'medical_condition_details' => $yeastRegistration->medical_condition_details,
                    'has_criminal_record' => $yeastRegistration->has_criminal_record,
                    'background_check_consent' => $yeastRegistration->background_check_consent,
                ],

                // H. Uploads
                'documents' => [
                    'has_passport_photograph' => (bool) $yeastRegistration->passport_photograph_path,
                    'has_cv' => (bool) $yeastRegistration->cv_path,
                    'has_supporting_documents' => (bool) $yeastRegistration->supporting_documents_path,
                ],

                // I. Declaration & Consent
                'declaration' => [
                    'consent' => $yeastRegistration->declaration_consent,
                    'date' => $yeastRegistration->declaration_date?->format('M d, Y H:i:s'),
                ],

                'created_at' => $yeastRegistration->created_at?->format('M d, Y H:i:s'),
                'updated_at' => $yeastRegistration->updated_at?->format('M d, Y H:i:s'),
            ],
        ]);
    }

    /**
     * Export registrations to Excel.
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download(
            new YeastRegistrationsExport,
            'yeast-registrations-'.now()->format('Y-m-d').'.xlsx'
        );
    }

    /**
     * Download a specific document.
     */
    public function downloadDocument(YeastRegistration $yeastRegistration, string $documentType): BinaryFileResponse|RedirectResponse
    {
        $pathMap = [
            'identification' => $yeastRegistration->identification_document_path,
            'certificates' => $yeastRegistration->certificates_path,
            'passport' => $yeastRegistration->passport_photograph_path,
            'cv' => $yeastRegistration->cv_path,
            'supporting' => $yeastRegistration->supporting_documents_path,
        ];

        $path = $pathMap[$documentType] ?? null;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            return redirect()->back()->with('error', 'Document not found');
        }

        return response()->download(
            Storage::disk('public')->path($path),
            basename($path)
        );
    }
}
