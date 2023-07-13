<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Repository\ComposerRepository;
use App\Repository\MasterclassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;



class ComposerController extends AbstractController
{
    #[Route('/composers', name: 'app_composers_show')]
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

    /**
    * @Route("/create_composer", name="app_create_composer")
    */ 
    #[Route('/create_composer', name: 'app_create_composer')]
    public function create_composer(Request $request, ManagerRegistry $doctrine, 
                                    ComposerRepository $composerRepository) { 
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

    #[Route('/composer/{id}', name: 'app_composer_show')]
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
