<div>
    <div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Account</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your account settings and preferences</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Profile Information -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Profile Information</h2>
                    
                    @if (session('profile_success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('profile_success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="updateProfile">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                            <input type="text" id="name" wire:model="name" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" wire:model="email" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span wire:loading.remove wire:target="updateProfile">Update Profile</span>
                            <span wire:loading wire:target="updateProfile">Updating...</span>
                        </button>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Change Password</h2>
                    
                    @if (session('password_success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('password_success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="updatePassword">
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                            <input type="password" id="current_password" wire:model="current_password" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                            <input type="password" id="new_password" wire:model="new_password" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" wire:model="new_password_confirmation" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <button type="submit" 
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <span wire:loading.remove wire:target="updatePassword">Change Password</span>
                            <span wire:loading wire:target="updatePassword">Changing...</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Account Overview</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ auth()->user()->orders()->count() }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">Total Orders</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ auth()->user()->created_at->format('M Y') }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">Member Since</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                            {{ auth()->user()->email_verified_at ? 'Verified' : 'Pending' }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">Email Status</div>
                    </div>
                </div>

                <div class="mt-6 flex justify-center">
                    <a href="/my-orders" wire:navigate 
                        class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        View My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
