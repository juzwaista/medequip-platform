<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedEquip | Medical Equipment & Supply Marketplace</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">



    <!-- NAVBAR -->
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center space-x-2">
                <span class="text-xl font-bold text-blue-700">MedEquip</span>
                <span class="text-sm text-gray-500 hidden md:block">
                    Medical Equipment Marketplace
                </span>
            </div>

            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="#features" class="hover:text-blue-700">Features</a>
                <a href="#how-it-works" class="hover:text-blue-700">How It Works</a>
                <a href="#roles" class="hover:text-blue-700">Who It’s For</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-blue-700">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-700">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Get Started
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                The Trusted Marketplace for Medical Equipment
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-10 max-w-3xl mx-auto">
                Connect directly with verified medical suppliers. Source hospital-grade equipment, supplies, and
                instruments
                with confidence.
            </p>

            <div class="flex justify-center space-x-4">
                <a href="#products"
                    class="bg-white text-blue-700 px-8 py-3 rounded-full font-bold shadow hover:bg-gray-100 transition">
                    Browse Products
                </a>
                <a href="{{ route('register') }}"
                    class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-bold hover:bg-white hover:text-blue-700 transition">
                    Join as Supplier
                </a>
            </div>
        </div>
    </section>

    <!-- PRODUCT PROTOTYPE SECTION -->
    <section id="products" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Featured Equipment</h2>
                    <p class="text-gray-600 mt-2">Latest verified listings from top suppliers</p>
                </div>
                <a href="#" class="text-blue-600 font-medium hover:underline">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Dummy Product 1 -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        <!-- Placeholder Image -->
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wide">Diagnostic</span>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">Digital Ultrasound System</h3>
                        <p class="text-gray-500 text-sm mt-1">MedTech Solutions Inc.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">$12,499</span>
                            <button
                                class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">Details</button>
                        </div>
                    </div>
                </div>

                <!-- Dummy Product 2 -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Lab</span>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">Hematology Analyzer</h3>
                        <p class="text-gray-500 text-sm mt-1">LabCorp Supply</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">$8,250</span>
                            <button
                                class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">Details</button>
                        </div>
                    </div>
                </div>

                <!-- Dummy Product 3 -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-purple-600 uppercase tracking-wide">Surgical</span>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">Anesthesia Machine</h3>
                        <p class="text-gray-500 text-sm mt-1">Global Medical</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">$24,000</span>
                            <button
                                class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">Details</button>
                        </div>
                    </div>
                </div>

                <!-- Dummy Product 4 -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-orange-600 uppercase tracking-wide">Consumables</span>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">Surgical Mask Box (50)</h3>
                        <p class="text-gray-500 text-sm mt-1">SafeGuard Supplies</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">$12.50</span>
                            <button
                                class="text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200">Details</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-12">
                Why MedEquip Exists
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Verified Suppliers</h3>
                    <p class="text-gray-600">
                        All distributors submit licenses and accreditations
                        before being approved by administrators.
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Centralized Marketplace</h3>
                    <p class="text-gray-600">
                        Compare products, suppliers, and availability
                        across multiple verified distributors.
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Decision Support</h3>
                    <p class="text-gray-600">
                        Built-in analytics help buyers choose suppliers
                        and help owners manage inventory and demand.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how-it-works" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-12">
                How It Works
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-4">1</div>
                    <h3 class="font-semibold mb-2">Register</h3>
                    <p class="text-gray-600">
                        Sign up as a buyer or a medical supplier.
                    </p>
                </div>

                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-4">2</div>
                    <h3 class="font-semibold mb-2">Verify</h3>
                    <p class="text-gray-600">
                        Suppliers submit licenses for admin verification.
                    </p>
                </div>

                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-4">3</div>
                    <h3 class="font-semibold mb-2">Transact</h3>
                    <p class="text-gray-600">
                        Buyers purchase from trusted, verified suppliers.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- WHO IT'S FOR -->
    <section id="roles" class="py-20">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-12">
                Built for Every Stakeholder
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Hospitals & Clinics</h3>
                    <p class="text-gray-600">
                        Source medical equipment from verified suppliers
                        with confidence.
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Medical Suppliers</h3>
                    <p class="text-gray-600">
                        Manage distributors, upload licenses, and
                        reach institutional buyers.
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-xl font-semibold mb-2">Administrators</h3>
                    <p class="text-gray-600">
                        Enforce compliance, verify suppliers,
                        and maintain marketplace integrity.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 py-10">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm">
            © {{ date('Y') }} MedEquip. All rights reserved.
        </div>
    </footer>

</body>

</html>