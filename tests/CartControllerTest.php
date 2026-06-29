<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testCartPageIsAccessible(): void
    {
        $client = static::createClient();

        $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
    }

    public function testAddProductToCart(): void 
    {
        $client = static::createClient();

        $client->request('POST', '/cart/add/1', [ 'size' => 'L', ]);

        $this->assertResponseRedirects('/cart');
    }
}