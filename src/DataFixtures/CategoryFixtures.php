<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $nbCategories = 50;
        for ($i = 0; $i < $nbCategories; ++$i) {
            $category = new Category();
            $category->setName($this->faker->name())
                      ->setDescription($this->faker->realText());
            $manager->persist($category);
        }
        $manager->flush();
    }
}
