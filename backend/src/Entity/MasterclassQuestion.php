<?php

namespace App\Entity;

use App\Repository\MasterclassQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterclassQuestionRepository::class)]
class MasterclassQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $answer = null;

    #[ORM\Column(nullable: true)]
    private ?int $xp_value = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $proposition = [];

    #[ORM\ManyToMany(targetEntity: MasterclassQuizz::class, mappedBy: 'MasterclassQuestion')]
    private Collection $masterclassQuizzs;

    public function __construct()
    {
        $this->masterclassQuizzs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getXpValue(): ?int
    {
        return $this->xp_value;
    }

    public function setXpValue(?int $xp_value): self
    {
        $this->xp_value = $xp_value;

        return $this;
    }

    public function getProposition(): array
    {
        return $this->proposition;
    }

    public function setProposition(?array $proposition): self
    {
        $this->proposition = $proposition;

        return $this;
    }

    /**
     * @return Collection<int, MasterclassQuizz>
     */
    public function getMasterclassQuizzs(): Collection
    {
        return $this->masterclassQuizzs;
    }

    public function addMasterclassQuizz(MasterclassQuizz $masterclassQuizz): self
    {
        if (!$this->masterclassQuizzs->contains($masterclassQuizz)) {
            $this->masterclassQuizzs->add($masterclassQuizz);
            $masterclassQuizz->addMasterclassQuestion($this);
        }

        return $this;
    }

    public function removeMasterclassQuizz(MasterclassQuizz $masterclassQuizz): self
    {
        if ($this->masterclassQuizzs->removeElement($masterclassQuizz)) {
            $masterclassQuizz->removeMasterclassQuestion($this);
        }

        return $this;
    }
}
