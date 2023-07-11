<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Formation;
use App\Entity\Masterclass;
use App\Entity\User;
use App\Repository\ComposerRepository;
use App\Repository\FormationRepository;
use App\Repository\MasterclassRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Firebase\JWT\JWT;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_create', methods: ['POST'])]
    public function createUser(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->json([
                'error' => 'L\'utilisateur existe déjà.'
            ], 409);
        }

        if (!is_array($data['roles'])) {
            return $this->json([
                'error' => 'Le format du rôle est incorrect.'
            ], 400);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'error' => 'Le format de l\'e-mail est incorrect.'
            ], 400);
        }

        $user = new User();
        $user->setEmail($data['email'])
            ->setRoles($data['roles'])
            ->setPassword($hasher->hashPassword($user, $data['password']));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'New user created'
        ]);
    }

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

    #[Route('/login', name: 'user_login')]
    public function login(string $appSecret): JsonResponse
    {
        /** @var $user ?User */
        $user = $this->getUser();

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $jwt = JWT::encode([
            'email' => $user->getEmail(),
            'id' => $user->getId()
        ],
            $appSecret,
            'HS256');

        return $this->json([
            'message' => 'Welcome ! ',
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'jwt' => $jwt
        ]);
    }
}
