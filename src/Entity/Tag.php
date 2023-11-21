<?php

namespace App\Entity;

use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasTimestampTrait;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use HasTimestampTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="children")
     *
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private ?self $parent;

    /**
     * @var Collection<int, Tag>
     *
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="parent")
     */
    private Collection $children;

    /**
     * @var Collection<int, Link>
     *
     * @ORM\ManyToMany(targetEntity=Link::class, inversedBy="tags")
     */
    private Collection $links;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->links = new ArrayCollection();
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Link>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        $this->links->removeElement($link);

        return $this;
    }
}
