<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sender', TextType::class, [
                'label' => 'Votre Nom',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'sender'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Indiquez votre nom.'])
                ]
            ])
            ->add('emailSender', EmailType::class, [
                'label' => 'Votre email',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'emailSender'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Email Obligatoire.'])
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Objet',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'subject',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'message',
                    'Saisissez votre message ici...'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Saisissez un message.'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
