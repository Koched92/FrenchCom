<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'username_label' => 'Your Email',
            'password_label' => 'Your password',
            'target_path' => $this->generateUrl('home'),
            'sign_in_label' => 'Log in',
            'forgot_password_enabled' => true,
            'forgot_password_label' => 'Forgot your password?',
            'remember_me_enabled' => true,
            'remember_me_parameter' => 'custom_remember_me_param',
            'remember_me_label' => 'Remember me',
            'csrf_token_intention' => 'authenticate',
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     *
     * @SuppressWarnings(MissingImport)
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
