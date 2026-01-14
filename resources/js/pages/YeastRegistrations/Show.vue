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
import { Badge } from '@/components/ui/badge';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ArrowLeft, Download, Edit, Trash2 } from 'lucide-vue-next';

interface Registration {
    id: number;
    personal_information: {
        surname: string;
        first_name: string;
        other_name: string;
        full_name: string;
        gender: string;
        date_of_birth: string;
        marital_status: string;
        nationality: string;
        state_of_origin: string;
        lga: string;
        residential_address: string;
        phone_number: string;
        email: string;
        identification: {
            type: string;
            number: string;
            has_document: boolean;
        };
    };
    education: {
        highest_level: string;
        institution: string;
        course_of_study: string;
        year_of_graduation: string;
        professional_certifications: string;
        has_certificates: boolean;
    };
    employment_history: {
        status: string;
        years_of_experience: number;
        previous_job_titles: string;
        previous_employers: string;
        key_responsibilities: string;
        reason_for_leaving: string;
    };
    job_preferences: {
        category: string;
        preferred_role: string;
        preferred_location: string;
        preferred_work_type: string;
        expected_salary_range: string;
        availability: string;
    };
    skills: {
        key_skills: string[];
        languages_spoken: string[];
        computer_literacy_level: string;
        special_skills: string;
    };
    reference: {
        name: string;
        relationship: string;
        phone_number: string;
        address: string;
    };
    background: {
        has_medical_condition: boolean;
        medical_condition_details: string;
        has_criminal_record: boolean;
        background_check_consent: boolean;
    };
    documents: {
        has_passport_photograph: boolean;
        passport_photograph_url: string | null;
        has_cv: boolean;
        has_supporting_documents: boolean;
    };
    declaration: {
        consent: boolean;
        date: string;
    };
    created_at: string;
    updated_at: string;
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
        title: 'View Registration',
        href: `/yeast-registrations/${props.registration.id}`,
    },
];

const goBack = () => {
    router.visit('/yeast-registrations');
};

const editRegistration = () => {
    router.visit(`/yeast-registrations/${props.registration.id}/edit`);
};

const deleteRegistration = () => {
    if (
        confirm(
            `Are you sure you want to delete the registration for ${props.registration.personal_information.full_name}? This action cannot be undone.`,
        )
    ) {
        router.delete(`/yeast-registrations/${props.registration.id}`, {
            onSuccess: () => {
                router.visit('/yeast-registrations');
            },
        });
    }
};

const downloadDocument = (documentType: string) => {
    window.location.href = `/yeast-registrations/${props.registration.id}/download/${documentType}`;
};
</script>

