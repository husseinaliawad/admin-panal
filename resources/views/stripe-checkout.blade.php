<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout Demo - CICS</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }
        .StripeElement--invalid {
            border-color: #ef4444;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefefe !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Stripe Checkout Demo</h1>
                <p class="text-gray-600 mt-2">Test your Stripe integration</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <form id="payment-form">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Test Product</h2>
                        <div class="flex justify-between items-center p-4 border rounded-lg">
                            <div>
                                <h3 class="font-medium">Sample Product</h3>
                                <p class="text-sm text-gray-600">Test payment integration</p>
                            </div>
                            <div class="text-lg font-semibold">$29.99</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="card-element" class="block text-sm font-medium text-gray-700 mb-2">
                            Credit or Debit Card
                        </label>
                        <div id="card-element" class="StripeElement">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        <div id="card-errors" role="alert" class="text-red-600 text-sm mt-2"></div>
                    </div>

                    <button 
                        type="submit" 
                        id="submit-button"
                        class="w-full gradient-primary text-white py-3 px-4 rounded-lg font-medium hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="button-text">Pay $29.99</span>
                        <span id="spinner" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Test card: 4242 4242 4242 4242<br>
                        Use any future date and CVC
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="/cart" class="text-orange-600 hover:text-orange-800 font-medium">
                    ← Back to Cart
                </a>
            </div>
        </div>
    </div>

    <script>
        // Initialize Stripe
        const stripe = Stripe('{{ config("stripe.publishable_key") }}');
        const elements = stripe.elements();

        // Create card element
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#424770',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#9e2146',
                },
            },
        });

        cardElement.mount('#card-element');

        // Handle real-time validation errors from the card Element
        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('spinner');

            // Disable button and show spinner
            submitButton.disabled = true;
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');

            try {
                // Create checkout session
                const response = await fetch('/create-checkout-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        items: [
                            {
                                product_id: 1,
                                quantity: 1,
                            }
                        ]
                    }),
                });

                const session = await response.json();

                if (session.success) {
                    // Redirect to Stripe Checkout
                    window.location.href = session.checkout_url;
                } else {
                    throw new Error(session.error || 'Payment failed');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('card-errors').textContent = error.message;
                
                // Re-enable button
                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
            }
        });
    </script>
</body>
</html> 