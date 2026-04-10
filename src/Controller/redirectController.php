<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class redirectController extends AbstractController
{
    #[Route('/redirect', name: 'app_redirect')]
    public function index(): Response
    {
        
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirect('/admin');
        }

        if ($this->isGranted('ROLE_EMPLOYEE_ADMIN')) {
            return $this->redirect('/admin/app/employee/list');
        }


        return $this->redirect('/home');
    }
}