<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_composer'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read_composer'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['read_composer'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['read_composer'])]
    private ?string $password = null;


    #[ORM\ManyToMany(targetEntity: badge::class, inversedBy: 'users')]
    #[Groups(['read_composer'])]
    private Collection $badge;

    #[ORM\ManyToMany(targetEntity: Event::class, inversedBy: 'users')]
    #[Groups(['read_composer'])]
    private Collection $Event;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Formation::class)]
    #[Groups(['read_composer'])]
    private Collection $Formation;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Masterclass::class)]
    #[Groups(['read_composer'])]
    private Collection $Masterclass;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Classroom::class)]
    #[Groups(['read_composer'])]
    private Collection $classroom;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FormationLvl::class)]
    #[Groups(['read_composer'])]
    private Collection $formationLvl;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MasterclassLvl::class)]
    #[Groups(['read_composer'])]
    private Collection $MasterclassLvl;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MasterclassQuizz::class)]
    #[Groups(['read_composer'])]
    private Collection $MasterclassQuizz;

    public function __construct()
    {
        $this->Badge = new ArrayCollection();
        $this->Event = new ArrayCollection();
        $this->Formation = new ArrayCollection();
        $this->Masterclass = new ArrayCollection();
        $this->classroom = new ArrayCollection();
        $this->formationLvl = new ArrayCollection();
        $this->MasterclassLvl = new ArrayCollection();
        $this->MasterclassQuizz = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, badge>
     */
    public function getBadge(): Collection
    {
        return $this->badge;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badge->contains($badge)) {
            $this->badge->add($badge);
        }

        return $this;
    }

    public function removeBadge(badge $badge): self
    {
        $this->badge->removeElement($badge);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $Event): self
    {
        if (!$this->Event->contains($Event)) {
            $this->Event->add($Event);
        }

        return $this;
    }

    public function removeEvent(Event $Event): self

    {
        $this->Event->removeElement($Event);

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormation(): Collection
    {
        return $this->Formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->Formation->contains($formation)) {
            $this->Formation->add($formation);
            $formation->setUser($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->Formation->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getUser() === $this) {
                $formation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Masterclass>
     */
    public function getMasterclass(): Collection
    {
        return $this->Masterclass;
    }

    public function addMasterclass(Masterclass $masterclass): self
    {
        if (!$this->Masterclass->contains($masterclass)) {
            $this->Masterclass->add($masterclass);
            $masterclass->setUser($this);
        }

        return $this;
    }

    public function removeMasterclass(Masterclass $masterclass): self
    {
        if ($this->Masterclass->removeElement($masterclass)) {
            // set the owning side to null (unless already changed)
            if ($masterclass->getUser() === $this) {
                $masterclass->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Classroom>
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom->add($classroom);
            $classroom->setUser($this);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->classroom->removeElement($classroom)) {
            // set the owning side to null (unless already changed)
            if ($classroom->getUser() === $this) {
                $classroom->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationLvl>
     */
    public function getFormationLvl(): Collection
    {
        return $this->formationLvl;
    }

    public function addFormationLvl(FormationLvl $formationLvl): self
    {
        if (!$this->formationLvl->contains($formationLvl)) {
            $this->formationLvl->add($formationLvl);
            $formationLvl->setUser($this);
        }

        return $this;
    }

    public function removeFormationLvl(FormationLvl $formationLvl): self
    {
        if ($this->formationLvl->removeElement($formationLvl)) {
            // set the owning side to null (unless already changed)
            if ($formationLvl->getUser() === $this) {
                $formationLvl->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MasterclassLvl>
     */
    public function getMasterclassLvl(): Collection
    {
        return $this->MasterclassLvl;
    }

    public function addMasterclassLvl(MasterclassLvl $masterclassLvl): self
    {
        if (!$this->MasterclassLvl->contains($masterclassLvl)) {
            $this->MasterclassLvl->add($masterclassLvl);
            $masterclassLvl->setUser($this);
        }

        return $this;
    }

    public function removeMasterclassLvl(MasterclassLvl $masterclassLvl): self
    {
        if ($this->MasterclassLvl->removeElement($masterclassLvl)) {
            // set the owning side to null (unless already changed)
            if ($masterclassLvl->getUser() === $this) {
                $masterclassLvl->setUser(null);
            }
        }

        return $this;
    }


    

    
}
