<template>
    <MainLayout>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Privacy Settings</h1>
                <p class="text-gray-600 mt-2">Manage your privacy preferences</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 space-y-6">
                <!-- Coming Soon Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-blue-800">Coming Soon</p>
                            <p class="text-sm text-blue-700 mt-1">
                                Privacy settings are currently under development. 
                                Check back later for options to manage your data and preferences.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Placeholder Settings -->
                <div class="space-y-4 opacity-50">
                    <div class="flex items-center justify-between py-4 border-b">
                        <div>
                            <p class="font-semibold text-gray-900">Email Notifications</p>
                            <p class="text-sm text-gray-600">Receive order updates and promotions</p>
                        </div>
                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-not-allowed rounded-full bg-gray-200" disabled>
                            <span class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between py-4 border-b">
                        <div>
                            <p class="font-semibold text-gray-900">SMS Notifications</p>
                            <p class="text-sm text-gray-600">Receive delivery updates via text</p>
                        </div>
                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-not-allowed rounded-full bg-blue-600" disabled>
                            <span class="translate-x-5 inline-block h-5 w-5 rounded-full bg-white shadow transform transition mt-0.5"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <div>
                            <p class="font-semibold text-gray-900">Data Sharing</p>
                            <p class="text-sm text-gray-600">Allow sharing anonymous usage data</p>
                        </div>
                        <button class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-not-allowed rounded-full bg-gray-200" disabled>
                            <span class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>
                </div>

                <a href="/settings" class="block text-center text-blue-600 hover:text-blue-700 font-medium mt-6">
                    ← Back to Account Settings
                </a>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
</script>
