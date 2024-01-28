<?php

namespace App\Form;

use App\Entity\Depenses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MontantDepense')
            ->add('FichierPreuve')
            ->add('NomFichierPreuve')
            ->add('DateExe')
            ->add('HeureExe')
            ->add('PaiementFournisseur')
            ->add('IDChapitre')
            ->add('IDActivites')
            ->add('IDPacc')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depenses::class,
        ]);
    }
}
