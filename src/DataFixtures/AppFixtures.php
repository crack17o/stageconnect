<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\ResponsableEntreprise;
use App\Entity\OffreDeStage;
use App\Entity\Etudiant;
use App\Entity\Superviseur;
use App\Entity\Candidature;
use App\Entity\Utilisateur;
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
        if (method_exists($responsable, 'setEmail')) {
            $responsable->setEmail('responsable@entreprise.com');
        }
        if (method_exists($responsable, 'setPassword')) {
            $responsable->setPassword('password');
        }
        if (method_exists($responsable, 'setRoles')) {
            $responsable->setRoles(['ROLE_ENTREPRISE']);
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
        if (method_exists($superviseur, 'setRoles')) {
            $superviseur->setRoles(['ROLE_SUPERVISEUR']);
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
        if (method_exists($etudiant, 'setRoles')) {
            $etudiant->setRoles(['ROLE_ETUDIANT']);
        }
        $manager->persist($etudiant);

        // Création du super admin
        $superadmin = new Utilisateur();
        if (method_exists($superadmin, 'setEmail')) {
            $superadmin->setEmail('superadmin@upc.com');
        }
        if (method_exists($superadmin, 'setPassword')) {
            $superadmin->setPassword('password');
        }
        if (method_exists($superadmin, 'setRoles')) {
            $superadmin->setRoles(['ROLE_SUPERADMIN']);
        }
        $manager->persist($superadmin);

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
