<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Masterclass;
use App\Repository\ComposerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



class ComposerController extends AbstractController
{
    #[Route('/composers', name: 'app_composers_show')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $composers = $doctrine->getRepository(Composer::class)->findAll();
        
        // if(!$composers) {
        //     throw $this->createNotFoundException(
        //         'No composer found'
        //     );
        // }

        // //var_dump($composers);
        // return $this->render('composer/index.html.twig', ['composers' => $composers]);


        try {
            return $this->json([
                'composers' => $composers
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "composers not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
     }

    /**
    * @Route("/create_composer", name="app_create_composer")
    */ 
    #[Route('/create_composer', name: 'app_create_composer')]
    public function create_composer(Request $request, ManagerRegistry $doctrine, 
                                    ComposerRepository $composerRepository) { 
        $current_user = $this->getUser();
        $name = $request->request->get('name');
        $description = $request->request->get('description');

        try {
            $composer = new Composer();
            $composer->setName($name)
                ->setDescription($description);

            $composerRepository->save($composer, true);

            return $this->json([
                'status' => 1,
                'message' => "New Composer Add"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);;
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 0,
                'error' => "error durring add composer"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        /*
        $form = $this->createFormBuilder($composer)
        ->add("name", TextType::class,[
            "label"=> "Nom",
            "attr"=>[
                'placeholder' => 'Ludwig Van Beethoven'
            ]
        ])
        ->add("description", TextType::class,[
            "label"=> "Descriprion",
            "attr"=>[
                'placeholder' => "Ludwig van Beethoven est un compositeur, pianiste et chef d'orchestre allemand, né à Bonn le 15 ou le 16 décembre 1770 et mort à Vienne le 26 mars 1827 à 56 ans."
            ]
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Submit'
        ])
        ->getForm();
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($composer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_composer_show', [
                'id' => $composer->getId(),
            ]);
        }

        return $this->render('composer/create_composer.html.twig', [
            "form" => $form
        ]);

        */
    }

    #[Route('/composer/{id}', name: 'app_composer_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $composer = $doctrine->getRepository(Composer::class)->find($id);
        $masterclass = $doctrine->getRepository(Masterclass::class)->findMasterclassByComposer($composer->getId());
        
        /*
        if(!$composer) {
            throw $this->createNotFoundException(
                'No composer found for id '.$id
            );
        }

        //var_dump($masterclass);
        
        return $this->render('composer/show_composer.html.twig', [
            'composer' => $composer,
            'masterclass' => $masterclass
            ]
        );
        */

        try {
            return $this->json([
                'composer' => $composer,
                'masterclass' => $masterclass
            ], 200, [], ['groups' => 'read_composer']);
        } catch (\Exception $exception) {
            return $this->json([
                'error' => "composer not found"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
