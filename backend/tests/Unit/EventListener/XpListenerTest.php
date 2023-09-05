<?php

use App\Entity\User;
use App\EventListener\XpListener;
use App\Service\BadgeService;
use Doctrine\ORM\Event\PreUpdateEventArgs;

beforeEach(function() {
    $this->badgeService = Mockery::mock(BadgeService::class);
    $this->listener = new XpListener($this->badgeService);

    $this->user = new User();
    $this->user->setXp(150);
});

it('calls badge service when user XP changes', function() {
    $args = Mockery::mock(PreUpdateEventArgs::class);
    $args->shouldReceive('getObject')->andReturn($this->user);
    $args->shouldReceive('hasChangedField')->with(XpListener::XP_FIELD)->andReturn(true);

    $this->badgeService->shouldReceive('assignBadge')->once()->with($this->user);

    $this->listener->preUpdate($args);
});
