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

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Form type for creating or editing a Comment entity.
 */
class CommentTypeForm extends AbstractType
{
    /**
     * Builds the form for the Comment entity.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', TextType::class, [
                'label' => 'comment.nickname',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 50]),
                ],
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'comment.nickname',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'comment.email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'comment.email',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'comment.content',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 1000]),
                ],
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'rows' => 2,
                    'placeholder' => 'comment.content',
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
            'data_class' => Comment::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'post_comment',
            'translation_domain' => 'validators', // dzięki temu klucze będą tłumaczone
        ]);
    }
}
