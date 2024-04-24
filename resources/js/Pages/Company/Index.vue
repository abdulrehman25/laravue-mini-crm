<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {Link} from '@inertiajs/vue3'
import {router} from '@inertiajs/vue3'

defineProps({
    companies: {
        type: Array,
        default: () => [],
    },
});
const deleteCompany = (id) => {
    router.delete(`company/${id}`);
};
</script>

<template>
    <Head title="Companies"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <button class="btn btn-sm btn-warning rounded-pill float-right">
                        <Link href="company/create">
                            Create Company
                        </Link>
                    </button>
                    <table class="table table-sm table-striped border text-center" style="width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Website</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in companies.data">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.website }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning rounded-pill mr-1">
                                    <Link :href="`company/${item.id}/edit`">
                                        Edit
                                    </Link>
                                </button>
                                <button class="btn btn-sm btn-danger rounded-pill ml-1" @click="deleteCompany(item.id)">
                                    Delete
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
