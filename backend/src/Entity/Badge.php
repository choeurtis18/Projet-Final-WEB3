<?php

namespace App\Entity;

use App\Repository\BadgeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BadgeRepository::class)]
class Badge
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
    private ?string $image = null;

    /**
     * @var int xp limit
     */
    #[Assert\Range(
        min: 0,
        max: 1500,
        notInRangeMessage : 'xpThreshold should be between {{ min }} and {{ max }}.',
    )]
    #[ORM\Column(type: 'integer')]
    private $xpThreshold;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Badge')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addBadge($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeBadge($this);
        }

        return $this;
    }

    public function getXpThreshold(): int
    {
        return $this->xpThreshold;
    }

    public function setXpThreshold(int $xpThreshold): self
    {
        $this->xpThreshold = $xpThreshold;

        return $this;
    }
}
