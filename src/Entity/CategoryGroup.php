<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Repository\CategoryGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryGroupRepository::class)
 *
 * @ApiResource(
 *  itemOperations={"GET","DELETE","PATCH"}
 * )
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

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="categoryGroup")
     */
    private $Category;

    public function __construct()
    {
        $this->linkHasCategories = new ArrayCollection();
        $this->Category = new ArrayCollection();
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

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->Category->contains($category)) {
            $this->Category[] = $category;
            $category->setCategoryGroup($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->Category->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCategoryGroup() === $this) {
                $category->setCategoryGroup(null);
            }
        }

        return $this;
    }
}
