<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Blackbelt**',
                'price' => 29.90,
                'image' => 'images/products/1.jpeg'
            ],
            [
                'name' => 'BlueBelt',
                'price' => 29.90,
                'image' => 'images/products/2.jpeg'
            ],
            [
                'name' => 'Street',
                'price' => 34,50,
                'image' => 'images/products/3.jpeg'
            ],
            [
                'name' => 'Pokeball**',
                'price' => 45,
                'image' => 'images/products/4.jpeg'
            ],
            [
                'name' => 'PinkLady',
                'price' => 29.90,
                'image' => 'images/products/5.jpeg'
            ],
            [
                'name' => 'Snow',
                'price' => 32,
                'image' => 'images/products/6.jpeg'
            ],
            [
                'name' => 'Greyback',
                'price' => 28.50,
                'image' => 'images/products/7.jpeg'
            ],
            [
                'name' => 'BlueCloud',
                'price' => 45,
                'image' => 'images/products/8.jpeg'
            ],
            [
                'name' => 'BornInUsa ** ',
                'price' => 59.90,
                'image' => 'images/products/9.jpeg'
            ],
            [
                'name' =>'GreenSchool',
                'price' => 42.20,
                'image' => 'images/products/10.jpeg'
            ]
        ];

        foreach ($products as $data) {

            $product = new Product();

            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setImage($data['image']);

            $product->setFeatured(true);

            $product->setStockXS(10);
            $product->setStockS(10);
            $product->setStockM(10);
            $product->setStockL(10);
            $product->setStockXL(10);

            $manager->persist($product);
        }

        $manager->flush();
    }
}