<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\ResponsableEntreprise;
use App\Entity\OffreDeStage;
use App\Entity\Etudiant;
use App\Entity\Superviseur;
use App\Entity\Candidature;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'une entreprise
        $entreprise = new Entreprise();
        $entreprise->setNom('Entreprise Test');
        $manager->persist($entreprise);

        // Création d'un responsable d'entreprise
        $responsable = new ResponsableEntreprise();
        $responsable->setEntreprise($entreprise);
        // Exemple pour User : à adapter selon les propriétés de User
        if (method_exists($responsable, 'setEmail')) {
            $responsable->setEmail('responsable@entreprise.com');
        }
        if (method_exists($responsable, 'setPassword')) {
            $responsable->setPassword('password');
        }
        $manager->persist($responsable);

        // Création d'un superviseur
        $superviseur = new Superviseur();
        if (method_exists($superviseur, 'setEmail')) {
            $superviseur->setEmail('superviseur@upc.com');
        }
        if (method_exists($superviseur, 'setPassword')) {
            $superviseur->setPassword('password');
        }
        $manager->persist($superviseur);

        // Création d'un étudiant
        $etudiant = new Etudiant();
        $etudiant->setMatricule('20250001')
                 ->setNom('Dupont')
                 ->setSuperviseur($superviseur);
        if (method_exists($etudiant, 'setEmail')) {
            $etudiant->setEmail('etudiant@upc.com');
        }
        if (method_exists($etudiant, 'setPassword')) {
            $etudiant->setPassword('password');
        }
        $manager->persist($etudiant);

        // Création d'une offre de stage
        $offre = new OffreDeStage();
        $offre->setTitre('Stage Développeur')
              ->setDescription('Développement web Symfony')
              ->setEntreprise($entreprise);
        $manager->persist($offre);

        // Création d'une candidature
        $candidature = new Candidature();
        $candidature->setEtudiant($etudiant)
                    ->setOffre($offre)
                    ->setDescription('Je suis motivé pour ce stage.')
                    ->setStatut('en attente');
        $manager->persist($candidature);

        $manager->flush();
    }
}
