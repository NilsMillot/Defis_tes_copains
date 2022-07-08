<?php

namespace App\Form;

use App\Entity\Remark;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemarkBackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('post',EntityType::class,[
                'class' => Post::class,
                'choice_label' => 'name',
                'placeholder'=>'Choisir un post',
                'attr'   =>  array(
                    'class'   => 'post_remark_new',
                )
            ])
            ->add('contentRemark',TextareaType::class, [
                'attr'   =>  array(
                    'class'   => 'materialize-textarea',
                    'id'=> 'icon_prefix2'
                )
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remark::class,
        ]);
    }
}
