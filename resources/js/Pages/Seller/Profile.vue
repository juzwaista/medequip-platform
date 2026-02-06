<template>
    <MainLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- Cover Photo Hero -->
            <div class="relative h-64 bg-gradient-to-r from-blue-600 to-blue-800">
                <img 
                    v-if="distributor.cover_photo_path"
                    :src="`/storage/${distributor.cover_photo_path}`" 
                    alt="Cover Photo"
                    class="w-full h-full object-cover"
                />
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Profile Header -->
                <div class="relative -mt-20 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <!-- Logo -->
                            <div class="w-32 h-32 flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden border-4 border-white shadow-lg">
                                <img 
                                    v-if="distributor.logo_path"
                                    :src="`/storage/${distributor.logo_path}`" 
                                    :alt="distributor.company_name"
                                    class="w-full h-full object-cover"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center text-4xl font-bold text-gray-600">
                                    {{ distributor.company_name.charAt(0) }}
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-gray-900">{{ distributor.company_name }}</h1>
                                <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Verified Seller
                                    </span>
                                    <span>Member since {{ stats.active_since }}</span>
                                    <span>{{ stats.total_products }} Products</span>
                                </div>
                                <p v-if="distributor.description" class="mt-4 text-gray-700 leading-relaxed">
                                    {{ distributor.description }}
                                </p>
                            </div>

                            <!-- Contact Button -->
                            <div class="flex flex-col gap-2">
                                <a 
                                    v-if="distributor.phone"
                                    :href="`tel:${distributor.phone}`"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center font-medium"
                                >
                                    Contact Seller
                                </a>
                                <a 
                                    v-if="distributor.website"
                                    :href="distributor.website"
                                    target="_blank"
                                    class="px-6 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition text-center font-medium"
                                >
                                    Visit Website
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Products from this Seller</h2>
                    
                    <!-- Products Grid -->
                    <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <Link 
                            v-for="product in products.data" 
                            :key="product.id"
                            :href="`/products/${product.id}`"
                            class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden group"
                        >
                            <!-- Product Image -->
                            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                                <img 
                                    v-if="product.image_path"
                                    :src="`/storage/${product.image_path}`" 
                                    :alt="product.name"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center">
                                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 line-clamp-2 mb-2">{{ product.name }}</h3>
                                <p v-if="product.category" class="text-sm text-gray-600 mb-2">{{ product.category.name }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-blue-600">₱{{ Number(product.base_price).toLocaleString() }}</span>
                                    <span v-if="product.inventory && product.inventory.length > 0" class="text-xs text-green-600 font-semibold">
                                        In Stock
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-12 bg-white rounded-xl">
                        <svg class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">No Products Available</h3>
                        <p class="text-gray-600 mt-2">This seller hasn't listed any products yet.</p>
                    </div>

                    <!-- Pagination -->
                    <div v-if="products.data.length > 0 && products.last_page > 1" class="mt-6 flex justify-center gap-2">
                        <template v-for="link in products.links" :key="link.label">
                            <Link 
                                v-if="link.url"
                                :href="link.url"
                                :class="[
                                    'px-4 py-2 rounded-lg',
                                    link.active ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 shadow-sm'
                                ]"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    distributor: Object,
    products: Object,
    stats: Object,
});
</script>
