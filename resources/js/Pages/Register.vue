<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
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
    <GuestLayout>

        <Head title="Vaccine Registration" />

        <h1 class="text-xl font-bold text-gray-600 text-center mb-6 border-b border-gray-300 pb-2">Vaccine Registration
            Form
        </h1>
        <form @submit.prevent="submit">

            <div class="space-y-2">
                <div>
                    <InputLabel for="name" value="Full Name" :required="true" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                        autocomplete="name" placeholder="Example: John Doe" />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="col-span-2">
                    <InputLabel for="email" value="Email" :required="true" />

                    <TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.email"
                        autocomplete="email" placeholder="Example: john@example.com" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="col-span-2">
                    <InputLabel for="nid" value="National ID (NID)" :required="true" />

                    <TextInput id="nid" type="number" class="mt-1 block w-full" v-model="form.nid" autocomplete="nid"
                        placeholder="Example: 123456789012345 (10 to 17 digit)" />

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
                    <div class=" text-gray-600 text-sm mt-1">
                        The Vaccination Center will be notified of your registration.
                    </div>
                    <InputError class="mt-2" :message="form.errors.vaccine_center_id" />
                </div>

            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton :disabled="form.processing">
                    <span v-if="form.processing">Registering</span>
                    <span v-else>Register</span>
                </PrimaryButton>
            </div>
        </form>

        <div class="text-center mt-4 flex flex justify-between">
            <Link href="/search" class="text-blue-500 hover:underline">Search User</Link>
            <Link href="/registrations" class="text-blue-500 hover:underline">View All</Link>
        </div>
    </GuestLayout>
</template>
