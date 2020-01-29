<?php

namespace App\Form;

use App\Entity\Inmobiliaria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Positive;

class InmobiliariaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 6])
                ]
            ])
            ->add('direccion', TextType::class)
            ->add('nif', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 9]),
                    new Length(['max' => 9])
                ]
            ])
            ->add('telefono', TelType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 9]),
                    new Length(['max' => 9]),
                    new Positive()
                ]
            ])
            ->add('logo', FileType::class, array('data_class' => null),[
                'required' => true,
                'constraints' => [
                    new File(['maxSize' => '4M'], ['mimeTypes' => 'image/jpeg'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inmobiliaria::class,
        ]);
    }
}
