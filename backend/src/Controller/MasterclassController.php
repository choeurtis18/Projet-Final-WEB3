<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Instrument;
use App\Entity\Masterclass;
use App\Form\Type\ComposerType;
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
    #[Route('/masterclasss', name: 'app_masterclasss_show')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $masterclasss = $doctrine->getRepository(Masterclass::class)->findAll();
        if(!$masterclasss) {
            throw $this->createNotFoundException(
                'No masterclass found'
            );
        }

        return $this->render('masterclass/index.html.twig', ['masterclasss' => $masterclasss]);
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

    // #[Route('/masterclass/{id}', name: 'app_masterclass_show')]
    // public function show(ManagerRegistry $doctrine, int $id): Response
    // {
    //     $masterclass = $doctrine->getRepository(Masterclass::class)->find($id);

    //     if(!$masterclass) {
    //         throw $this->createNotFoundException(
    //             'No masterclass found for id '.$id
    //         );
    //     }

    //     return $this->render('masterclass/show_masterclass.html.twig', 
    //         ['masterclass' => $masterclass]
    //     );

    //     // or render a template
    //     // in the template, print things with {{ annonce.name }}
    //     // return $this->render('annonce/show.html.twig', ['annonce' => $annonce]);
    // }
}
