<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $nbUsers = 5;
        for ($i = 0; $i < $nbUsers; ++$i) {
            $user = new User();
            $user->setFirstName($this->faker->firstName());
            $user->setLastName($this->faker->lastName());
            $user->setEmail($this->faker->safeEmail())
                  ->setPassword($this->faker->password(6, 8));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
