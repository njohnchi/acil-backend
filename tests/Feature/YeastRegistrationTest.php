<?php

use App\Models\YeastRegistration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    Storage::fake('public');
});

it('can create a yeast registration with valid data', function () {
    $data = [
        // A. Personal Information
        'surname' => 'Adebayo',
        'first_name' => 'Oluwaseun',
        'other_name' => 'Emmanuel',
        'gender' => 'Male',
        'date_of_birth' => '1995-05-15',
        'marital_status' => 'Single',
        'nationality' => 'Nigerian',
        'state_of_origin' => 'Lagos',
        'lga' => 'Ikeja',
        'residential_address' => '123 Allen Avenue, Ikeja, Lagos',
        'phone_number' => '+2348012345678',
        'email' => 'oluwaseun.adebayo@example.com',
        'identification_type' => 'NIN',
        'identification_number' => '12345678901',

        // B. Education & Qualifications
        'highest_education_level' => 'Bachelor\'s Degree',
        'institution_attended' => 'University of Lagos',
        'course_of_study' => 'Computer Science',
        'year_of_graduation' => '2018',
        'professional_certifications' => 'AWS Certified Solutions Architect',

        // C. Employment & Work History
        'employment_status' => 'Employed',
        'years_of_experience' => 5,
        'previous_job_titles' => 'Software Developer',
        'previous_employers' => 'TechCorp Nigeria',
        'key_responsibilities' => 'Developed web applications and APIs',
        'reason_for_leaving' => 'Seeking better opportunities',

        // D. Job Preference & Availability
        'job_category' => 'Admin',
        'preferred_job_role' => 'Administrative Officer',
        'preferred_work_location' => 'Lagos',
        'preferred_work_type' => 'Full-time',
        'expected_salary_range' => '200,000 - 500,000',
        'availability' => 'Immediate',

        // E. Skills & Competence
        'key_skills' => ['Communication', 'Leadership', 'Problem Solving'],
        'languages_spoken' => ['English', 'Yoruba'],
        'computer_literacy_level' => 'Advanced',
        'special_skills' => 'Proficient in Microsoft Office Suite',

        // F. References
        'referee_name' => 'Dr. Chukwuma Okonkwo',
        'referee_relationship' => 'Former Supervisor',
        'referee_phone_number' => '+2348098765432',
        'referee_address' => '456 Victoria Island, Lagos',

        // G. Health & Background
        'has_medical_condition' => false,
        'has_criminal_record' => false,
        'background_check_consent' => true,

        // I. Declaration & Consent
        'declaration_consent' => true,
    ];

    $response = postJson('/api/yeast-registrations', $data);

    $response->assertCreated()
        ->assertJson([
            'success' => true,
            'message' => 'Registration submitted successfully',
        ]);

    assertDatabaseHas('yeast_registrations', [
        'email' => 'oluwaseun.adebayo@example.com',
        'surname' => 'Adebayo',
        'first_name' => 'Oluwaseun',
    ]);
});

it('can upload files during registration', function () {
    $data = [
        // A. Personal Information
        'surname' => 'Johnson',
        'first_name' => 'Mary',
        'gender' => 'Female',
        'date_of_birth' => '1990-03-20',
        'marital_status' => 'Married',
        'nationality' => 'Nigerian',
        'state_of_origin' => 'Abuja',
        'lga' => 'Garki',
        'residential_address' => '789 Wuse II, Abuja',
        'phone_number' => '+2348023456789',
        'email' => 'mary.johnson@example.com',
        'identification_type' => 'NIN',
        'identification_number' => '98765432109',
        'identification_document' => UploadedFile::fake()->create('id.pdf', 1024),

        // B. Education & Qualifications
        'highest_education_level' => 'Master\'s Degree',
        'institution_attended' => 'University of Abuja',
        'course_of_study' => 'Business Administration',
        'year_of_graduation' => '2015',
        'certificates' => UploadedFile::fake()->create('certificates.pdf', 2048),

        // C. Employment & Work History
        'employment_status' => 'Self-Employed',
        'years_of_experience' => 8,

        // D. Job Preference & Availability
        'job_category' => 'Sales',
        'preferred_job_role' => 'Sales Manager',
        'preferred_work_location' => 'Abuja',
        'preferred_work_type' => 'Full-time',
        'expected_salary_range' => '300,000 - 600,000',
        'availability' => '1-2 weeks',

        // E. Skills & Competence
        'computer_literacy_level' => 'Intermediate',

        // F. References
        'referee_name' => 'Mr. Ahmed Ibrahim',
        'referee_relationship' => 'Mentor',
        'referee_phone_number' => '+2348034567890',

        // G. Health & Background
        'has_medical_condition' => false,
        'has_criminal_record' => false,
        'background_check_consent' => true,

        // H. Uploads
        'passport_photograph' => UploadedFile::fake()->image('photo.jpg'),
        'cv' => UploadedFile::fake()->create('cv.pdf', 1024),

        // I. Declaration & Consent
        'declaration_consent' => true,
    ];

    $response = postJson('/api/yeast-registrations', $data);

    $response->assertCreated();

    Storage::disk('public')->assertExists('registrations/identifications/'.$data['identification_document']->hashName());
    Storage::disk('public')->assertExists('registrations/certificates/'.$data['certificates']->hashName());
    Storage::disk('public')->assertExists('registrations/photographs/'.$data['passport_photograph']->hashName());
    Storage::disk('public')->assertExists('registrations/cvs/'.$data['cv']->hashName());
});

it('validates required fields', function () {
    $response = postJson('/api/yeast-registrations', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors([
            'surname',
            'first_name',
            'gender',
            'date_of_birth',
            'email',
            'phone_number',
            'declaration_consent',
        ]);
});

it('validates email format', function () {
    $data = YeastRegistration::factory()->raw([
        'email' => 'invalid-email',
    ]);

    $response = postJson('/api/yeast-registrations', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('validates gender enum values', function () {
    $data = YeastRegistration::factory()->raw([
        'gender' => 'Invalid',
    ]);

    $response = postJson('/api/yeast-registrations', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['gender']);
});

it('requires medical condition details when has_medical_condition is true', function () {
    $data = YeastRegistration::factory()->raw([
        'has_medical_condition' => true,
        'medical_condition_details' => null,
    ]);

    $response = postJson('/api/yeast-registrations', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['medical_condition_details']);
});

it('can list all registrations', function () {
    YeastRegistration::factory()->count(5)->create();

    $response = $this->getJson('/api/yeast-registrations');

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
            'message' => 'Yeast registrations retrieved successfully',
        ])
        ->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'personal_information',
                        'education',
                        'employment_history',
                        'job_preferences',
                        'skills',
                        'reference',
                        'background',
                        'documents',
                        'declaration',
                    ],
                ],
            ],
        ]);

    expect($response->json('data.data'))->toHaveCount(5);
});

it('can show a single registration', function () {
    $registration = YeastRegistration::factory()->create();

    $response = $this->getJson("/api/yeast-registrations/{$registration->id}");

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
            'message' => 'Registration retrieved successfully',
            'data' => [
                'id' => $registration->id,
                'personal_information' => [
                    'email' => $registration->email,
                ],
            ],
        ]);
});

it('can delete a registration', function () {
    $registration = YeastRegistration::factory()->create();

    $response = $this->deleteJson("/api/yeast-registrations/{$registration->id}");

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
            'message' => 'Registration deleted successfully',
        ]);

    expect(YeastRegistration::find($registration->id))->toBeNull();
});
