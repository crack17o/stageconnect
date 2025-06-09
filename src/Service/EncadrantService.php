<?php
namespace App\Service;

use App\Repository\EncadrantRepository;

class EncadrantService
{
    private $encadrantRepository;

    public function __construct(EncadrantRepository $encadrantRepository)
    {
        $this->encadrantRepository = $encadrantRepository;
    }

    public function getEncadrantByEmail(string $email)
    {
        return $this->encadrantRepository->findByEmail($email);
    }
}
