<?php

namespace App\Controller;

use App\Entity\OffreDeStage;
use App\Form\OffreDeStageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager
            ->getRepository(OffreDeStage::class)
            ->findAll();

        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new OffreDeStage();
        $form = $this->createForm(OffreDeStageType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer l'offre à l'entreprise connectée
            $user = $this->getUser();

            if ($user instanceof \App\Entity\ResponsableEntreprise && $user->getEntreprise() !== null) {
                $offre->setEntreprise($user->getEntreprise());
            } else {
                throw $this->createAccessDeniedException('Utilisateur non valide pour créer une offre.');
            }

            
            $entityManager->persist($offre);
            $entityManager->flush();

            $this->addFlash('success', 'L\'offre de stage a été créée avec succès.');

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offre_show', methods: ['GET'])]
    public function show(OffreDeStage $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function edit(Request $request, OffreDeStage $offre, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est l'entreprise propriétaire de l'offre
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\ResponsableEntreprise || $offre->getEntreprise() !== $user->getEntreprise()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier cette offre.');
        }

        $form = $this->createForm(OffreDeStageType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'L\'offre de stage a été modifiée avec succès.');

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offre_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function delete(Request $request, OffreDeStage $offre, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\ResponsableEntreprise || $offre->getEntreprise() !== $user->getEntreprise()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette offre.');
        }

        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();

            $this->addFlash('success', 'L\'offre de stage a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }
}
