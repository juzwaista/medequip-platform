@extends('layouts.app')

@section('content')
    <div class="space-y-10">

        <!-- Promo Banner -->
        <div
            class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-2xl p-8 md:p-12 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-5xl font-bold mb-4">Summer Supply Sale</h1>
                <p class="text-blue-100 text-lg mb-6 max-w-lg">
                    Get up to 40% off on diagnostic equipment and bulk consumables. Verified hospital-grade supplies ready
                    for same-day shipping.
                </p>
                <button class="bg-white text-blue-700 px-6 py-3 rounded-full font-bold shadow hover:bg-gray-100 transition">
                    Shop Deals
                </button>
            </div>
            <!-- Decorative Circle -->
            <div class="absolute -right-10 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
        </div>

        <!-- Categories -->
        <div>
            <h2 class="text-xl font-bold mb-4">Browse by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                @php
                    $tags = ['Diagnostic', 'Surgical', 'PPE', 'Laboratory', 'Imaging', 'furniture'];
                @endphp
                @foreach($tags as $tag)
                    <div class="bg-white border rounded-xl p-4 text-center hover:shadow-md cursor-pointer transition">
                        <div
                            class="h-12 w-12 bg-blue-100 rounded-full mx-auto mb-2 flex items-center justify-center text-blue-600">
                            #
                        </div>
                        <span class="font-medium text-gray-700">{{ $tag }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Product Grid -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Recommended for You</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border rounded hover:bg-gray-50">Sort: Newest</button>
                    <button class="px-3 py-1 border rounded hover:bg-gray-50">Filter</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @for ($i = 1; $i <= 8; $i++)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100">
                        <!-- Image -->
                        <div class="h-48 bg-gray-200 relative">
                            <div
                                class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:text-red-500 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <span class="text-sm">Image Placeholder</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">
                                        {{ ['Surgical', 'Diagnostic', 'Lab'][rand(0, 2)] }}
                                    </p>
                                    <h3 class="font-bold text-gray-900 mt-1 lines-clamp-2">
                                        {{ ['Digital Stethoscope', 'Surgical Mask Box (50)', 'Portable Ultrasound', 'ECG Monitor', 'Sterile Gloves (100)'][$i % 5] }}
                                    </h3>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-2">Sold by: <span class="font-medium text-gray-700">Medical
                                    Supplies Co.</span></p>

                            <div class="flex justify-between items-end mt-4">
                                <span class="text-lg font-bold text-gray-900">${{ rand(50, 5000) }}.00</span>
                                <button
                                    class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm font-medium hover:bg-blue-700">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection