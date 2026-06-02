<?php

namespace App\Controller;

use App\Service\StripeService;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $session = $requestStack->getSession();
        $cart = $session->get('cart', []);

        $products = [];
        $total =0;

        foreach ($cart as $key => $item) {
            $product = $productRepository->find($item['id']);

            if($product) {

                $products[] = [
                    'key' => $key,
                    'product' => $product,
                    'size' => $item['size']
                ];

                $total += $product->getPrice();
            }
        }

        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add($id, RequestStack $requestStack, Request $request)
    {
        $session = $requestStack->getSession();
        $cart = $session->get('cart', []);

        $cart[] =['id' => $id, 'size' => $request->request->get('size') ];

       $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{key}', name: 'app_cart_remove')]
    public function remove(int $key, RequestStack $requestStack)
    {
        $session = $requestStack->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(RequestStack $requestStack, ProductRepository $productRepository, StripeService $stripeService)
    {
        $cart = $requestStack->getSession()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $product = $productRepository->find($item['id']);

            if ($product) {
                $total += $product->getPrice();
            }
        }

        $session = $stripeService->createCheckoutSession($total);

        return $this->redirect($session->url);
    }

    #[Route('/payment/success', name: 'app_payment_success')]
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }

}
