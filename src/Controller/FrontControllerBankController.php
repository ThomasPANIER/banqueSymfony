<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationFormType;
use App\Repository\AccountRepository;
use App\Repository\UserRepository;
use App\Repository\OperationRepository;

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

    #[Route('/index/account/new', name: 'newAccount')]
    public function newAccount(Request $request): Response 
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $account->setAccountNumber(mt_rand(100000, 200000));
            $account->setOpenDate(new \DateTime());
            $account->setUser($this->getUser());
            //dump($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('bank/newAccount.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
