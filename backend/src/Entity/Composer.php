<?php

namespace App\Entity;

use App\Repository\ComposerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ComposerRepository::class)]
class Composer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_composer'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_composer'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read_composer'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'Composer', targetEntity: Masterclass::class)]
    #[Groups(['read_composer'])]
    private Collection $masterclasses;

    public function __construct()
    {
        $this->masterclasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Masterclass>
     */
    public function getMasterclasses(): Collection
    {
        return $this->masterclasses;
    }

    public function addMasterclass(Masterclass $masterclass): self
    {
        if (!$this->masterclasses->contains($masterclass)) {
            $this->masterclasses->add($masterclass);
            $masterclass->setComposer($this);
        }

        return $this;
    }

    public function removeMasterclass(Masterclass $masterclass): self
    {
        if ($this->masterclasses->removeElement($masterclass)) {
            // set the owning side to null (unless already changed)
            if ($masterclass->getComposer() === $this) {
                $masterclass->setComposer(null);
            }
        }

        return $this;
    }
}
