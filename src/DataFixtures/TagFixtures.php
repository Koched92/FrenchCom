<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends AbstractFixtures
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $tags = $this->tagRepository->findAll();

        $nbTags = 15;

        // empty array instance
        $tags = [];

        for ($i = 0; $i < $nbTags; ++$i) {
            $tag = new Tag();

            // get a random element from tags array
            // add an optional faker ratio to get some null elements #credibility
            $parentTag = $this->faker->optional(0.125)->randomElement($tags);

            $tag->setName($this->faker->name())
            ->setDescription($this->faker->realText(500))
            // verify if the random tag element is an instance of Tag object
            ->setParent($parentTag instanceof Tag ? $parentTag : null);

            // fill tags array with the new created tag element
            $tags[] = $tag;

            $manager->persist($tag);
        }
        $manager->flush();
    }
}
