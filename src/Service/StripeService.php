<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    private string $secretKey;

    public function __construct(string $stripeSecretKey)
    {
        $this->secretKey = $stripeSecretKey;
    }

    public function createCheckoutSession(float $total): Session
    {
        Stripe::setApiKey($this->secretKey);

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Commande Stubborn',
                    ],
                    'unit_amount' => (int) ($total * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/payment/success',
            'cancel_url' => 'http://127.0.0.1:8000/cart',
        ]);
    }
}