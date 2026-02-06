<template>
    <MainLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
                    <p class="text-gray-600 mt-2">Review your items before checkout</p>
                </div>
                
                <!-- Edit Mode Toggle -->
                <button 
                    v-if="cartItems.length > 0"
                    @click="editMode = !editMode"
                    :class="[
                        'px-4 py-2 rounded-lg font-medium transition flex items-center gap-2',
                        editMode 
                            ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
                            : 'bg-blue-100 text-blue-700 hover:bg-blue-200'
                    ]"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ editMode ? 'Done Editing' : 'Edit Cart' }}
                </button>
            </div>

            <div v-if="cartItems.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Select All -->
                    <div class="bg-white rounded-xl shadow-md p-4 flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                :checked="allSelected"
                                @change="toggleSelectAll"
                                class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                            />
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                Select All ({{ selectedCount }} of {{ cartItems.length }} selected)
                            </span>
                        </label>
                        
                        <button 
                            v-if="editMode && selectedCount > 0"
                            @click="removeSelected"
                            class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-1"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Remove Selected
                        </button>
                    </div>

                    <!-- Cart Item Cards -->
                    <div 
                        v-for="item in cartItems" 
                        :key="item.product.id"
                        :class="[
                            'bg-white rounded-xl shadow-md p-6 transition',
                            selectedItems[item.product.id] ? 'ring-2 ring-blue-500 hover:shadow-lg' : 'hover:shadow-lg',
                            editMode ? 'bg-gray-50' : ''
                        ]"
                    >
                        <div class="flex gap-4">
                            <!-- Checkbox -->
                            <div class="flex items-start pt-1">
                                <input 
                                    type="checkbox" 
                                    :checked="selectedItems[item.product.id]"
                                    @change="toggleItem(item.product.id)"
                                    class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                />
                            </div>

                            <!-- Product Image -->
                            <div class="w-24 h-24 flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <Link :href="`/products/${item.product.id}`" class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                            {{ item.product.name }}
                                        </Link>
                                        <p class="text-sm text-gray-600">{{ item.product.brand || 'Generic' }}</p>
                                        <p class="text-sm text-gray-500">
                                            by 
                                            <Link 
                                                v-if="item.product.distributor?.slug"
                                                :href="`/seller/${item.product.distributor.slug}`"
                                                class="text-blue-600 hover:underline"
                                            >
                                                {{ item.product.distributor?.company_name || 'Unknown Seller' }}
                                            </Link>
                                            <span v-else>{{ item.product.distributor?.company_name || 'Unknown Seller' }}</span>
                                        </p>
                                        
                                        <!-- Wholesale Badge -->
                                        <div v-if="item.is_wholesale" class="mt-2">
                                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-semibold">
                                                Wholesale Price Applied
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Remove Button (Edit Mode) -->
                                    <button 
                                        v-if="editMode"
                                        @click="removeItem(item.product.id)"
                                        class="text-red-500 hover:text-red-700 p-2 h-fit"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Quantity and Price -->
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-3">
                                        <label class="text-sm text-gray-600">Qty:</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button 
                                                @click="updateQuantity(item.product.id, item.quantity - 1)"
                                                :disabled="item.quantity <= 1"
                                                class="px-3 py-1 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                −
                                            </button>
                                            <input 
                                                type="number"
                                                :value="item.quantity"
                                                @change="updateQuantity(item.product.id, $event.target.value)"
                                                min="1"
                                                class="w-16 text-center border-x border-gray-300 py-1 focus:outline-none"
                                            />
                                            <button 
                                                @click="updateQuantity(item.product.id, item.quantity + 1)"
                                                class="px-3 py-1 hover:bg-gray-100"
                                            >
                                                +
                                            </button>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">₱{{ Number(item.unit_price).toLocaleString() }} each</p>
                                        <p class="text-xl font-bold text-blue-600">₱{{ Number(item.subtotal).toLocaleString() }}</p>
                                    </div>
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
                                <span>Selected Items</span>
                                <span>{{ selectedCount }} of {{ cartItems.length }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>₱{{ Number(selectedSubtotal).toLocaleString() }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="text-green-600 font-semibold">FREE</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-blue-600">₱{{ Number(selectedSubtotal).toLocaleString() }}</span>
                            </div>
                        </div>

                        <button 
                            v-if="$page.props.auth.user"
                            @click="proceedToCheckout"
                            :disabled="selectedCount === 0"
                            class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center px-6 py-3 rounded-xl hover:shadow-xl transition font-bold disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Checkout ({{ selectedCount }} items)
                        </button>
                        <button 
                            v-else
                            @click="redirectToLogin"
                            class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center px-6 py-3 rounded-xl hover:shadow-xl transition font-bold"
                        >
                            Login to Checkout
                        </button>

                        <Link 
                            href="/products"
                            class="block w-full text-center text-blue-600 hover:text-blue-700 mt-4 font-medium"
                        >
                            ← Continue Shopping
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty Cart -->
            <div v-else class="text-center py-16">
                <svg class="h-32 w-32 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Start adding products to see them here!</p>
                <Link 
                    href="/products"
                    class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl hover:shadow-xl transition font-bold"
                >
                    Browse Products
                </Link>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    cartItems: Array,
    subtotal: Number,
});

// Edit mode state
const editMode = ref(false);

// Selection state - initialize all items as selected
const selectedItems = ref({});

onMounted(() => {
    // Select all items by default
    props.cartItems.forEach(item => {
        selectedItems.value[item.product.id] = true;
    });
});

// Computed properties
const selectedCount = computed(() => {
    return Object.values(selectedItems.value).filter(v => v).length;
});

const allSelected = computed(() => {
    return props.cartItems.length > 0 && selectedCount.value === props.cartItems.length;
});

const selectedSubtotal = computed(() => {
    return props.cartItems
        .filter(item => selectedItems.value[item.product.id])
        .reduce((sum, item) => sum + Number(item.subtotal), 0);
});

// Actions
const toggleItem = (productId) => {
    selectedItems.value[productId] = !selectedItems.value[productId];
};

const toggleSelectAll = () => {
    const newValue = !allSelected.value;
    props.cartItems.forEach(item => {
        selectedItems.value[item.product.id] = newValue;
    });
};

const updateQuantity = (productId, quantity) => {
    if (quantity < 1) return;
    
    router.patch(`/cart/${productId}`, {
        quantity: parseInt(quantity)
    }, {
        preserveScroll: true,
    });
};

const removeItem = (productId) => {
    if (confirm('Remove this item from cart?')) {
        router.delete(`/cart/${productId}`, {
            preserveScroll: true,
        });
        delete selectedItems.value[productId];
    }
};

const removeSelected = () => {
    const selectedIds = Object.entries(selectedItems.value)
        .filter(([_, selected]) => selected)
        .map(([id, _]) => id);
    
    if (selectedIds.length === 0) return;
    
    if (confirm(`Remove ${selectedIds.length} selected items from cart?`)) {
        // Remove items one by one (could be optimized with batch endpoint)
        selectedIds.forEach(id => {
            router.delete(`/cart/${id}`, {
                preserveScroll: true,
            });
        });
    }
};

const proceedToCheckout = () => {
    // Store selected items in session before checkout
    const selectedProductIds = Object.entries(selectedItems.value)
        .filter(([_, selected]) => selected)
        .map(([id, _]) => parseInt(id));
    
    // For now, just go to checkout (backend will handle all cart items)
    // TODO: Implement selected-only checkout
    router.visit('/checkout');
};

const redirectToLogin = () => {
    alert('Please login to proceed with checkout');
    window.location.href = '/login';
};
</script>
