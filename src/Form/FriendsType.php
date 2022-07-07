<?php

namespace App\Form;

use App\Entity\Friends;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FriendsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('receiverUser');
            ->add('receiverUser', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.username', 'DESC');
                    // ->where('TODO: filter without current user');
                },
                // 'choice_label' => 'username',
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Friends::class,
        ]);
    }
}
