<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('users', EntityType::class, [
                'class' => User::class,
                'expanded' => true,
                'multiple' => true,
                'attr'   =>  array(
                    'class'   => 'filled-in',
                    'id' => 'categorie'
                ),
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->select('*')
                        ->join("u.sender_user_id f", "OR", "u.receiver_user_id f" )
                        ->where("f.status = accepted")
                        ->getQuery()
                        ->getResult();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
