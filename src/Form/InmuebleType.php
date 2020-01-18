<?php

namespace App\Form;

use App\Entity\Inmueble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InmuebleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoInmueble')
            ->add('precio')
            ->add('superficie')
            ->add('direccion')
            ->add('ciudad')
            ->add('cp')
            ->add('habitaciones')
            ->add('bathroom')
            ->add('comentarios')
            ->add('extras')
            ->add('idCreador')
            ->add('disponible')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inmueble::class,
        ]);
    }
}
