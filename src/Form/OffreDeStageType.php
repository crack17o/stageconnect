<?php
namespace App\Form;

use App\Entity\OffreDeStage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OffreDeStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du stage',
                'attr' => [
                    'placeholder' => 'Ex: Stagiaire en Développement Web',
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du stage',
                'attr' => [
                    'placeholder' => 'Décrivez les missions, responsabilités et compétences requises...',
                    'class' => 'form-control',
                    'rows' => 10
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OffreDeStage::class,
        ]);
    }
}