<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MasterclassControllerJson extends AbstractController
{
    /**
     * @Route("/masterclassjson", name="masterclass_list", methods={"GET"})
     */
    public function getMasterclassList(EntityManagerInterface $entityManager): JsonResponse
    {
        $masterclassRepository = $entityManager->getRepository(\App\Entity\Masterclass::class);
        $masterclasses = $masterclassRepository->findAll();

        $masterclassList = [];
        foreach ($masterclasses as $masterclass) {
            $masterclassData = [
                'id' => $masterclass->getId(),
                'user_id' => $masterclass->getUser(),
                'instrument_id' => $masterclass->getInstrument(),
                'masterclass_lvl_id' => $masterclass->getMasterclassLvl(),
                'fun_fact_id' => $masterclass->getFunFact(),
                'title' => $masterclass->getTitle(),
                'description' => $masterclass->getDescription(),
                'video' => $masterclass->getVideo(),
                'certification' => $masterclass->getCertification(),
                'partition_file' => $masterclass->getPartitionFile(),
                'quizz' => [],
            ];

            foreach ($masterclass->getMasterclassQuizz() as $quizz) {
                $masterclassData['quizz'][] = [
                    'id' => $quizz->getId(),
                    // 'user_id' => $quizz->getUser(),
                    'name' => $quizz->getName(),
                    'counter' => $quizz->getCounter(),
                ];
            }

            $masterclassList[] = $masterclassData;
        }

        return new JsonResponse($masterclassList);
    }

    /**
 * @Route("/masterclassjson/{id}", name="masterclass_details")
 */
public function getMasterclassDetails(EntityManagerInterface $entityManager, $id)
{
   
    $masterclassRepository = $entityManager->getRepository(\App\Entity\Masterclass::class);
    $masterclass = $masterclassRepository->find($id);

    if (!$masterclass) {
        throw $this->createNotFoundException('Masterclass not found.');
    }

    $data = [
        'title' => $masterclass->getTitle(),
        'description' => $masterclass->getDescription(),
    ];

    $quizzes = $masterclass->getMasterclassQuizz();

    $quizData = [];
    foreach ($quizzes as $quizz) {
        $quizzData[] = [
            'id' => $quizz->getId(),
            'name' => $quizz->getName(),
            'counter' => $quizz->getCounter(),
        ];
    }

    $data['quizzes'] = $quizzData;

    return new JsonResponse($data);
}

}
