<?php

// src/Form/PostType.php
namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Tytuł',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Tytuł nie może być pusty.']),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Treść',
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'constraints' => [
                    new NotNull(['message' => 'Treść nie może być pusta.']),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => '-- wybierz kategorię --',
                'label' => 'Kategoria',
                'attr' => ['class' => 'form-select'],
                'required' => true,
                'constraints' => [
                    new NotNull(['message' => 'Musisz wybrać kategorię.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
