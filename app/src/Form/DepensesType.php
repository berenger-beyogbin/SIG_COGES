<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Chapitre;
use App\Entity\Depense;
use App\Entity\Fournisseur;
use App\Entity\Pacc;
use App\Entity\Source;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MontantDepense', NumberType::class,[
                'label' => 'Montant',
                'required' => false
            ])
            ->add('FichierPreuve', FileType::class,[
                'required' => false,
                'label' => 'Fichier preuve',
                'data_class' =>  null,
                'mapped' => true,
            ])
            ->add('NomFichierPreuve', TextType::class,[
                'label' => 'Nom du fichier',
                'required' => false
            ])
            ->add('dateExecution', DateType::class,[
                'label' => "Date d'exécution",
                'attr' => ['class' => 'date'],
                'required' => false
            ])
            ->add('PaiementFournisseur', TextType::class,[
                'label' => 'Paiement fournisseur',
                'required' => false
            ])
            ->add('pacc', EntityType::class, [
                'class' => Pacc::class,
                'label' => 'PACC',
                'choice_label' => 'libelle'
            ])
            ->add('activite', EntityType::class, [
                'class' => Activite::class,
                'label' => 'Activité',
                'choice_label' => 'libelleActivite'
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'label' => 'Fournisseur',
                'choice_label' => 'entreprise'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depense::class,
        ]);
    }
}
