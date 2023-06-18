<?php

namespace App\Controller;

use App\Entity\MasterclassQuizz;
use App\Form\MasterclassQuizzType;
use App\Repository\MasterclassQuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MasterclassQuizzController extends AbstractController
{
    /**
     * @Route("/masterclass/quizzes", name="masterclass_quizz_index", methods={"GET"})
     */
    public function index(MasterclassQuizzRepository $masterclassQuizzRepository): Response
    {
        $quizzes = $masterclassQuizzRepository->findAll();

        return $this->render('masterclass_quizz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * @Route("/masterclass/quizzes/new", name="masterclass_quizz_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,ManagerRegistry $mangerRegistry): Response
    {
        $quizz = new MasterclassQuizz();

        $form = $this->createForm(MasterclassQuizzType::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quizz);
            $entityManager->flush();

            return $this->redirectToRoute('masterclass_quizz_show', ['id' => $quizz->getId()]);
        }

        return $this->render('masterclass_quizz/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/masterclass/quizzes/{id}", name="masterclass_quizz_show", methods={"GET"})
     */
    public function show(MasterclassQuizz $quizz): Response
    {
        return $this->render('masterclass_quizz/show.html.twig', [
            'quizz' => $quizz,
        ]);
    }

    /**
     * @Route("/masterclass/quizzes/{id}/edit", name="masterclass_quizz_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MasterclassQuizz $quizz): Response
    {
        $form = $this->createForm(MasterclassQuizzType::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('masterclass_quizz_index');
        }

        return $this->render('masterclass_quizz/edit.html.twig', [
            'quizz' => $quizz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/masterclass/quizzes/{id}", name="masterclass_quizz_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MasterclassQuizz $quizz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quizz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quizz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('masterclass_quizz_index');
    }
}
