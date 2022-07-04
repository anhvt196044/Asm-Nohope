<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('city', ChoiceType::class, 
        [
            'label'=>'City',
            'required' => true,
            'choices' => [
                'Hanoi' =>'Hanoi',
                'Thai Binh' =>'Thai Binh',
                'Tan lap' =>'Tan lap',
                'HCM ' =>'HCM',
            ]
        ])
        ->add('phone', TextType::class,[
            'label' => "Phone number",
            'attr' => 
            [
                'length' => 10
            ]
        ])
        ->add('direction',TextType::class)

        ->add("Add", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}