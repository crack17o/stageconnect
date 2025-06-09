<?php
namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Superviseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class)
            ->add('nom', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('superviseur', EntityType::class, [
                'class' => Superviseur::class,
                'choice_label' => 'email', // ou autre propriété d'affichage
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}