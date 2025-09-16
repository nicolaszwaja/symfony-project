<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

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

/**
 * Form type for creating or editing a Post entity.
 */
class PostType extends AbstractType
{
    /**
     * Builds the form for the Post entity.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
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
                'placeholder' => 'label.select_category',
                'label' => 'Kategoria',
                'attr' => ['class' => 'form-select'],
                'required' => true,
                'constraints' => [
                    new NotNull(['message' => 'Musisz wybrać kategorię.']),
                ],
            ]);
    }

    /**
     * Configures the options for this form type.
     *
     * @param OptionsResolver $resolver The options resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
