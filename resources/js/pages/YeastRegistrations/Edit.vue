<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

interface Registration {
    id: number;
    surname: string;
    first_name: string;
    other_name: string | null;
    gender: string;
    date_of_birth: string;
    marital_status: string;
    nationality: string;
    state_of_origin: string;
    lga: string;
    residential_address: string;
    phone_number: string;
    email: string;
    identification_type: string;
    identification_number: string;
    highest_education_level: string;
    institution_attended: string;
    course_of_study: string;
    year_of_graduation: string;
    professional_certifications: string | null;
    employment_status: string;
    years_of_experience: number;
    previous_job_titles: string | null;
    previous_employers: string | null;
    key_responsibilities: string | null;
    reason_for_leaving: string | null;
    job_category: string;
    preferred_job_role: string;
    preferred_work_location: string;
    preferred_work_type: string;
    expected_salary_range: string;
    availability: string;
    key_skills: string[];
    languages_spoken: string[];
    computer_literacy_level: string;
    special_skills: string | null;
    referee_name: string;
    referee_relationship: string;
    referee_phone_number: string;
    referee_address: string | null;
    has_medical_condition: boolean;
    medical_condition_details: string | null;
    has_criminal_record: boolean;
    background_check_consent: boolean;
    declaration_consent: boolean;
    has_identification_document: boolean;
    has_certificates: boolean;
    has_passport_photograph: boolean;
    has_cv: boolean;
    has_supporting_documents: boolean;
}

interface Props {
    registration: Registration;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'YEAST Registrations',
        href: '/yeast-registrations',
    },
    {
        title: 'Edit Registration',
        href: `/yeast-registrations/${props.registration.id}/edit`,
    },
];

const form = useForm({
    surname: props.registration.surname,
    first_name: props.registration.first_name,
    other_name: props.registration.other_name || '',
    gender: props.registration.gender,
    date_of_birth: props.registration.date_of_birth,
    marital_status: props.registration.marital_status,
    nationality: props.registration.nationality,
    state_of_origin: props.registration.state_of_origin,
    lga: props.registration.lga,
    residential_address: props.registration.residential_address,
    phone_number: props.registration.phone_number,
    email: props.registration.email,
    identification_type: props.registration.identification_type,
    identification_number: props.registration.identification_number,
    identification_document: null as File | null,
    highest_education_level: props.registration.highest_education_level,
    institution_attended: props.registration.institution_attended,
    course_of_study: props.registration.course_of_study,
    year_of_graduation: props.registration.year_of_graduation,
    professional_certifications: props.registration.professional_certifications || '',
    certificates: null as File | null,
    employment_status: props.registration.employment_status,
    years_of_experience: props.registration.years_of_experience,
    previous_job_titles: props.registration.previous_job_titles || '',
    previous_employers: props.registration.previous_employers || '',
    key_responsibilities: props.registration.key_responsibilities || '',
    reason_for_leaving: props.registration.reason_for_leaving || '',
    job_category: props.registration.job_category,
    preferred_job_role: props.registration.preferred_job_role,
    preferred_work_location: props.registration.preferred_work_location,
    preferred_work_type: props.registration.preferred_work_type,
    expected_salary_range: props.registration.expected_salary_range,
    availability: props.registration.availability,
    key_skills: props.registration.key_skills || [],
    languages_spoken: props.registration.languages_spoken || [],
    computer_literacy_level: props.registration.computer_literacy_level,
    special_skills: props.registration.special_skills || '',
    referee_name: props.registration.referee_name,
    referee_relationship: props.registration.referee_relationship,
    referee_phone_number: props.registration.referee_phone_number,
    referee_address: props.registration.referee_address || '',
    has_medical_condition: props.registration.has_medical_condition,
    medical_condition_details: props.registration.medical_condition_details || '',
    has_criminal_record: props.registration.has_criminal_record,
    background_check_consent: props.registration.background_check_consent,
    passport_photograph: null as File | null,
    cv: null as File | null,
    supporting_documents: null as File | null,
    declaration_consent: props.registration.declaration_consent,
});

