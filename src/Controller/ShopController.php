<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $min = $request->query->get('min');
        $max = $request->query->get('max');

        if ($min !== null && $max !== null) {
            $products = $productRepository->createQueryBuilder('p')
            ->where('p.price >= :min')
            ->andWhere('p.price <= :max')
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->getQuery()
            ->getResult();

        } else {
            $products = $productRepository->findAll();
        }
        
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'min' => $min,
            'max' => $max,
        ]);

    }
}
