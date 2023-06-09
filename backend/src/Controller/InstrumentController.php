<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Masterclass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class InstrumentController extends AbstractController
{
    #[Route('/instruments', name: 'app_instruments_show')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $instruments = $doctrine->getRepository(Instrument::class)->findAll();
        if(!$instruments) {
            throw $this->createNotFoundException(
                'No instrument found'
            );
        }

        return $this->render('instrument/index.html.twig', ['instruments' => $instruments]);
    }

    #[Route('/create_instrument', name: 'app_create_instrument')]
    public function create_instrument(Request $request, EntityManagerInterface $entityManagerInterface) { 
        $instrument = new Instrument();
        $current_user = $this->getUser();

        $form = $this->createFormBuilder($instrument)
        ->add("name", TextType::class,[
            "label"=> "Nom",
            "attr"=>[
                'placeholder' => 'Piano'
            ]
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Submit'
        ])
        ->getForm();
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($instrument);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_instrument_show', [
                'id' => $instrument->getId(),
            ]);
        }

        return $this->render('instrument/create_instrument.html.twig', [
            "form" => $form
        ]);
    }

    #[Route('/instrument/{id}', name: 'app_instrument_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);
        $masterclass = $doctrine->getRepository(Masterclass::class)->findMasterclassByInstrument($instrument->getId());
        
        if(!$instrument) {
            throw $this->createNotFoundException(
                'No instrument found for id '.$id
            );
        }

        return $this->render('instrument/show_instrument.html.twig', [
            'instrument' => $instrument,
            'masterclass' => $masterclass
            ]
        );

        // or render a template
        // in the template, print things with {{ annonce.name }}
        // return $this->render('annonce/show.html.twig', ['annonce' => $annonce]);
    }
}
