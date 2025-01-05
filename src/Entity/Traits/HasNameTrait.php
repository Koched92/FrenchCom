<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

trait HasNameTrait
{
    /**
     * @ORM\Column(type="string", length=128)
     *
     * @Groups({"link:read", "link:write"})
     */
    private string $name;

    /**
     * @gedmo\Slug(fields={"name"}, unique=true)
     * 
     * @Groups({"link:read", "link:write"})
     * 
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private string $slug;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
