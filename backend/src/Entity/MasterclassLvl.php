<?php

namespace App\Entity;

use App\Repository\MasterclassLvlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterclassLvlRepository::class)]
class MasterclassLvl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $progression = null;

    #[ORM\Column(nullable: true)]
    private ?int $progression_xp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'MasterclassLvl')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgression(): ?int
    {
        return $this->progression;
    }

    public function setProgression(?int $progression): self
    {
        $this->progression = $progression;

        return $this;
    }

    public function getProgressionXp(): ?int
    {
        return $this->progression_xp;
    }

    public function setProgressionXp(?int $progression_xp): self
    {
        $this->progression_xp = $progression_xp;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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
}
