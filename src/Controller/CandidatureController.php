<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\OffreDeStage;
use App\Form\CandidatureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/new/{id}', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function new(Request $request, OffreDeStage $offre, EntityManagerInterface $entityManager): Response
    {
        $candidature = new Candidature();
        $candidature->setOffre($offre);
        $candidature->setEtudiant($this->getUser()->getEtudiant());
        $candidature->setDate(new \DateTime());
        $candidature->setStatut('En attente');

        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidature);
            $entityManager->flush();

            $this->addFlash('success', 'Votre candidature a été soumise avec succès !');

            return $this->redirectToRoute('app_offre_show', ['id' => $offre->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
            'offre' => $offre
        ]);
    }

    #[Route('/{id}', name: 'app_candidature_show', methods: ['GET'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function show(Candidature $candidature): Response
    {
        // Vérifier si l'utilisateur est l'étudiant qui a postulé
        if ($candidature->getEtudiant() !== $this->getUser()->getEtudiant()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à voir cette candidature.');
        }

        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidature_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function edit(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est l'étudiant qui a postulé
        if ($candidature->getEtudiant() !== $this->getUser()->getEtudiant()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier cette candidature.');
        }

        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Votre candidature a été modifiée avec succès !');

            return $this->redirectToRoute('app_candidature_show', ['id' => $candidature->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidature_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function delete(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est l'étudiant qui a postulé
        if ($candidature->getEtudiant() !== $this->getUser()->getEtudiant()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette candidature.');
        }

        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $entityManager->remove($candidature);
            $entityManager->flush();

            $this->addFlash('success', 'Votre candidature a été supprimée avec succès !');
        }

        return $this->redirectToRoute('app_offre_show', ['id' => $candidature->getOffre()->getId()], Response::HTTP_SEE_OTHER);
    }
} 