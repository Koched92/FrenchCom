<?php

// src/EventSubscriber/EasyAdminSubscriber.php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordHasherInterface
     */
    protected $userPasswordHasher;

    private MailerInterface $mailer;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['persistHashPassword'],
            BeforeEntityUpdatedEvent::class => ['updateHashPassword'],
            AfterEntityUpdatedEvent::class => ['approveNotifier'],
        ];
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    public function persistHashPassword(BeforeEntityPersistedEvent $event): void
    {
        $this->hashPassword($event);
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    public function updateHashPassword(BeforeEntityUpdatedEvent $event): void
    {
        $this->hashPassword($event);
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    public function approveNotifier(AfterEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $approved = $entity->getIsApproved();

        if ($approved) {
            $email = (new TemplatedEmail())

            ->from(new Address('noreply@frenchCom.com', 'FrenchCom Bot'))
            ->to($entity->getEmail())
            ->subject('Account approved')
            ->htmlTemplate('registration/approve.html.twig');

            $this->mailer->send($email);
        }
    }

    /**
     * @phpstan-ignore-next-line
     */
    private function hashPassword($event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        $plainPassword = $entity->getPlainPassword();
        if ($plainPassword) {
            $entity->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $entity,
                    $plainPassword
                )
            );
        }
    }
}
