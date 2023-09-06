<?php

namespace App\EventListener;

use App\Entity\User;
use App\Service\BadgeService;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class XpListener
{
    public const XP_FIELD = 'xp';

    private BadgeService $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        //check if the xp field of the User entity has been modified
        if ($entity instanceof User && $args->hasChangedField(self::XP_FIELD)) {
            $this->badgeService->assignBadge($entity);
        }
    }
}
