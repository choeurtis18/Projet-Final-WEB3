<?php

namespace App\Controller;

use App\Entity\Masterclass;
use App\Entity\Funfact;
use App\Form\FunFactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class FunFactController extends AbstractController
{

    /**
     * @Route("/funfact/new/{id}", name="funfact_new", methods={"GET", "POST"})
     */
    public function create_funfact(Request $request, EntityManagerInterface $entityManager,ManagerRegistry $doctrine, int $id): Response
    {
        $funfact = new Funfact();
        $masterclass = $doctrine->getRepository(Masterclass::class)->find($id);
        $funfact->setMasterclass($masterclass);
        
        $form = $this->createForm(FunfactType::class, $funfact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($funfact);
            $entityManager->flush();

            return $this->redirectToRoute('app_masterclass_show', ['id' => $masterclass->getId()]);
        }

        return $this->render('funfact/create_funfact.html.twig', [
            'form' => $form->createView(),
            'masterclass' => $masterclass
        ]);
    }
}
