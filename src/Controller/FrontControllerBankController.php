<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\RegistrationFormType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
    * Require ROLE_ADMIN for *every* controller method in this class.
    *
    * @IsGranted("IS_AUTHENTICATED_FULLY")
    */

class FrontControllerBankController extends AbstractController
{
    #[Route('/bank', name: 'bank')]
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('bank/index.html.twig', [
            'controller_name' => 'FrontControllerBankController',
        ]);
    }

    public function newAccount(Request $request): Response 
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
    }
    
}
