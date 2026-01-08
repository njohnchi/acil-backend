<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yeast_registrations', function (Blueprint $table) {
            $table->id();

            // A. Personal Information
            $table->string('surname');
            $table->string('first_name');
            $table->string('other_name')->nullable();
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('marital_status');
            $table->string('nationality');
            $table->string('state_of_origin');
            $table->string('lga');
            $table->text('residential_address');
            $table->string('phone_number');
            $table->string('email');
            $table->string('identification_type');
            $table->string('identification_number');
            $table->string('identification_document_path')->nullable();

            // B. Education & Qualifications
            $table->string('highest_education_level');
            $table->string('institution_attended');
            $table->string('course_of_study');
            $table->string('year_of_graduation');
            $table->text('professional_certifications')->nullable();
            $table->string('certificates_path')->nullable();

            // C. Employment & Work History
            $table->string('employment_status');
            $table->integer('years_of_experience')->default(0);
            $table->text('previous_job_titles')->nullable();
            $table->text('previous_employers')->nullable();
            $table->text('key_responsibilities')->nullable();
            $table->text('reason_for_leaving')->nullable();

            // D. Job Preference & Availability
            $table->string('job_category');
            $table->string('preferred_job_role');
            $table->string('preferred_work_location');
            $table->string('preferred_work_type');
            $table->string('expected_salary_range');
            $table->string('availability');

            // E. Skills & Competence
            $table->json('key_skills')->nullable();
            $table->json('languages_spoken')->nullable();
            $table->string('computer_literacy_level');
            $table->text('special_skills')->nullable();

            // F. References
            $table->string('referee_name');
            $table->string('referee_relationship');
            $table->string('referee_phone_number');
            $table->text('referee_address')->nullable();

            // G. Health & Background
            $table->boolean('has_medical_condition')->default(false);
            $table->text('medical_condition_details')->nullable();
            $table->boolean('has_criminal_record')->default(false);
            $table->boolean('background_check_consent')->default(false);

            // H. Uploads
            $table->string('passport_photograph_path')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('supporting_documents_path')->nullable();

            // I. Declaration & Consent
            $table->boolean('declaration_consent')->default(false);
            $table->timestamp('declaration_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeast_registrations');
    }
};
