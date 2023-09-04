<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Repository\InstrumentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;


class InstrumentController extends AbstractController
{
    #[Route('/instrument', name: 'app_instruments_show', methods: ['GET'])]
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

    #[Route('/instrument', name: 'app_create_instrument', methods: ['POST'])]
    public function create_instrument(Request $request, InstrumentRepository $instrumentRepository) { 
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

    #[Route('/instrument/{id}', name: 'app_delete_instrument', methods: ['DELETE'])]
    public function delete_instrument(UserRepository $userRepository, InstrumentRepository $instrumentRepository, int $id, 
                                EntityManagerInterface $em) { 
        $current_user = $this->getUser();
        $admins = $userRepository->getAllAdminUser();

        try {
            if (in_array($current_user, $admins)) {

                $instrument = $em->getReference(Instrument::class, $id);
                $em->remove($instrument);
                $em->flush();

                return $this->json([
                    'status' => 1,
                    'message' => "Instrument Delete"
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
                'error' => "error durring remove instrument"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/instrument/{id}', name: 'app_update_instrument', methods: ['PATCH'])]
    public function update_instrument(Request $request, EntityManagerInterface $em, int $id,
                                UserRepository $userRepository, InstrumentRepository $instrumentRepository) { 
        $current_user = $this->getUser();
        $admins = $userRepository->getAllAdminUser();

        $data = json_decode($request->getContent(), true);
        $name = $data['name'];

        try {
            if (in_array($current_user, $admins)) {
                $instrument = $em->getReference(Instrument::class, $id);
                $instrument->setName($name);
                $em->flush();

                return $this->json([
                    'status' => 1,
                    'message' => "Instrument Update"
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
                'error' => "error durring update instrument"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/instrument/{id}', name: 'app_instrument_show', methods: ['GET'])]
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
