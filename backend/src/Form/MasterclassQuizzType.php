<?php

namespace App\Form;

use App\Entity\MasterclassQuizz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MasterclassQuizzType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre du Quizz',
            ])
            ->add('counter')
            ->add('masterclasses', EntityType::class, [
                'class' => 'App\Entity\Masterclass',
                'choice_label' => 'title',
                'multiple' => true,
            ])
            ->add('masterclassQuestion', EntityType::class, [
                'class' => 'App\Entity\MasterclassQuestion',
                'choice_label' => 'title',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MasterclassQuizz::class,
        ]);
    }
}
