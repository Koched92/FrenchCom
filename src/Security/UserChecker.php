<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
        $isVerified = $user->getIsVerified();

        // this is your custom check:
        if (!$isVerified) {
            throw new CustomUserMessageAccountStatusException('Please validate your Email, before logging in.');
        }
    }

    /* public function checkPostAuth(UserInterface $user)
    {
        // nothing to check here.
        return;
    } */
}
