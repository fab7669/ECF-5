<?php


namespace App\Controller;

use App\Entity\Enfant;
use App\Entity\Responsable;
use App\Form\EnfantType;
use App\Repository\EnfantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/enfant')]
class EnfantController extends AbstractController
{
    #[Route('/', name: 'app_enfant_index', methods: ['GET'])]
    public function index(EnfantRepository $enfantRepository): Response
    {
        return $this->render('enfant/index.html.twig', [
            'enfants' => $enfantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_enfant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enfant = new Enfant();
        $form = $this->createForm(EnfantType::class, $enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $nouveauResponsableData = $form->get('nouveauResponsable')->getData();
            
            // Vérifier si le responsable a été saisi
            if ($nouveauResponsableData && !empty($nouveauResponsableData->getNom()) && !empty($nouveauResponsableData->getPrenom())) {
                // Créer un nouvel objet Responsable avec les données du formulaire
                $nouveauResponsable = new Responsable();
                $nouveauResponsable->setNom($nouveauResponsableData->getNom());
                $nouveauResponsable->setPrenom($nouveauResponsableData->getPrenom());
                
                if (method_exists($nouveauResponsableData, 'getTelephone') && $nouveauResponsableData->getTelephone()) {
                    $nouveauResponsable->setTelephone($nouveauResponsableData->getTelephone());
                } else {
                    $nouveauResponsable->setTelephone('Non renseigné');
                }
                
                if (method_exists($nouveauResponsableData, 'getEmail') && $nouveauResponsableData->getEmail()) {
                    $nouveauResponsable->setEmail($nouveauResponsableData->getEmail());
                } else {
                    $nouveauResponsable->setEmail('Non renseigné');
                }
                
                // Toujours persister le responsable AVANT de l'associer à l'enfant
                $entityManager->persist($nouveauResponsable);
                
                // Associer explicitement le responsable à l'enfant
                $enfant->addResponsable($nouveauResponsable);
                
                // Pour débogage
                $this->addFlash('success', 'Responsable créé : ' . $nouveauResponsable->getNom() . ' ' . $nouveauResponsable->getPrenom());
            }
            
            // Persister l'enfant
            $entityManager->persist($enfant);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_enfant_index');
        }
        
        return $this->render('enfant/new.html.twig', [
            'enfant' => $enfant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enfant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enfant $enfant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnfantType::class, $enfant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $nouveauResponsableData = $form->get('nouveauResponsable')->getData();
            
            // Vérifier si le responsable a été saisi
            if ($nouveauResponsableData && !empty($nouveauResponsableData->getNom()) && !empty($nouveauResponsableData->getPrenom())) {
                // Créer un nouvel objet Responsable avec les données du formulaire
                $nouveauResponsable = new Responsable();
                $nouveauResponsable->setNom($nouveauResponsableData->getNom());
                $nouveauResponsable->setPrenom($nouveauResponsableData->getPrenom());
                
                if (method_exists($nouveauResponsableData, 'getTelephone') && $nouveauResponsableData->getTelephone()) {
                    $nouveauResponsable->setTelephone($nouveauResponsableData->getTelephone());
                } else {
                    $nouveauResponsable->setTelephone('Non renseigné');
                }
                
                if (method_exists($nouveauResponsableData, 'getEmail') && $nouveauResponsableData->getEmail()) {
                    $nouveauResponsable->setEmail($nouveauResponsableData->getEmail());
                } else {
                    $nouveauResponsable->setEmail('Non renseigné');
                }
                
                // Persister le responsable
                $entityManager->persist($nouveauResponsable);
                
                // Associer le responsable à l'enfant
                $enfant->addResponsable($nouveauResponsable);
            }
            
            $entityManager->flush();
            
            $this->addFlash('success', 'L\'enfant a été modifié avec succès');
            return $this->redirectToRoute('app_enfant_index');
        }

        return $this->render('enfant/edit.html.twig', [
            'enfant' => $enfant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_enfant_show', methods: ['GET'])]
    public function show(Enfant $enfant): Response
    {
        return $this->render('enfant/show.html.twig', [
            'enfant' => $enfant,
        ]);
    }

    #[Route('/{id}', name: 'app_enfant_delete', methods: ['POST'])]
    public function delete(Request $request, Enfant $enfant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enfant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($enfant);
            $entityManager->flush();
            $this->addFlash('success', 'L\'enfant a été supprimé avec succès');
        }

        return $this->redirectToRoute('app_enfant_index');
    }
}