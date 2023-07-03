<?php

namespace App\Entity;

use App\Repository\ClassroomQuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClassroomQuizzRepository::class)]
class ClassroomQuizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_composer'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_composer'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read_composer'])]
    private ?int $counter = null;

    #[ORM\ManyToMany(targetEntity: ClassroomQuestion::class, inversedBy: 'classroomQuizzs')]
    private Collection $ClassroomQuestion;

    public function __construct()
    {
        $this->ClassroomQuestion = new ArrayCollection();
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
     * @return Collection<int, ClassroomQuestion>
     */
    public function getClassroomQuestion(): Collection
    {
        return $this->ClassroomQuestion;
    }

    public function addClassroomQuestion(ClassroomQuestion $classroomQuestion): self
    {
        if (!$this->ClassroomQuestion->contains($classroomQuestion)) {
            $this->ClassroomQuestion->add($classroomQuestion);
        }

        return $this;
    }

    public function removeClassroomQuestion(ClassroomQuestion $classroomQuestion): self
    {
        $this->ClassroomQuestion->removeElement($classroomQuestion);

        return $this;
    }
}
