<?php

namespace App\Entity;

use App\Repository\ClassroomQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomQuestionRepository::class)]
class ClassroomQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $xp_value = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $proposition = [];

    #[ORM\ManyToMany(targetEntity: ClassroomQuizz::class, mappedBy: 'ClassroomQuestion')]
    private Collection $classroomQuizzs;

    public function __construct()
    {
        $this->classroomQuizzs = new ArrayCollection();
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

    public function getXpValue(): ?int
    {
        return $this->xp_value;
    }

    public function setXpValue(int $xp_value): self
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
     * @return Collection<int, ClassroomQuizz>
     */
    public function getClassroomQuizzs(): Collection
    {
        return $this->classroomQuizzs;
    }

    public function addClassroomQuizz(ClassroomQuizz $classroomQuizz): self
    {
        if (!$this->classroomQuizzs->contains($classroomQuizz)) {
            $this->classroomQuizzs->add($classroomQuizz);
            $classroomQuizz->addClassroomQuestion($this);
        }

        return $this;
    }

    public function removeClassroomQuizz(ClassroomQuizz $classroomQuizz): self
    {
        if ($this->classroomQuizzs->removeElement($classroomQuizz)) {
            $classroomQuizz->removeClassroomQuestion($this);
        }

        return $this;
    }
}
