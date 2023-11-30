<?php

namespace App\DataFixtures;

use App\Entity\LinkHasCategory;
use App\Repository\CategoryGroupRepository;
use App\Repository\CategoryRepository;
use App\Repository\LinkRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;

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
    protected $categoryGroupRepository;

    public function __construct(
        LinkRepository $linkRepository,
        CategoryRepository $categoryRepository,
        CategoryGroupRepository $categoryGroupRepository
    ) {
        $this->linkRepository = $linkRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categoryGroupRepository = $categoryGroupRepository;

        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $output = new ConsoleOutput();

        $links = $this->linkRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $categoryGroups = $this->categoryGroupRepository->findAll();

        foreach ($links as $link) {
            $lhc = new LinkHasCategory();
            $randomCategGroup = $this->faker->randomElement($categoryGroups);
            $randomCateg = $this->faker->randomElement($categories);
            $lhc->setCategoryGroup($randomCategGroup)
              ->setCategory($randomCateg)
              ->setLink($link);

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
