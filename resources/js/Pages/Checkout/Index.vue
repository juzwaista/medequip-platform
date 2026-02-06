<template>
    <MainLayout>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                <p class="text-gray-600 mt-2">Complete your order</p>
            </div>

            <form @submit.prevent="submitOrder" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Error Display -->
                    <div v-if="form.errors && Object.keys(form.errors).length > 0" class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                                <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                    <li v-for="(error, field) in form.errors" :key="field">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Delivery Information</h2>
                        
                        <div class="space-y-4">
                            <!-- Saved Addresses -->
                            <div v-if="savedAddresses.length > 0" class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-semibold text-blue-900">Saved Addresses</h3>
                                    <Link href="/addresses" class="text-xs text-blue-600 hover:underline">Manage Addresses</Link>
                                </div>
                                <select 
                                    v-model="selectedSavedAddress"
                                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white"
                                >
                                    <option value="">-- Select a saved address --</option>
                                    <option v-for="addr in savedAddresses" :key="addr.id" :value="addr.id">
                                        {{ addr.label ? `${addr.label}: ` : '' }}{{ addr.address_line }}
                                    </option>
                                </select>
                            </div>

                            <!-- Customer Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Recipient Name *
                                    <span v-if="form.errors.customer_name" class="text-red-600 font-normal ml-2">{{ form.errors.customer_name }}</span>
                                </label>
                                <input 
                                    v-model="form.customer_name"
                                    type="text"
                                    required
                                    :class="[
                                        'w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                        form.errors.customer_name ? 'border-red-500' : 'border-gray-300'
                                    ]"
                                    placeholder="Juan Dela Cruz"
                                />
                            </div>

                            <!-- City Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        City/Municipality *
                                    </label>
                                    <select 
                                        v-model="selectedCity"
                                        @change="onCityChange"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required
                                    >
                                        <option value="">Select City</option>
                                        <option v-for="(data, city) in cities" :key="city" :value="city">
                                            {{ city }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Barangay *
                                    </label>
                                    <select 
                                        v-if="availableBarangays.length > 0"
                                        v-model="selectedBarangay"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required
                                    >
                                        <option value="">Select Barangay</option>
                                        <option v-for="brgy in availableBarangays" :key="brgy" :value="brgy">
                                            {{ brgy }}
                                        </option>
                                        <option value="other">Other (type manually)</option>
                                    </select>
                                    <input
                                        v-else
                                        v-model="manualBarangay"
                                        type="text"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter barangay name"
                                    />
                                </div>
                            </div>

                            <!-- Manual Barangay Input (when "Other" is selected) -->
                            <div v-if="selectedBarangay === 'other' && availableBarangays.length > 0">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Barangay Name *
                                </label>
                                <input 
                                    v-model="manualBarangay"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Type your barangay name"
                                />
                            </div>

                            <!-- Street Address -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Complete Address *
                                    <span class="font-normal text-gray-500">(Block, Lot, Street, Subdivision)</span>
                                </label>
                                <input 
                                    v-model="streetAddress"
                                    type="text"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="e.g., Blk 5 Lot 10 Sampaguita St., Golden Meadows Subd."
                                />
                            </div>

                            <!-- Zip Code & Contact -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Zip Code *
                                    </label>
                                    <input 
                                        v-model="zipCode"
                                        type="text"
                                        readonly
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-600"
                                        placeholder="Auto-filled"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Contact Number *
                                        <span v-if="form.errors.contact_number" class="text-red-600 font-normal ml-2">{{ form.errors.contact_number }}</span>
                                    </label>
                                    <input 
                                        v-model="form.contact_number"
                                        type="tel"
                                        required
                                        :class="[
                                            'w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                                            form.errors.contact_number ? 'border-red-500' : 'border-gray-300'
                                        ]"
                                        placeholder="09XX XXX XXXX"
                                    />
                                </div>
                            </div>

                            <!-- Order Notes -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Order Notes (Optional)</label>
                                <textarea 
                                    v-model="form.notes"
                                    rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Special instructions for your order"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>
                        
                        <div class="space-y-3">
                            <div 
                                v-for="item in cartItems" 
                                :key="item.product.id"
                                class="flex justify-between items-center py-3 border-b last:border-0"
                            >
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ item.product.name }}</p>
                                    <p class="text-sm text-gray-600">{{ item.product.brand || 'Generic' }}</p>
                                    <span v-if="item.is_wholesale" class="inline-block mt-1 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                        Wholesale Price
                                    </span>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">{{ item.quantity }} × ₱{{ Number(item.unit_price).toLocaleString() }}</p>
                                    <p class="font-semibold text-gray-900">₱{{ Number(item.subtotal).toLocaleString() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ cartItems.length }} items)</span>
                                <span>₱{{ Number(subtotal).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Delivery Fee</span>
                                <span class="text-green-600 font-semibold">FREE</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-blue-600">₱{{ Number(subtotal).toLocaleString() }}</span>
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Payment on Delivery</p>
                                    <p>You can pay when you receive your order</p>
                                </div>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            :disabled="form.processing || !isFormValid"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 rounded-xl hover:shadow-xl transition font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                        >
                            <svg v-if="form.processing" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ form.processing ? 'Processing Order...' : 'Place Order' }}
                        </button>

                        <a 
                            href="/cart"
                            class="block w-full text-center text-blue-600 hover:text-blue-700 mt-4 font-medium"
                        >
                            ← Back to Cart
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    cartItems: Array,
    subtotal: Number,
    cities: Object,
    barangays: Object,
    savedAddresses: {
        type: Array,
        default: () => []
    },
});

