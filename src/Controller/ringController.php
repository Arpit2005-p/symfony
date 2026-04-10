<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ringController extends AbstractController
{
    #[Route('/ring', name: 'app_ring')]
    public function ringList(EntityManagerInterface $em): Response
    {
       $products = $em->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->innerJoin('p.category', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', 'ring')
            ->getQuery()
            ->getResult();
        
        return $this->render('/ring/index.html.twig', [
            'products' => $products,
            'type' => 'Ring'
        ]);
    }

    #[Route('/ring/{id}', name: 'app_ring_detail')]
    public function show(Product $product): Response
    {
      
        return $this->render('/ring/detail.html.twig', [
            'product' => $product
        ]);
    }

}