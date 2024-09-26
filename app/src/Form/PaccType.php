<?php

namespace App\Form;

use App\Entity\MandatCoges;
use App\Entity\Pacc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaccType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début',
                'required' => false,
                'mapped' => true,
                'attr' => ['class' => 'date']
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin',
                'required' => false,
                'mapped' => true,
                'attr' => ['class' => 'date']
            ])
            ->add('cheminFichier', FileType::class, [
                'label' => 'Chemin du fichier',
                'mapped' => true,
                'required' => false,
            ])
            ->add('nomFichier', TextType::class, [
                'label' => 'Nom du fichier',
                'mapped' => true,
                'required' => false,
            ])
            ->add('mandatCoges', EntityType::class,[
                'class' => MandatCoges::class,
                'mapped' => true,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pacc::class,
        ]);
    }
}
