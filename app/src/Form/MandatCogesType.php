<?php

namespace App\Form;

use App\Entity\Coges;
use App\Entity\MandatCoges;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MandatCogesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'html5' => false,
                'mapped' => true,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'date'],
                'required' => false,
            ])
            ->add('DateFin', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'html5' => false,
                'mapped' => true,
                'format' => 'dd/MM/yyyy',
                'attr' => ['class' => 'date'],
                'required' => false,
            ])
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'required' => false,
            ])
            ->add('coges', EntityType::class,[
                'class' => Coges::class,
                'mapped' => true,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MandatCoges::class,
        ]);
    }
}
