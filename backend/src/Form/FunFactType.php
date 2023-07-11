<?php

namespace App\Form;

use App\Entity\Funfact;
use App\Entity\Masterclass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FunFactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de la Funfact',
            ])
            ->add('description', TextType::class, [
              'label' => 'Funfact',
            ])
            // ->add('masterclass', EntityType::class, [
            //   'class' => 'App\Entity\Masterclass',
            //   'choice_value' => 'id',
            // ])
            ->add('save', SubmitType::class, [
              'label' => 'Submit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Funfact::class,
        ]);
    }
}
