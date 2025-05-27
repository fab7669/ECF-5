<?php


namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableType;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/responsable')]
class ResponsableController extends AbstractController // Renommez cette classe en ResponsableController
{
    #[Route('/', name: 'app_responsable_index', methods: ['GET'])]
    public function index(ResponsableRepository $responsableRepository): Response
    {
        return $this->render('responsable/index.html.twig', [
            'responsables' => $responsableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_responsable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responsable);
            $entityManager->flush();

            $this->addFlash('success', 'Le responsable a été ajouté avec succès');
            return $this->redirectToRoute('app_responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('responsable/new.html.twig', [
            'responsable' => $responsable,
            'form' => $form->createView(),
        ]);
    }

    // Autres méthodes du contrôleur...
}