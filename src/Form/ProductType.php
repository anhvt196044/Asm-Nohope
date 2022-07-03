<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'label' => 'Product Name',
            'required' => true,
            'attr' => [
                'minlength' => 1,
                'maxlength' => 40
            ]
        ])
        
        ->add('color', TextType::class,
        [
            'label' => 'Product Color'
        ])

        ->add('description', TextType::class,
        [
            'label' => 'Product Description'
            
        ])

        ->add('price', IntegerType::class,
        [
            'label' => "Product Price",
            'attr' => [
                'min' => 1,
                'max' => 203001
            ]
        ])

        ->add('image', FileType::class,
        [
            'label' => 'Product image',
            'data_class' => null,
            'required' => is_null($builder->getData()->getImage())
        ])
        

        ->add('category', EntityType::class,
        [
            'label' => 'category Name',
            'class' => Category::class,
            'choice_label' => 'name'
        ])
        ->add('Save', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
