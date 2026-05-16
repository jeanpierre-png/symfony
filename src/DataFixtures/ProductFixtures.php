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