// Address fields
const selectedCity = ref('');
const selectedBarangay = ref('');
const manualBarangay = ref('');
const streetAddress = ref('');
const zipCode = ref('');
const selectedSavedAddress = ref('');

// Auto-fill from saved address
watch(selectedSavedAddress, (newId) => {
    if (!newId) return;
    
    const address = props.savedAddresses.find(a => a.id === newId);
    if (address) {
        form.customer_name = address.recipient_name;
        form.contact_number = address.contact_number;
        streetAddress.value = address.address_line;
        
        // Handle location fields
        if (Object.keys(props.cities || {}).includes(address.city)) {
            selectedCity.value = address.city;
            
            // Wait for next tick/computation of availableBarangays
            setTimeout(() => {
                const barangays = props.barangays[address.city] || [];
                if (barangays.includes(address.barangay)) {
                    selectedBarangay.value = address.barangay;
                    manualBarangay.value = '';
                } else {
                    selectedBarangay.value = 'other';
                    manualBarangay.value = address.barangay;
                }
                zipCode.value = address.zip_code;
            }, 50);
        } else {
            // Fallback for custom cities if we support them later
            selectedCity.value = '';
        }
    }
});

// Form data
const form = useForm({
    customer_name: '',
    delivery_address: '',
    contact_number: '',
    notes: '',
});

// Get available barangays for selected city
const availableBarangays = computed(() => {
    if (!selectedCity.value || !props.barangays) return [];
    return props.barangays[selectedCity.value] || [];
});

// Show manual barangay input when "Other" is selected OR when no barangays available
const showManualBarangay = computed(() => {
    return selectedBarangay.value === 'other' || 
           (selectedCity.value && availableBarangays.value.length === 0);
});

// Auto-fill zip code when city changes
const onCityChange = () => {
    selectedBarangay.value = '';
    manualBarangay.value = '';
    if (selectedCity.value && props.cities[selectedCity.value]) {
        zipCode.value = props.cities[selectedCity.value].zip;
        // Auto-select "other" if no barangays available
        if (availableBarangays.value.length === 0) {
            selectedBarangay.value = 'other';
        }
    } else {
        zipCode.value = '';
    }
};

// Combine address fields into delivery_address
watch([selectedCity, selectedBarangay, manualBarangay, streetAddress, zipCode], () => {
    const parts = [];
    if (streetAddress.value) parts.push(streetAddress.value);
    
    // Use manual barangay if entered, otherwise use selected
    const barangayToUse = showManualBarangay.value && manualBarangay.value 
        ? manualBarangay.value 
        : (selectedBarangay.value !== 'other' ? selectedBarangay.value : '');
    
    if (barangayToUse) parts.push('Brgy. ' + barangayToUse);
    if (selectedCity.value) parts.push(selectedCity.value + ', Cavite');
    if (zipCode.value) parts.push(zipCode.value);
    
    form.delivery_address = parts.join(', ');
});

// Form validation - relaxed to handle manual input
const isFormValid = computed(() => {
    const hasName = form.customer_name.length >= 2;
    const hasCity = !!selectedCity.value;
    const hasBarangay = selectedBarangay.value && (
        selectedBarangay.value !== 'other' || manualBarangay.value.length >= 2
    );
    const hasStreetAddress = streetAddress.value.length >= 5;
    const hasContactNumber = form.contact_number.length >= 7;
    
    // Debug logging
    console.log('Form Validation State:', {
        hasName,
        hasCity,
        hasBarangay,
        hasStreetAddress,
        hasContactNumber,
        'customer_name': form.customer_name,
        'selectedCity': selectedCity.value,
        'selectedBarangay': selectedBarangay.value,
        'manualBarangay': manualBarangay.value,
        'streetAddress': streetAddress.value,
        'contact_number': form.contact_number,
        'isValid': hasName && hasCity && hasBarangay && hasStreetAddress && hasContactNumber
    });
    
    return hasName && hasCity && hasBarangay && hasStreetAddress && hasContactNumber;
});

const submitOrder = () => {
    console.log('submitOrder called!');
    console.log('Form data:', {
        customer_name: form.customer_name,
        delivery_address: form.delivery_address,
        contact_number: form.contact_number,
        notes: form.notes
    });
    console.log('isFormValid:', isFormValid.value);
    
    form.post('/orders', {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Order placed successfully!');
            // Redirected to confirmation page
        },
        onError: (errors) => {
            console.error('Order placement errors:', errors);
        }
    });
};
</script>
