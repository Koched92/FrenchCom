<?php

namespace App\DataFixtures;

use App\Entity\Icon;
use Doctrine\Persistence\ObjectManager;

class IconFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $nbIcons = 50;
        for ($i = 0; $i < $nbIcons; ++$i) {
            $icon = new Icon();
            $icon->setName($this->faker->name())
                  ->setPath($this->faker->imageUrl(40, 40, 'link', true))
                  ->setSize($this->faker->numberBetween(0, 100));
            $manager->persist($icon);
        }
        $manager->flush();
    }
}
