
<?php

namespace App\Service;

use App\Repository\EntrepriseRepository;

class EntrepriseService
{
    private $entrepriseRepository;

    public function __construct(EntrepriseRepository $entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    public function getEntrepriseByNom(string $nom)
    {
        return $this->entrepriseRepository->findByNom($nom);
    }
}
