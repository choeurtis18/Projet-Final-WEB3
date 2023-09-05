<?php

namespace App\Service;

use App\Entity\Badge;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class BadgeService 
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
       $this->entityManager = $entityManager; 
    }

    public function assignBadge(User $user): void
    {
        $xp = $user->getXp();
        $badgeRepo = $this->entityManager->getRepository(Badge::class);

        $badges = $badgeRepo->findBy([], ['xpThreshold' => 'DESC']);

        foreach ($badges as $badge) {
            if ($xp >= $badge->getXpThreshold() && !$user->addBadge($badge)) {
                $user->addBadge($badge);
                break;
            }
        }

        $this->entityManager->flush();
    }
}