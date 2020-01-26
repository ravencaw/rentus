<?php

namespace App\Form;

use App\Entity\Inmueble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InmuebleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoInmueble', ChoiceType::class, [
                'choices' => [
                    'Venta' => 'venta',
                    'Alquiler' => 'alquiler'
                ]
            ])
            ->add('precio')
            ->add('superficie')
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
            ->add('cp')
            ->add('habitaciones')
            ->add('bathroom')
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
