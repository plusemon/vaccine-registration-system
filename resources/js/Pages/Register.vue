<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import LinkButton from '@/Components/LinkButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import SelectField from '@/Components/SelectField.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps({
    vaccineCenters: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    name: '',
    email: '',
    nid: '',
    vaccine_center_id: '',
})

const submit = () => {
    form.post(route('register'))
}
</script>

<template>

    <Head title="Vaccine Registration" />
    <GuestLayout>
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800">
            <h1 class="text-xl font-bold text-gray-600 text-center mb-6 border-b border-gray-300 pb-2">Vaccine
                Registration
                Form
            </h1>
            <form @submit.prevent="submit">

                <div class="space-y-2">
                    <div>
                        <InputLabel for="name" value="Full Name" :required="true" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                            autocomplete="name" placeholder="Ex: John Doe" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="col-span-2">
                        <InputLabel for="email" value="Email" :required="true" />

                        <TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.email"
                            autocomplete="email" placeholder="Ex: john@example.com" />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="col-span-2">
                        <InputLabel for="nid" value="National ID (NID)" :required="true" />

                        <TextInput id="nid" type="number" class="mt-1 block w-full" v-model="form.nid"
                            autocomplete="nid" placeholder="Ex: 123456789012345 (10 to 17 digit)" />

                        <InputError class=" mt-2" :message="form.errors.nid" />
                    </div>

                    <div class="col-span-2">
                        <InputLabel for="vaccine_center_id" value="Vaccine Center" :required="true" />
                        <SelectField id="vaccine_center_id" class="mt-1 block w-full" v-model="form.vaccine_center_id"
                            autocomplete="vaccine_center_id" placeholder="Select Vaccine Center">
                            <option value="">Select A Vaccine Center</option>
                            <option v-for="vaccineCenter in vaccineCenters" :key="vaccineCenter.id"
                                :value="vaccineCenter.id">{{ vaccineCenter.name }}</option>
                        </SelectField>
                        <div v-if="!form.errors.vaccine_center_id" class=" text-gray-600 text-sm mt-1">
                            The place where you will be vaccinated.
                        </div>
                        <InputError class="mt-2" :message="form.errors.vaccine_center_id" />
                    </div>

                </div>

                <div class="mt-4 flex items-center justify-end">
                    <PrimaryButton :disabled="form.processing">
                        <span v-if="form.processing">Registering...</span>
                        <span v-else>Register</span>
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div class="flex justify-between items-center mt-4 w-full max-w-md">
            <LinkButton href="/search" text="Search" />
            <LinkButton href="/registrations" text="View All" />
        </div>
    </GuestLayout>
</template>
