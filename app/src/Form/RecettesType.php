<?php

namespace App\Form;

use App\Entity\Pacc;
use App\Entity\Recette;
use App\Entity\Source;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montantRecette', NumberType::class,[
                'label' => 'Montant',
                'required' => false
            ])
            ->add('pacc', EntityType::class, [
                'class' => Pacc::class,
                'required' => false,
                'label' => 'pacc',
                'choice_label' => 'libelle'
            ])
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'required' => false,
                'label' => 'Source',
                'choice_label' => 'libelleSource'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
