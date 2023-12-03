<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @SuppressWarnings(ShortVariable)
 * @SuppressWarnings(UnusedFormalParameter)
 */
class LoginListener extends AbstractController
{
    /* @phpstan-ignore-next-line */
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /* @phpstan-ignore-next-line */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        /*  $user = $event->getAuthenticationToken()->getUser();

         $IsVerified = $user->getIsVerified();
         if (!$IsVerified) {
           $event->stopPropagation();
           $this->addFlash('error', 'Email not verified');
           return $this->redirectToRoute('login');
         } */

        // Update your field here.
        // $user->setLastLogin(new \DateTime());

        // Persist the data to database.
        // $this->em->persist($user);
        // $this->em->flush();
    }
}
