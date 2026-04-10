<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class cartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function cart(): Response
    {    
        return $this->render('Frontend/cart/cart.html.twig');
    }
}