<?php

namespace App\Form;

use App\Entity\Coges;
use App\Entity\Dren;
use App\Entity\Etablissement;
use App\Entity\Iepp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => false
            ])
            ->add('localite', TextType::class, [
                'label' => 'Nom',
                'required' => false
            ])
            ->add('typeMilieu', TextType::class, [
                'label' => 'Type milieu',
                'required' => false
            ])
            ->add('cycle', ChoiceType::class, [
                'label' => 'Cycle',
                'required' => false,
                'choices' => [
                    "Primaire" => 1,
                    "Secondaire" => 2,
                ]
            ])
            ->add('codeEts', TextType::class,[
                'label' => 'Code établissement',
                'required' => false
            ])
            ->add('dren', EntityType::class,[
                'class' => Dren::class,
                'mapped' => true,
                'label' => 'DREN',
                'choice_label' => 'libelle',
                'required' => false,
                'attr' => ['class' => 'select2']
            ])
            ->add('coges', EntityType::class,[
                'class' => Coges::class,
                'mapped' => true,
                'label' => 'COGES',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
