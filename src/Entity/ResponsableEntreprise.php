namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ResponsableEntreprise extends User
{
    #[ORM\ManyToOne]
    private ?Entreprise $entreprise = null;

    public function getEntreprise(): ?Entreprise { return $this->entreprise; }
    public function setEntreprise(?Entreprise $entreprise): static { $this->entreprise = $entreprise; return $this; }
}