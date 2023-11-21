<?php

namespace App\Entity;

use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasTimestampTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use HasTimestampTrait;

    /**
     * @var Collection<int, LinkHasCategory>
     *
     * @ORM\OneToMany(targetEntity=LinkHasCategory::class, mappedBy="category")
     */
    private Collection $linkHasCategories;

    public function __construct()
    {
        $this->linkHasCategories = new ArrayCollection();
    }

    /**
     * @return Collection<int, LinkHasCategory>
     */
    public function getLinkHasCategories(): Collection
    {
        return $this->linkHasCategories;
    }

    public function addLinkHasCategory(LinkHasCategory $linkHasCategory): self
    {
        if (!$this->linkHasCategories->contains($linkHasCategory)) {
            $this->linkHasCategories[] = $linkHasCategory;
            $linkHasCategory->setCategory($this);
        }

        return $this;
    }

    public function removeLinkHasCategory(LinkHasCategory $linkHasCategory): self
    {
        if ($this->linkHasCategories->removeElement($linkHasCategory)) {
            // set the owning side to null (unless already changed)
            if ($linkHasCategory->getCategory() === $this) {
                $linkHasCategory->setCategory(null);
            }
        }

        return $this;
    }
}
