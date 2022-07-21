<?php

namespace App\Form;

use App\Entity\Challenges;
use App\Entity\Category;
use App\Entity\Tags;
use App\Form\TagsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ChallengesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('deadline',DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder'=>'Choisir une catégorie',
            ])
            ->add('tags',TagsType::class)
            ->add('status', CheckboxType::class, [
                'label'    => 'Ouvert ? ',
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Challenges::class,
        ]);
    }
}
