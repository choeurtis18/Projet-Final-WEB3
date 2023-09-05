<?php

use App\Entity\ClassroomQuestion;
use App\Entity\User;
use App\Service\XpService;
use App\Controller\ClassroomQuestionController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

it('calls XpService when a question is successfully answered', function () {
    $user = new User;
    $question = new ClassroomQuestion;
    $question->setXpValue(15); // Assuming you have a setter; adjust as needed

    $xpService = \Mockery::mock(XpService::class);
    $xpService->shouldReceive('addXpToUser')
        ->once()
        ->with($user, 15);

    $router = \Mockery::mock(RouterInterface::class);
    $router->shouldReceive('generate')
        ->andReturn('some_route_url');

    $controller = \Mockery::mock(ClassroomQuestionController::class, [$xpService])
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('getUser')
        ->andReturn($user)
        ->getMock();

    $container = new \Symfony\Component\DependencyInjection\Container;
    $container->set('router', $router);
    $controller->setContainer($container);

    $response = $controller->onQuestionSuccess($question);

    expect($response->getTargetUrl())->toBe('some_route_url');
});
