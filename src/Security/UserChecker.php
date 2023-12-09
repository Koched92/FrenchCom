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
        $isApproved = $user->getIsApproved();

        // this is your custom check:
        if (!$isVerified) {
            throw new CustomUserMessageAccountStatusException('Please verify your email address by clicking on the confirmation link that has been sent to your inbox.');
        } elseif (!$isApproved) {
            throw new CustomUserMessageAccountStatusException('Your account has not yet been approved by the administrator.');
        }
    }

    /**
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function checkPostAuth(UserInterface $user)
    {
        // nothing to check here.
        return;
    }
}
