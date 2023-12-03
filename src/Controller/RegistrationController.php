<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * @SuppressWarnings(CouplingBetweenObjects)
 */
class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private MailerInterface $mailer;

    public function __construct(EmailVerifier $emailVerifier, MailerInterface $mailer)
    {
        $this->emailVerifier = $emailVerifier;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, VerifyEmailHelperInterface $verifyEmailHelper): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $plainPassword = $form->get('plainPassword')->getData();
            $rolesArr = ['ROLE_USER'];
            $user->setRoles($rolesArr);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    /* @phpstan-ignore-next-line */
                    $plainPassword
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                /* @phpstan-ignore-next-line */
                $user->getId(),
                /* @phpstan-ignore-next-line */
                $user->getEmail(),
                ['id' => $user->getId()]
            );

            $email = (new TemplatedEmail())
            ->from(new Address('noreply@frenchCom.com', 'FrenchCom Bot'))
            /* @phpstan-ignore-next-line */
            ->to($user->getEmail())
            ->subject('Please Confirm your Email')

            ->htmlTemplate('registration/confirmation_email.html.twig')

            ->context([
                'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
                'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
                'signedUrl' => $signatureComponents->getSignedUrl(),
            ]);

            $this->mailer->send($email);

            $this->addFlash('warning', 'verification email sent');

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register2.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     *
     *  @SuppressWarnings(MissingImport)
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        // validate email confirmation link, sets User::isVerified=true and persists
        $user = $userRepository->find($request->query->get('id'));

        try {
            if (!$user instanceof UserInterface) {
                throw new \LogicException('The user is not an instance of UserInterface.');
            }

            $this->emailVerifier->handleEmailConfirmation($request, $user);
            $this->addFlash('success', 'Account Verified! You can now log in.');

            return $this->redirectToRoute('login');
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('login');
        }
    }
}
