@extends('layouts.auth')

@section('content')
    <div class="max-w-lg w-full space-y-8">
        <div>
            <h2 class="text-2xl font-bold text-center">Create an Account</h2>
        </div>

        <!-- Form Register -->
        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6" novalidate>
            @csrf
            <div class="rounded-md shadow-sm">
                <!-- Name -->
                <div>
                    <label for="name" class="sr-only">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        autocomplete="name" autofocus
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        @error('name') border-red-500 @enderror"
                        placeholder="Full Name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <label for="email" class="sr-only">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        autocomplete="email"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        @error('email') border-red-500 @enderror"
                        placeholder="Email Address">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        @error('password') border-red-500 @enderror"
                        placeholder="Password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mt-4">
                    <label for="phone" class="sr-only">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="phone"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        @error('phone') border-red-500 @enderror"
                        placeholder="Phone Number (Optional)">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <label for="address" class="sr-only">Address</label>
                    <textarea id="address" name="address" rows="3" autocomplete="address"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        @error('address') border-red-500 @enderror"
                        placeholder="Address (Optional)">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mt-4">
                    <label for="role" class="sr-only">Role</label>
                    <select id="role" name="role"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                        @error('role') border-red-500 @enderror">
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="cs" {{ old('role') == 'cs' ? 'selected' : '' }}>Customer Service</option>
                        <option value="technician" {{ old('role') == 'technician' ? 'selected' : '' }}>Technician</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Account
                </button>
            </div>
        </form>

        <!-- Link to Login -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Login here
                </a>
            </p>
        </div>

    </div>
@endsection
