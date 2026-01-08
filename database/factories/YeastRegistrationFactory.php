<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YeastRegistration>
 */
class YeastRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // A. Personal Information
            'surname' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'other_name' => fake()->optional()->firstName(),
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
            'marital_status' => fake()->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'nationality' => 'Nigerian',
            'state_of_origin' => fake()->randomElement(['Lagos', 'Kano', 'Rivers', 'Oyo', 'Kaduna', 'Abuja']),
            'lga' => fake()->city(),
            'residential_address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'identification_type' => fake()->randomElement(['NIN', 'International Passport', "Voter's Card"]),
            'identification_number' => fake()->numerify('##########'),

            // B. Education & Qualifications
            'highest_education_level' => fake()->randomElement(['SSCE', 'OND', 'HND', 'Bachelor\'s Degree', 'Master\'s Degree', 'PhD']),
            'institution_attended' => fake()->company().' University',
            'course_of_study' => fake()->randomElement(['Business Administration', 'Computer Science', 'Engineering', 'Mass Communication', 'Accounting']),
            'year_of_graduation' => fake()->year(),
            'professional_certifications' => fake()->optional()->sentence(),

            // C. Employment & Work History
            'employment_status' => fake()->randomElement(['Employed', 'Unemployed', 'Self-Employed']),
            'years_of_experience' => fake()->numberBetween(0, 20),
            'previous_job_titles' => fake()->optional()->jobTitle(),
            'previous_employers' => fake()->optional()->company(),
            'key_responsibilities' => fake()->optional()->paragraph(),
            'reason_for_leaving' => fake()->optional()->sentence(),

            // D. Job Preference & Availability
            'job_category' => fake()->randomElement(['Admin', 'Domestic Staff', 'Driver', 'Security', 'Sales', 'Skilled Labour']),
            'preferred_job_role' => fake()->jobTitle(),
            'preferred_work_location' => fake()->city(),
            'preferred_work_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Live-in']),
            'expected_salary_range' => fake()->randomElement(['50,000 - 100,000', '100,000 - 200,000', '200,000 - 500,000']),
            'availability' => fake()->randomElement(['Immediate', '1-2 weeks', '1 month']),

            // E. Skills & Competence
            'key_skills' => fake()->randomElements(['Communication', 'Leadership', 'Problem Solving', 'Time Management', 'Team Work'], 3),
            'languages_spoken' => fake()->randomElements(['English', 'Hausa', 'Yoruba', 'Igbo', 'French'], 2),
            'computer_literacy_level' => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced', 'Expert']),
            'special_skills' => fake()->optional()->sentence(),

            // F. References
            'referee_name' => fake()->name(),
            'referee_relationship' => fake()->randomElement(['Former Supervisor', 'Colleague', 'Mentor', 'Teacher']),
            'referee_phone_number' => fake()->phoneNumber(),
            'referee_address' => fake()->optional()->address(),

            // G. Health & Background
            'has_medical_condition' => fake()->boolean(10),
            'medical_condition_details' => fake()->optional(0.1)->sentence(),
            'has_criminal_record' => fake()->boolean(2),
            'background_check_consent' => true,

            // I. Declaration & Consent
            'declaration_consent' => true,
            'declaration_date' => now(),
        ];
    }
}
