<?php

namespace App\Controller;

use App\Entity\Balance;
use App\Entity\User;
use App\Repository\BalanceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/user/profiler', name: 'profiler')]
    public function profiler(): Response
    {
        $user = $this->getUser();
        if ($user->getRoleAbility() == 'user')
            return $this->render('security/profiler.html.twig',
                ['user' => $user]);
        else{
            return $this->redirectToRoute('profiler_admin');
        }

    }

    #[Route(path: '/user/admin', name: 'profiler_admin')]
    public function profiler_admin(BalanceRepository $balanceRepository): Response
    {
        $admin = $this->getUser();
        if ($admin->getRoleAbility() == 'admin'){
            $balances = $balanceRepository->findAll();
            return $this->render('security/admin.html.twig',
                ['admin' => $admin, 'balances' => $balances]);
        }
        else
            return $this->redirectToRoute('app_main');
    }



    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
