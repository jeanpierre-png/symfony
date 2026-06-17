<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/products')]
final class AdminProductController extends AbstractController
{
    #[Route('', name: 'app_admin_products')]
    public function index(Request $request, ProductRepository $productRepository, EntityManagerInterface $entityManager ): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        $imageFile = $form->get('image')->getData();

        if ($imageFile) {

            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            $imageFile->move(
                $this->getParameter('kernel.project_dir').'/public/images/products',
                $newFilename
            );

            $product->setImage('images/products/' .$newFilename);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_products');
        }

        return $this->render('admin_product/index.html.twig', [ 
            'products' => $productRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_admin_product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createform(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_products');
        }

        return $this->render('admin_product/edit.html.twig', [ 'form' => $form, 'product' => $product ]);

        {
            return $this->render('admin_product/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'app_admin_product_delete')]
    public function delete(Product $product, EntityManagerInterface $entityManager): Response
    {
        $imagePath = $this->getParameter('kernel.project_dir').'/public/'.$product->getImage();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_products');
    }
    
} 