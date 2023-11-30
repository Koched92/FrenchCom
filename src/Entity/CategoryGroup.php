<?php

namespace App\Entity;

use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Repository\CategoryGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryGroupRepository::class)
 */
class CategoryGroup
{
    use HasIdTrait;
    use HasNameTrait;

    /**
     * @var Collection<int, LinkHasCategory>
     *
     * @ORM\OneToMany(targetEntity=LinkHasCategory::class, mappedBy="categoryGroup")
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
            $linkHasCategory->setCategoryGroup($this);
        }

        return $this;
    }

    public function removeLinkHasCategory(LinkHasCategory $linkHasCategory): self
    {
        if ($this->linkHasCategories->removeElement($linkHasCategory)) {
            // set the owning side to null (unless already changed)
            if ($linkHasCategory->getCategoryGroup() === $this) {
                $linkHasCategory->setCategoryGroup(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}
