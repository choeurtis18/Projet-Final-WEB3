<?php

use App\Controller\ClassroomQuestionController;
use App\Entity\ClassroomQuestion;
use App\Entity\User;
use App\Service\XpService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;

it('calls XpService when a question is successfully answered', function () {
    $question = Mockery::mock(ClassroomQuestion::class);
    $question->shouldReceive('getXpValue')->andReturn(15);

    $user = Mockery::mock(User::class);

    $security = Mockery::mock(Security::class);
    $security->shouldReceive('getUser')->andReturn($user);

    // Mocking the XpService
    $xpService = Mockery::mock(XpService::class);
    $xpService->shouldReceive('addXpToUser')->once()->with($user, 50);

    $controller = new ClassroomQuestionController($xpService);

    $controller->setContainer(Mockery::mock(ContainerInterface::class, ['get' => $security]));

    $controller->onQuestionSuccess($question);
});
