<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_composer'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_composer'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'Instrument', targetEntity: Masterclass::class)]
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
            $masterclass->setInstrument($this);
        }

        return $this;
    }

    public function removeMasterclass(Masterclass $masterclass): self
    {
        if ($this->masterclasses->removeElement($masterclass)) {
            // set the owning side to null (unless already changed)
            if ($masterclass->getInstrument() === $this) {
                $masterclass->setInstrument(null);
            }
        }

        return $this;
    }
}
