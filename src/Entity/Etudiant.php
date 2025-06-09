namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Etudiant extends User
{
    #[ORM\Column(length: 50, unique: true)]
    protected ?string $matricule = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    private ?Superviseur $superviseur = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Candidature::class)]
    private $candidatures;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    public function getMatricule(): ?string { return $this->matricule; }
    public function setMatricule(string $matricule): static { $this->matricule = $matricule; return $this; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }
    public function getSuperviseur(): ?Superviseur { return $this->superviseur; }
    public function setSuperviseur(?Superviseur $superviseur): static { $this->superviseur = $superviseur; return $this; }
}