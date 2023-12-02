<?php

namespace App\DataFixtures;

use App\Entity\Icon;
use App\Entity\Link;
use App\Repository\IconRepository;
use App\Repository\TagRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LinkFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    /**
     * @var IconRepository
     */
    protected $iconRepository;
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    public function __construct(IconRepository $iconRepository, TagRepository $tagRepository)
    {
        $this->iconRepository = $iconRepository;
        $this->tagRepository = $tagRepository;
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $icons = $this->iconRepository->findAll();
        $tags = $this->tagRepository->findAll();
        $nbLinks = 50;
        for ($i = 0; $i < $nbLinks; ++$i) {
            $link = new Link();
            $link->setName($this->faker->lastName())
                ->setDescription($this->faker->realText(500))
                ->setUrl($this->faker->url());
            $randomIcon = $this->faker->randomElement($icons);
            if (!is_null($randomIcon) && $randomIcon instanceof Icon) {
                $link->setIcon($randomIcon);
            }
            $linkTags = $this->faker->randomElements($tags, $this->faker->randomNumber(1));
            foreach ($linkTags as $linkTag) {
                $link->addTag($linkTag);
            }
            $manager->persist($link);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            // syntaxe FQCN ("Fully Qualified Class Name")
            IconFixtures::class,
        ];
    }
}