const goBack = () => {
    router.visit(`/yeast-registrations/${props.registration.id}`);
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'PATCH',
    })).post(`/yeast-registrations/${props.registration.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            router.visit(`/yeast-registrations/${props.registration.id}`);
        },
    });
};
</script>

<template>
    <Head title="Edit Registration" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4">
            <div class="flex items-center justify-between">
                <Button @click="goBack" variant="ghost" size="sm">
                    <ArrowLeft class="mr-2 h-4 w-4" />
                    Back to Registration
                </Button>
            </div>

            <div>
                <h1 class="text-3xl font-bold tracking-tight">
                    Edit Registration
                </h1>
                <p class="text-muted-foreground">
                    Update the YEAST registration information
                </p>
            </div>

            <form @submit.prevent="submit" class="grid gap-6">
                <!-- A. Personal Information -->
                <Card>
                    <CardHeader>
                        <CardTitle>Personal Information</CardTitle>
                        <CardDescription>
                            Basic personal details
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="surname">Surname *</Label>
                                <Input
                                    id="surname"
                                    v-model="form.surname"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.surname" />
                            </div>
                            <div class="space-y-2">
                                <Label for="first_name">First Name *</Label>
                                <Input
                                    id="first_name"
                                    v-model="form.first_name"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.first_name" />
                            </div>
                            <div class="space-y-2">
                                <Label for="other_name">Other Name</Label>
                                <Input
                                    id="other_name"
                                    v-model="form.other_name"
                                    type="text"
                                />
                                <InputError :message="form.errors.other_name" />
                            </div>
                            <div class="space-y-2">
                                <Label for="gender">Gender *</Label>
                                <select
                                    id="gender"
                                    v-model="form.gender"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    required
                                >
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <InputError :message="form.errors.gender" />
                            </div>
                            <div class="space-y-2">
                                <Label for="date_of_birth">Date of Birth *</Label>
                                <Input
                                    id="date_of_birth"
                                    v-model="form.date_of_birth"
                                    type="date"
                                    required
                                />
                                <InputError :message="form.errors.date_of_birth" />
                            </div>
                            <div class="space-y-2">
                                <Label for="marital_status">Marital Status *</Label>
                                <select
                                    id="marital_status"
                                    v-model="form.marital_status"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    required
                                >
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                                <InputError :message="form.errors.marital_status" />
                            </div>
                            <div class="space-y-2">
                                <Label for="nationality">Nationality *</Label>
                                <Input
                                    id="nationality"
                                    v-model="form.nationality"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.nationality" />
                            </div>
                            <div class="space-y-2">
                                <Label for="state_of_origin">State of Origin *</Label>
                                <Input
                                    id="state_of_origin"
                                    v-model="form.state_of_origin"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.state_of_origin" />
                            </div>
                            <div class="space-y-2">
                                <Label for="lga">LGA *</Label>
                                <Input
                                    id="lga"
                                    v-model="form.lga"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.lga" />
                            </div>
                            <div class="space-y-2">
                                <Label for="phone_number">Phone Number *</Label>
                                <Input
                                    id="phone_number"
                                    v-model="form.phone_number"
                                    type="tel"
                                    required
                                />
                                <InputError :message="form.errors.phone_number" />
                            </div>
                            <div class="space-y-2">
                                <Label for="email">Email *</Label>
                                <Input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label for="residential_address">Residential Address *</Label>
                            <textarea
                                id="residential_address"
                                v-model="form.residential_address"
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                rows="2"
                                required
                            ></textarea>
                            <InputError :message="form.errors.residential_address" />
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="identification_type">Identification Type *</Label>
                                <select
                                    id="identification_type"
                                    v-model="form.identification_type"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    required
                                >
                                    <option value="NIN">NIN</option>
                                    <option value="International Passport">International Passport</option>
                                    <option value="Voter's Card">Voter's Card</option>
                                </select>
                                <InputError :message="form.errors.identification_type" />
                            </div>
                            <div class="space-y-2">
                                <Label for="identification_number">Identification Number *</Label>
                                <Input
                                    id="identification_number"
                                    v-model="form.identification_number"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.identification_number" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label for="identification_document">
                                Identification Document
                                <span v-if="registration.has_identification_document" class="text-xs text-muted-foreground">(Currently uploaded)</span>
                            </Label>
                            <Input
                                id="identification_document"
                                @input="form.identification_document = ($event.target as HTMLInputElement).files?.[0] || null"
                                type="file"
                                accept=".pdf,.jpg,.jpeg,.png"
                            />
                            <InputError :message="form.errors.identification_document" />
                        </div>
                    </CardContent>
                </Card>

                <!-- B. Education & Qualifications -->
                <Card>
                    <CardHeader>
                        <CardTitle>Education & Qualifications</CardTitle>
                        <CardDescription>
                            Educational background
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="highest_education_level">Highest Education Level *</Label>
                                <Input
                                    id="highest_education_level"
                                    v-model="form.highest_education_level"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.highest_education_level" />
                            </div>
                            <div class="space-y-2">
                                <Label for="institution_attended">Institution Attended *</Label>
                                <Input
                                    id="institution_attended"
                                    v-model="form.institution_attended"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.institution_attended" />
                            </div>
                            <div class="space-y-2">
                                <Label for="course_of_study">Course of Study *</Label>
                                <Input
                                    id="course_of_study"
                                    v-model="form.course_of_study"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.course_of_study" />
                            </div>
                            <div class="space-y-2">
                                <Label for="year_of_graduation">Year of Graduation *</Label>
                                <Input
                                    id="year_of_graduation"
                                    v-model="form.year_of_graduation"
                                    type="text"
                                    maxlength="4"
                                    required
                                />
                                <InputError :message="form.errors.year_of_graduation" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label for="professional_certifications">Professional Certifications</Label>
                            <textarea
                                id="professional_certifications"
                                v-model="form.professional_certifications"
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                rows="2"
                            ></textarea>
                            <InputError :message="form.errors.professional_certifications" />
                        </div>
                        <div class="space-y-2">
                            <Label for="certificates">
                                Certificates
                                <span v-if="registration.has_certificates" class="text-xs text-muted-foreground">(Currently uploaded)</span>
                            </Label>
                            <Input
                                id="certificates"
                                @input="form.certificates = ($event.target as HTMLInputElement).files?.[0] || null"
                                type="file"
                                accept=".pdf,.jpg,.jpeg,.png"
                            />
                            <InputError :message="form.errors.certificates" />
                        </div>
                    </CardContent>
                </Card>

                <!-- C. Employment & Work History -->
                <Card>
                    <CardHeader>
                        <CardTitle>Employment & Work History</CardTitle>
                        <CardDescription>
                            Work experience and history
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="employment_status">Employment Status *</Label>
                                <select
                                    id="employment_status"
                                    v-model="form.employment_status"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    required
                                >
                                    <option value="Employed">Employed</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Self-Employed">Self-Employed</option>
                                </select>
                                <InputError :message="form.errors.employment_status" />
                            </div>
                            <div class="space-y-2">
                                <Label for="years_of_experience">Years of Experience *</Label>
                                <Input
                                    id="years_of_experience"
                                    v-model.number="form.years_of_experience"
                                    type="number"
                                    min="0"
                                    max="100"
                                    required
                                />
                                <InputError :message="form.errors.years_of_experience" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label for="previous_job_titles">Previous Job Titles</Label>
                            <Input
                                id="previous_job_titles"
                                v-model="form.previous_job_titles"
                                type="text"
                            />
                            <InputError :message="form.errors.previous_job_titles" />
                        </div>
                        <div class="space-y-2">
                            <Label for="previous_employers">Previous Employers</Label>
                            <Input
                                id="previous_employers"
                                v-model="form.previous_employers"
                                type="text"
                            />
                            <InputError :message="form.errors.previous_employers" />
                        </div>
                        <div class="space-y-2">
                            <Label for="key_responsibilities">Key Responsibilities</Label>
                            <textarea
                                id="key_responsibilities"
                                v-model="form.key_responsibilities"
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                rows="3"
                            ></textarea>
                            <InputError :message="form.errors.key_responsibilities" />
                        </div>
                        <div class="space-y-2">
                            <Label for="reason_for_leaving">Reason for Leaving</Label>
                            <Input
                                id="reason_for_leaving"
                                v-model="form.reason_for_leaving"
                                type="text"
                            />
                            <InputError :message="form.errors.reason_for_leaving" />
                        </div>
                    </CardContent>
                </Card>

                <!-- D. Job Preference & Availability -->
                <Card>
                    <CardHeader>
                        <CardTitle>Job Preference & Availability</CardTitle>
                        <CardDescription>
                            Preferred job type and availability
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="job_category">Job Category *</Label>
                                <Input
                                    id="job_category"
                                    v-model="form.job_category"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.job_category" />
                            </div>
                            <div class="space-y-2">
                                <Label for="preferred_job_role">Preferred Job Role *</Label>
                                <Input
                                    id="preferred_job_role"
                                    v-model="form.preferred_job_role"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.preferred_job_role" />
                            </div>
                            <div class="space-y-2">
                                <Label for="preferred_work_location">Preferred Work Location *</Label>
                                <Input
                                    id="preferred_work_location"
                                    v-model="form.preferred_work_location"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.preferred_work_location" />
                            </div>
                            <div class="space-y-2">
                                <Label for="preferred_work_type">Preferred Work Type *</Label>
                                <select
                                    id="preferred_work_type"
                                    v-model="form.preferred_work_type"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    required
                                >
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Live-in">Live-in</option>
                                </select>
                                <InputError :message="form.errors.preferred_work_type" />
                            </div>
                            <div class="space-y-2">
                                <Label for="expected_salary_range">Expected Salary Range *</Label>
                                <Input
                                    id="expected_salary_range"
                                    v-model="form.expected_salary_range"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.expected_salary_range" />
                            </div>
                            <div class="space-y-2">
                                <Label for="availability">Availability *</Label>
                                <select
                                    id="availability"
                                    v-model="form.availability"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    required
                                >
                                    <option value="Immediate">Immediate</option>
                                    <option value="1-2 weeks">1-2 weeks</option>
                                    <option value="1 month">1 month</option>
                                </select>
                                <InputError :message="form.errors.availability" />
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- E. Skills & Competence -->
                <Card>
                    <CardHeader>
                        <CardTitle>Skills & Competence</CardTitle>
                        <CardDescription>
                            Skills and language proficiency
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="space-y-2">
                            <Label for="computer_literacy_level">Computer Literacy Level *</Label>
                            <select
                                id="computer_literacy_level"
                                v-model="form.computer_literacy_level"
                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                required
                            >
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                                <option value="Expert">Expert</option>
                            </select>
                            <InputError :message="form.errors.computer_literacy_level" />
                        </div>
                        <div class="space-y-2">
                            <Label for="special_skills">Special Skills</Label>
                            <textarea
                                id="special_skills"
                                v-model="form.special_skills"
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                rows="2"
                            ></textarea>
                            <InputError :message="form.errors.special_skills" />
                        </div>
                    </CardContent>
                </Card>

                <!-- F. References -->
                <Card>
                    <CardHeader>
                        <CardTitle>References</CardTitle>
                        <CardDescription>
                            Referee information
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="referee_name">Referee Name *</Label>
                                <Input
                                    id="referee_name"
                                    v-model="form.referee_name"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.referee_name" />
                            </div>
                            <div class="space-y-2">
                                <Label for="referee_relationship">Referee Relationship *</Label>
                                <Input
                                    id="referee_relationship"
                                    v-model="form.referee_relationship"
                                    type="text"
                                    required
                                />
                                <InputError :message="form.errors.referee_relationship" />
                            </div>
                            <div class="space-y-2">
                                <Label for="referee_phone_number">Referee Phone Number *</Label>
                                <Input
                                    id="referee_phone_number"
                                    v-model="form.referee_phone_number"
                                    type="tel"
                                    required
                                />
                                <InputError :message="form.errors.referee_phone_number" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label for="referee_address">Referee Address</Label>
                            <textarea
                                id="referee_address"
                                v-model="form.referee_address"
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                rows="2"
                            ></textarea>
                            <InputError :message="form.errors.referee_address" />
                        </div>
                    </CardContent>
                </Card>

                <!-- G. Health & Background -->
                <Card>
                    <CardHeader>
                        <CardTitle>Health & Background</CardTitle>
                        <CardDescription>
                            Health and background information
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <input
                                    id="has_medical_condition"
                                    v-model="form.has_medical_condition"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300"
                                />
                                <Label for="has_medical_condition">
                                    I have a medical condition
                                </Label>
                            </div>
                            <InputError :message="form.errors.has_medical_condition" />
                        </div>
                        <div v-if="form.has_medical_condition" class="space-y-2">
                            <Label for="medical_condition_details">Medical Condition Details *</Label>
                            <textarea
                                id="medical_condition_details"
                                v-model="form.medical_condition_details"
                                class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                rows="2"
                            ></textarea>
                            <InputError :message="form.errors.medical_condition_details" />
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <input
                                    id="has_criminal_record"
                                    v-model="form.has_criminal_record"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300"
                                />
                                <Label for="has_criminal_record">
                                    I have a criminal record
                                </Label>
                            </div>
                            <InputError :message="form.errors.has_criminal_record" />
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <input
                                    id="background_check_consent"
                                    v-model="form.background_check_consent"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300"
                                    required
                                />
                                <Label for="background_check_consent">
                                    I consent to background check *
                                </Label>
                            </div>
                            <InputError :message="form.errors.background_check_consent" />
                        </div>
                    </CardContent>
                </Card>

                <!-- H. Uploads -->
                <Card>
                    <CardHeader>
                        <CardTitle>Document Uploads</CardTitle>
                        <CardDescription>
                            Upload required documents
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4">
                        <div class="space-y-2">
                            <Label for="passport_photograph">
                                Passport Photograph
                                <span v-if="registration.has_passport_photograph" class="text-xs text-muted-foreground">(Currently uploaded)</span>
                            </Label>
                            <Input
                                id="passport_photograph"
                                @input="form.passport_photograph = ($event.target as HTMLInputElement).files?.[0] || null"
                                type="file"
                                accept=".jpg,.jpeg,.png"
                            />
                            <InputError :message="form.errors.passport_photograph" />
                        </div>
                        <div class="space-y-2">
                            <Label for="cv">
                                CV (PDF)
                                <span v-if="registration.has_cv" class="text-xs text-muted-foreground">(Currently uploaded)</span>
                            </Label>
                            <Input
                                id="cv"
                                @input="form.cv = ($event.target as HTMLInputElement).files?.[0] || null"
                                type="file"
                                accept=".pdf"
                            />
                            <InputError :message="form.errors.cv" />
                        </div>
                        <div class="space-y-2">
                            <Label for="supporting_documents">
                                Supporting Documents
                                <span v-if="registration.has_supporting_documents" class="text-xs text-muted-foreground">(Currently uploaded)</span>
                            </Label>
                            <Input
                                id="supporting_documents"
                                @input="form.supporting_documents = ($event.target as HTMLInputElement).files?.[0] || null"
                                type="file"
                                accept=".pdf,.jpg,.jpeg,.png"
                            />
                            <InputError :message="form.errors.supporting_documents" />
                        </div>
                    </CardContent>
                </Card>

                <!-- I. Declaration & Consent -->
                <Card>
                    <CardHeader>
                        <CardTitle>Declaration & Consent</CardTitle>
                        <CardDescription>
                            Final declaration
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <input
                                    id="declaration_consent"
                                    v-model="form.declaration_consent"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300"
                                    required
                                />
                                <Label for="declaration_consent">
                                    I declare that all information provided is accurate and true *
                                </Label>
                            </div>
                            <InputError :message="form.errors.declaration_consent" />
                        </div>
                    </CardContent>
                </Card>

                <!-- Submit Button -->
                <div class="flex gap-4 justify-end">
                    <Button
                        type="button"
                        variant="outline"
                        @click="goBack"
                    >
                        Cancel
                    </Button>
                    <Button
                        type="submit"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Updating...' : 'Update Registration' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

