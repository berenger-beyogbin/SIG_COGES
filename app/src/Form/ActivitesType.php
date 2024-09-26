<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Chapitre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleActivite', TextType::class, [
                'label' => 'Libellé',
                'mapped' => true,
                'required' => false
            ])
            ->add('chapitre', EntityType::class,[
                'class' => Chapitre::class,
                'mapped' => true,
                'label' => 'Chapitre',
                'choice_label' => 'libelleChapitre',
                'required' => false,
                'attr' => ['class' => 'select2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
