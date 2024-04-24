<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {useForm} from "@inertiajs/vue3";
import {router} from '@inertiajs/vue3'

const props = defineProps({
    errors: Object,
    companies: Object,
    employee: {
        type: Object,
        default: null,
    },
    update: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    first_name: props?.employee?.first_name,
    last_name: props?.employee?.last_name,
    email: props?.employee?.email,
    company_id: props?.employee?.company_id,
    phone: props?.employee?.phone,
});
const create = () => router.post("/employee", {
    ...form
});
const update = () => router.post(`/employee/${props?.employee?.id}`, {
    _method: 'put',
    ...form
});

const submit = () => (props.update ? update() : create());
</script>

<template>
    <Head title="Companies"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Employee</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <label for="company_id">Company</label>
                            <select id="company_id" v-model="form.company_id">
                                <option v-for="(item) in props?.companies?.data" :value="item.id"
                                        :selected="item.id === form?.company_id ? selected : null">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div v-if="errors.company_id">{{ errors.company_id }}</div>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" v-model="form.first_name"/>
                            <div v-if="errors.first_name">{{ errors.first_name }}</div>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" v-model="form.last_name"/>
                            <div v-if="errors.last_name">{{ errors.last_name }}</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" v-model="form.email"/>
                            <div v-if="errors.email">{{ errors.email }}</div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" v-model="form.phone"/>
                            <div v-if="errors.phone">{{ errors.phone }}</div>
                        </div>
                        <button type="submit" class="mr-2 mt-2">
                            <Link href="/employee">
                                Cancel
                            </Link>
                        </button>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped></style>
