@section('title', 'Login')

<x-guest-layout>
    @if ($errors->any())
        <x-alert.error :errors="$errors->all()" />
    @endif

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="lg:h-screen flex items-center w-full justify-center bg-gradient-to-r from-#FBF6E9 to-#E0D7BD">
            <!-- Container for all screen sizes -->
            <div
                class="w-full md:w-[100%] lg:w-[95%] xl:w-[85%]  lg:mx-auto lg:h-[70%] lg:my-auto rounded-lg lg:shadow-2xl overflow-hidden flex flex-col lg:flex-row">
                <!-- Left Section (Logo and Title) -->
                <div class="lg:w-1/2 bg-[#FBF6E9] flex items-center justify-center p-8">
                    <div class="text-center text-gray-800">
                        <img src="{{ asset('assets/home/logo.png') }}" class="w-64 object-contain h-32 mx-auto mb-6"
                            alt="Logo" style="filter:drop-shadow(1px 1px 1px #000)">
                        <h1 class="text-4xl font-bold mb-2">Welcome Back!</h1>
                        <p class="text-lg">Please login to your account</p>
                        <div class="mt-6">
                            <p class="text-sm">Don't have an account yet?a</p>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">
                                    {{ __('Create an account') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Section (Form) -->
                <div class="lg:w-1/2 p-8 bg-white flex flex-col justify-center">
                    <!-- Form Title -->
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Login</h2>

                    <div>
                        <!-- Username Field -->
                        <div class="mb-6">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required
                                autofocus
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-primary    focus:border-redring-red-primary   transition duration-300">
                        </div>

                        <!-- Password Field -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-primary    focus:border-redring-red-primary   transition duration-300">
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-6 flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="h-4 w-4 text-red-primary focus:ring-red-primary  border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="px-4 py-2 bg-red-primary text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-red-primary  focus:ring-offset-2 transition duration-300">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </x-form>
</x-guest-layout>
