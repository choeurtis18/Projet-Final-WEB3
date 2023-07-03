<?php

namespace App\Entity;

use App\Repository\MasterclassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterclassRepository::class)]
class Masterclass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $video = null;

    #[ORM\Column(length: 255)]
    private ?string $certification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $partition_file = null;

    #[ORM\ManyToOne(inversedBy: 'Masterclass')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'masterclasses')]
    private ?Instrument $Instrument = null;

    #[ORM\ManyToMany(targetEntity: MasterclassQuizz::class, inversedBy: 'masterclasses')]
    private Collection $MasterclassQuizz;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?MasterclassLvl $masterclassLvl = null;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'masterclasses')]
    private Collection $Formation;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?FunFact $FunFact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'masterclasses')]
    private ?Composer $Composer = null;

    public function __construct()
    {
        $this->MasterclassQuizz = new ArrayCollection();
        $this->Formation = new ArrayCollection();
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


    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCertification(): ?string
    {
        return $this->certification;
    }

    public function setCertification(string $certification): self
    {
        $this->certification = $certification;

        return $this;
    }

    public function getPartitionFile(): ?string
    {
        return $this->partition_file;
    }

    public function setPartitionFile(?string $partition_file): self
    {
        $this->partition_file = $partition_file;

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

    public function getInstrument(): ?instrument
    {
        return $this->Instrument;
    }

    public function setInstrument(?instrument $Instrument): self
    {
        $this->Instrument = $Instrument;

        return $this;
    }

    /**
     * @return Collection<int, masterclassQuizz>
     */
    public function getMasterclassQuizz(): Collection
    {
        return $this->MasterclassQuizz;
    }

    public function addMasterclassQuizz(masterclassQuizz $masterclassQuizz): self
    {
        if (!$this->MasterclassQuizz->contains($masterclassQuizz)) {
            $this->MasterclassQuizz->add($masterclassQuizz);
        }

        return $this;
    }

    public function removeMasterclassQuizz(masterclassQuizz $masterclassQuizz): self
    {
        $this->MasterclassQuizz->removeElement($masterclassQuizz);

        return $this;
    }

    public function getMasterclassLvl(): ?MasterclassLvl
    {
        return $this->masterclassLvl;
    }

    public function setMasterclassLvl(?MasterclassLvl $masterclassLvl): self
    {
        $this->masterclassLvl = $masterclassLvl;

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
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        $this->Formation->removeElement($formation);

        return $this;
    }

    public function getFunFact(): ?FunFact
    {
        return $this->FunFact;
    }

    public function setFunFact(?FunFact $FunFact): self
    {
        $this->FunFact = $FunFact;

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

    public function getComposer(): ?Composer
    {
        return $this->Composer;
    }

    public function setComposer(?Composer $Composer): self
    {
        $this->Composer = $Composer;

        return $this;
    }
}
