<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Commune;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommuneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class,[
                'label' => 'Nom',
                'mapped' => true,
                'required' => false
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description',
                'mapped' => true,
                'required' => false
            ])
            ->add('region', EntityType::class,[
                'class' => Region::class,
                'mapped' => true,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commune::class,
        ]);
    }
}
