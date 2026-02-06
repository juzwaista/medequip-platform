<template>
    <MainLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Saved Addresses</h1>
                    <p class="text-gray-600 mt-2">Manage your delivery addresses for faster checkout</p>
                </div>
                <button 
                    @click="showAddForm = true"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Address
                </button>
            </div>

            <!-- Add/Edit Form Modal -->
            <div v-if="showAddForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ editingAddress ? 'Edit Address' : 'Add New Address' }}</h2>
                    
                    <form @submit.prevent="saveAddress" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Label (Optional)</label>
                            <input 
                                v-model="form.label"
                                type="text"
                                placeholder="e.g., Home, Office"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Recipient Name *</label>
                            <input 
                                v-model="form.recipient_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Number *</label>
                            <input 
                                v-model="form.contact_number"
                                type="tel"
                                required
                                placeholder="09XX XXX XXXX"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Address *</label>
                            <textarea 
                                v-model="form.address_line"
                                rows="2"
                                required
                                placeholder="House number, street, subdivision"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Barangay *</label>
                                <input 
                                    v-model="form.barangay"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">City *</label>
                                <input 
                                    v-model="form.city"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Province *</label>
                                <input 
                                    v-model="form.province"
                                    type="text"
                                    required
                                    value="Cavite"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Zip Code *</label>
                                <input 
                                    v-model="form.zip_code"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input 
                                v-model="form.is_default"
                                type="checkbox"
                                class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                            />
                            <label class="ml-3 text-sm font-medium text-gray-700">Set as default address</label>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button"
                                @click="cancelForm"
                                class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                            >
                                {{ editingAddress ? 'Update Address' : 'Save Address' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Addresses List -->
            <div v-if="addresses.length > 0" class="space-y-4">
                <div 
                    v-for="address in addresses" 
                    :key="address.id"
                    class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition"
                >
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ address.label || 'Address' }}</h3>
                                <span v-if="address.is_default" class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold">
                                    Default
                                </span>
                            </div>
                            <p class="font-semibold text-gray-900">{{ address.recipient_name }}</p>
                            <p class="text-gray-600">{{ address.contact_number }}</p>
                            <p class="text-gray-700 mt-2">{{ address.full_address }}</p>
                        </div>

                        <div class="flex gap-2">
                            <button 
                                v-if="!address.is_default"
                                @click="setAsDefault(address)"
                                class="text-blue-600 hover:text-blue-700 text-sm font-medium"
                            >
                                Set Default
                            </button>
                            <button 
                                @click="editAddress(address)"
                                class="text-gray-600 hover:text-gray-700"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button 
                                @click="deleteAddress(address)"
                                class="text-red-600 hover:text-red-700"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="h-20 w-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Saved Addresses</h3>
                <p class="text-gray-600 mb-6">Add an address for faster checkout</p>
                <button 
                    @click="showAddForm = true"
                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                >
                    Add Your First Address
                </button>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    addresses: Array,
});

const showAddForm = ref(false);
const editingAddress = ref(null);

const form = reactive({
    label: '',
    recipient_name: '',
    contact_number: '',
    address_line: '',
    barangay: '',
    city: '',
    province: 'Cavite',
    zip_code: '',
    is_default: false,
});

const resetForm = () => {
    form.label = '';
    form.recipient_name = '';
    form.contact_number = '';
    form.address_line = '';
    form.barangay = '';
    form.city = '';
    form.province = 'Cavite';
    form.zip_code = '';
    form.is_default = false;
    editingAddress.value = null;
};

const cancelForm = () => {
    showAddForm.value = false;
    resetForm();
};

const editAddress = (address) => {
    editingAddress.value = address;
    form.label = address.label || '';
    form.recipient_name = address.recipient_name;
    form.contact_number = address.contact_number;
    form.address_line = address.address_line;
    form.barangay = address.barangay;
    form.city = address.city;
    form.province = address.province;
    form.zip_code = address.zip_code;
    form.is_default = address.is_default;
    showAddForm.value = true;
};

const saveAddress = () => {
    if (editingAddress.value) {
        router.put(`/addresses/${editingAddress.value.id}`, form, {
            onSuccess: () => {
                showAddForm.value = false;
                resetForm();
            }
        });
    } else {
        router.post('/addresses', form, {
            onSuccess: () => {
                showAddForm.value = false;
                resetForm();
            }
        });
    }
};

const setAsDefault = (address) => {
    router.post(`/addresses/${address.id}/default`);
};

const deleteAddress = (address) => {
    if (confirm('Are you sure you want to delete this address?')) {
        router.delete(`/addresses/${address.id}`);
    }
};
</script>
