<?php

namespace App\Form;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('number', IntegerType::class, [
            'attr' => [
                'required' => true,
                'minlength' => '1',
                'class' =>'form-control row',
            ],
            'label' => 'Numéro de la saison',
            'label_attr' => [
                'class' => 'col-form-label mt-4 row'
            ],
            'constraints' => [
                new Assert\Length(['min' => 1]),
                new Assert\Positive(),
                new Assert\NotBlank()
            ]
        ])
        ->add('year', IntegerType::class, [
            'attr' => [
                'required' => true,
                'class' =>'form-control ',
                'minlength' => '4',
                'maxlength' => '4',
            ],
            'label' => 'Date de sortie',
            'label_attr' => [
                'class' => 'col-form-label mt-4 row'
            ],
            'constraints' => [
                new Assert\Length(['min' => 4, 'max' => 4]),
                new Assert\Positive(),
                new Assert\NotBlank()
            ]
        ])
        ->add('description', TextareaType::class, [
            'attr' => [
                'required' => true,
                'class' => 'form-control row',
                'minlength' => '2',
                'maxlength' => '6000',
            ],
            'label' => 'Description de la saison',
            'label_attr' => [
                'class' => 'form-label mt-4 row'
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 6000]),
                new Assert\Positive(),
                new Assert\NotBlank()
            ]
        ])
        ->add('Program', EntityType::class, [
            'attr' => [
                'class'=>'form-control row',
            ],
            'class' => Program::class,
            'choice_label' => 'title',
            'multiple' => false,
            'label' => 'Programme',
            'label_attr' => [
                'class' => 'form-label mt-4 row'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4 row'
            ]
        ]);
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
