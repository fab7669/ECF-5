<?php


namespace App\Entity;

use App\Repository\EnfantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnfantRepository::class)]
class Enfant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    
    private $id = null;

    #[ORM\Column(length: 255)]
    private $nom = null;

    #[ORM\Column(length: 255)]
    private $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private $dateNaissance = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private $allergies = null;

    #[ORM\ManyToMany(targetEntity: Responsable::class, inversedBy: 'enfants')]
    private $responsables;

    public function __construct()
    {
        $this->responsables = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getAllergies()
    {
        return $this->allergies;
    }

    public function setAllergies($allergies)
    {
        $this->allergies = $allergies;
        return $this;
    }

    public function getResponsables()
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable)
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables->add($responsable);
        }
        return $this;
    }

    public function removeResponsable(Responsable $responsable)
    {
        $this->responsables->removeElement($responsable);
        return $this;
    }
}