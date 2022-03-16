<?php

namespace App\Form;

use App\Entity\Remark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemarkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content',TextareaType::class, [
                'form_attr' => true,
                'label'  => 'Subject',
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
