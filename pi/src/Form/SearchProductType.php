<?php

namespace App\Form;

use App\Entity\SearchProduct;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minsurface',IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' =>[
                    'placeholder' => 'Surface minimale'
                ]
             ])
            ->add('maxprice',IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' =>[
                    'placeholder' => 'budget max'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchProduct::class,
        ]);
    }
}