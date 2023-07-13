<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Repository\InstrumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;


class InstrumentController extends AbstractController
{
    #[Route('/instruments', name: 'app_instruments_show')]
    public function index(InstrumentRepository $instrumentRepository): Response
    {
        $instruments = $instrumentRepository->findAll();

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
        $current_user = $this->getUser();

        $data = json_decode($request->getContent(), true);
        $name = $data['name'];

        try {
            if (!$instrumentRepository->findOneBy(['name' => $name])) {
                $instrument = new Instrument();
                $instrument->setName($name);

                $instrumentRepository->save($instrument, true);

                return $this->json([
                    'status' => 1,
                    'message' => "New Instrument Add"
                ], Response::HTTP_OK);;                
            } else {
                return $this->json([
                    'status' => 0,
                    'message' => "Instrument déjà existant"
                ], Response::HTTP_OK);;     
            }

        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring add instrument"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/instrument/{id}', name: 'app_instrument_show')]
    public function show(InstrumentRepository $instrumentRepository, int $id): Response
    {
        $instrument = $instrumentRepository->findOneBy(['id' => $id]);

        try {
            return $this->json([
                'instrument' => $instrument,
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "composer not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
