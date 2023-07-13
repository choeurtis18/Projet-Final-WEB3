<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Repository\ComposerRepository;
use App\Repository\MasterclassRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


class ComposerController extends AbstractController
{
    #[Route('/composer', name: 'app_composers_show', methods: ['GET'])]
    public function index(ComposerRepository $composerRepository): Response
    {
        $composers = $composerRepository->findAll();
        
        try {
            return $this->json([
                'composers' => $composers
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "composers not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    #[Route('/composer', name: 'app_create_composer', methods: ['POST'])]
    public function create_composer(Request $request, ComposerRepository $composerRepository) { 
        $current_user = $this->getUser();

        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $description = $data['description'];

        try {
            if (!$composerRepository->findOneBy(['name' => $name])) {
                $composer = new Composer();
                $composer->setName($name);
                $composer->setDescription($description);

                $composerRepository->save($composer, true);

                return $this->json([
                    'status' => 1,
                    'message' => "New Composer Add"
                ], Response::HTTP_OK);;                
            } else {
                return $this->json([
                    'status' => 0,
                    'message' => "Composer déjà existant"
                ], Response::HTTP_OK);;     
            }

        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring add composer"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/composer/{id}', name: 'app_delete_composer', methods: ['DELETE'])]
    public function delete_composer(UserRepository $userRepository, ComposerRepository $composerRepository, int $id, 
                                EntityManagerInterface $em) { 
        $current_user = $this->getUser();
        $admins = $userRepository->getAllAdminUser();

        try {
            if (in_array($current_user, $admins)) {

                $composer = $em->getReference(Composer::class, $id);
                $em->remove($composer);
                $em->flush();

                return $this->json([
                    'status' => 1,
                    'message' => "Composer Delete"
                ], Response::HTTP_OK);;                
            } else {
                return $this->json([
                    'status' => 0,
                    'message' => "Vous n'est pas autorisé à être ici "
                ], Response::HTTP_OK);;     
            }

        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring remove composer"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/composer/{id}', name: 'app_update_composer', methods: ['PATCH'])]
    public function update_composer(Request $request, EntityManagerInterface $em, int $id,
                                UserRepository $userRepository, ComposerRepository $composerRepository) { 
        $current_user = $this->getUser();
        $admins = $userRepository->getAllAdminUser();

        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $description = $data['description'];

        try {
            if (in_array($current_user, $admins)) {
                $composer = $em->getReference(Composer::class, $id);
                $composer->setName($name);
                $composer->setDescription($description);
                $em->flush();

                return $this->json([
                    'status' => 1,
                    'message' => "composer Update"
                ], Response::HTTP_OK);;                
            } else {
                return $this->json([
                    'status' => 0,
                    'message' => "Vous n'est pas autorisé à être ici "
                ], Response::HTTP_OK);;     
            }

        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring update composer"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/composer/{id}', name: 'app_composer_show', methods: ['GET'])]
    public function show(MasterclassRepository $masterclassRepository, ComposerRepository $composerRepository, 
                            int $id): Response
    {
        $composer = $composerRepository->findOneBy(['id' => $id]);
        $masterclass = $masterclassRepository->findMasterclassByComposer($composer->getId());

        try {
            return $this->json([
                'composer' => $composer,
                'masterclass' => $masterclass
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "composer not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
