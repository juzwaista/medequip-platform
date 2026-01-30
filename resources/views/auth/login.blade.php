<x-guest-layout>

    <h2 class="text-2xl font-bold text-center mb-2">
        Login to MedEquip
    </h2>

    <p class="text-sm text-gray-500 text-center mb-6">
        Access the medical equipment marketplace
    </p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" required autofocus
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                Remember me
            </label>

            <a href="{{ route('password.request') }}"
               class="text-blue-600 hover:underline">
                Forgot password?
            </a>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>

    <p class="text-sm text-center mt-6">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
            Register
        </a>
    </p>

</x-guest-layout>
