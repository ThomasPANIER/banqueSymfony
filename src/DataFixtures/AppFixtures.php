<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Account;
use App\Entity\Operation;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Boucle qui crée mes utilisateurs
        for ($i = 1; $i < 8; $i++) {
            $user = new User();
            $user->setEmail("useremail" . $i . "@exemple.com");
            $password = $this->encoder->encodePassword($user, "password" . $i);
            $user->setPassword($password);
            $user->setFirstname("Firstname" . $i);
            $user->setLastname("Lastname" . $i);
            $user->setAddress("18 rue de la frite" . $i);
            $user->setCity("Ville n°" . $i);
            $user->setPostal("BP n°0000" . $i);
            $user->setTel("n°" . $i);
            for ($j = 1; $j < mt_rand(1, 8); $j++) {
                $account = new Account();
                $account->setAccountName("Name :" . $j);
                $account->setAccountNumber("Number" . $j);
                $account->setOpenDate(new \DateTime());
                $account->setAccountAmount($j);
                $account->setUser($user);
                $manager->persist($account);
                for ($k = 1; $k < mt_rand(1, 5); $k++) {
                    $operation = new Operation();
                    $operation->setOperationType("Crédit ou Débit" . $k);
                    $operation->setOperationName("Nom de l'Opération :" . $k);
                    $operation->setOperationAmount($k);
                    $operation->setOperationDate(new \DateTime());
                    $operation->setAccount($account);
                    $manager->persist($operation);
                }
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}
