<?php

use App\Service\XpService;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;

it('adds xp to user', function () {
    /** @var EntityManagerInterface|MockObject $entityManagerMock */
    $entityManagerMock = $this->createMock(EntityManagerInterface::class);
    
    $xpService = new XpService($entityManagerMock);
    
    $user = new User();
    $user->setXp(100);
    
    $xpService->addXpToUser($user, 50);
    
    expect($user->getXp())->toBe(150);
});
 