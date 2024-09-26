<?php

namespace App\Form;

use App\Entity\MandatCoges;
use App\Entity\MembreOrgane;
use App\Entity\PosteOrgane;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreOrganeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom',
                'mapped' => 'true',
                'required' => 'true',
            ])
            ->add('genre', ChoiceType::class,[
                'label' => 'Sexe',
                'mapped' => 'true',
                'choices' => [
                    "Homme" => "H",
                    "Femme" => "F",
                ]
            ])
            ->add('profession', TextType::class,[
                'label' => 'Profession',
                'mapped' => 'true',
                'required' => 'false',
            ])
            ->add('contact', TelType::class, [
                'label' => "Contact",
                'mapped' => 'true',
                'required' => 'false',
            ])
            ->add('mandat',EntityType::class,[
                'class' => MandatCoges::class,
                'choice_label' => 'libelle'
            ])
            ->add('poste',EntityType::class,[
                'class' => PosteOrgane::class,
                'choice_label' => 'libellePoste'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MembreOrgane::class,
        ]);
    }
}
