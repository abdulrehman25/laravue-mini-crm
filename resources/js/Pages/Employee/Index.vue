<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";

defineProps({
    employees: {
        type: Array,
        default: () => [],
    },
});
const deleteEmployee = (id) => {
    router.delete(`employee/${id}`);
};
</script>

<template>
    <Head title="Employees"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <button class="btn btn-sm btn-warning rounded-pill float-right">
                        <Link href="employee/create">
                            Create Employee
                        </Link>
                    </button>
                    <table class="table table-sm table-striped border text-center" style="width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in employees?.data">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ item.first_name + ' ' + item.last_name }}</td>
                            <td>{{ item.company.name }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.phone }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning rounded-pill">
                                    <Link :href="`employee/${item.id}/edit`">
                                        Edit
                                    </Link>
                                </button>
                                <button class="btn btn-sm btn-danger rounded-pill ml-1"
                                        @click="deleteEmployee(item.id)">Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
