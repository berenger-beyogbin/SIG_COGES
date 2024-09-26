<?php

namespace App\Form;

use App\Entity\OrganeCoges;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganeCogesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleOrgane', TextType::class, [
                'label' => 'Libellé organe',
                'mapped' => true,
                'required' => false,
            ])
            ->add('sigle', TextType::class, [
                'label' => 'Sigle',
                'mapped' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrganeCoges::class,
        ]);
    }
}
