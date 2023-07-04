<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Masterclass;
use App\Repository\InstrumentRepository;
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

        try {
            return $this->json([
                'instruments' => $instruments
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "instruments not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/create_instrument', name: 'app_create_instrument')]
    public function create_instrument(Request $request, EntityManagerInterface $entityManagerInterface,
                                    InstrumentRepository $instrumentRepository) { 
        $instrument = new Instrument();
        $current_user = $this->getUser();
        $name = $request->request->get('name');

        try {
            $instrument = new Instrument();
            $instrument->setName($name);

            $instrumentRepository->save($instrument, true);

            return $this->json([
                'status' => 1,
                'message' => "New Instrument Add"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);;
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring add instrument"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /*
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
        */
    }

    #[Route('/instrument/{id}', name: 'app_instrument_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);
        $masterclass = $doctrine->getRepository(Masterclass::class)->findMasterclassByInstrument($instrument->getId());
        
        try {
            return $this->json([
                'instrument' => $instrument,
                'masterclass' => $masterclass
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "composer not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
