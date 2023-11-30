<?php

namespace App\Entity;

use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasTimestampTrait;
use App\Repository\IconRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IconRepository::class)
 */
class Icon
{
    use HasIdTrait;
    use HasNameTrait;
    use HasTimestampTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $path;

    /**
     * @ORM\Column(type="integer")
     */
    private int $size;

    /**
     * @var Collection<int, Link>
     *
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="icon")
     */
    private Collection $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

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
            $link->setIcon($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getIcon() === $this) {
                $link->setIcon(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getPath();
    }
}
