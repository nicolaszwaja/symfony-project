<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class CommentTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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

    public function configureOptions(OptionsResolver $resolver)
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
