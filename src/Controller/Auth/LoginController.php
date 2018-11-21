<?php

namespace App\Controller\Auth;

use App\Form\Auth\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/auth/login", name="auth_login")
     * @param AuthenticationUtils $helper
     * @return Response
     */
    public function index(AuthenticationUtils $helper): Response
    {
        $form = $this->createForm(LoginType::class);

        return $this->render('auth/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }
}
