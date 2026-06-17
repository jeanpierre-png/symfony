<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', textType::class, [ 'label' => 'Nom'])
            ->add('price', NumberType::class, [ 'label' => 'Prix'])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => true,
            ])
            ->add('featured')
            ->add('stockXS', NumberType::class, [ 'label' => 'Stock XS'])
            ->add('stockS', NumberType::class, [ 'label' => 'Stock S'])
            ->add('stockM', NumberType::class, [ 'label' => 'Stock M'])
            ->add('stockL', NumberType::class, [ 'label' => 'Stock L'])
            ->add('stockXL', NumberType::class, [ 'label' => 'Stock XL'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
