<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Votre Email',

            ])
            ->add('username',TextType::class,[
                'label' => 'Votre pseudo',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'=>[
                    'label'=> "Votre mot de passe",
                ],
                'second_options'=>[
                    'label'=>"Repeter votre mot de passe",
                ]
            ])
            ->add('pro', ChoiceType::class, array(
                'choices'=> array(
                    'true',
                    'false'
                )
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
