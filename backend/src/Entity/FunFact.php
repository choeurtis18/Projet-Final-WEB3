<?php

namespace App\Entity;

use App\Repository\FunFactRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FunFactRepository::class)]
class FunFact
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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Masterclass $Masterclass = null;

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

    public function getMasterclass(): ?Masterclass
    {
        return $this->Masterclass;
    }

    public function setMasterclass(Masterclass $Masterclass): static
    {
        $this->Masterclass = $Masterclass;

        return $this;
    }

}
