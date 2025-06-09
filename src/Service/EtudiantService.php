<?php

namespace App\Service;

use App\Repository\EtudiantRepository;

class EtudiantService
{
    private $etudiantRepository;

    public function __construct(EtudiantRepository $etudiantRepository)
    {
        $this->etudiantRepository = $etudiantRepository;
    }

    public function getEtudiantByEmail(string $email)
    {
        return $this->etudiantRepository->findByEmail($email);
    }
}
