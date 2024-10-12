<script setup>
import { Link, Head } from '@inertiajs/vue3'

defineProps({
    user: {
        type: Object,
        required: true,
    }
})
</script>
<template>

    <Head title="Registration Confirmation"></Head>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="bg-white shadow-md rounded-lg p-6 max-w-lg w-full">
            <div class="text-center mb-6">
                <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-800">Registration Successful!</h2>
                <p class="text-gray-600 mt-2">Thank you for registering for vaccination.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-medium text-gray-700 mb-4">Your Vaccination Details:</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Full Name:</span>
                        <span class="text-gray-800">{{ user.name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">National ID (NID):</span>
                        <span class="text-gray-800">{{ user.nid }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Email Address:</span>
                        <span class="text-gray-800">{{ user.email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Vaccine Center:</span>
                        <span class="text-gray-800">{{ user.vaccine_center_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Scheduled Date:</span>
                        <span class="text-gray-800">{{ user.scheduled_at }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <Link href="/"
                    class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300">
                Back to Home
                </Link>
            </div>
        </div>
    </div>
</template>