<template>
    <Head
        :title="`Registration - ${registration.personal_information.full_name}`"
    />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4">
            <div class="flex items-center justify-between">
                <Button @click="goBack" variant="ghost" size="sm">
                    <ArrowLeft class="mr-2 h-4 w-4" />
                    Back to Registrations
                </Button>
                <div class="flex gap-2">
                    <Button @click="editRegistration" variant="outline">
                        <Edit class="mr-2 h-4 w-4" />
                        Edit Registration
                    </Button>
                    <Button
                        @click="deleteRegistration"
                        variant="destructive"
                    >
                        <Trash2 class="mr-2 h-4 w-4" />
                        Delete
                    </Button>
                </div>
            </div>

            <div class="flex items-start gap-6">
                <div
                    v-if="registration.documents.passport_photograph_url"
                    class="flex-shrink-0"
                >
                    <img
                        :src="registration.documents.passport_photograph_url"
                        :alt="`${registration.personal_information.full_name} - Passport Photograph`"
                        class="h-32 w-32 rounded-lg border-2 border-border object-cover shadow-sm"
                    />
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold tracking-tight">
                        {{ registration.personal_information.full_name }}
                    </h1>
                    <p class="text-muted-foreground">
                        Registration submitted on {{ registration.created_at }}
                    </p>
                </div>
            </div>

            <div class="grid gap-6">
                <!-- Personal Information -->
                <Card>
                    <CardHeader>
                        <CardTitle>Personal Information</CardTitle>
                        <CardDescription>
                            Basic personal details of the applicant
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Surname</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .surname
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >First Name</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .first_name
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Other Name</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .other_name || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Gender</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information.gender
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Date of Birth</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .date_of_birth
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Marital Status</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .marital_status
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Nationality</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .nationality
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >State of Origin</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .state_of_origin
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >LGA</label
                                >
                                <p class="text-base">
                                    {{ registration.personal_information.lga }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Phone Number</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .phone_number
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Email</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information.email
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Residential Address</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .residential_address
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Identification Type</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .identification.type
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Identification Number</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.personal_information
                                            .identification.number
                                    }}
                                </p>
                            </div>
                            <div
                                v-if="
                                    registration.personal_information
                                        .identification.has_document
                                "
                            >
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Identification Document</label
                                >
                                <Button
                                    @click="downloadDocument('identification')"
                                    variant="outline"
                                    size="sm"
                                    class="mt-1"
                                >
                                    <Download class="mr-2 h-3 w-3" />
                                    Download
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Education & Qualifications -->
                <Card>
                    <CardHeader>
                        <CardTitle>Education & Qualifications</CardTitle>
                        <CardDescription>
                            Educational background and certifications
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Highest Education Level</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.education.highest_level ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Institution Attended</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.education.institution ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Course of Study</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.education
                                            .course_of_study || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Year of Graduation</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.education
                                            .year_of_graduation || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Professional Certifications</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.education
                                            .professional_certifications ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                            <div
                                v-if="registration.education.has_certificates"
                            >
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Certificates</label
                                >
                                <Button
                                    @click="downloadDocument('certificates')"
                                    variant="outline"
                                    size="sm"
                                    class="mt-1"
                                >
                                    <Download class="mr-2 h-3 w-3" />
                                    Download
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Employment History -->
                <Card>
                    <CardHeader>
                        <CardTitle>Employment & Work History</CardTitle>
                        <CardDescription>
                            Previous employment and work experience
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Employment Status</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.employment_history
                                            .status || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Years of Experience</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.employment_history
                                            .years_of_experience || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Previous Job Titles</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.employment_history
                                            .previous_job_titles || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Previous Employers</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.employment_history
                                            .previous_employers || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Key Responsibilities</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.employment_history
                                            .key_responsibilities || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Reason for Leaving</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.employment_history
                                            .reason_for_leaving || 'N/A'
                                    }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Job Preferences -->
                <Card>
                    <CardHeader>
                        <CardTitle>Job Preferences & Availability</CardTitle>
                        <CardDescription>
                            Preferred job details and availability
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Job Category</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.job_preferences.category ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Preferred Role</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.job_preferences
                                            .preferred_role || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Preferred Location</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.job_preferences
                                            .preferred_location || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Preferred Work Type</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.job_preferences
                                            .preferred_work_type || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Expected Salary Range</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.job_preferences
                                            .expected_salary_range || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Availability</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.job_preferences
                                            .availability || 'N/A'
                                    }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Skills & Competence -->
                <Card>
                    <CardHeader>
                        <CardTitle>Skills & Competence</CardTitle>
                        <CardDescription>
                            Skills, languages, and competencies
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Key Skills</label
                                >
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <Badge
                                        v-for="(skill, index) in registration
                                            .skills.key_skills"
                                        :key="index"
                                        variant="secondary"
                                    >
                                        {{ skill }}
                                    </Badge>
                                    <span
                                        v-if="
                                            !registration.skills.key_skills ||
                                            registration.skills.key_skills
                                                .length === 0
                                        "
                                        class="text-base"
                                        >N/A</span
                                    >
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Languages Spoken</label
                                >
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <Badge
                                        v-for="(
                                            language, index
                                        ) in registration.skills
                                            .languages_spoken"
                                        :key="index"
                                        variant="secondary"
                                    >
                                        {{ language }}
                                    </Badge>
                                    <span
                                        v-if="
                                            !registration.skills
                                                .languages_spoken ||
                                            registration.skills.languages_spoken
                                                .length === 0
                                        "
                                        class="text-base"
                                        >N/A</span
                                    >
                                </div>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Computer Literacy Level</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.skills
                                            .computer_literacy_level || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Special Skills</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.skills.special_skills ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- References -->
                <Card>
                    <CardHeader>
                        <CardTitle>Reference</CardTitle>
                        <CardDescription>
                            Referee contact information
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Referee Name</label
                                >
                                <p class="text-base">
                                    {{ registration.reference.name || 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Relationship</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.reference.relationship ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Phone Number</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.reference.phone_number ||
                                        'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Address</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.reference.address || 'N/A'
                                    }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Background & Health -->
                <Card>
                    <CardHeader>
                        <CardTitle>Health & Background</CardTitle>
                        <CardDescription>
                            Medical and background information
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Has Medical Condition</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.background
                                            .has_medical_condition
                                            ? 'Yes'
                                            : 'No'
                                    }}
                                </p>
                            </div>
                            <div
                                v-if="
                                    registration.background.has_medical_condition
                                "
                            >
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Medical Condition Details</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.background
                                            .medical_condition_details || 'N/A'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Has Criminal Record</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.background
                                            .has_criminal_record
                                            ? 'Yes'
                                            : 'No'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Background Check Consent</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.background
                                            .background_check_consent
                                            ? 'Yes'
                                            : 'No'
                                    }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Documents -->
                <Card>
                    <CardHeader>
                        <CardTitle>Documents</CardTitle>
                        <CardDescription>
                            Uploaded documents and files
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4 md:grid-cols-3">
                            <div v-if="registration.documents.has_passport_photograph">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Passport Photograph</label
                                >
                                <Button
                                    @click="downloadDocument('passport')"
                                    variant="outline"
                                    size="sm"
                                    class="mt-1"
                                >
                                    <Download class="mr-2 h-3 w-3" />
                                    Download
                                </Button>
                            </div>
                            <div v-if="registration.documents.has_cv">
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >CV/Resume</label
                                >
                                <Button
                                    @click="downloadDocument('cv')"
                                    variant="outline"
                                    size="sm"
                                    class="mt-1"
                                >
                                    <Download class="mr-2 h-3 w-3" />
                                    Download
                                </Button>
                            </div>
                            <div
                                v-if="
                                    registration.documents
                                        .has_supporting_documents
                                "
                            >
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Supporting Documents</label
                                >
                                <Button
                                    @click="downloadDocument('supporting')"
                                    variant="outline"
                                    size="sm"
                                    class="mt-1"
                                >
                                    <Download class="mr-2 h-3 w-3" />
                                    Download
                                </Button>
                            </div>
                            <div
                                v-if="
                                    !registration.documents
                                        .has_passport_photograph &&
                                    !registration.documents.has_cv &&
                                    !registration.documents
                                        .has_supporting_documents
                                "
                                class="md:col-span-3"
                            >
                                <p class="text-sm text-muted-foreground">
                                    No documents uploaded
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Declaration -->
                <Card>
                    <CardHeader>
                        <CardTitle>Declaration & Consent</CardTitle>
                        <CardDescription>
                            Applicant's declaration and consent
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-4">
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Consent Given</label
                                >
                                <p class="text-base">
                                    {{
                                        registration.declaration.consent
                                            ? 'Yes'
                                            : 'No'
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="text-sm font-medium text-muted-foreground"
                                    >Declaration Date</label
                                >
                                <p class="text-base">
                                    {{ registration.declaration.date }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

