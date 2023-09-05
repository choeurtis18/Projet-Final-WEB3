<?php

namespace App\Controller;

use App\Entity\ClassroomQuestion;
use App\Entity\User;
use App\Service\XpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomQuestionController extends AbstractController
{
    private XpService $xpService;

    public function __construct(XpService $xpService)
    {
        $this->xpService = $xpService;
    }

    #[Route('/classroom_question/success/{id}', name: 'classroom_question_success')]

    public function onQuestionSuccess(ClassroomQuestion $question): Response
    {
        $user = $this->getUser();
        if(!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        $this->xpService->addXpToUser($user, $question->getXpValue());

        return $this->redirectToRoute("some_route_name");
    }
}