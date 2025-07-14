<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret_key'));
    }

    /**
     * Create a Stripe checkout session
     */
    public function createCheckoutSession(Request $request)
    {
        try {
            $cartItems = $request->input('items', []);
            $lineItems = [];
            
            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    continue;
                }
                
                $lineItems[] = [
                    'price_data' => [
                        'currency' => config('stripe.currency', 'usd'),
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->description,
                            'images' => $product->image ? [asset('storage/' . $product->image)] : [],
                        ],
                        'unit_amount' => $product->price * 100, // Convert to cents
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
                'metadata' => [
                    'user_id' => auth()->id() ?? 'guest',
                    'order_data' => json_encode($cartItems),
                ],
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $session->id,
                'checkout_url' => $session->url,
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout Session Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to create checkout session. Please try again.',
            ], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        
        if (!$sessionId) {
            return redirect()->route('cart')->with('error', 'Invalid payment session.');
        }

        try {
            $session = Session::retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                // Create order record
                $orderData = json_decode($session->metadata->order_data, true);
                $this->createOrder($session, $orderData);
                
                // Clear cart (if using session-based cart)
                session()->forget('cart');
                
                return view('payment.success', compact('session'));
            }
            
            return redirect()->route('cart')->with('error', 'Payment was not completed.');
            
        } catch (\Exception $e) {
            Log::error('Payment Success Error: ' . $e->getMessage());
            return redirect()->route('cart')->with('error', 'Unable to verify payment. Please contact support.');
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel()
    {
        return view('payment.cancel');
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload in webhook: ' . $e->getMessage());
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature in webhook: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            default:
                Log::info('Unhandled webhook event type: ' . $event->type);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Create order from successful payment
     */
    private function createOrder($session, $orderData)
    {
        try {
            $order = Order::create([
                'user_id' => $session->metadata->user_id !== 'guest' ? $session->metadata->user_id : null,
                'stripe_session_id' => $session->id,
                'payment_intent_id' => $session->payment_intent,
                'amount' => $session->amount_total / 100, // Convert from cents
                'currency' => $session->currency,
                'status' => 'paid',
                'customer_email' => $session->customer_details->email ?? null,
                'customer_name' => $session->customer_details->name ?? null,
                'order_data' => json_encode($orderData),
            ]);

            Log::info('Order created successfully: ' . $order->id);
            return $order;
            
        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle checkout session completed webhook
     */
    private function handleCheckoutSessionCompleted($session)
    {
        Log::info('Checkout session completed: ' . $session->id);
        
        // Update order status if needed
        $order = Order::where('stripe_session_id', $session->id)->first();
        if ($order && $order->status !== 'paid') {
            $order->update(['status' => 'paid']);
        }
    }

    /**
     * Handle payment intent succeeded webhook
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        Log::info('Payment intent succeeded: ' . $paymentIntent->id);
        
        // Additional processing if needed
    }

    /**
     * Get Stripe publishable key for frontend
     */
    public function getPublishableKey()
    {
        return response()->json([
            'publishable_key' => config('stripe.publishable_key'),
        ]);
    }
}
