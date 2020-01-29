<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class UsuarioType extends AbstractType
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
            ->add('correo', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Email(['mode' => 'loose'])
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
            ->add('password', PasswordType::class, [
                'required' => true,
                'constraints' => [
                    new Length(['min' => 8]),
                    new NotCompromisedPassword()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
