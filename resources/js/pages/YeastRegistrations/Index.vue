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
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { Download, Eye, FileText, Edit, Trash2 } from 'lucide-vue-next';

interface Registration {
    id: number;
    full_name: string;
    email: string;
    phone_number: string;
    job_category: string;
    preferred_job_role: string;
    employment_status: string;
    created_at: string;
}

interface PaginatedData {
    data: Registration[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
}

interface Props {
    registrations: PaginatedData;
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
];

const exportToExcel = () => {
    window.location.href = '/yeast-registrations-export';
};

const viewRegistration = (id: number) => {
    router.visit(`/yeast-registrations/${id}`);
};

const editRegistration = (id: number) => {
    router.visit(`/yeast-registrations/${id}/edit`);
};

const deleteRegistration = (id: number, fullName: string) => {
    if (
        confirm(
            `Are you sure you want to delete the registration for ${fullName}? This action cannot be undone.`,
        )
    ) {
        router.delete(`/yeast-registrations/${id}`, {
            preserveScroll: true,
        });
    }
};

const goToPage = (url: string | null) => {
    if (url) {
        router.visit(url);
    }
};
</script>

<template>
    <Head title="YEAST Registrations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">
                        YEAST Registrations
                    </h1>
                    <p class="text-muted-foreground">
                        View and manage all YEAST program registrations
                    </p>
                </div>
                <Button @click="exportToExcel" variant="default">
                    <Download class="mr-2 h-4 w-4" />
                    Export to Excel
                </Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>All Registrations</CardTitle>
                    <CardDescription>
                        Total: {{ registrations.total }} registrations
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="overflow-x-auto">
                        <table
                            class="w-full border-collapse text-sm"
                            v-if="registrations.data.length > 0"
                        >
                            <thead>
                                <tr
                                    class="border-b border-sidebar-border/70 dark:border-sidebar-border"
                                >
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Full Name
                                    </th>
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Email
                                    </th>
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Phone
                                    </th>
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Job Category
                                    </th>
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Preferred Role
                                    </th>
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="p-3 text-left font-semibold text-foreground"
                                    >
                                        Submitted
                                    </th>
                                    <th
                                        class="p-3 text-center font-semibold text-foreground"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="registration in registrations.data"
                                    :key="registration.id"
                                    class="border-b border-sidebar-border/70 hover:bg-muted/50 dark:border-sidebar-border"
                                >
                                    <td class="p-3 font-medium">
                                        {{ registration.full_name }}
                                    </td>
                                    <td class="p-3 text-muted-foreground">
                                        {{ registration.email }}
                                    </td>
                                    <td class="p-3 text-muted-foreground">
                                        {{ registration.phone_number }}
                                    </td>
                                    <td class="p-3">
                                        {{ registration.job_category }}
                                    </td>
                                    <td class="p-3">
                                        {{ registration.preferred_job_role }}
                                    </td>
                                    <td class="p-3">
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium"
                                            :class="{
                                                'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300':
                                                    registration.employment_status ===
                                                    'Employed',
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300':
                                                    registration.employment_status ===
                                                    'Unemployed',
                                                'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300':
                                                    registration.employment_status ===
                                                    'Self-employed',
                                            }"
                                        >
                                            {{
                                                registration.employment_status ||
                                                'N/A'
                                            }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-muted-foreground">
                                        {{ registration.created_at }}
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex gap-1 justify-center">
                                            <Button
                                                @click="
                                                    viewRegistration(
                                                        registration.id,
                                                    )
                                                "
                                                variant="ghost"
                                                size="sm"
                                            >
                                                <Eye class="h-4 w-4" />
                                            </Button>
                                            <Button
                                                @click="
                                                    editRegistration(
                                                        registration.id,
                                                    )
                                                "
                                                variant="ghost"
                                                size="sm"
                                            >
                                                <Edit class="h-4 w-4" />
                                            </Button>
                                            <Button
                                                @click="
                                                    deleteRegistration(
                                                        registration.id,
                                                        registration.full_name,
                                                    )
                                                "
                                                variant="ghost"
                                                size="sm"
                                                class="text-destructive hover:text-destructive"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div
                            v-else
                            class="flex flex-col items-center justify-center py-12 text-center"
                        >
                            <FileText
                                class="mb-4 h-12 w-12 text-muted-foreground"
                            />
                            <h3 class="mb-2 text-lg font-semibold">
                                No registrations found
                            </h3>
                            <p class="text-sm text-muted-foreground">
                                There are no YEAST registrations yet.
                            </p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="
                            registrations.data.length > 0 &&
                            registrations.last_page > 1
                        "
                        class="mt-6 flex items-center justify-between border-t border-sidebar-border/70 pt-4 dark:border-sidebar-border"
                    >
                        <div class="text-sm text-muted-foreground">
                            Showing
                            {{
                                (registrations.current_page - 1) *
                                    registrations.per_page +
                                1
                            }}
                            to
                            {{
                                Math.min(
                                    registrations.current_page *
                                        registrations.per_page,
                                    registrations.total,
                                )
                            }}
                            of {{ registrations.total }} results
                        </div>

                        <div class="flex gap-2">
                            <template
                                v-for="link in registrations.links"
                                :key="link.label"
                            >
                                <Button
                                    v-if="
                                        link.label !== '&laquo; Previous' &&
                                        link.label !== 'Next &raquo;'
                                    "
                                    @click="goToPage(link.url)"
                                    :variant="link.active ? 'default' : 'outline'"
                                    size="sm"
                                    :disabled="!link.url"
                                >
                                    {{ link.label }}
                                </Button>
                                <Button
                                    v-else
                                    @click="goToPage(link.url)"
                                    :variant="link.active ? 'default' : 'outline'"
                                    size="sm"
                                    :disabled="!link.url"
                                >
                                    {{
                                        link.label === '&laquo; Previous'
                                            ? 'Previous'
                                            : 'Next'
                                    }}
                                </Button>
                            </template>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

