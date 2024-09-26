<?php

namespace App\Form;

use App\Entity\Dren;
use App\Entity\Iepp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IeppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'required' => false,
            ])
            ->add('telephone', TelType::class,[
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('email', TelType::class,[
                'label' => 'Téléphone',
                'required' => false,
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
            'data_class' => Iepp::class,
        ]);
    }
}
