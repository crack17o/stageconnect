
<?php

namespace App\Service;

use App\Repository\TuteurRepository;

class TuteurService
{
    private $tuteurRepository;

    public function __construct(TuteurRepository $tuteurRepository)
    {
        $this->tuteurRepository = $tuteurRepository;
    }

    public function getTuteursByEntreprise(int $entrepriseId)
    {
        return $this->tuteurRepository->findByEntreprise($entrepriseId);
    }
}
