<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled - CICS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 animate-fade-in">
            <div class="text-center">
                <!-- Cancel Icon -->
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100">
                    <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Payment Cancelled
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Your payment was cancelled. No charges were made to your account.
                </p>
            </div>

            <!-- Information Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What happened?</h3>
                
                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-900 font-medium">Payment was cancelled</p>
                            <p class="text-sm text-gray-600">You chose to cancel the payment process</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-900 font-medium">No charges made</p>
                            <p class="text-sm text-gray-600">Your payment method was not charged</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-900 font-medium">Cart preserved</p>
                            <p class="text-sm text-gray-600">Your items are still in your cart</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="/cart" 
                   class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white gradient-primary hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5"></path>
                    </svg>
                    Return to Cart
                </a>
                
                <a href="/products" 
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Continue Shopping
                </a>
                
                <a href="/" 
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Go to Home
                </a>
            </div>

            <!-- Help Section -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    Need help? Contact our support team for assistance with your order.
                </p>
            </div>
        </div>
    </div>
</body>
</html> 