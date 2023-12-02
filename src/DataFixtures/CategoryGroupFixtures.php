<?php

namespace App\DataFixtures;

use App\Entity\CategoryGroup;
use Doctrine\Persistence\ObjectManager;

class CategoryGroupFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $categorieGroups = [
          'Gaming',
          'Education',
          'Tips',
        ];
        $categorieGroupsCount = count($categorieGroups);
        for ($i = 0; $i < $categorieGroupsCount; ++$i) {
            $categoryGroup = new CategoryGroup();
            $categoryGroup->setName($categorieGroups[$i]);
            $manager->persist($categoryGroup);
        }
        $manager->flush();
    }

    /**
     * @return array<int, string>
     */
    public function getDependencies()
    {
        return [
            LinkFixtures::class,
        ];
    }
}
