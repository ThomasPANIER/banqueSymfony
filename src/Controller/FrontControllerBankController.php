<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use App\Entity\User;
use App\Entity\Operation;
use App\Form\AccountType;
use App\Form\CreditType;
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

        // $account = new Account();
        // $id = $account->setUser($this->getUser());
        $accountRepository = $this->getDoctrine()->getRepository(Account::class);
        $accounts = $accountRepository->findby(
            ['user' => $this->getUser()],
        );

        
        return $this->render('bank/index.html.twig', [
            'accounts' => $accounts,
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

    #[Route('/index/account/{id}', name: 'singleAccount', requirements: ['id' => '\d+'])]
    public function singleAccount(int $id, OperationRepository $operationRepository, $operation = null): Response
    {

        $operationRepository = $this->getDoctrine()->getRepository(Operation::class);
        $operation = $operationRepository->find($id);
        $accountRepository = $this->getDoctrine()->getRepository(Account::class);
        $account = $accountRepository->find($id);

        
        return $this->render('bank/singleAccount.html.twig', [
            'account' => $account,
            'operation' => $operation,
        ]);
    }

    #[Route('/index/account/{accountId}/credit', name: 'creditOperation', requirements: ['accountId' => '\d+'])]
    public function creditOperation(Request $request, AccountRepository $accountRepository, int $accountId): Response 
    {
        $credit = new Operation();
        $form = $this->createForm(CreditType::class, $credit);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $credit->setOperationType("Crédit");
            $credit->setOperationDate(new \DateTime());
            $account = $accountRepository->find($accountId);
            $credit->setAccount($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($credit);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('bank/creditOperation.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}

