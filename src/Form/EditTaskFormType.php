<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditTaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints'=>[
                    new NotBlank(['message' => 'Veuillez indiquer un titre.']),
                    new Regex([
                        'pattern' => '/^[a-z0-9-_\.\,]+$/i',
                        'message' => 'Le titre ne peut contenir que des caractères alphanumériques, undescores, points et virgules.'
                    ]),
                    new length([
                        'max'=> 40,
                        'maxMessage' => 'Le titre ne peut contenir plus de 40 caractères'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'required'=>false,
                'constraints'=>[
                    new Regex([
                        'pattern' => '/^[a-z0-9-_\.\,]+$/i',
                        'message' => 'La description ne peut contenir que des caractères alphanumériques, undescores, points et virgules.'
                    ]),
                    new length([
                        'max'=> 500,
                        'maxMessage' => 'La description ne peut contenir plus de 500 caractères'
                    ])
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'A faire' => 'A faire',
                    'En cours' => 'En cours',
                    'Terminée' => 'Terminée',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
