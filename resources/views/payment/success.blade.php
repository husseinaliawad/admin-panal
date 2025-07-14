<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - CICS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        .animate-checkmark {
            animation: checkmark 0.6s ease-in-out;
        }
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 animate-checkmark">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Payment Successful!
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Thank you for your order. Your payment has been processed successfully.
                </p>
            </div>

            <!-- Order Details -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Details</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Order ID:</span>
                        <span class="text-sm text-gray-900">{{ $session->id }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Amount Paid:</span>
                        <span class="text-sm text-gray-900 font-semibold">
                            ${{ number_format($session->amount_total / 100, 2) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Payment Method:</span>
                        <span class="text-sm text-gray-900">Card</span>
                    </div>
                    
                    @if($session->customer_details->email)
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Email:</span>
                        <span class="text-sm text-gray-900">{{ $session->customer_details->email }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-600">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Paid
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="/my-orders" 
                   class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white gradient-primary hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    View My Orders
                </a>
                
                <a href="/" 
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    Continue Shopping
                </a>
            </div>

            <!-- Additional Info -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    You will receive an email confirmation shortly. 
                    If you have any questions, please contact our support team.
                </p>
            </div>
        </div>
    </div>
</body>
</html> 