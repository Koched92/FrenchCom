<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $nbIcons = 50;
        for ($i = 0; $i < $nbIcons; ++$i) {
            $icon = new User();
            $icon->setEmail($this->faker->safeEmail())
                  ->setPassword($this->faker->password(6, 8));
            $manager->persist($icon);
        }
        $manager->flush();
    }
}
