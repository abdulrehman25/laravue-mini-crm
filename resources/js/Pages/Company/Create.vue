<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {useForm} from "@inertiajs/vue3";
import {router} from '@inertiajs/vue3'

const props = defineProps({
    errors: Object,
    company: {
        type: Object,
        default: null,
    },
    update: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    name: props?.company?.name,
    email: props?.company?.email,
    logo: null,
    website: props?.company?.website,
});
const create = () => router.post("/company", {
    ...form
});
const update = () => router.post(`/company/${props?.company?.id}`, {
    _method: 'put',
    ...form
});

const submit = () => (props.update ? update() : create());
</script>

<template>
    <Head title="Companies"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Company</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" v-model="form.name"/>
                            <div v-if="errors.name">{{ errors.name }}</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" v-model="form.email"/>
                            <div v-if="errors.email">{{ errors.email }}</div>
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" v-model="form.website"/>
                            <div v-if="errors.website">{{ errors.website }}</div>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" @input="form.logo = $event.target.files[0]"/>
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                            <div v-if="errors.logo">{{ errors.logo }}</div>
                        </div>
                        <button type="submit" class="mr-2 mt-2">
                            <Link href="/company">
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
