<?php

namespace App\Form;

use App\Entity\Inmueble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Positive;

class InmuebleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoInmueble', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Venta' => 'venta',
                    'Alquiler' => 'alquiler'
                ]
            ])
            ->add('precio', NumberType::class,[
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('superficie', NumberType::class,[
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('direccion')
            ->add('zona', ChoiceType::class, [
                'choices' => [
                    'Centro' => "centro",
                    'Cerca del centro' => "cerca_centro",
                    'Periferia' => "periferia",
                    'Extrarradio' => "extrarradio",
                    'Afueras' => "afueras"
                ]
            ])
            ->add('ciudad')
            ->add('cp', NumberType::class,[
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('habitaciones', NumberType::class,[
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('bathroom', NumberType::class,[
                'required' => true,
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('comentarios')
            ->add('extras')
            ->add('disponible', ChoiceType::class, [
                'choices' => [
                    'Si' => 1,
                    'No' => 0
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inmueble::class,
        ]);
    }
}
