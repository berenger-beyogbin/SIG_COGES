<?php

namespace App\Form;

use App\Entity\Coges;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CogesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleCOGES')
            ->add('cycle')
            ->add('numeroCompte')
            ->add('domiciliation')
            ->add('groupeScolaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coges::class,
        ]);
    }
}
