<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Instrument;
use App\Entity\Masterclass;
use App\Repository\ComposerRepository;
use App\Repository\InstrumentRepository;
use App\Repository\MasterclassRepository;
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
    #[Route('/masterclasses', name: 'app_masterclass_list_show')]
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

    #[Route('/create_masterclass', name: 'app_create_masterclass')]
    public function create_masterclass(Request $request, EntityManagerInterface $entityManagerInterface, ManagerRegistry $doctrine) { 
        $masterclass = new Masterclass();
        $current_user = $this->getUser();

        $composers = $doctrine->getRepository(Composer::class)->findAll();
        $array_composers = [];
        foreach($composers as $composer){
            array_push($array_composers, [
                $composer->getName() => $composer
            ]);
        }

        $instruments = $doctrine->getRepository(Instrument::class)->findAll();
        $array_instrument = [];
        foreach($instruments as $instrument){
            array_push($array_instrument, [
                $instrument->getName() => $instrument
            ]);
        }

        $form = $this->createFormBuilder($masterclass)
        ->add("title", TextType::class,[
            "label"=> "Title",
            "attr"=>[
                'placeholder' => 'Nocturnes, opus 9 de Chopin'
            ]
        ])
        ->add("description", TextType::class,[
            "label"=> "Description",
            "attr"=>[
                'placeholder' => 'Les nocturnes opus 9 de Chopin sont trois nocturnes lyriques romantiques pour piano de Frédéric Chopin. Composés entre 1830 et 1832, ils sont dédiés à son élève Marie Pleyel. Ils sont publiés à Leipzig en 1832, puis à Londres chez Wessel, et à Paris chez Schlesinger en 1833.'
            ]
        ])
        ->add("video", TextType::class,[
            "label"=> "Lien youtube",
            "attr"=>[
                'placeholder' => 'https://www.youtube.com/embed/9E6b3swbnWg'
            ]
        ])
        ->add("certification", TextType::class,[
            "label"=> "Certification",
            "attr"=>[
                'placeholder' => 'Bonne certif'
            ]
        ])/*
        ->add("composer", ChoiceType::class, [
            "choices" => $array_composers
        ])*/
        ->add("instrument", ChoiceType::class, [
            "choices" => $array_instrument
        ])

        ->add('save', SubmitType::class, [
            'label' => 'Submit'
        ])
        ->getForm();
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($masterclass);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_masterclass_show', [
                'id' => $masterclass->getId(),
            ]);
        }

        return $this->render('masterclass/create_masterclass.html.twig', [
            "form" => $form
        ]);
    }

    #[Route('/masterclass/{id}', name: 'app_masterclass_show')]
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
