
<?php

namespace App\Service;

use App\Repository\StageRepository;

class StageService
{
    private $stageRepository;

    public function __construct(StageRepository $stageRepository)
    {
        $this->stageRepository = $stageRepository;
    }

    public function getStageByEtudiant(int $etudiantId)
    {
        return $this->stageRepository->findByEtudiant($etudiantId);
    }
}
