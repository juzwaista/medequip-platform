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
                <a href="{{ route('register') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Get Started
                </a>
            @endauth
        </div>

    </div>
</nav>

<!-- HERO SECTION -->
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <div>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                A Trusted Marketplace for  
                <span class="text-blue-700">Medical Equipment & Supplies</span>
            </h1>

            <p class="text-lg text-gray-600 mb-8">
                MedEquip connects verified medical suppliers with hospitals,
                clinics, and individuals—ensuring safe, compliant, and
                transparent transactions.
            </p>

            <div class="flex space-x-4">
                <a href="{{ route('register') }}"
                   class="bg-blue-600 text-white px-6 py-3 rounded text-lg hover:bg-blue-700">
                    Join as Buyer
                </a>

                <a href="{{ route('register') }}"
                   class="border border-blue-600 text-blue-600 px-6 py-3 rounded text-lg hover:bg-blue-50">
                    Become a Supplier
                </a>
            </div>
        </div>

        <div class="hidden md:block">
            <div class="bg-blue-50 rounded-lg p-10 text-center">
                <p class="text-xl font-semibold text-blue-700 mb-2">
                    Compliance • Trust • Efficiency
                </p>
                <p class="text-gray-600">
                    Built specifically for the medical industry
                </p>
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
                    Sign up as a buyer or a distributor.
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
