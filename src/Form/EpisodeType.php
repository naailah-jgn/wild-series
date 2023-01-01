<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'required' => true,
                    'class' =>'form-control',
                    'length' => '255',
                ],
                'label' => 'Nom d\'un épisode',
                'label_attr' => [
                    'class' => 'form-label'
                ]
                ])
            ->add('number', IntegerType::class, [
                'attr' => [
                    'required' => true,
                    'minlength' => '1',
                    'class' =>'form-control row',
                ],
                'label' => 'Numéro de l\'épisode',
                'label_attr' => [
                    'class' => 'col-form-label mt-4 row'
                ],
                'constraints' => [
                    new Length(['min' => 1]),
                    new Positive(),
                    new NotBlank()
                ]
            ])
            ->add('synopsis', TextareaType::class, [
                'attr' => [
                    'required' => true,
                    'class' => 'form-control row text-center',
                    'minlength' => '2',
                    'maxlength' => '6000',
                ],
                'label' => 'Résumé de l\'épisode',
                'label_attr' => [
                    'class' => 'form-label mt-4 row'
                ],
                'constraints' => [
                    new Length(['min' => 2, 'max' => 6000]),
                    new Positive(),
                    new NotBlank()
                ]
            ])
            ->add('season', EntityType::class, [
                'attr' => [
                    'class'=>'form-control row',
                ],
                'class' => Season::class,
                'choice_label' => 'number',
                'multiple' => false,
                'label' => 'Numéro de la saison',
                'label_attr' => [
                    'class' => 'form-label mt-4 row'
                ]
            ])
            ->add('program', EntityType::class, [
                'attr' => [
                    'class'=>'form-control row',
                ],
                'class' => Program::class,
                'choice_label' => 'title',
                'multiple' => false,
                'label' => 'Nom de la série',
                'label_attr' => [
                    'class' => 'form-label mt-4 row'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
