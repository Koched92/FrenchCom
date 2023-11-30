<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryGroup;
use App\Entity\LinkHasCategory;
use App\Repository\CategoryGroupRepository;
use App\Repository\CategoryRepository;
use App\Repository\LinkRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LinkHasCategoryFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    /**
     * @var LinkRepository
     */
    protected $linkRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var CategoryGroupRepository
     */
    protected $categGroupRepository;

    public function __construct(
        LinkRepository $linkRepository,
        CategoryRepository $categoryRepository,
        CategoryGroupRepository $categGroupRepository
    ) {
        $this->linkRepository = $linkRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categGroupRepository = $categGroupRepository;

        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $links = $this->linkRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $categoryGroups = $this->categGroupRepository->findAll();

        foreach ($links as $link) {
            $lhc = new LinkHasCategory();
            $randomCategGroup = $this->faker->randomElement($categoryGroups);
            $randomCateg = $this->faker->randomElement($categories);
            if (!is_null($randomCategGroup) && $randomCategGroup instanceof CategoryGroup) {
                $lhc->setCategoryGroup($randomCategGroup);
            }
            if (!is_null($randomCateg) && $randomCateg instanceof Category) {
                $lhc->setCategory($randomCateg);
            }
            $lhc->setLink($link);

            $manager->persist($lhc);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          LinkFixtures::class,
          CategoryFixtures::class,
          CategoryGroupFixtures::class,
        ];
    }
}
