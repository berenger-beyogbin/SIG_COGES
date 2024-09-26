<?php

namespace App\Form;

use App\Entity\Coges;
use App\Entity\Commune;
use App\Entity\Dren;
use App\Entity\Iepp;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CogesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Nom',
                'mapped' => true,
                'required' => false
            ])
            ->add('cycle', ChoiceType::class, [
                'label' => 'Cycle',
                'choices' => [
                    'Primaire' => 1,
                    'Secondaire' => 2
                ],
                'mapped' => true,
                'empty_data' => 1,
                'required' => false
            ])
            ->add('numeroCompte', TextType::class, [
                'label' => 'Numéro de compte',
                'mapped' => true,
                'required' => false
            ])
            ->add('groupeScolaire', CheckboxType::class, [
                'label' => 'Groupe scolaire',
                'mapped' => true,
                'required' => false
            ])
            ->add('domiciliation', TextType::class, [
                'label' => 'Domiciliation',
                'mapped' => true,
                'required' => false
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'mapped' => true,
                'label' => 'REGION',
                'choice_label' => 'libelle',
                'required' => false,
                'attr' => ['class' => 'select2']
            ])
            ->add('commune', EntityType::class,[
                'class' => Commune::class,
                'mapped' => true,
                'label' => 'COMMUNE',
                'choice_label' => 'libelle',
                'required' => false,
                'attr' => ['class' => 'select2']
            ])
            ->add('iepp', EntityType::class,[
                'class' => Iepp::class,
                'mapped' => true,
                'label' => 'IEPP',
                'choice_label' => 'libelle',
                'required' => false,
                'attr' => ['class' => 'select2']
            ])
            ->add('dren', EntityType::class,[
                'class' => Dren::class,
                'mapped' => true,
                'label' => 'DREN',
                'choice_label' => 'libelle',
                'required' => false,
                'attr' => ['class' => 'select2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coges::class,
        ]);
    }
}
