<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchChallengesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', SearchType::class,[
                'label'=> false,
                'attr'=>[
                    'placeholder'=>'Entrer un Nom de challenge'
                ],
                'required'=>false
            ])
            ->add('categorie', EntityType::class,[
                'class'=> Category::class,
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Choisir une Catégorie'
                ],
            ])
            ->add('Rechercher', SubmitType::class,[
                'attr'=>[
                    'class'=>'waves-effect waves-light btn green accent-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true
        ]);
    }
}