<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\RegistrationFormType;


class FrontControllerBankController extends AbstractController
{
    #[Route('/bank', name: 'bank')]
    #[Route('/', name: 'bank')]
    public function index(): Response
    {
        return $this->render('bank/index.html.twig', [
            'controller_name' => 'FrontControllerBankController',
        ]);
    }

    
}
