<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class productController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(): Response
    {    
        return $this->render('Frontend/products/index.html.twig');
    }

     #[Route('/products/{id}', name: 'app_product')]
    public function details(int $id): Response
    {  
        return $this->render('Frontend/product/index.html.twig',[
            'id'=> $id
        ]);
    }


}   