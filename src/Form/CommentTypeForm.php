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
                'label' => 'Twój nick',
                'constraints' => [
                    new NotBlank(['message' => 'Nick nie może być pusty']),
                    new Length(['max' => 50, 'maxMessage' => 'Nick może mieć maksymalnie {{ limit }} znaków']),
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Twój email',
                'attr' => ['class' => 'form-control form-control-sm', 'placeholder' => 'Twój email'],
                'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Twój komentarz',
                'constraints' => [
                    new NotBlank(['message' => 'Komentarz nie może być pusty']),
                    new Length(['max' => 1000, 'maxMessage' => 'Komentarz może mieć maksymalnie {{ limit }} znaków']),
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
        ]);
    }
}
