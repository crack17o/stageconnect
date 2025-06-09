
<?php

namespace App\Service;

use App\Repository\UtilisateurRepository;

class UtilisateurService
{
    private $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function getUtilisateurByUsername(string $username)
    {
        return $this->utilisateurRepository->findByUsername($username);
    }
}
