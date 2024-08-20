<?php

namespace App\Form;

use App\Entity\OrganeCoges;
use App\Entity\PosteOrgane;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteOrganeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libellePoste', TextType::class, [
                'label' => 'Libellé',
                'mapped' => true,
                'required' => false,
            ])
            ->add('organeCoges', EntityType::class,[
                'class' => OrganeCoges::class,
                'label' => 'Organe COGES',
                'mapped' => true,
                'choice_label' => 'libelleOrgane'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PosteOrgane::class,
        ]);
    }
}
