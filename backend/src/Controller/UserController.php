<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
}
