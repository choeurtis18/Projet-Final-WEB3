<?php

namespace App\Entity;

use App\Repository\MasterclassQuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterclassQuizzRepository::class)]
class MasterclassQuizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $counter = null;

    #[ORM\ManyToMany(targetEntity: Masterclass::class, mappedBy: 'MasterclassQuizz')]
    private Collection $masterclasses;

    #[ORM\ManyToOne(inversedBy: 'MasterclassQuizz')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: MasterclassQuestion::class, inversedBy: 'masterclassQuizzs')]
    private Collection $MasterclassQuestion;

    public function __construct()
    {
        $this->masterclasses = new ArrayCollection();
        $this->MasterclassQuestion = new ArrayCollection();
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

    public function getCounter(): ?int
    {
        return $this->counter;
    }

    public function setCounter(?int $counter): self
    {
        $this->counter = $counter;

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
            $masterclass->addMasterclassQuizz($this);
        }

        return $this;
    }

    public function removeMasterclass(Masterclass $masterclass): self
    {
        if ($this->masterclasses->removeElement($masterclass)) {
            $masterclass->removeMasterclassQuizz($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MasterclassQuestion>
     */
    public function getMasterclassQuestion(): Collection
    {
        return $this->MasterclassQuestion;
    }

    public function addMasterclassQuestion(MasterclassQuestion $masterclassQuestion): self
    {
        if (!$this->MasterclassQuestion->contains($masterclassQuestion)) {
            $this->MasterclassQuestion->add($masterclassQuestion);
        }

        return $this;
    }

    public function removeMasterclassQuestion(MasterclassQuestion $masterclassQuestion): self
    {
        $this->MasterclassQuestion->removeElement($masterclassQuestion);

        return $this;
    }
}
