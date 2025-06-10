<?php
namespace App\Form;

use App\Entity\Candidature;
use App\Entity\Etudiant;
use App\Entity\OffreDeStage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => 'nom',
            ])
            ->add('offre', EntityType::class, [
                'class' => OffreDeStage::class,
                'choice_label' => 'titre',
            ])
            ->add('lettreMotivation', TextareaType::class, [
                'label' => 'Lettre de motivation',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 10,
                    'placeholder' => 'Expliquez pourquoi vous êtes intéressé par ce stage et pourquoi vous seriez un bon candidat...'
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'en attente',
                    'Acceptée' => 'acceptée',
                    'Refusée' => 'refusée',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}