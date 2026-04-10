<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class braceleteController extends AbstractController
{
    #[Route('/bracelete', name: 'app_bracelete')]
    public function braceletList(EntityManagerInterface $em): Response
    {
       $products = $em->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->innerJoin('p.category', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', 'bracelete')
            ->getQuery()
            ->getResult();
         
        return $this->render('/bracelete/index.html.twig', [
            'products' => $products,
            'type' => 'Bracelete'
        ]);
    }

    #[Route('/bracelete/{id}', name: 'app_bracelete_detail')]
    public function show(Product $product): Response
    {
      
        return $this->render('/bracelete/detail.html.twig', [
            'product' => $product
        ]);
    }
}