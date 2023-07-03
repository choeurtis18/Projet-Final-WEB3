<?php

namespace App\Controller;

use App\Repository\MasterclassQuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MasterclassQuizzController extends AbstractController
{
    /**
     * @Route("/masterclass/quizzes", name="masterclass_quizz_index", methods={"GET"})
     */
    public function index(MasterclassQuizzRepository $masterclassQuizzRepository): JsonResponse
    {
        $quizzes = $masterclassQuizzRepository->findAll();

        $quizArray = array_map(function ($quiz) {
            return $quiz->toArray();
        }, $quizzes);

        return new JsonResponse($quizArray);
    }

    /**
     * @Route("/masterclass-quizz", name="masterclass_quizz_list", methods={"GET"})
     */
    public function listMasterclassQuizz(MasterclassQuizzRepository $masterclassQuizzRepository): JsonResponse
    {
        $masterclassQuizzs = $masterclassQuizzRepository->findAll();

        $data = [];
        foreach ($masterclassQuizzs as $masterclassQuizz) {
            $masterclassQuestions = $masterclassQuizz->getMasterclassQuestion();
            $questionsData = [];
            foreach ($masterclassQuestions as $masterclassQuestion) {
                $questionData = [
                    'id' => $masterclassQuestion->getId(),
                    'title' => $masterclassQuestion->getTitle(),
                    'answer' => $masterclassQuestion->getAnswer(),
                    'xp_value' => $masterclassQuestion->getXpValue(),
                    'proposition' => $masterclassQuestion->getProposition(),
                ];
                $questionsData[] = $questionData;
            }

            $quizzData = [
                'id' => $masterclassQuizz->getId(),
                'name' => $masterclassQuizz->getName(),
                'counter' => $masterclassQuizz->getCounter(),
                'questions' => $questionsData,
            ];
            $data[] = $quizzData;
        }

        return new JsonResponse($data);
    }
}
