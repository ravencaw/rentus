<?php

namespace App\Form;

use App\Entity\Cita;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CitaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_hora', DateTimeType::class, [
                'attr'=>['class'=>'datepicker'],
                'label'=>'Fecha de la cita'
            ])
            ->add('id_usuario1', null, array('label'=>'Convocante'))
            ->add('id_usuario2', null, array('label'=>'Convocado'))
            ->add('direccion')
            ->add('ciudad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cita::class,
        ]);
    }
}
