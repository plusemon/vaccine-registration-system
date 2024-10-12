<script setup>
import InputError from '@/Components/InputError.vue'
import LinkButton from '@/Components/LinkButton.vue'
import { Link, useForm, Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps(['user'])

const showResult = ref(props.user?.status)

const form = useForm({
    nid: '',
})

const submit = () => {
    form.post('/search', {
        onSuccess: () => showResult.value = true
    })
};

</script>

<template>

    <Head title="Vaccine Status"></Head>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center flex-col">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Check Vaccination Status</h2>

            <div v-if="showResult" class="mt-6">
                <div class="text-center border border-gray-300 rounded-lg shadow p-4">
                    <table class="min-w-full text-left ">
                        <tr v-if="user.name" class="text-gray-800 ">
                            <td>Name</td>
                            <td>:</td>
                            <td> {{ user.name }}</td>
                        </tr>
                        <tr v-if="user.nid" class="text-gray-800 ">
                            <td>NID</td>
                            <td>:</td>
                            <td> {{ user.nid }}</td>
                        </tr>
                        <tr v-if="user.vaccine_center_name">
                            <td>Center</td>
                            <td>:</td>
                            <td> {{ user.vaccine_center_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <span class="text-white rounded-lg px-3 py-1" :class="{
                                    'bg-green-500': user.status == 'Registered',
                                    'bg-red-500': user.status == 'Not Registered',
                                    'bg-yellow-500': user.status == 'Not Scheduled',
                                    'bg-blue-500': user.status == 'Scheduled',
                                }">{{ user.status }}</span>
                            </td>
                        </tr>
                        <tr v-if="user.scheduled_at">
                            <td>Scheduled</td>
                            <td>:</td>
                            <td> {{ user.scheduled_at }}</td>
                        </tr>
                    </table>
                </div>

                <div class="text-center">
                    <div class="mt-4" v-if="user.status == 'Not Registered'">
                        <a href="/register" class="text-blue-500 hover:underline">
                            Click here to register</a>
                    </div>
                    <div>
                        <button @click="showResult = null"
                            class="mt-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                            Search Again</button>
                    </div>
                </div>
            </div>

            <form v-else @submit.prevent="submit">
                <div class="mb-4">
                    <label for="nid" class="block text-sm font-medium text-gray-700">National ID</label>
                    <input type="number" id="nid" v-model="form.nid" placeholder="Ex: 1234567890123 (10 to 17 digits)"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <InputError class="mt-2" :message="form.errors.nid" />
                </div>

                <button type="submit" :disabled="form.processing" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50
                    disabled:opacity-50">
                    <span v-if="form.processing">Checking...</span>
                    <span v-else>Check Status</span>
                </button>
            </form>
        </div>
        <div class="text-center mt-4 flex flex justify-between max-w-md w-full">
            <LinkButton href="/" text="Register" />
            <LinkButton href="/registrations" text="View All" />
        </div>
    </div>


</template>

<style>
table td {
    padding: 8px;
}
</style>