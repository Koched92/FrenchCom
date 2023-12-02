<?php

// src/EventSubscriber/EasyAdminSubscriber.php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordHasherInterface
     */
    protected $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public static function getSubscribedEvents()
    {
        return [
          BeforeEntityPersistedEvent::class => ['persistHashPassword'],
          BeforeEntityUpdatedEvent::class => ['updateHashPassword'],
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
