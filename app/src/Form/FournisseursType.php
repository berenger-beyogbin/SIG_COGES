<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => false
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact',
                'required' => false
            ])
            ->add('entreprise', TextType::class, [
                'label' => 'Entreprise',
                'required' => false
            ])
            ->add('domaineActivite', TextType::class, [
                'label' => "Domaine d'activité",
                'required' => false
            ])
            ->add('localite', TextType::class, [
                'label' => 'Localite',
                'required' => false
            ])
            ->add('rib', TextType::class, [
                'label' => 'RIB',
                'required' => false
            ])
            ->add('domiciliation', TextType::class, [
                'label' => 'Domiciliation',
                'required' => false
            ])
            ->add('intituleCompte', TextType::class, [
                'label' => 'Intitule de compte',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
