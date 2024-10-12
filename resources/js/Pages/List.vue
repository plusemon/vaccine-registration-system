<script setup>
import { Link, Head } from '@inertiajs/vue3'
import LinkButton from '@/Components/LinkButton.vue'
import moment from 'moment'
import { ref, computed } from 'vue'

const props = defineProps({
    users: Object
})

const search = ref('')

const filteredRegistrations = computed(() => {
    let query = search.value.toLowerCase()

    // return all users if query is empty
    if (!query) {
        return props.users.data
    }

    // filter users if query is not empty
    return props.users.data.filter(user => {
        // search by name or nid or center
        return user.name.toLowerCase().includes(query)
            || user.nid.includes(search.value)
            || user.vaccine_center?.name.toLowerCase().includes(query)
    })
})


</script>

<template>

    <Head title="List of Vaccination Registrations" />
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">All Vaccination Registrations</h1>
            <div class="flex gap-4">
                <LinkButton href="/search" text="Check Status" />
                <LinkButton href="/register" text="Register" />
            </div>
        </div>

        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm mb-2" v-model="search"
            placeholder="Search by name, NID or center (this search will find in this page contents only at this moment)">

        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b !text-start">#</th>
                    <th class="py-2 px-4 border-b !text-start">Name</th>
                    <th class="py-2 px-4 border-b !text-start">Email</th>
                    <th class="py-2 px-4 border-b !text-start">NID</th>
                    <th class="py-2 px-4 border-b !text-start">Center Name</th>
                    <th class="py-2 px-4 border-b !text-start">Registered</th>
                    <th class="py-2 px-4 border-b !text-start">Scheduled At</th>
                    <th class="py-2 px-4 border-b !text-start">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in filteredRegistrations" :key="user.id">
                    <td class="py-2 px-4 border-b">{{ user.id }}</td>
                    <td class="py-2 px-4 border-b">{{ user.name }}</td>
                    <td class="py-2 px-4 border-b">{{ user.email }}</td>
                    <td class="py-2 px-4 border-b">{{ user.nid }}</td>
                    <td class="py-2 px-4 border-b">{{ user.vaccine_center?.name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ moment(user.created_at).fromNow() }}</td>
                    <td class="py-2 px-4 border-b">{{ moment(user.scheduled_at).format('Do MMM, YYYY h:mm A') }} </td>
                    <td class="py-2 px-4 border-b">
                        <span :class="[user.status === 'Scheduled' ? 'bg-blue-500' : 'bg-green-500']"
                            class="px-2 py-1 rounded-lg text-white text-sm lowercase">
                            {{ user.status }}
                        </span>
                    </td>
                </tr>
                <tr v-if="filteredRegistrations.length === 0">
                    <td class="py-2 px-4 border-b" colspan="6">
                        <p v-if="search" class="text-center">
                            No results found for <b>"{{ search }}"</b>
                        </p>
                        <p v-else class="text-center">
                            No registrations found
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-4">
            <Link v-if="users.prev_page_url" :href="users.prev_page_url"
                class="inline-block px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">Previous</Link>

            <Link v-if="users.next_page_url" :href="users.next_page_url"
                class="inline-block px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600 ml-2">Next</Link>
        </div>
    </div>
</template>
