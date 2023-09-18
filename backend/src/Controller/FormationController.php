<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use App\Repository\MasterclassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FormationController extends AbstractController
{
    #[Route('/formations', name: 'app_formations_list_show', methods: ['GET'])]
    public function index(FormationRepository $formationsRepository): Response
    {
        $formations = $formationsRepository->findAll();

        try {
            return $this->json([
                'formations' => $formations
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "formations not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/formations/{id}', name: 'app_masterclass_show', methods: ['GET'])]
    public function show(FormationRepository $formationsRepository, int $id): Response
    {
        $formations = $formationsRepository->findOneBy(['id' => $id]);

        try {
            return $this->json([
                'formations' => $formations
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "masterclass not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/formation/masterclass/{id}', name: 'app_formation_masterclass_show')]
    public function showMasterclassFormation(MasterclassRepository $masterclassRepository, int $id,
                                                FormationRepository $formationRepository): Response
    {
        $masterclass = $masterclassRepository->findOneBy(['id' => $id]);
        $formation = $formationRepository->findFormationByMasterclass($masterclass->getId());

        try {
            return $this->json([
                'formation' => $formation
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "formation not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
