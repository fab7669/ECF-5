<?php


namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponsableRepository::class)]
class Responsable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
   #[ORM\Column(type: 'integer')]
    private $id = null;

    #[ORM\Column(length: 255)]
    private $nom = null;

    #[ORM\Column(length: 255)]
    private $prenom = null;

    #[ORM\Column(length: 255)]
    private $telephone = null;

    #[ORM\Column(length: 255)]
    private $email = null;

    #[ORM\ManyToMany(targetEntity: Enfant::class, mappedBy: 'responsables')]
    private $enfants;

    public function __construct()
    {
        $this->enfants = new ArrayCollection();
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

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(Enfant $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants->add($enfant);
            $enfant->addResponsable($this);
        }
        return $this;
    }

    public function removeEnfant(Enfant $enfant): self
    {
        if ($this->enfants->removeElement($enfant)) {
            $enfant->removeResponsable($this);
        }
        return $this;
    }

    public function __toString()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}