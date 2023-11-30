<?php

namespace App\DataFixtures;

use App\Entity\CategoryGroup;
use Doctrine\Persistence\ObjectManager;

class CategoryGroupFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $CategorieGroups = [
          'Gaming',
          'Education',
          'Tips',
        ];
        for ($i = 0; $i < count($CategorieGroups); ++$i) {
            $categoryGroup = new CategoryGroup();
            $categoryGroup->setName($CategorieGroups[$i]);
            $manager->persist($categoryGroup);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LinkFixtures::class,
        ];
    }
}
