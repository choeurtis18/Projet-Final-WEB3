<?php

use App\Service\BadgeService;
use App\Entity\Badge;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\MockObject\MockObject;

it('assigns badge to user based on xp', function () {
    $badge1 = new Badge();
    $badge1->setXpThreshold(500);

    $badge2 = new Badge();
    $badge2->setXpThreshold(1000);

    /** @var EntityManagerInterface|MockObject $entityManagerMock */
    $entityManagerMock = $this->createMock(EntityManagerInterface::class);

    /** @var EntityRepository|MockObject $badgeRepoMock */
    $badgeRepoMock = $this->createMock(EntityRepository::class);

    $badgeRepoMock->method('findBy')->willReturn([$badge2, $badge1]);
    $entityManagerMock->method('getRepository')->willReturn($badgeRepoMock);

    $badgeService = new BadgeService($entityManagerMock);
    
    $user = new User();
    $user->setXp(600);
    
    $badgeService->assignBadge($user);
    
    expect($user->getBadge())->toHaveCount(1);
    expect($user->getBadge()[0])->toBe($badge1);
});
