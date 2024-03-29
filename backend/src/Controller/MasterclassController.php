<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Instrument;
use App\Entity\Masterclass;
use App\Repository\ComposerRepository;
use App\Repository\InstrumentRepository;
use App\Repository\MasterclassRepository;
use App\Repository\FunFactRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MasterclassController extends AbstractController
{
    #[Route('/masterclass', name: 'app_masterclass_list_show', methods: ['GET'])]
    public function index(MasterclassRepository $masterclassRepository): Response
    {
        $masterclasses = $masterclassRepository->findAll();

        try {
            return $this->json([
                'masterclasses' => $masterclasses
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "instruments not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclass', name: 'app_create_masterclass', methods: ['POST'])]
    public function create_masterclass(Request $request, MasterclassRepository $masterclassRepository, 
                                            ComposerRepository $composerRepository, ManagerRegistry $doctrine, 
                                            InstrumentRepository $instrumentRepository) { 
        $current_user = $this->getUser();
        
        $data = json_decode($request->getContent(), true);
        $instrument = $instrumentRepository->findOneBy(['id' => $data['instrument']]);
        $composer = $composerRepository->findOneBy(['id' => $data['composer']]);
        $title = $data['title'];
        $video = "https://www.youtube.com/watch?v=Dp2SJN4UiE4";
        $certification = $data['certification'];
        $description = $data['description'];

        try {
            if (!$masterclassRepository->findOneBy(['title' => $title])) {
                $masterclass = new Masterclass();
                $masterclass->setUser($current_user);
                $masterclass->setInstrument($instrument);
                $masterclass->setComposer($composer);
                $masterclass->setTitle($title);
                $masterclass->setVideo($video);
                $masterclass->setCertification($certification);
                $masterclass->setDescription($description);

                $masterclassRepository->save($masterclass, true);

                return $this->json([
                    'status' => 1,
                    'message' => "New Masterclass Add"
                ], Response::HTTP_OK);;                
            } else {
                return $this->json([
                    'status' => 0,
                    'message' => "Masterclass déjà existant"
                ], Response::HTTP_OK);;     
            }

        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring add masterclass"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclass/{id}', name: 'app_delete_masterclass', methods: ['DELETE'])]
    public function delete_masterclass(UserRepository $userRepository, int $id, 
                                        FunFactRepository $funFactRepository, EntityManagerInterface $em) { 
        $current_user = $this->getUser();
        $admins = $userRepository->getAllAdminUser();

        try {
            if (in_array($current_user, $admins)) {

                $masterclass = $em->getReference(Masterclass::class, $id);
                $funfact = $funFactRepository->findOneBy(['Masterclass' => $masterclass]);
                $em->remove($funfact);
                $em->remove($masterclass);
                $em->flush();

                return $this->json([
                    'status' => 1,
                    'message' => "Masterclass Delete"
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
                'error' => "error durring remove masterclass".$exception
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclass/{id}', name: 'app_update_masterclass', methods: ['PATCH'])]
    public function update_masterclass(Request $request, EntityManagerInterface $em, int $id,
                                        ComposerRepository $composerRepository, InstrumentRepository $instrumentRepository, 
                                        UserRepository $userRepository) { 
        $current_user = $this->getUser();
        $admins = $userRepository->getAllAdminUser();

        $data = json_decode($request->getContent(), true);
        $instrument = $instrumentRepository->findOneBy(['id' => $data['instrument']]);
        $composer = $composerRepository->findOneBy(['id' => $data['composer']]);
        $title = $data['title'];
        $certification = $data['certification'];
        $description = $data['description'];

        try {
            if (in_array($current_user, $admins)) {
                $masterclass = $em->getReference(Masterclass::class, $id);
                $masterclass->setInstrument($instrument);
                $masterclass->setComposer($composer);
                $masterclass->setTitle($title);
                $masterclass->setCertification($certification);
                $masterclass->setDescription($description);
                $em->flush();

                return $this->json([
                    'status' => 1,
                    'message' => "Masterclass Update"
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
                'error' => "error durring update masterclass"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclass/{id}', name: 'app_masterclass_show', methods: ['GET'])]
    public function show(MasterclassRepository $masterclassRepository, int $id): Response
    {
        $masterclass = $masterclassRepository->findOneBy(['id' => $id]);

        try {
            return $this->json([
                'masterclass' => $masterclass
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "masterclass not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclass/instrument/{id}', name: 'app_masterclass_instrument_show')]
    public function showMasterclassByInstrument(InstrumentRepository $instrumentRepository, int $id,
                                                    MasterclassRepository $masterclassRepository): Response
    {
        try {
            $instrument = $instrumentRepository->findOneBy(['id' => $id]);
            $masterclasses = $masterclassRepository->findMasterclassByInstrument($instrument->getId());

            return $this->json([
                'masterclasses' => $masterclasses
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "masterclass not found \n".$exception
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclass/composer/{id}', name: 'app_masterclass_composer_show')]
    public function showMasterclassByComposer(ComposerRepository $composerRepository, int $id,
                                                    MasterclassRepository $masterclassRepository): Response
    {
        try {
            $composer = $composerRepository->findOneBy(['id' => $id]);
            $masterclasses = $masterclassRepository->findMasterclassByComposer($composer->getId());

            return $this->json([
                'masterclasses' => $masterclasses
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "masterclass not found \n".$exception
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/masterclasses/centredeformation/{id}', name: 'app_masterclasses_centredeformation_show')]
    public function showMasterclassByCentreDeFormation(UserRepository $userRepository, int $id,
                                                    MasterclassRepository $masterclassRepository): Response
    {
            $user = $userRepository->findOneBy(['id' => $id]);
            $masterclasses = $masterclassRepository->findMasterclassByCentreDeFormation($user->getId());

        try {
            return $this->json([
                'masterclasses' => $masterclasses
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "masterclass not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


#[Route('/masterclass/{id}/quizzes', name: 'app_masterclass_quizzes')]
public function getMasterclassQuizzes(Masterclass $masterclass): Response
{
    $quizzes = $masterclass->getMasterclassQuizz();

    try {
        return $this->json([
            'quizzes' => $quizzes
        ], 200, [], ['groups' => 'read_composer']);
    } catch (\Exception $exception) {
        return $this->json([
            'error' => "quizzes not found"
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    
}
