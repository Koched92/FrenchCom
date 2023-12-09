<?php

namespace App\Entity;

use App\Entity\Traits\HasDescriptionTrait;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasTimestampTrait;
use App\Repository\LinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 */
class Link
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use HasTimestampTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\ManyToOne(targetEntity=Icon::class, inversedBy="links", cascade={"persist"})
     */
    private ?Icon $icon;

    /**
     * @var Collection<int, Tag>
     *
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="links")
     */
    private Collection $tags;

    /**
     * @var Collection<int, LinkHasCategory>
     *
     * @ORM\OneToMany(targetEntity=LinkHasCategory::class, mappedBy="link", cascade={"persist", "remove"})
     */
    private Collection $linkHasCategories;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->linkHasCategories = new ArrayCollection();
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIcon(): ?Icon
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addLink($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeLink($this);
        }

        return $this;
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
            $linkHasCategory->setLink($this);
        }

        return $this;
    }

    public function removeLinkHasCategory(LinkHasCategory $linkHasCategory): self
    {
        if ($this->linkHasCategories->removeElement($linkHasCategory)) {
            // set the owning side to null (unless already changed)
            if ($linkHasCategory->getLink() === $this) {
                $linkHasCategory->setLink(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}
