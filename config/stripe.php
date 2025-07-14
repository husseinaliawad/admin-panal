<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Stripe settings. You can get your keys from
    | https://dashboard.stripe.com/apikeys
    |
    */

    'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
    'secret_key' => env('STRIPE_SECRET'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    
    /*
    |--------------------------------------------------------------------------
    | Stripe Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for your Stripe payments
    |
    */
    'currency' => 'usd',
    
    /*
    |--------------------------------------------------------------------------
    | Stripe API Version
    |--------------------------------------------------------------------------
    |
    | The API version to use for Stripe requests
    |
    */
    'api_version' => '2023-10-16',
]; 