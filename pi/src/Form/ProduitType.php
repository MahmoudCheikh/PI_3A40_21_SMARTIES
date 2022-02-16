<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('image',FileType::class,array('label'=>'inserer une image','data_class' => null))
            ->add('description')
            ->add('prix')
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Piece de Rechange' => "Piece de Rechange",
                    'Accessoire' => "Accessoire",
                    'Velo' => "Velo",
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
