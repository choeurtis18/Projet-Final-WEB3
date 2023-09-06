<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

class EventController extends AbstractController
    {
        #[Route('/events', name: 'app_events_show', methods: ['GET'])]
        public function show_all(EventRepository $eventRepository): Response
        {
            $events = $eventRepository->findAll();

            try {
                return $this->json([
                    'events' => $events
                ], 200, [], ['groups' => 'read_composer']);
            } catch (\Exception $exception) {
                return $this->json([
                    'error' => "Events not found"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    
        
        #[Route('/event/{id}', name: 'app_event_show',  methods: ['GET'])]
        public function show(EventRepository $eventRepository, int $id): Response
        {

            $event = $eventRepository->findOneBy(['id' => $id]);

            try {
                return $this->json([
                    'event' => $event,
                ], 200, [], ['groups' => 'read_composer']);
            } catch (\Exception $exception) {
                return $this->json([
                    'error' => "No event found"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
        }

        #[Route('/event', name: 'app_create_event', methods: ['POST'])]
        public function create_event(Request $request, EventRepository $eventRepository) { 
            $current_user = $this->getUser();

            $data = json_decode($request->getContent(), true);
            $name = $data['name'];

            try {
                if (!$eventRepository->findOneBy(['name' => $name])) {
                    $event = new Event();
                    $event->setName($name);

                    $eventRepository->save($event, true);

                    return $this->json([
                        'status' => 1,
                        'message' => "New Event Add"
                    ], Response::HTTP_OK);;                
                } else {
                    return $this->json([
                        'status' => 0,
                        'message' => "Event already exists"
                    ], Response::HTTP_OK);;     
                }

            } catch (\Exception $exception) {
                return $this->json([
                    'status' => 0,
                    'error' => "error durring add event"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        #[Route('/event/{id}', name: 'app_delete_event', methods: ['DELETE'])]
        public function delete_event(UserRepository $userRepository, EventRepository $eventRepository, int $id, EntityManagerInterface $em) 
        { 
            $current_user = $this->getUser();
            $admins = $userRepository->getAllAdminUser();

            try {
                if (in_array($current_user, $admins)) {

                    $event = $em->getReference(Event::class, $id);
                    $em->remove($event);
                    $em->flush();

                    return $this->json([
                        'status' => 1,
                        'message' => "Evénement Supprimé"
                    ], Response::HTTP_OK);;                
                } else {
                    return $this->json([
                        'status' => 0,
                        'message' => "Vous n'êtes pas autorisé à supprimer un événement"
                    ], Response::HTTP_OK);;     
                }

            } catch (\Exception $exception) {
                return $this->json([
                    'status' => 0,
                    'error' => "Erreur lors de la supression d'un événement"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        #[Route('/event/{id}', name: 'app_update_event', methods: ['PATCH'])]
        public function update_event(Request $request, EntityManagerInterface $em, int $id,
        UserRepository $userRepository, EventRepository $eventRepository) { 
            $current_user = $this->getUser();
            $admins = $userRepository->getAllAdminUser();

            $data = json_decode($request->getContent(), true);
            $name = $data['name'];

            try {
                if (in_array($current_user, $admins)) {
                    $event = $em->getReference(Event::class, $id);
                    $event->setName($name);
                    $em->flush();

                    return $this->json([
                        'status' => 1,
                        'message' => "Event Update"
                    ], Response::HTTP_OK);;                
                } else {
                    return $this->json([
                        'status' => 0,
                        'message' => "Vous n'êtes pas autorisé à mettre à jour un événement"
                    ], Response::HTTP_OK);;     
                }

            } catch (\Exception $exception) {
                return $this->json([
                    'status' => 0,
                    'error' => "Erreur lors de la mise à jour d'un événement"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

}