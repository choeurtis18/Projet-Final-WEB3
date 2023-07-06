<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class EventController extends AbstractController
{
  #[Route('/events', name: 'app_events_show')]
    public function show_all(ManagerRegistry $doctrine): Response
    {
        $events = $doctrine->getRepository(Event::class)->findAll();
        if (!$events) {
            throw $this->createNotFoundException(
                'No events found'
            );
        }

        return $this->render('event/index.html.twig', ['events' => $events]);

    }

    #[Route('/event/{id}', name: 'app_event_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $event = $doctrine->getRepository(Event::class)->find($id);
        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id '.$id
            );
        }

        return $this->render('event/show_event.html.twig', ['event' => $event]);

    }


}