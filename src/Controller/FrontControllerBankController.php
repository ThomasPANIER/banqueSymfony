<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontControllerBankController extends AbstractController
{
    #[Route('/bank', name: 'bank')]
    public function index(): Response
    {
        return $this->render('front_controller_bank/index.html.twig', [
            'controller_name' => 'FrontControllerBankController',
        ]);
    }
}
