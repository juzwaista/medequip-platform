<template>
    <MainLayout>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Edit Inventory Batch</h1>
                <p class="text-gray-600 mt-2">Update stock levels and expiry information for {{ inventory.product.name }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <!-- Product (Read-only) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Product</label>
                            <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-700">
                                {{ inventory.product.name }}
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity *</label>
                            <input 
                                v-model="form.quantity"
                                type="number"
                                min="0"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            <p class="text-xs text-gray-500 mt-1">
                                Reserved: {{ inventory.reserved_quantity }} | Available: {{ inventory.quantity - inventory.reserved_quantity }}
                            </p>
                            <p v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">{{ form.errors.quantity }}</p>
                        </div>

                        <!-- Reorder Level -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Reorder Level *</label>
                            <input 
                                v-model="form.reorder_level"
                                type="number"
                                min="0"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            <p v-if="form.errors.reorder_level" class="text-red-500 text-sm mt-1">{{ form.errors.reorder_level }}</p>
                        </div>

                        <!-- Batch Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Batch Number</label>
                            <input 
                                v-model="form.batch_number"
                                type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            <p v-if="form.errors.batch_number" class="text-red-500 text-sm mt-1">{{ form.errors.batch_number }}</p>
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                            <input 
                                v-model="form.expiry_date"
                                type="date"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            <p v-if="form.errors.expiry_date" class="text-red-500 text-sm mt-1">{{ form.errors.expiry_date }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button 
                            type="submit"
                            :disabled="form.processing"
                            class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg disabled:opacity-50"
                        >
                            {{ form.processing ? 'Updating...' : 'Update Inventory' }}
                        </button>
                        <Link 
                            href="/owner/inventory"
                            class="px-6 py-3 border-2 border-gray-300 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition"
                        >
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    inventory: Object,
});

const form = useForm({
    quantity: props.inventory.quantity,
    reorder_level: props.inventory.reorder_level,
    batch_number: props.inventory.batch_number || '',
    expiry_date: props.inventory.expiry_date || '',
});

const submit = () => {
    form.put(`/owner/inventory/${props.inventory.id}`);
};
</script>
