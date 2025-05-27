<?php

namespace App\Controller;

use App\Entity\Enfant;
use App\Entity\Presence;
use App\Repository\EnfantRepository;
use App\Repository\PresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class PlanningController extends AbstractController
{
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    #[Route('/planning', name: 'app_planning')]
    public function index(EnfantRepository $enfantRepository): Response
    {
        // Récupérer tous les enfants
        $enfants = $enfantRepository->findAll();
        
        return $this->render('planning/index.html.twig', [
            'enfants' => $enfants,
        ]);
    }
    
    #[Route('/planning/presences', name: 'app_planning_presences', methods: ['GET'])]
    public function getPresences(PresenceRepository $presenceRepository): JsonResponse
    {
        $presences = $presenceRepository->findBy([], ['date' => 'ASC']);
        
        $data = [];
        foreach ($presences as $presence) {
            $data[] = [
                'id' => $presence->getId(),
                'enfant' => [
                    'id' => $presence->getEnfant()->getId(),
                    'nom' => $presence->getEnfant()->getNom(),
                    'prenom' => $presence->getEnfant()->getPrenom()
                ],
                'date' => $presence->getDate()->format('Y-m-d'),
                'heureDebut' => $presence->getHeureDebut()->format('H:i'),
                'heureFin' => $presence->getHeureFin()->format('H:i')
            ];
        }
        
        return new JsonResponse($data);
    }
    
    #[Route('/planning/presence/nouvelle', name: 'app_planning_new_presence', methods: ['POST'])]
    public function addPresence(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            // Récupérer et décoder les données JSON
            $content = $request->getContent();
            $this->logger->info('Contenu reçu: ' . $content);
            
            $data = json_decode($content, true);
            
            if ($data === null) {
                $this->logger->error('Erreur JSON: ' . json_last_error_msg());
                return new JsonResponse(['error' => 'JSON invalide: ' . json_last_error_msg()], Response::HTTP_BAD_REQUEST);
            }
            
            // Vérifier que toutes les données requises sont présentes
            if (!isset($data['enfant_id'], $data['date'], $data['heureDebut'], $data['heureFin'])) {
                $this->logger->error('Données incomplètes: ' . json_encode($data));
                return new JsonResponse(['error' => 'Données incomplètes. Veuillez fournir enfant_id, date, heureDebut et heureFin'], Response::HTTP_BAD_REQUEST);
            }
            
            // Récupérer l'enfant
            $enfant = $entityManager->getRepository(Enfant::class)->find($data['enfant_id']);
            if (!$enfant) {
                $this->logger->error('Enfant non trouvé: ' . $data['enfant_id']);
                return new JsonResponse(['error' => 'Enfant non trouvé (ID: ' . $data['enfant_id'] . ')'], Response::HTTP_BAD_REQUEST);
            }
            
            // Créer une nouvelle présence
            $presence = new Presence();
            $presence->setEnfant($enfant);
            $presence->setDate(new \DateTime($data['date']));
            
            // Format attendu: hh:mm
            try {
                // Pour stocker correctement les heures, on ajoute une date (aujourd'hui)
                $today = date('Y-m-d');
                $heureDebut = \DateTime::createFromFormat('Y-m-d H:i', $today . ' ' . $data['heureDebut']);
                $heureFin = \DateTime::createFromFormat('Y-m-d H:i', $today . ' ' . $data['heureFin']);
                
                if (!$heureDebut || !$heureFin) {
                    throw new \Exception("Format d'heure invalide");
                }
                
                $presence->setHeureDebut($heureDebut);
                $presence->setHeureFin($heureFin);
            } catch (\Exception $e) {
                $this->logger->error('Erreur format heure: ' . $e->getMessage());
                return new JsonResponse(['error' => 'Format d\'heure invalide: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }
            
            // Vérifier que l'heure de fin est après l'heure de début
            if ($presence->getHeureDebut() >= $presence->getHeureFin()) {
                return new JsonResponse(['error' => 'L\'heure de fin doit être après l\'heure de début'], Response::HTTP_BAD_REQUEST);
            }
            
            // Persister l'entité
            $entityManager->persist($presence);
            $entityManager->flush();
            
            $this->logger->info('Présence ajoutée avec succès: ID=' . $presence->getId());
            
            // Réponse de succès
            return new JsonResponse([
                'id' => $presence->getId(),
                'message' => 'Présence enregistrée avec succès'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $this->logger->error('Exception: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Une erreur est survenue: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}