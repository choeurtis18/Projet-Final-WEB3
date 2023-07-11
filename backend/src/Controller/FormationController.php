<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Formation;
use App\Entity\Masterclass;
use App\Repository\ComposerRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



class FormationController extends AbstractController
{
    #[Route('/formation/masterclass/{id}', name: 'app_formation_masterclass_show')]
    public function showMasterclassFormation(ManagerRegistry $doctrine, int $id,
                                                FormationRepository $formationRepository): Response
    {
        $masterclass = $doctrine->getRepository(Masterclass::class)->find($id);
        $formation = $formationRepository->findFormationByMasterclass($masterclass->getId());

        var_dump($formation);
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
