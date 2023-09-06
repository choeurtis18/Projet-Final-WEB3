<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class XpService 
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addXpToUser(User $user, int $xpAmount): void
    {
        $currentXp = $user->getXp();
        $user->setXp($currentXp + $xpAmount);
    }
}

