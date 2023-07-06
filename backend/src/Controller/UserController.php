<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Formation;
use App\Entity\Masterclass;
use App\Entity\User;
use App\Repository\ComposerRepository;
use App\Repository\FormationRepository;
use App\Repository\MasterclassRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



class UserController extends AbstractController
{
    #[Route('/users/admin', name: 'app_users_admin_show')]
    public function showMasterclassFormation(UserRepository $userRepository): Response
    {
        $users = $userRepository->getAllAdminUser();

        var_dump($users);
        try {
            return $this->json([
                'users' => $users
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "formation not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/centre_formation/masterclass/{id}', name: 'app_centre_formation_masterclass_show')]
    public function showMasterclassCentreDeFormation(ManagerRegistry $doctrine, int $id, UserRepository $userRepository, MasterclassRepository $masterclassRepository): Response
    {
        $masterclass = $masterclassRepository->findOneBy(['id' => $id]);
        $user = $doctrine->getRepository(User::class)->find($masterclass->getUser()->getId());

        try {
            return $this->json([
                'centre_formation' => $user
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "formation not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
