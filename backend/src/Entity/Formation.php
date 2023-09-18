<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_composer'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_composer'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_composer'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'Formation')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Masterclass::class, mappedBy: 'Formation')]
    private Collection $masterclasses;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?FormationLvl $FormationLvl = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $masterclass->addFormation($this);
        }

        return $this;
    }

    public function removeMasterclass(Masterclass $masterclass): self
    {
        if ($this->masterclasses->removeElement($masterclass)) {
            $masterclass->removeFormation($this);
        }

        return $this;
    }

    public function getFormationLvl(): ?FormationLvl
    {
        return $this->FormationLvl;
    }

    public function setFormationLvl(?FormationLvl $FormationLvl): self
    {
        $this->FormationLvl = $FormationLvl;

        return $this;
    }
}
