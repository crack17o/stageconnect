<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Superviseur extends User
{
    #[ORM\OneToMany(mappedBy: 'superviseur', targetEntity: Etudiant::class)]
    private $etudiants;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getEtudiants() { return $this->etudiants; }
}