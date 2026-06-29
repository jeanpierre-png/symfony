<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckoutControllerTest extends WebTestCase
{
    public function testPaymentSuccessPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/payment/success');

        $this->assertResponseIsSuccessful();
    }
}